<?php

namespace App\Services\gudang;

use App\Models\gudang\GudangProdukIdItem;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\repair\repository\RepairEstimasiRepository;
use App\Repositories\umum\UmumRepository;
use Exception;
use Illuminate\Http\Request;

class GudangKonfirmasiPengirimanServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private RepairCaseRepository $repairCase,
        private RepairEstimasiRepository $repairEstimasi,
        private GudangProdukIdItem $produkIdITem,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $repairCase = $this->repairCase->getAllDataNeededNewCase();
        $case = $repairCase['data_case'];

        return view('gudang.distribusi-produk.konfirmasi.main-distribusi', [
            'title' => 'Gudang Konfirmasi',
            'active' => 'gudang-konfirmasi',
            'navActive' => 'distribusi',
            'divisi' => $divisiName,
            'repairCase' => $case
        ]);
    }

    public function pageKonfirmasi($encryptId)
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $id = decrypt($encryptId);
        $dataCase = $this->repairCase->findCase($id);

        return view('gudang.distribusi-produk.page.konfirmasi-sparepart', [
            'title' => 'Gudang Konfirmasi',
            'active' => 'gudang-konfirmasi',
            'navActive' => 'distribusi',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);
    }

    public function sendPart(Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            $this->repairCase->beginTransaction();

            $timeStamp = now();
            $idEstimasiPart = $request->input('id_estimasi_part');
            $barcodeScan = $request->input('scan_barcode');

            foreach ($idEstimasiPart as $index => $estimasi) {
                if (!empty($barcodeScan[$index])) {
                    $identity = explode('*', $barcodeScan[$index]);
                    $sku = trim($identity[0]);
                    $idItem = trim($identity[1]);

                    $dataEstimasiPart = [
                        'id_item' => $idItem,
                        'tanggal_dikirim' => $timeStamp
                    ];

                    $matchedProduct = $this->produkIdITem->where('sku_lama', 'LIKE', "%$sku%")->first();

                    if ($matchedProduct) {
                        $matchedProduct->update(['status_inventory' => 'Piutang']);
                        $this->repairEstimasi->updateEstimasiPart($dataEstimasiPart, $estimasi);
                    } else {
                        return ['status' => 'error', 'message' => "SKU $sku tidak ditemukan."];
                    }
                }
            }

            $this->transaction->commitTransaction();
            $this->repairCase->commitTransaction();

            return ['status' => 'success', 'message' => 'Sparepart berhasil dikirim.'];

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            $this->repairCase->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

}