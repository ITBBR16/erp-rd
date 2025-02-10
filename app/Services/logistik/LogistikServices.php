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
            return $item->status_request === 'Belum Pickup' || $item->status_request === 'Belum Ada Resi';
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

    public function storePIR(Request $request)
    {
        try {
            $this->logTransaction->beginTransaction();

            $timeStamps = now();
            $jenisForm = $request->input('option_jenis_form');

            if ($jenisForm == 'form-pickup') {
                $checkboxPickup = $request->input('checkbox_select_pickup', []);

                foreach ($checkboxPickup as $pickUp) {
                    $dataPickup = [
                        'tanggal_pickup' => $timeStamps,
                        'status_request' => 'Belum Ada Resi',
                    ];
                    $this->reqPacking->updateRequestPacking($pickUp, $dataPickup);
                }

                $this->logTransaction->commitTransaction();
                return ['status' => 'success', 'message' => 'Berhasil update data menunggu resi.'];

            } elseif ($jenisForm == 'form-input-resi') {
                $checkboxResi = $request->input('checkbox_select_resi', []);
                
                foreach ($checkboxResi as $index => $resi) {
                    $noResi = $request->input('no_resi')[$index] ?? '';
                    $nominalOngkir = preg_replace("/[^0-9]/", "", $request->input('nominal_ongkir')[$index] ?? 0);
                    $nominalPacking = preg_replace("/[^0-9]/", "", $request->input('nominal_packing')[$index] ?? 0);

                    $dataResi = [
                        'no_resi' => $noResi,
                        'biaya_ekspedisi_ongkir' => $nominalOngkir,
                        'biaya_ekspedisi_packing' => $nominalPacking,
                        'status_request' => ''
                    ];
                    $this->reqPacking->updateRequestPacking($resi, $dataResi);
                }

                $this->logTransaction->commitTransaction();
                return ['status' => 'success', 'message' => 'Berhasil update data menunggu request pembayaran.'];
            } else {
                $this->logTransaction->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Jenis form tidak teridentifikasi.'];
            }

        } catch (Exception $e) {
            $this->logTransaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
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