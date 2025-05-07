<?php

namespace App\Services\logistik;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\customer\Customer;
use App\Models\divisi\Divisi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Repositories\umum\UmumRepository;
use App\Models\management\AkuntanDaftarAkun;
use App\Repositories\logistik\repository\EkspedisiRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;
use App\Repositories\logistik\repository\LogistikTransactionRepository;
use App\Repositories\logistik\repository\LogistikRequestPackingRepository;

class LogistikServices
{
    public function __construct(
        private UmumRepository $umum,
        private LogistikTransactionRepository $logTransaction,
        private LogistikRequestPackingRepository $reqPacking,
        private AkuntanDaftarAkun $daftarAkun,
        private RepairCustomerRepository $customerRepo,
        private EkspedisiRepository $ekspedisiRepo,
        private Divisi $divisi,
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

        if ($dataReq->divisi->nama == 'Logistik') {
            if ($dataReq->logCase->jenis_penerima == 'RD') {
                $customer = $dataReq->logCase->customer;

                $namaCustomer = ($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '') . ' - ' . ($customer->id ?? '');
                $noTelponCustomer = $customer->no_telpon ?? '';
                
                $alamatCustomer = ($customer->nama_jalan ?? '') 
                                    . ',' . ($customer->provinsi->name ?? '')
                                    . ',' . ($customer->kota->name ?? '')
                                    . ',' . ($customer->kecamatan->name ?? '')
                                    . ',' . ($customer->kelurahan->name ?? '')
                                    . ',' . ($customer->kode_pos ?? '');
        
                $alamatCustomer = trim(preg_replace('/,+/', ',', $alamatCustomer), ',');
            } else {
                $namaCustomer = $dataReq->logCase->logPenerima->nama;
                $noTelponCustomer = $dataReq->logCase->logPenerima->no_telpon;

                $alamatCustomer = ($dataReq->logCase->logPenerima->nama_jalan ?? '') 
                                    . ',' . ($dataReq->logCase->logPenerima->provinsi->name ?? '')
                                    . ',' . ($dataReq->logCase->logPenerima->kota->name ?? '')
                                    . ',' . ($dataReq->logCase->logPenerima->kecamatan->name ?? '')
                                    . ',' . ($dataReq->logCase->logPenerima->kelurahan->name ?? '')
                                    . ',' . ($dataReq->logCase->logPenerima->kode_pos ?? '');
                
                $alamatCustomer = trim(preg_replace('/,+/', ',', $alamatCustomer), ',');
            }
        } else {
            $customer = $dataReq->customer;
    
            $namaCustomer = ($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '') . ' - ' . ($customer->id ?? '');
            $noTelponCustomer = $customer->no_telpon ?? '';
            
            $alamatCustomer = ($customer->nama_jalan ?? '') 
                                . ',' . ($customer->provinsi->name ?? '')
                                . ',' . ($customer->kota->name ?? '')
                                . ',' . ($customer->kecamatan->name ?? '')
                                . ',' . ($customer->kelurahan->name ?? '')
                                . ',' . ($customer->kode_pos ?? '');
    
            $alamatCustomer = trim(preg_replace('/,+/', ',', $alamatCustomer), ',');
        }

        $dataString = "Nama: $namaCustomer\nNo Telpon: $noTelponCustomer\nAlamat: $alamatCustomer";
        $barcodeUrl = 'https://quickchart.io/chart?cht=qr&chl=' . urlencode($dataString);

        $dataEkspedisi = $dataReq->layananEkspedisi->ekspedisi->ekspedisi;

        if ($dataEkspedisi == 'Lion Parcel') {
            $textEkspedisi = $dataEkspedisi . ', ' . $dataReq->layananEkspedisi->nama_layanan
                            . ($dataReq->biaya_customer_packing > 0 ? ', Pack Kayu' : '')
                            . (($dataReq->nominal_asuransi == 0) ? '' : ($dataReq->nominal_produk < 10000000 
                                ? ', RD' . substr($dataReq->nominal_produk, 0, 1) 
                                : ', RD' . substr($dataReq->nominal_produk, 0, 2)));

        } else {
            $textEkspedisi = $dataEkspedisi . ', ' . $dataReq->layananEkspedisi->nama_layanan;
        }

        $dataView = [
            'textEkspedisi' => $textEkspedisi,
            'barcode' => $barcodeUrl,
            'namaCustomer' => $namaCustomer,
            'noTelponCustomer' => $noTelponCustomer,
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
        $dataDivisi = $this->divisi->all();
        $divisiName = $this->umum->getDivisi($user);
        $dataProvinsi = $this->customerRepo->getProvinsi();
        $dataCustomer = $this->customerRepo->getDataCustomer();
        $dataEkspedisi = $this->ekspedisiRepo->getDataEkspedisi();
        $daftarAkun = $this->daftarAkun->where('kode_akun', 'like', '111%')->get();

        $dataCustomers = $dataCustomer->map(function ($customer) {
            return [
                'id' => $customer->id,
                'display' => "{$customer->first_name} {$customer->last_name} - {$customer->id}"
            ];
        });

        return view('logistik.req-packing.index', [
            'title' => 'Form Request Packing',
            'active' => 'frp',
            'divisi' => $divisiName,
            'dataProvinsi' => $dataProvinsi,
            'dataEkspedisi' => $dataEkspedisi,
            'dataCustomers' => $dataCustomers,
            'dataDivisi' => $dataDivisi,
            'daftarAkun' => $daftarAkun,
        ]);
    }

    public function storeReqPacking(Request $request)
    {
        try {

            $this->logTransaction->beginTransaction();

            $user = auth()->user();
            $employeeId = $user->id;
            $tanggalRequest = Carbon::now();
            $checkboxCustomer = $request->input('checkbox_customer');
            $nominalOngkir = preg_replace("/[^0-9]/", "",$request->input('nominal_ongkir')) ?: 0;
            $nominalPacking = preg_replace("/[^0-9]/", "",$request->input('nominal_packing')) ?: 0;
            $nominalAsuransi = preg_replace("/[^0-9]/", "",$request->input('nominal_asuransi')) ?: 0;

            if ($checkboxCustomer) {
                $dataCustomerNonRD = [
                    'nama' => $request->input('nama_penerima'),
                    'no_telpon' => $request->input('no_whatsapp'),
                    'provinsi_id' => $request->input('provinsi_customer'),
                    'kabupaten_kota_id' => $request->input('kota_kabupaten'),
                    'kecamatan_id' => $request->input('kecamatan'),
                    'kelurahan_id' => $request->input('kelurahan'),
                    'kode_pos' => $request->input('kode_pos'),
                    'nama_jalan' => $request->input('alamat'),
                ];

                $jenisPenerima = 'Non RD';
                $createPenerima = $this->reqPacking->createLogPenerima($dataCustomerNonRD);
                $idCustomer = $createPenerima->id;
            } else {
                $idCustomer = $request->input('customer_rd');
                $jenisPenerima = 'RD';
            }

            $dataLogCase = [
                'penerima_id' => $idCustomer,
                'asal_divisi_id' => $request->input('asal_divisi'),
                'jenis_pengiriman' => $request->input('jenis_pengiriman'),
                'jenis_penerima' => $jenisPenerima,
                'opsi_transaksi' => $request->input('opsi_transaksi'),
                'nama_akun_id' => $request->input('rekening_pembayaran'),
                'keterangan' => $request->input('keterangan'),
            ];

            $logCase = $this->reqPacking->createLogCase($dataLogCase);

            foreach ($request->input('nama_item') as $index => $item) {
                $dataKelengkapan = [
                    'log_case_id' => $logCase->id,
                    'nama_item' => $item,
                    'quantity' => $request->input("quantity")[$index],
                    'keterangan' => $request->input("keterangan_isi_paket")[$index] ?? '',
                ];

                $this->reqPacking->createLogKelengkapan($dataKelengkapan);
            }

            $dataRequestLogistik = [
                'employee_id' => $employeeId,
                'divisi_id' => 6,
                'source_id' => $logCase->id,
                'penerima_id' => $idCustomer,
                'layanan_id' => $request->input('layanan_ekspedisi'),
                'biaya_customer_ongkir' => $nominalOngkir,
                'biaya_customer_packing' => $nominalPacking,
                'nominal_produk' => 0,
                'nominal_asuransi' => $nominalAsuransi,
                'tipe_penerima' => 'Other',
                'tanggal_request' => $tanggalRequest,
                'status_request' => 'Request Packing',
            ];

            $this->reqPacking->createLogRequest($dataRequestLogistik);
            $this->logTransaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil menyimpan request packing.'];

        } catch (Exception $e) {
            Log::error('Error storing request packing: ' . $e->getMessage());
            $this->logTransaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
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
        $dataRequest->load('customer', 'divisi', 'logCase.customer', 'logCase.logPenerima', 'logPenerima');

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

    public function getCustomer($id)
    {
        $dataCustomer = Customer::where('id', $id)->get();
        return response()->json($dataCustomer);
    }

    public function getLayanan($id)
    {
        return $this->ekspedisiRepo->getDataLayanan($id);
    }

}