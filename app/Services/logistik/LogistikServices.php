<?php

namespace App\Services\logistik;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Repositories\umum\UmumRepository;
use App\Repositories\logistik\repository\LogistikRequestPackingRepository;

class LogistikServices
{
    public function __construct(
        private UmumRepository $umum,
        private LogistikRequestPackingRepository $reqPacking,
    ){}

    // List Request Packing
    public function indexLRP()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataRequest = $this->reqPacking->getDataRequest();

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
        $dataRequest = $this->reqPacking->getDataRequest();

        return view('logistik.unpicked.index', [
            'title' => 'Form Request Packing',
            'active' => 'pir',
            'divisi' => $divisiName,
            'dataRequest' => $dataRequest
        ]);
    }
}