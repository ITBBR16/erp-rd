<?php

namespace App\Services\repair;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Repositories\umum\UmumRepository;
use App\Models\customer\CustomerInfoPerusahaan;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\logistik\repository\EkspedisiRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;
use App\Repositories\repair\repository\RepairEstimasiRepository;
use App\Repositories\repair\repository\RepairTimeJurnalRepository;

class RepairCaseService
{
    public function __construct(
        private UmumRepository $umum,
        private RepairCustomerRepository $customerRepository,
        private RepairCaseRepository $repairCase,
        private ProdukRepository $product,
        private RepairTimeJurnalRepository $repairTimeJurnal,
        private EkspedisiRepository $ekspedisi,
        private RepairEstimasiRepository $estimasi)
    {}

    // Input New Case
    public function indexNewCase()
    {
        $user = auth()->user();
        $caseService = $this->getDataDropdown();
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $caseService['data_case'];
        $dataCustomer = collect($caseService['data_customer'])->sortByDesc('id');
        $dataCustomers = $dataCustomer->map(function ($customer) {
            return [
                'id' => $customer->id,
                'display' => "{$customer->first_name} {$customer->last_name} - {$customer->id}"
            ];
        });
        $dataProvinsi = $caseService['data_provinsi'];
        $dataJenisCase = $caseService['jenis_case'];
        $jenisDrone = $caseService['jenis_drone'];
        $dataJenisDrone = $jenisDrone->map(function ($jenis) {
            return [
                'id' => $jenis->id,
                'display' => $jenis->jenis_produk,
            ];
        });
        $dataFungsionalDrone = $caseService['fungsional_drone'];
        $infoPerusahaan = CustomerInfoPerusahaan::all();

        return view('repair.csr.case-list', [
            'title' => 'Case List',
            'active' => 'list-case',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'dataCustomers' => $dataCustomers,
            'dataProvinsi' => $dataProvinsi,
            'infoPerusahaan' => $infoPerusahaan,
            'jenisCase' => $dataJenisCase,
            'jenisDrone' => $dataJenisDrone,
            'fungsionalDrone' => $dataFungsionalDrone,
        ]);
    }

    public function editNewCase($encryptId)
    {
        $user = auth()->user();
        $id = decrypt($encryptId);
        $caseService = $this->getDataDropdown();
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $this->findCase($id);
        $dataProvinsi = $caseService['data_provinsi'];
        $dataJenisCase = $caseService['jenis_case'];
        $dataJenisDrone = $caseService['jenis_drone'];
        $dataFungsionalDrone = $caseService['fungsional_drone'];
        $infoPerusahaan = CustomerInfoPerusahaan::all();

        return view('repair.csr.edit.edit-list-case', [
            'title' => 'Edit Case List',
            'active' => 'list-case',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'dataProvinsi' => $dataProvinsi,
            'infoPerusahaan' => $infoPerusahaan,
            'jenisCase' => $dataJenisCase,
            'jenisDrone' => $dataJenisDrone,
            'fungsionalDrone' => $dataFungsionalDrone,
        ]);
    }

    public function getDataDropdown()
    {
        $dataDD = $this->repairCase->getAllDataNeededNewCase();
        return [
            'data_customer' => $this->customerRepository->getDataCustomer(),
            'data_provinsi' => $this->customerRepository->getProvinsi(),
            'jenis_drone' => $this->product->getAllJenisProduct(),
            'fungsional_drone' => $dataDD['fungsional_drone'],
            'jenis_case' => $dataDD['jenis_case'],
            'data_case' => $dataDD['data_case'],
        ];
    }

    public function findCase($id)
    {
        return $this->repairCase->findCase($id);
    }

    public function createNewCase(Request $request)
    {
        $this->repairCase->beginTransaction();
        $employeeId = auth()->user()->id;

        try {
            $customerId = $request->input('case_customer');
            $jenisDroneId = $request->input('case_jenis_drone');
            $fungsionalDroneId = $request->input('case_fungsional');
            $jenisCaseId = $request->input('case_jenis');

            $keluhan = $request->input('case_keluhan');
            $kronologiKerusakan = $request->input('case_kronologi');
            $penggunaanAfterCrash = $request->input('case_penggunaan');
            $riwayatPengguna = $request->input('case_riwayat');

            $dataKelengkapan = $request->input('case_kelengkapan');
            $dataQty = $request->input('case_quantity');
            $dataSN = $request->input('case_sn');
            $dataKeterangan = $request->input('case_keterangan');

            $dataInput = [
                'produk_jenis_id' => $jenisDroneId,
                'jenis_fungsional_id' => $fungsionalDroneId,
                'jenis_status_id' => 1,
                'jenis_case_id' => $jenisCaseId,
                'employee_id' => $employeeId,
                'customer_id' => $customerId,
                'keluhan' => $keluhan,
                'kronologi_kerusakan' => $kronologiKerusakan,
                'penanganan_after_crash' => $penggunaanAfterCrash,
                'riwayat_penggunaan' => $riwayatPengguna,
            ];

            $newCase = $this->repairCase->createNewCase($dataInput);

            $dataCustomer = $this->customerRepository->findCustomer($customerId);
            $dataProduct = $this->product->findJenisProduct($jenisDroneId);
            $urlCreateFolder = 'https://script.google.com/macros/s/AKfycbx4BPCbG9OiQvlilMHQrlQXs-d3mytuJ5qFPf4zBhqjvmtYo3tEFMYBQ2JZndR49Dw3/exec';
            $response = Http::post($urlCreateFolder, [
                'nama' => $dataCustomer->first_name . '-' . $dataCustomer->last_name,
                'jenisDrone' => $dataProduct->jenis_produk,
                'noInvoice' => 'R' . $newCase->id,
            ]);

            $decodePayloads = json_decode($response->body(), true);
            $status = $decodePayloads['status'];
            $linkDoc = $decodePayloads['folderUrl'];

            if ($status === 'success') {
                $this->repairCase->updateCase($newCase->id, ['link_doc' => $linkDoc]);

                $dataToDetailKelengkapan = [];
                foreach ($dataKelengkapan as $index => $kelengkapan) {
                    $dataToDetailKelengkapan[] = [
                        'case_id' => $newCase->id,
                        'item_kelengkapan_id' => $kelengkapan,
                        'quantity' => $dataQty[$index],
                        'serial_number' => $dataSN[$index],
                        'keterangan' => $dataKeterangan[$index],
                    ];
                }

                $this->repairCase->createDetailKelengkapan($dataToDetailKelengkapan);

                $this->repairCase->commitTransaction();
                return ['status' => 'success', 'message' => 'Berhasil membuat case baru.'];
            } else {
                $this->repairCase->rollBackTransaction();
                return ['status' => 'error', 'message' => 'Terjadi kesalahan silahkan coba lagi.'];
            }

        } catch (Exception $e) {
            $this->repairCase->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function reviewPdfTandaTerima($id)
    {
        $user = auth()->user();
        $employee = $user->first_name . " " . $user->last_name;
        $dataCase = $this->repairCase->findCase($id);
        $dataView = [
            'title' => 'Preview Tanda Terima',
            'case' => $dataCase,
            'employee' => $employee,
        ];

        $pdf = Pdf::loadView('repair.csr.preview.preview-tt', $dataView)
                    ->setPaper('a5', 'portrait');

        return $pdf;
    }

    public function downloadPdfTandaTerima($id)
    {
        $user = auth()->user();
        $employee = $user->first_name . " " . $user->last_name;
        $dataCase = $this->repairCase->findCase($id);
        $namaCustomer = $dataCase->customer->first_name . " " . $dataCase->customer->last_name . "-" . $dataCase->customer->id . "-" . $id;
        $dataView = [
            'title' => 'Tanda Terima',
            'case' => $dataCase,
            'employee' => $employee,
        ];

        $pdf = Pdf::loadView('repair.csr.preview.preview-tt', $dataView)
                    ->setPaper('a5', 'portrait');

        return ['pdf' => $pdf, 'namaCustomer' => $namaCustomer];
    }

    public function kirimTandaTerimaCustomer($id)
    {
        try {
            $user = auth()->user();
            $employee = $user->first_name . " " . $user->last_name;
            $dataCase = $this->repairCase->findCase($id);

            if (!$dataCase || !$dataCase->customer) {
                throw new Exception('Data case atau customer tidak ditemukan.');
            }

            $greeting = $this->showTimeForChat();
            $namaCustomer = "{$dataCase->customer->first_name} {$dataCase->customer->last_name}-{$dataCase->customer->id}-{$id}";
            $linkDrive = $dataCase->link_doc;
            $notelpon = 6285156519066; //$dataCase->customer->no_telpon

            $tanggalMasuk = Carbon::parse($dataCase->created_at)->isoFormat('D MMMM YYYY');
            $namaReal = $dataCase->customer->first_name . " " . $dataCase->customer->last_name;
            $pesan = "{$greeting} {$namaReal}\nBerikut adalah invoice tanda terima untuk transaksi pada tanggal {$tanggalMasuk}.";

            $dataView = [
                'title' => 'Tanda Terima',
                'case' => $dataCase,
                'employee' => $employee,
            ];

            $pdf = Pdf::loadView('repair.csr.preview.preview-tt', $dataView)
                        ->setPaper('a5', 'portrait');
            $pdfContent = $pdf->output();
            $pdfEncode = base64_encode($pdfContent);

            $payload = [
                'nama_customer' => $namaCustomer,
                'link_drive' => $linkDrive,
                'pesan' => $pesan,
                'pdf' => $pdfEncode,
                'no_telpon' => $notelpon,
            ];

            $url = 'https://script.google.com/macros/s/AKfycbw27RdAKxTIrfoCVCsZtXfZwJqz4uEL92BL-KA_pXtkjyI-2fb-1evPXTfpYoIF1Fblrw/exec';
            $response = Http::post($url, $payload);

            if ($response->failed()) {
                throw new Exception('Gagal mengirim tanda terima. Error: ' . $response->body());
            }

            return ['status' => 'success', 'message' => 'Tanda terima berhasil dikirim.'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Konfirmasi QC
    public function indexKonfirmasiQC()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $caseService = $this->getDataDropdown();
        $dataCase = $caseService['data_case'];

        return view('repair.csr.konfirmasi-qc', [
            'title' => 'Konfirmasi QC',
            'active' => 'konf-qc',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);
    }

    public function sendKonfirmasiQC($id)
    {
        try {
            $user = auth()->user();
            $employee = $user->first_name . " " . $user->last_name;
            $dataCase = $this->repairCase->findCase($id);

            if (!$dataCase || !$dataCase->customer) {
                throw new Exception('Data case atau customer tidak ditemukan.');
            }

            $greeting = $this->showTimeForChat();
            $namaCustomer = "{$dataCase->customer->first_name} {$dataCase->customer->last_name}-{$dataCase->customer->id}-{$id}";
            $linkDrive = $dataCase->link_doc;
            $notelpon = 6285156519066; //$dataCase->customer->no_telpon

            $namaReal = $dataCase->customer->first_name . " " . $dataCase->customer->last_name;
            $pesan = "{$greeting} {$namaReal}\nBerikut adalah hasil quality control : ";

            $dataView = [
                'title' => 'Tanda Terima',
                'case' => $dataCase,
                'employee' => $employee,
            ];

            $pdf = Pdf::loadView('repair.csr.preview.preview-qc', $dataView);
            $pdfContent = $pdf->output();
            $pdfEncode = base64_encode($pdfContent);

            $payload = [
                'nama_customer' => $namaCustomer,
                'link_drive' => $linkDrive,
                'pesan' => $pesan,
                'pdf' => $pdfEncode,
                'no_telpon' => $notelpon,
            ];

            $url = 'https://script.google.com/macros/s/AKfycbw3dvbe6445EH1suz3tiLmHxM823CQd9P6Yj_ZeR8QpmYRVjVewgxz0nlm14NeHKwWq7w/exec';
            $response = Http::post($url, $payload);

            if ($response->failed()) {
                throw new Exception('Gagal mengirim hasil quality control. Error: ' . $response->body());
            }

            return ['status' => 'success', 'message' => 'Hasil quality control berhasil dikirim.'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function konfirmasiQc($id)
    {
        $this->repairCase->beginTransaction();
        $employeeId = auth()->user()->id;

        try {
            $tglWaktu = Carbon::now();
            
            $dataTimestamp = [
                'case_id' => $id,
                'jenis_status_id' => 9,
                'tanggal_waktu' => $tglWaktu,
            ];
            $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 1,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Sudah konfirmasi QC Menunggu Pembayaran',
            ];
            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $dataUpdateCase = ['jenis_status_id' => 9];
            $this->repairCase->updateCase($id, $dataUpdateCase);

            $this->repairCase->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil pindah status to menunggu pembayaran.'];

        } catch (Exception $e) {
            $this->repairCase->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Kasir
    public function indexKasir()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataProvinsi = $this->customerRepository->getProvinsi();
        $caseService = $this->getDataDropdown();
        $dataEkspedisi = $this->ekspedisi->getDataEkspedisi();
        $dataCase = $caseService['data_case'];

        return view('repair.csr.kasir-repair', [
            'title' => 'List Kasir Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataProvinsi' => $dataProvinsi,
            'dataCase' => $dataCase,
            'dataEkspedisi' => $dataEkspedisi,
        ]);
    }

    public function pagePelunasan($id)
    {
        $user = auth()->user();
        $idCase = decrypt($id);
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $this->findCase($idCase);
        $daftarAkun = $this->getDataAkun();

        return view('repair.csr.edit.kasir-pelunasan', [
            'title' => 'Kasir Pelunasan Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'daftarAkun' => $daftarAkun,
        ]);
    }

    public function pageDp($encryptId)
    {
        $user = auth()->user();
        $idCase = decrypt($encryptId);
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $this->findCase($idCase);
        $daftarAkun = $this->getDataAkun();

        return view('repair.csr.edit.kasir-dp', [
            'title' => 'Kasir DP Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'daftarAkun' => $daftarAkun,
        ]);
    }

    public function createOngkirKasir(Request $request, $id)
    {
        $this->ekspedisi->beginTransaction();
        $this->customerRepository->beginTransaction();
        $tanggalRequest = Carbon::now();

        try {

            $user = auth()->user();
            $employeeId = $user->id;
            $divisiId = $user->divisi_id;
            $checkboxCustomer = $request->has('checkbox_customer_kasir');

            $layananEkspedisi = $request->input('layanan_ongkir_repair');
            $nominalOngkir = preg_replace("/[^0-9]/", "",$request->input('nominal_ongkir_repair')) ?? 0;
            $nominalPacking = preg_replace("/[^0-9]/", "",$request->input('nominal_packing_repair')) ?? 0;
            $nominalProduk = preg_replace("/[^0-9]/", "",$request->input('nominal_produk')) ?? 0;
            $nominalAsuransi = preg_replace("/[^0-9]/", "",$request->input('nominal_asuransi')) ?? 0;

            if ($checkboxCustomer) {
                $tipePenerima = 'Other';
                $dataPenerima = [
                    'nama' => $request->input('nama_penerima'),
                    'no_telpon' => $request->input('no_telpon'),
                    'provinsi_id' => $request->input('provinsi_penerima'),
                    'kabupaten_kota_id' => $request->input('kota_penerima'),
                    'kecamatan_id' => $request->input('kecamatan_penerima'),
                    'kelurahan_id' => $request->input('kelurahan_penerima'),
                    'kode_pos' => $request->input('kode_pos_penerima'),
                    'nama_jalan' => $request->input('nama_jalan_penerima'),
                ];
        
                $resultPenerima = $this->ekspedisi->createLogPenerima($dataPenerima);
            } else {
                $tipePenerima = 'Customer';
                $customerId = $request->input('customer_id');
                $dataCustomer = [
                    'provinsi' => $request->input('provinsi_customer'),
                    'kota_kabupaten' => $request->input('kota_customer'),
                    'kecamtan' => $request->input('kecamatan_customer'),
                    'kelurahan' => $request->input('kelurahan_customer'),
                    'kedo_pos' => $request->input('kode_pos_customer'),
                    'nama_jalan' => $request->input('alamat_customer'),
                ];

                $resultPenerima = $this->customerRepository->updateCustomer($customerId, $dataCustomer);
            }

            $dataRequestLogistik = [
                'employee_id' => $employeeId,
                'divisi_id' => $divisiId,
                'source_id' => $id,
                'penerima_id' => $resultPenerima->id,
                'layanan_id' => $layananEkspedisi,
                'biaya_customer_ongkir' => $nominalOngkir,
                'biaya_customer_packing' => $nominalPacking,
                'nominal_produk' => $nominalProduk,
                'nominal_asuransi' => $nominalAsuransi,
                'tipe_penerima' => $tipePenerima,
                'tanggal_request' => $tanggalRequest,
                'status_request' => 'Request Packing',
            ];

            $this->ekspedisi->createLogRequest($dataRequestLogistik);
            $this->ekspedisi->commitTransaction();
            $this->customerRepository->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil menambahkan ongkir baru.'];

        } catch (Exception $e) {
            Log::error('Error menambahkan ongkir: ' . $e->getMessage());
            $this->ekspedisi->rollbackTransaction();
            $this->customerRepository->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createPembayaran(Request $request, $id)
    {
        $this->repairCase->beginTransaction();

        try {
            $employeeId = auth()->user()->id;
            $tglWaktu = Carbon::now();
            $folderAkuntan = Carbon::now()->format('F-Y');
            $metodePembayaran = $request->input('metode_pembayaran_pembayaran');
            $nominalPembayaran = preg_replace("/[^0-9]/", "", $request->input('nominal_pembayaran'));
            $linkDrive = $request->input('link_doc');
            $fileBukti = base64_encode($request->file('file_bukti_transaksi')->get());
            
            $checkTransaksi = $this->repairCase->findTransaksiByCase($id);

            if (!empty($checkTransaksi)) {
                $transaksi = $checkTransaksi;
                $totalPembayaran = $transaksi->total_pembayaran + $nominalPembayaran;
                $dataUpdateTransaksi = [
                    'total_pembayaran' => $totalPembayaran,
                ];

                $this->repairCase->updateTransaksi($transaksi->id, $dataUpdateTransaksi);
            } else {
                $dataTransaksi = [
                    'case_id' => $id,
                    'total_pembayaran' => $nominalPembayaran,
                    'status_pembayaran' => 'Belum Lunas',
                ];

                $transaksi = $this->repairCase->createTransaksi($dataTransaksi);
            }

            $dataCase = $this->repairCase->findCase($id);
            $namaCustomer = $dataCase->customer->first_name . "-" . $dataCase->customer->id;
            
            $dataView = [
                'title' => 'Preview Down Payment',
                'dataCase' => $dataCase,
            ];

            $pdf = Pdf::loadView('repair.csr.invoice.invoice-dp', $dataView);
            $pdfContent = $pdf->output();
            $pdfEncode = base64_encode($pdfContent);

            $payload = [
                'nama_customer' => $namaCustomer,
                'link_drive' => $linkDrive,
                'file' => $fileBukti,
                'pdf' => $pdfEncode,
                'status_payment' => 'DP',
                'folderAkuntan' => $folderAkuntan,
            ];


            $urlApi = 'https://script.google.com/macros/s/AKfycbxN1mlhPrtrnbyiWJSVdcA1YCkV6tBUhlSTcf9pQca4hKozqcwrrupxM_f0wJJrNh99kA/exec';
            $response = Http::post($urlApi, $payload);
            if ($response->successful()) {
                $dataResponse = $response->json();
                $statusResponse = $dataResponse['status'];
        
                if ($statusResponse === 'success') {
                    $fileMutasi = $dataResponse['fileMutasi'] ?? null;
                    
                    $dataPembayaran = [
                        'transaksi_id' => $transaksi->id,
                        'metode_pembayaran_id' => $metodePembayaran,
                        'employee_id' => $employeeId,
                        'jumlah_pembayaran' => $nominalPembayaran,
                        'link_bukti' => $fileMutasi,
                    ];

                    $checkTimestamp = $this->repairTimeJurnal->findTimestime($id, 9);
                    if ($checkTimestamp) {
                        $timestamp = $checkTimestamp;
                    } else {
                        $dataTimestamp = [
                            'case_id' => $id,
                            'jenis_status_id' => 9,
                            'tanggal_waktu' => $tglWaktu,
                        ];
            
                        $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);
                    }

                    $dataJurnal = [
                        'employee_id' => $employeeId,
                        'jenis_substatus_id' => 1,
                        'timestamps_status_id' => $timestamp->id,
                        'isi_jurnal' => 'Melakukan pembayaran Down Payment.',
                    ];
        
                    $this->repairTimeJurnal->addJurnal($dataJurnal);
        
                    $this->repairCase->createPembayaran($dataPembayaran);
                    $this->repairCase->commitTransaction();
                    
                    return ['status' => 'success', 'message' => 'Berhasil melakukan pembayaran.'];

                } else {
                    $this->repairCase->rollBackTransaction();
                    return [
                        'status' => 'error',
                        'message' => $dataResponse['message'] ?? 'Terjadi kesalahan'
                    ];
                }
            } else {
                $this->repairCase->rollBackTransaction();
                return [
                    'status' => 'error',
                    'message' => 'Gagal menghubungi Google App Script'
                ];
            }

        } catch (Exception $e) {
            $this->repairCase->rollBackTransaction();
            return ['status' => 'error' , 'message' => $e->getMessage()];
        }
    }

    public function createPelunasan(Request $request, $id)
    {
        $this->repairCase->beginTransaction();

        try {
            $employeeId = auth()->user()->id;
            $tglWaktu = Carbon::now();
            $folderAkuntan = Carbon::now()->format('F-Y');
            $metodePembayaran = $request->input('metode_pembayaran_pembayaran');
            $nominalPembayaran = preg_replace("/[^0-9]/", "", $request->input('sisa_tagihan'));
            $linkDrive = $request->input('link_doc');
            $fileBukti = base64_encode($request->file('file_bukti_transaksi')->get());
            
            $checkTransaksi = $this->repairCase->findTransaksiByCase($id);

            if (!empty($checkTransaksi)) {
                $transaksi = $checkTransaksi;
                $totalPembayaran = $transaksi->total_pembayaran + $nominalPembayaran;
                $dataUpdateTransaksi = [
                    'total_pembayaran' => $totalPembayaran,
                    'status_pembayaran' => 'Lunas',
                ];

                $this->repairCase->updateTransaksi($transaksi->id, $dataUpdateTransaksi);
            } else {
                $dataTransaksi = [
                    'case_id' => $id,
                    'total_pembayaran' => $nominalPembayaran,
                    'status_pembayaran' => 'Belum Lunas',
                ];

                $transaksi = $this->repairCase->createTransaksi($dataTransaksi);
            }

            $dataCase = $this->repairCase->findCase($id);
            $namaCustomer = $dataCase->customer->first_name . "-" . $dataCase->customer->id;
            
            $dataView = [
                'title' => 'Preview Pelunasan',
                'dataCase' => $dataCase,
            ];

            $pdf = Pdf::loadView('repair.csr.invoice.invoice-pelunasan', $dataView);
            $pdfContent = $pdf->output();
            $pdfEncode = base64_encode($pdfContent);

            $payload = [
                'nama_customer' => $namaCustomer,
                'link_drive' => $linkDrive,
                'file' => $fileBukti,
                'pdf' => $pdfEncode,
                'status_payment' => 'Lunas',
                'folderAkuntan' => $folderAkuntan,
            ];


            $urlApi = 'https://script.google.com/macros/s/AKfycbxN1mlhPrtrnbyiWJSVdcA1YCkV6tBUhlSTcf9pQca4hKozqcwrrupxM_f0wJJrNh99kA/exec';
            $response = Http::post($urlApi, $payload);
            if ($response->successful()) {
                $dataResponse = $response->json();
                $statusResponse = $dataResponse['status'];
        
                if ($statusResponse === 'success') {
                    $fileMutasi = $dataResponse['fileMutasi'] ?? null;
                    $fileInvoice = $dataResponse['fileInvoice'] ?? null;
                    
                    $dataPembayaran = [
                        'transaksi_id' => $transaksi->id,
                        'metode_pembayaran_id' => $metodePembayaran,
                        'employee_id' => $employeeId,
                        'jumlah_pembayaran' => $nominalPembayaran,
                        'link_bukti' => $fileMutasi,
                    ];

                    $checkTimestamp = $this->repairTimeJurnal->findTimestime($id, 10);
                    if ($checkTimestamp) {
                        $timestamp = $checkTimestamp;
                    } else {
                        $dataTimestamp = [
                            'case_id' => $id,
                            'jenis_status_id' => 10,
                            'tanggal_waktu' => $tglWaktu,
                        ];
            
                        $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);
                    }

                    $dataJurnal = [
                        'employee_id' => $employeeId,
                        'jenis_substatus_id' => 1,
                        'timestamps_status_id' => $timestamp->id,
                        'isi_jurnal' => 'Case Close Done.',
                    ];
                    $updateCase = ['jenis_status_id' => 10];

                    $idEstimasi = $dataCase->estimasi->id;
                    $findEstimasi = $this->estimasi->ensureHaveEstimasi($id);
                    $updateEstimasi = ['status' => 'Lunas'];
                    
                    if ($findEstimasi) {
                        $estimasiActive = $findEstimasi->estimasiPart()->where('active', 'Active');
                        
                        if ($estimasiActive->exists()) {
                            $estimasiActive->update(['tanggal_lunas' => $tglWaktu]);
                        }
                    } else {
                        $this->repairCase->rollBackTransaction();
                        return ['status' => 'error', 'message' => 'Tidak bisa menemukan estimasi.'];
                    }

                    $statusTransaksi = $checkTransaksi->status_pembayaran;
                    if ($statusTransaksi == 'Lunas') {
                        $updateLink = ['link_invoice' => $totalPembayaran,];
                        $this->repairCase->updateTransaksi($transaksi->id, $updateLink);
                    }
    

                    $this->estimasi->updateEstimasi($updateEstimasi, $idEstimasi);
                    $this->repairTimeJurnal->addJurnal($dataJurnal);
                    $this->repairCase->createPembayaran($dataPembayaran);
                    $this->repairCase->updateCase($id, $updateCase);
                    $this->repairCase->commitTransaction();
                    
                    return ['status' => 'success', 'message' => 'Berhasil melakukan pelunasan.'];

                } else {
                    $this->repairCase->rollBackTransaction();
                    return [
                        'status' => 'error',
                        'message' => $dataResponse['message'] ?? 'Terjadi kesalahan'
                    ];
                }
            } else {
                $this->repairCase->rollBackTransaction();
                return [
                    'status' => 'error',
                    'message' => 'Gagal menghubungi Google App Script'
                ];
            }

        } catch (Exception $e) {
            $this->repairCase->rollBackTransaction();
            return ['status' => 'error' , 'message' => $e->getMessage()];
        }
    }

    // Function Get Data
    public function showTimeForChat()
    {
        $hour = date('H');
        $greeting = '';

        if ($hour >= 5 && $hour < 11) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        return $greeting;
    }

    public function getDataRequest()
    {
        return $this->repairCase->getDataRequestPart();
    }

    public function getDataForPenerimaanPart()
    {
        return $this->repairCase->getDataPenerimaanReqPart();
    }

    public function getDataAkun()
    {
        return $this->repairCase->getMetodePembayaran();
    }

    public function getDataCustomer($id)
    {
        return $this->customerRepository->findCustomer($id);
    }

    public function getLayanan($id)
    {
        return $this->ekspedisi->getDataLayanan($id);
    }

}
