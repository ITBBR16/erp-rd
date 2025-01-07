<?php

namespace App\Services\gudang;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\umum\UmumRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\gudang\repository\GudangQualityControllRepository;

class GudangQCServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private GudangQualityControllRepository $qc,
        private GudangProdukIdItemRepository $idItem,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $listQcIdItem = $this->idItem->getListProdukIdItem();
        $groupedItems = $listQcIdItem->filter(function ($item) {
            return $item->qualityControll !== null;
        })->groupBy(function ($item) {
            return $item->gudang_belanja_id . '-' . $item->gudang_produk_id;
        });
        
        return view('gudang.receive-goods.quality-control.list-qc', [
            'title' => 'Gudang Quality Control',
            'active' => 'gudang-qc',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'listQcIdItem' => $groupedItems
        ]);
    }

    public function qcFisik($idBelanja, $idProduk)
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataCekFisik = $this->idItem->getProdukForQc($idBelanja, $idProduk);
        
        return view('gudang.receive-goods.quality-control.edit.qc-fisik', [
            'title' => 'Gudang Quality Control',
            'active' => 'gudang-qc',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'dataCekFisik' => $dataCekFisik,
            'idBelanja' => $idBelanja
        ]);
    }

    public function qcFungsional($idBelanja, $idProduk)
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataCekFungsional = $this->idItem->getProdukForQc($idBelanja, $idProduk);
        
        return view('gudang.receive-goods.quality-control.edit.qc-fungsional', [
            'title' => 'Gudang Quality Control',
            'active' => 'gudang-qc',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'dataCekFungsional' => $dataCekFungsional,
            'idBelanja' => $idBelanja
        ]);
    }

    public function createResultQcFisik(Request $request)
    {
        try {
            $this->transaction->beginTransaction();

            $picQc = auth()->user()->id;
            $dateToday = Carbon::today()->format('Y-m-d');
            $status = 'Menunggu Validasi';
            
            foreach ($request->input('idItemId') as $index => $idItem) {
                $dataQc = [
                    'employee_qc_id' => $picQc,
                    'checked_quantity' => $request->input('cek_qty')[$index],
                    'checked_fisik' => $request->input('cek_fisik')[$index],
                    'tanggal_qc_fisik' => $dateToday,
                    'status_qc' => $status,
                ];

                $this->qc->updateQc($idItem, $dataQc);

                $idItemUpdateData = ['status_inventory' => $status];
                if (!empty($request->input('serial_number')[$index])) {
                    $idItemUpdateData['serial_number'] = $request->input('serial_number')[$index];
                }
                $this->idItem->updateIdItem($idItem, $idItemUpdateData);
            }

            $this->transaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil melakukan quality control fisik.'];
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createResultQcFungsional(Request $request)
    {
        try {
            $this->transaction->beginTransaction();

            $picQc = auth()->user()->id;
            $dateToday = Carbon::today()->format('Y-m-d');

            foreach ($request->input('idItemId') as $index => $idItem) {
                $dataQc = [
                    'employee_qc_fungsional_id' => $picQc,
                    'checked_fungsional' => $request->input('cek_fungsional')[$index],
                    'keterangan_fungsional' => $request->input('keterangan')[$index],
                    'tanggal_qc_fungsional' => $dateToday,
                ];

                $this->qc->updateQc($idItem, $dataQc);
            }

            $this->transaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil melakukan quality control fungsional.'];

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}