<?php

namespace App\Services\gudang;

use App\Repositories\gudang\repository\GudangBelanjaRepository;
use App\Repositories\gudang\repository\GudangPengirimanRepository;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\gudang\repository\GudangQualityControllRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\umum\UmumRepository;
use App\Repositories\gudang\repository\GudangUnboxingRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use Carbon\Carbon;

class GudangUnboxingServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private GudangUnboxingRepository $unboxing,
        private GudangBelanjaRepository $belanja,
        private GudangPengirimanRepository $pengiriman,
        private GudangProdukIdItemRepository $idItem,
        private GudangQualityControllRepository $qc,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataUnboxing = $this->unboxing->getDataUnboxing()->sortByDesc('id');
        
        return view('gudang.receive-goods.unboxing.unboxing', [
            'title' => 'Gudang Unboxing',
            'active' => 'gudang-unboxing',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'dataUnboxing' => $dataUnboxing,
        ]);
    }

    public function processUnboxing($id, Request $request)
    {
        try {
            $this->transaction->beginTransaction();

            $tanggalDiterima = Carbon::today()->format('Y-m-d');
            $orderId = $request->input('order_id');
            $pengirimanId = $request->input('pengiriman_id');
            $linkDrive = $request->input('link_drive');
            $file = $request->file('files_unboxing');
            $fileContent = base64_encode(file_get_contents($file));
            $mimeType = $file->getMimeType();

            $data = [
                'file' => $fileContent,
                'orderId' => 'Unboxing N.' . $orderId,
                'link_drive' => $linkDrive,
                'mimeType' => $mimeType,
            ];

            $urlApi = 'https://script.google.com/macros/s/AKfycbwcDRXaK4cn2VUe65o2ysA94yCvkXXEvjJ-S5h_S-JNqmVBW_IILKuT6OEnzipr0mSP/exec';
            $response = Http::post($urlApi, $data);

            if ($response->json('status') == 'success') {

                $belanja = $this->belanja->findBelanja($orderId);
                if (!$belanja) {
                    throw new \Exception("List belanja not found.");
                }

                $belanja->update(['status' => 'Process Quality Control']);

                $detailBelanja = $belanja->detailBelanja;
                $dataIdItems = [];
                $timestamp = now();

                foreach ($detailBelanja as $detail) {
                    $gudangProdukId = $detail->sparepart->id;
                    if ($gudangProdukId === null) {
                        continue;
                    }

                    for ($i = 0; $i < $detail->quantity; $i++) {
                        $dataIdItems[] = [
                            'gudang_belanja_id' => $orderId,
                            'gudang_produk_id' => $gudangProdukId,
                            'status_inventory' => 'Menunggu QC',
                            'produk_asal' => 'Belanja',
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp,
                        ];
                    }
                }
                
                $insertIdItem = $this->idItem->insertIdItem($dataIdItems);
                $dataQc = [];

                foreach ($insertIdItem as $item) {
                    $dataQc[] = [
                        'gudang_produk_id_item_id' => $item,
                        'status_qc' => 'Menunggu QC',
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];
                }

                $this->qc->insertQc($dataQc);
                $this->pengiriman->updatePengiriman($pengirimanId, ['status' => 'Diterima']);
                $this->unboxing->updateUnboxing($id, [
                    'tanggal_diterima' => $tanggalDiterima,
                    'link_file' => $response->json('fileUrl'), 
                    'status' => 'Diterima']);

                $this->transaction->commitTransaction();

                return ['status' => 'success', 'message' => 'Berhasil melakukan proses unboxing'];
            } else {
                $this->transaction->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Terjadi kesalahan ketika upload file.'];
            }

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}