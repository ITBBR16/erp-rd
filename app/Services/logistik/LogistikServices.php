<?php

namespace App\Services\logistik;

use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Repositories\umum\UmumRepository;
use App\Models\management\AkuntanDaftarAkun;
use App\Repositories\logistik\repository\LogistikTransactionRepository;
use App\Repositories\logistik\repository\LogistikRequestPackingRepository;
use Illuminate\Support\Facades\Http;

class LogistikServices
{
    public function __construct(
        private UmumRepository $umum,
        private LogistikTransactionRepository $logTransaction,
        private LogistikRequestPackingRepository $reqPacking,
        private AkuntanDaftarAkun $daftarAkun
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

        $customer = $dataReq->customer ?? null;

        $namaCustomer = ($customer->first_nama ?? '') . ' ' . ($customer->last_nama ?? '') . ' - ' . ($customer->id ?? '');
        $noTelponCustomer = $customer->no_telpon ?? '';
        
        $alamatCustomer = ($customer->nama_jalan ?? '') 
                            . ',' . ($customer->provinsi->name ?? '')
                            . ',' . ($customer->kota->name ?? '')
                            . ',' . ($customer->kecamatan->name ?? '')
                            . ',' . ($customer->kelurahan->name ?? '')
                            . ',' . ($customer->kode_pos ?? '');

        $alamatCustomer = trim(preg_replace('/,+/', ',', $alamatCustomer), ',');

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
                
                foreach ($checkboxResi as $resi) {
                    $noResi = $request->input("no_resi.$resi") ?: '';
                
                    if ($noResi == '') {
                        $this->logTransaction->rollbackTransaction();
                        return ['status' => 'error', 'message' => 'Pada pilihan data terdapat resi yang kosong.'];
                    }
                
                    $nominalOngkir = preg_replace("/[^0-9]/", "", $request->input("nominal_ongkir.$resi") ?: 0);
                    $nominalPacking = preg_replace("/[^0-9]/", "", $request->input("nominal_packing.$resi") ?: 0);
                
                    $dataResi = [
                        'no_resi' => $noResi,
                        'biaya_ekspedisi_ongkir' => $nominalOngkir,
                        'biaya_ekspedisi_packing' => $nominalPacking,
                        'status_request' => 'Menunggu Request Pembayaran'
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

    // Request Payment
    public function indexRP()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataRequest = $this->reqPacking->getDataRequest()->filter(function ($item) {
            return $item->status_request === 'Menunggu Request Pembayaran';
        });
        $ekspedisis = $this->reqPacking->getEkspedisi();
        $daftarAkun = $this->daftarAkun->where('kode_akun', 'like', '111%')->get();

        return view('logistik.req-payment.index', [
            'title' => 'Request Payment',
            'active' => 'rp',
            'divisi' => $divisiName,
            'dataRequest' => $dataRequest,
            'ekspedisis' => $ekspedisis,
            'daftarAkun' => $daftarAkun
        ]);
    }

    public function storeReqPayment(Request $request)
    {
        try {
            $this->logTransaction->beginTransaction();

            $invoice = $request->input('invoice_logistik');
            $invoiceEkternal = $request->input('invoice_eksternal');
            $ekspedisiId = $request->input('ekspedisi_id');
            $namaEkspedisi = $this->reqPacking->findEkspedisi($ekspedisiId);

            $paymentEkspedisi = $request->input('payment_ekspedisi');
            $biayaLainLain = preg_replace("/[^0-9]/", "", $request->input("biaya_lain_lain") ?: 0);
            $keteranganPayment = $request->input('keterangan_payment');
            $checkboxPayment = $request->input('check_box_payment');
            $totalPembayaran = 0;

            $ongkirChecked = $request->has('check_box_ongkir');
            $packingChecked = $request->has('check_box_packing');

            foreach ($checkboxPayment as $payment) {
                $nominalOngkir = preg_replace("/[^0-9]/", "", $request->input("nominal_ongkir.$payment") ?: 0);
                $nominalPacking = preg_replace("/[^0-9]/", "", $request->input("nominal_packing.$payment") ?: 0);
                $nominalAsuransi = preg_replace("/[^0-9]/", "", $request->input("nominal_asuransi.$payment") ?: 0);

                $dataRequest = $this->reqPacking->findDataRequest($payment);

                $biayaPackingAwal = $dataRequest->biaya_ekspedisi_packing ?? 0;
                $biayaOngkirAwal = $dataRequest->biaya_ekspedisi_ongkir ?? 0;

                $statusUpdated = false;

                // Jika biaya ongkir diinput
                if ($ongkirChecked) {
                    $dataResi = ['biaya_ekspedisi_ongkir_akhir' => $nominalOngkir];
                    $this->reqPacking->updateRequestPacking($payment, $dataResi);
                    $totalPembayaran += $nominalOngkir + $nominalAsuransi;

                    // Cek kondisi khusus untuk status
                    if (($biayaPackingAwal > 0 && $nominalPacking > 0) || ($biayaPackingAwal <= 0)) {
                        $statusUpdated = true;
                    }
                }

                // Jika biaya packing diinput
                if ($packingChecked) {
                    $dataResi = ['biaya_ekspedisi_packing_akhir' => $nominalPacking];
                    $this->reqPacking->updateRequestPacking($payment, $dataResi);
                    $totalPembayaran += $nominalPacking;

                    // Cek kondisi khusus untuk status
                    if ($biayaOngkirAwal <= 0) {
                        $statusUpdated = true;
                    }
                }

                // Jika keduanya diinput, selalu ubah status
                if ($ongkirChecked && $packingChecked) {
                    $statusUpdated = true;
                }

                if ($statusUpdated) {
                    $this->reqPacking->updateRequestPacking($payment, ['status_request' => 'Done Payment']);
                }
            }            

            $files = [];

            if ($request->hasFile('file_bukti_transaksi')) {
                foreach ($request->file('file_bukti_transaksi') as $file) {
                    if ($file->isValid()) {
                        $files[] = base64_encode(file_get_contents($file->getRealPath()));
                    }
                }
            } else {
                $this->logTransaction->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Files tidak teridentifikasi.'];
            }

            $totalPayment = $totalPembayaran + $biayaLainLain;
            $namaAkun = $this->daftarAkun->find($paymentEkspedisi);
            $payload = [
                'idInternal' => $invoice,
                'idEksternal' => $invoiceEkternal,
                'idCustomer' => $namaEkspedisi->ekspedisi,
                'inOut' => 'out',
                'source' => 'Logistik',
                'metodePembayaran' => $namaAkun->nama_akun,
                'totalPayment' => $totalPayment,
                'nilaiOngkir' => $totalPembayaran,
                'keterangan' => $keteranganPayment,
                'biayaLainLain' => $biayaLainLain,
                'files' => $files,
            ];

            $urlFinance = 'https://script.google.com/macros/s/AKfycbwVeUQ7qmpUypB8g-bukUFTpHWXjstgvpWGxY7l9-IMOdyyVQKlykg72nXzLDAveOaJtw/exec';
            $responseFinance = Http::post($urlFinance, $payload);

            if ($responseFinance->successful()) {
                $this->logTransaction->commitTransaction();
                return ['status' => 'success', 'message' => 'Berhasil melakukan request payment.'];
            } else {
                $this->logTransaction->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Terjadi kesalahan ketika menghubungkan dengan finance. Error: '];
            }

        } catch (Exception $e) {
            $this->logTransaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getDataReqPayment($id)
    {
        $dataRequest = $this->reqPacking->getDataRequest()
            ->where('status_request', 'Menunggu Request Pembayaran')
            ->filter(function ($item) use ($id) {
                return optional($item->layananEkspedisi)->ekspedisi?->id == $id;
            })
            ->values();

        return response()->json($dataRequest);
    }

}