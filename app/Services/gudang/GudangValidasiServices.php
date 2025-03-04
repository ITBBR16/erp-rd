<?php

namespace App\Services\gudang;

use App\Models\gudang\GudangProduk;
use App\Repositories\gudang\repository\GudangBelanjaRepository;
use App\Repositories\gudang\repository\GudangKomplainRepository;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\umum\UmumRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\gudang\repository\GudangProdukRepository;
use App\Repositories\gudang\repository\GudangQualityControllRepository;

class GudangValidasiServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private GudangQualityControllRepository $validasi,
        private GudangProdukIdItemRepository $idItem,
        private GudangKomplainRepository $komplain,
        private GudangBelanjaRepository $belanja,
        private GudangProdukRepository $produk,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $listValidasi = $this->idItem->getListProdukIdItem();
        
        return view('gudang.receive-goods.validasi.list-validasi', [
            'title' => 'Gudang Validasi',
            'active' => 'gudang-validasi',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'listValidasi' => $listValidasi,
        ]);
    }

    public function validasiPage($idBelanja, $idProduk)
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataCekValidasi = $this->idItem->getProdukForQc($idBelanja, $idProduk);
        
        return view('gudang.receive-goods.validasi.edit.validasi', [
            'title' => 'Gudang Validasi',
            'active' => 'gudang-validasi',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'dataCekValidasi' => $dataCekValidasi,
            'idBelanja' => $idBelanja,
            'idProduk' => $idProduk
        ]);
    }

    public function createValidasi(Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            $picId = auth()->user()->id;
            $dateToday = Carbon::today()->format('Y-m-d');
            $cekValidasi = $request->input('cek_validasi');
            $belnajaId = $request->input('belanja_id');
            $sparepartId = $request->input('sparepart_id');

            $findProduk = $this->produk->findBySparepart($sparepartId);
            $findBelanja = $this->belanja->findBelanja($belnajaId);
            $findDetailBelanja = $this->belanja->getDetailBelanja($belnajaId, $findProduk->produk_sparepart_id);

            $statusProduk = ($findProduk->status == 'Not Ready') ? 'Ready' : $findProduk->status;
            $modalAwal = $findProduk->modal_awal;
            $hargaPcs = $findDetailBelanja->nominal_pcs;
            $totalQuantity = $findBelanja->total_quantity;
            $pcsOngkir = $findBelanja->total_ongkir / $totalQuantity;
            $pcsPajak = $findBelanja->total_pajak / $totalQuantity;
            $modalProduk = 0;

            foreach ($request->input('idItemId') as $index => $item) {

                $dataValidasi = [
                    'employee_validasi_id' => $picId,
                    'status_qc' => 'Tervalidasi',
                    'tanggal_validasi' => $dateToday,
                    'keterangan_validasi' => $request->input('keterangan')[$index],
                    'status_validasi' => $cekValidasi[$index]
                ];
                $this->validasi->updateQc($item, $dataValidasi);

                if ($cekValidasi[$index] === 'Pass') {
                    $this->idItem->updateIdItem($item, ['status_inventory' => 'Ready']);
                    $modalProduk += $hargaPcs + $pcsOngkir + $pcsPajak;
                    
                } elseif ($cekValidasi[$index] === 'Komplain') {
                    $dataKomplain = [
                        'gudang_quality_control_id' => $request->input('qc_id')[$index],
                        'status' => 'Pending'
                    ];

                    $this->komplain->createKomplain($dataKomplain);
                    $this->idItem->updateIdItem($item, ['status_inventory' => 'Komplain']);
                }
            }

            
            $allValidated = $findBelanja->gudangProdukIdItem()->get()->every(function ($idItem) {
                return $idItem->qualityControll()->get()->every(fn($qc) => !empty($qc->status_validasi));
            });

            if ($allValidated) {
                $findBelanja->update(['status' => 'Done']);
            }

            $totalModalAwal = $modalAwal + $modalProduk;
            $this->produk->updateByValidasi($sparepartId, ['modal_awal' => $totalModalAwal, 'status' => $statusProduk]);
            $this->transaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil melakukan validasi barang.'];

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

}