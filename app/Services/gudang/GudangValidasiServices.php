<?php

namespace App\Services\gudang;

use App\Repositories\gudang\repository\GudangBelanjaRepository;
use App\Repositories\gudang\repository\GudangKomplainRepository;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\umum\UmumRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
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
            'idBelanja' => $idBelanja
        ]);
    }

    public function createValidasi(Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            $picId = auth()->user()->id;
            $dateToday = Carbon::today()->format('Y-m-d');
            $cekValidasi = $request->input('cek_validasi');

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
                    
                } elseif ($cekValidasi[$index] === 'Komplain') {
                    $dataKomplain = [
                        'gudang_quality_control_id' => $request->input('qc_id')[$index],
                        'status' => 'Pending'
                    ];

                    $this->komplain->createKomplain($dataKomplain);
                    $this->idItem->updateIdItem($item, ['status_inventory' => 'Komplain']);
                }
            }

            $findBelanja = $this->belanja->findBelanja($request->input('belanja_id'));
            $allValidated = $findBelanja->gudangProdukIdItem()->get()->every(function ($idItem) {
                return $idItem->qualityControll()->get()->every(fn($qc) => !empty($qc->status_validasi));
            });

            if ($allValidated) {
                $findBelanja->update(['status' => 'Done']);
            }

            $this->transaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil melakukan validasi barang.'];

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

}