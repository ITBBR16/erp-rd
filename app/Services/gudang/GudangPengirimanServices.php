<?php

namespace App\Services\gudang;

use App\Repositories\gudang\repository\GudangBelanjaRepository;
use App\Repositories\gudang\repository\GudangPengirimanRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\gudang\repository\GudangUnboxingRepository;
use App\Repositories\umum\UmumRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class GudangPengirimanServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private GudangPengirimanRepository $pengiriman,
        private GudangBelanjaRepository $belanja,
        private GudangUnboxingRepository $unboxing,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $listPengiriman = $this->pengiriman->getPengiriman()->sortByDesc('id');
        $listBelanja = $this->belanja->indexBelanja();
        $filterBelanja = $listBelanja->whereNotIn('status', ['Menunggu Konfirmasi Belanja', 'Waiting Payment', 'Received']);
        
        return view('gudang.purchasing.pengiriman.pengiriman', [
            'title' => 'Gudang Pengiriman',
            'active' => 'gudang-pengiriman',
            'navActive' => 'purchasing',
            'divisi' => $divisiName,
            'listPengiriman' => $listPengiriman,
            'filterBelanja' => $filterBelanja,
        ]);
    }

    public function addResiPembelanjaan($id, Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            $employeeId = auth()->user()->id;
            $dateToday = Carbon::today()->format('Y-m-d');
            $status = 'Process Shipping';
            $belanjaId = $request->input('belanja_id');

            $dataResi = [
                'tanggal_pengiriman' => $dateToday,
                'no_resi' => $request->input('no_resi'),
                'status' => $status
            ];

            $dataUnboxing = [
                'employee_id' => $employeeId,
                'gudang_belanja_id' => $belanjaId,
                'gudang_pengiriman_id' => $id,
                'status' => $status,
            ];

            $dataBelanja = ['status' => $status];
            $belanja = $this->belanja->findBelanja($belanjaId);
            if (!$belanja) {
                throw new \Exception("Belanja not found.");
            }
            $belanja->update($dataBelanja);

            $this->pengiriman->updatePengiriman($id, $dataResi);
            $this->unboxing->createUnboxing($dataUnboxing);
            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil menambahkan resi.'];
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function resiTambahan(Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            $tanggalInput = $request->input('tanggal_dikirim');
            $tanggal = Carbon::createFromFormat('m/d/Y', $tanggalInput)->format('Y-m-d');
            $status = 'Process Shipping';

            $dataResi = [
                'gudang_belanja_id' => $request->input('order_id'),
                'tanggal_pengiriman' => $tanggal,
                'no_resi' => $request->input('new_resi'),
                'keterangan' => $request->input('keterangan'),
                'status' => $status
            ];

            $this->pengiriman->createPengiriman($dataResi);
            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil menambahkan resi baru.'];
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}