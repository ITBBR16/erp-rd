<?php

namespace App\Services\logistik;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Repositories\umum\UmumRepository;
use App\Repositories\logistik\repository\LogistikRequestPackingRepository;
use App\Repositories\logistik\repository\LogistikTransactionRepository;
use Exception;
use Illuminate\Http\Request;

class LogistikServices
{
    public function __construct(
        private UmumRepository $umum,
        private LogistikTransactionRepository $logTransaction,
        private LogistikRequestPackingRepository $reqPacking,
    ){}

    // List Request Packing
    public function indexLRP()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataRequest = $this->reqPacking->getDataRequest()->filter(function ($item) {
            return $item->status_request === 'Request Packing';
        });

        return view('logistik.lrp.list-request-packing', [
            'title' => 'List Request Packing',
            'active' => 'lrp',
            'divisi' => $divisiName,
            'dataRequest' => $dataRequest
        ]);
    }

    public function previewLabel($encryptId)
    {
        $id = decrypt($encryptId);
        $dataReq = $this->reqPacking->findDataRequest($id);
        $namaCustomer = $dataReq->customer->first_nama . ($dataReq->customer->last_nama ?? '') . ' - ' . $dataReq->customer->id;
        $noTelponCustomer = $dataReq->customer->no_telpon;
        $alamatCustomer = $dataReq->customer->nama_jalan 
                            . ',' . $dataReq->customer->provinsi->name
                            . ',' . $dataReq->customer->kota->name
                            . ',' . $dataReq->customer->kecamatan->name
                            . ',' . $dataReq->customer->kelurahan->name
                            . ',' . $dataReq->customer->kode_pos;

        $dataString = "Nama: $namaCustomer\nNo Telpon: $noTelponCustomer\nAlamat: $alamatCustomer";
        $barcodeUrl = 'https://quickchart.io/chart?cht=qr&chl=' . urlencode($dataString);
        $dataView = [
            'dataReq' => $dataReq,
            'barcode' => $barcodeUrl,
            'alamat' => $alamatCustomer
        ];
        
        $pdf = Pdf::loadView('logistik.lrp.label.preview-label-packing', $dataView)
                    ->setPaper('a5', 'landscape');
        
        return $pdf;
    }

    public function storeLRP(Request $request)
    {
        try {
            $this->logTransaction->beginTransaction();

            $idPacking = $request->input('id_request');
            $this->reqPacking->updateRequestPacking($idPacking, ['status_request' => 'Belum Pickup']);

            $this->logTransaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil update data packing.'];
        } catch (Exception $e) {
            $this->logTransaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // I Req Packing
    public function indexFRP()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);

        return view('logistik.req-packing.index', [
            'title' => 'Form Request Packing',
            'active' => 'frp',
            'divisi' => $divisiName,
        ]);
    }

    // Pickup & Input Resi
    public function indexPIR()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataRequest = $this->reqPacking->getDataRequest()->filter(function ($item) {
            return $item->status_request === 'Belum Pickup';
        });
        $ekspedisis = $this->reqPacking->getEkspedisi();

        return view('logistik.unpicked.index', [
            'title' => 'Form Request Packing',
            'active' => 'pir',
            'divisi' => $divisiName,
            'dataRequest' => $dataRequest,
            'ekspedisis' => $ekspedisis,
        ]);
    }

    public function getDataByEkspedisi($status, $id)
    {
        $statusReq = ($status == 'form-pickup') ? 'Belum Pickup' : 'Belum Ada Resi';

        $dataRequest = $this->reqPacking->getDataRequest()
            ->where('status_request', $statusReq)
            ->filter(function ($item) use ($id) {
                return optional($item->layananEkspedisi)->ekspedisi?->id == $id;
            })
            ->values();
        $dataRequest->load('customer');

        return response()->json($dataRequest);
    }

}