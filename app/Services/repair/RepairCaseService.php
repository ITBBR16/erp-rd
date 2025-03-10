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
use App\Models\management\AkuntanDaftarAkun;
use App\Models\repair\RepairCase;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\repair\repository\RepairQCRepository;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\logistik\repository\EkspedisiRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;
use App\Repositories\repair\repository\RepairEstimasiRepository;
use App\Repositories\repair\repository\RepairTimeJurnalRepository;

class RepairCaseService
{
    public function __construct(
        private UmumRepository $umum,
        private AkuntanDaftarAkun $daftarAkun,
        private EkspedisiRepository $ekspedisi,
        private ProdukRepository $product,
        private GudangTransactionRepository $transactionGudang,
        private GudangProdukIdItemRepository $idItemGudang,
        private RepairCustomerRepository $customerRepository,
        private RepairCase $modelCase,
        private RepairCaseRepository $repairCase,
        private RepairTimeJurnalRepository $repairTimeJurnal,
        private RepairEstimasiRepository $estimasi,
        private RepairQCRepository $repairQC,
    ){}

    // Input New Case
    public function indexNewCase()
    {
        $user = auth()->user();
        $caseService = $this->getDataDropdown();
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $caseService['data_case']->sortByDesc('id');
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

    public function pageDetailListCase($encryptId)
    {
        $user = auth()->user();
        $id = decrypt($encryptId);
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $this->findCase($id);

        return view('repair.csr.page.detail-list-case', [
            'title' => 'Detail List Case',
            'active' => 'list-case',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'case' => $dataCase,
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
                'nama' => $dataCustomer->first_name . ' ' . $dataCustomer->last_name,
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

    public function updateCase(Request $request, $caseId)
    {
        $this->repairCase->beginTransaction();

        try {
            $fungsionalDroneId = $request->input('case_fungsional');
            $jenisCaseId = $request->input('case_jenis');
            $keluhan = $request->input('case_keluhan');
            $kronologiKerusakan = $request->input('case_kronologi');
            $penggunaanAfterCrash = $request->input('case_penggunaan');
            $riwayatPengguna = $request->input('case_riwayat');

            $dataInput = [
                'jenis_fungsional_id' => $fungsionalDroneId,
                'jenis_case_id' => $jenisCaseId,
                'keluhan' => $keluhan,
                'kronologi_kerusakan' => $kronologiKerusakan,
                'penanganan_after_crash' => $penggunaanAfterCrash,
                'riwayat_penggunaan' => $riwayatPengguna,
            ];

            $updatedCase = $this->repairCase->updateCase($caseId, $dataInput);

            $dataKelengkapan = $request->input('case_kelengkapan', []);
            $dataQty = $request->input('case_quantity', []);
            $dataSN = $request->input('case_sn', []);
            $dataKeterangan = $request->input('case_keterangan', []);

            if (!empty($dataKelengkapan)) {
                $dataToDetailKelengkapan = [];
                foreach ($dataKelengkapan as $index => $kelengkapan) {
                    $dataToDetailKelengkapan[] = [
                        'case_id' => $caseId,
                        'item_kelengkapan_id' => $kelengkapan,
                        'quantity' => $dataQty[$index] ?? null,
                        'serial_number' => $dataSN[$index] ?? null,
                        'keterangan' => $dataKeterangan[$index] ?? null,
                    ];
                }

                $this->repairCase->updateDetailKelengkapan($caseId, $dataToDetailKelengkapan);
            }

            $this->repairCase->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil memperbarui case.'];

        } catch (Exception $e) {
            $this->repairCase->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function reviewPdfLunas($id)
    {
        $user = auth()->user();
        $employee = $user->first_name . " " . $user->last_name;
        $dataCase = $this->repairCase->findCase($id);
        $dataView = [
            'title' => 'Preview Tanda Terima',
            'dataCase' => $dataCase,
            'employee' => $employee,
        ];

        $pdf = Pdf::loadView('repair.csr.preview.preview-lunas', $dataView)
                    ->setPaper('a5', 'portrait');

        return $pdf;
    }

    public function reviewBuktiPembayaran($id)
    {
        $user = auth()->user();
        $employee = $user->first_name . " " . $user->last_name;
        $dataCase = $this->repairCase->findCase($id);
        $dataView = [
            'title' => 'Preview Tanda Terima',
            'dataCase' => $dataCase,
            'employee' => $employee,
        ];

        $pdf = Pdf::loadView('repair.csr.preview.preview-bukti-pembayaran', $dataView)
                    ->setPaper('a5', 'portrait');

        return $pdf;
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
            $notelpon = $dataCase->customer->no_telpon;

            $namaReal = $dataCase->customer->first_name . " " . $dataCase->customer->last_name . "-" . $dataCase->customer->id . "-" . $dataCase->id;
            $pembukaan = "Drone sudah selesai pengerjaan dan lolos testfly ☺️";
            $penjelasan = "Untuk performa terbang drone dan gimbalnya sudah aman, sudah kembali normal";
            $pemberitahuanLink = "Hasil video test fly nya bisa cek disini ya kak";
            $penutupan = "*Note: proses testfly menggunakan propeller dan battery milik Rumah Drone*";
            $pesan = "*Hallo {$greeting} kak {$namaReal}*\n\n{$pembukaan}\n{$penjelasan}\n\n{$pemberitahuanLink}\n{$linkDrive}\n\n{$penutupan}";

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
        $dataCase = $caseService['data_case']
                    ->filter(function ($case) {
                        return $case->jenisStatus->jenis_status == 'Proses Konfirmasi Hasil QC';
                    })
                    ->sortByDesc('updated_at');

        return view('repair.csr.konfirmasi-qc', [
            'title' => 'Konfirmasi QC',
            'active' => 'konf-qc',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);
    }

    public function peageDetailKQC($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $dataCase = $this->repairCase->findCase($id);
        $divisiName = $this->umum->getDivisi($user);
        $dataQc = $this->repairQC->getAllData();
        $kondisi = $dataQc['kondisi'];
        $kategori = $dataQc['kategori'];

        return view('repair.csr.page.detail-konfirmasi-qc', [
            'title' => 'Detail Konfirmasi QC',
            'active' => 'konf-qc',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'case' => $dataCase,
            'kategoris' => $kategori,
            'kondisis' => $kondisi,
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
            $notelpon = $dataCase->customer->no_telpon;

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
        $dataEkspedisi = $this->ekspedisi->getDataEkspedisi(); // get data ekspedisi
        $dataCaseBelumLunas = $caseService['data_case']
                            ->filter(function ($case) {
                                return $case->jenisStatus->jenis_status == 'Proses Menunggu Pembayaran (Lanjut)';
                            })
                            ->sortByDesc('updated_at');
        $dataCaseLunas = $this->modelCase->whereHas('jenisStatus', function ($query) {
                                $query->where('jenis_status', 'Close Case (Done)');
                            })
                            ->orderByDesc('updated_at')
                            ->paginate(70);

        return view('repair.csr.kasir-repair', [
            'title' => 'List Kasir Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataProvinsi' => $dataProvinsi,
            'dataCaseBelumLunas' => $dataCaseBelumLunas,
            'dataCaseLunas' => $dataCaseLunas,
            'dataEkspedisi' => $dataEkspedisi,
        ]);
    }

    public function pageDetailKasir($encryptId)
    {
        $user = auth()->user();
        $id = decrypt($encryptId);
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $this->findCase($id);

        return view('repair.csr.page.detail-kasir', [
            'title' => 'Detail List Case',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'case' => $dataCase,
        ]);
    }

    public function pageInputOngkir($encryptId)
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $id = decrypt($encryptId);
        $dataCase = $this->findCase($id);
        $dataEkspedisi = $this->ekspedisi->getDataEkspedisi();

        return view('repair.csr.edit.kasir-ongkir', [
            'title' => 'Kasir Ongkir Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
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

    public function sendKonfirmasiAlamat($id)
    {
        try {
            $dataCase = $this->repairCase->findCase($id);

            if (!$dataCase || !$dataCase->customer) {
                throw new Exception('Data case atau customer tidak ditemukan.');
            }

            $notelpon = $dataCase->customer->no_telpon;
            $provinsi = $dataCase->customer->provinsi->name ?? '-';
            $kota = $dataCase->customer->kota->name ?? '-';
            $kecamatan = $dataCase->customer->kecamatan->name ?? '-';
            $kelurahan = $dataCase->customer->kelurahan->name ?? '-';
            $kodePos = $dataCase->customer->kode_pos ?? '-';
            $namaJalan = $dataCase->customer->nama_jalan ?? '-';

            $header = "Mohon Koreksi alamat berikut untuk pengiriman : \n\n";
            $body = "Provinsi : {$provinsi}\nKota / Kabupaten : {$kota}\nKecamatan : {$kecamatan}\nKelurahan : {$kelurahan}\nKode Pos : {$kodePos}\nNama Jalan : {$namaJalan}\n\n";
            $footer = "Jika sudah benar mohon balas pesan ini dengan *YA*";
            $pesan = $header . $body . $footer;

            $payload = [
                'pesan' => $pesan,
                'no_telpon' => $notelpon,
            ];

            $url = 'https://script.google.com/macros/s/AKfycbyC2ojngj6cSxq2kqW3H_wT-FjFBQrCL7oGW9dsFMwIC-JV89B-8gvwp54qX-pvnNeclg/exec';
            $response = Http::post($url, $payload);

            if ($response->failed()) {
                throw new Exception('Gagal mengirim konfirmasi alamat. Error: ' . $response->body());
            }

            return ['status' => 'success', 'message' => 'Konfirmasi alamat berhasil dikirim.'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
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
            $nominalOngkir = preg_replace("/[^0-9]/", "",$request->input('nominal_ongkir_repair')) ?: 0;
            $nominalPacking = preg_replace("/[^0-9]/", "",$request->input('nominal_packing_repair')) ?: 0;
            $nominalProduk = preg_replace("/[^0-9]/", "",$request->input('nominal_produk')) ?: 0;
            $nominalAsuransi = preg_replace("/[^0-9]/", "",$request->input('nominal_asuransi')) ?: 0;

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
                    'provinsi_id' => $request->input('provinsi_customer'),
                    'kota_kabupaten_id' => $request->input('kota_customer'),
                    'kecamatan_id' => $request->input('kecamatan_customer'),
                    'kelurahan_id' => $request->input('kelurahan_customer'),
                    'kode_pos' => $request->input('kode_pos_customer'),
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
            $linkDrive = $request->input('link_doc');
            $keteranganDp = $request->input('keterangan_dp');
            
            $checkTransaksi = $this->repairCase->findTransaksiByCase($id);

            if (!empty($checkTransaksi)) {
                $transaksi = $checkTransaksi;
            } else {
                $dataTransaksi = [
                    'case_id' => $id,
                    'total_pembayaran' => 0,
                    'status_pembayaran' => 'Belum Lunas',
                ];
                $transaksi = $this->repairCase->createTransaksi($dataTransaksi);
            }

            $totalPembayaran = $transaksi->total_pembayaran;
            $filesFinance = [];
            $namaAkunFinance = [];
            $nilaiAkunFinance = [];

            $dataCase = $this->repairCase->findCase($id);
            $namaCustomer = $dataCase->customer->first_name . "-" . $dataCase->customer->id;

            $dataView = [
                'title' => 'Preview Down Payment',
                'dataCase' => $dataCase,
            ];

            $pdf = Pdf::loadView('repair.csr.invoice.invoice-dp', $dataView);
            $pdfContent = $pdf->output();
            $pdfEncode = base64_encode($pdfContent);
            $filesFinance[] = $pdfEncode;

            $payload = [
                'nama_customer' => $namaCustomer,
                'link_drive' => $linkDrive,
                'pdf' => $pdfEncode,
                'status_payment' => 'DP',
            ];

            $urlInvoice = 'https://script.google.com/macros/s/AKfycbxN1mlhPrtrnbyiWJSVdcA1YCkV6tBUhlSTcf9pQca4hKozqcwrrupxM_f0wJJrNh99kA/exec';
            $response = Http::post($urlInvoice, $payload);

            if ($response->failed()) {
                throw new Exception('Terjadi kesalahan ketika upload invoice. Error: ' . $response->body());
            }

            foreach ($request->input('metode_pembayaran_pembayaran') as $index => $metodePembayaran) {
                $nominalPembayaran = preg_replace("/[^0-9]/", "", $request->input('nominal_pembayaran')[$index]);
                $filesFinance[] = base64_encode($request->file('file_bukti_transaksi')[$index]->get());

                $totalPembayaran += $nominalPembayaran;
                
                $dataPembayaran = [
                    'transaksi_id' => $transaksi->id,
                    'metode_pembayaran_id' => $metodePembayaran,
                    'employee_id' => $employeeId,
                    'jumlah_pembayaran' => $nominalPembayaran,
                ];
                $namaAkun = $this->daftarAkun->find($metodePembayaran);
                $namaAkunFinance[] = $namaAkun->nama_akun;
                $nilaiAkunFinance[] = $nominalPembayaran;
                $this->repairCase->createPembayaran($dataPembayaran);
            }

            $this->repairCase->updateTransaksi($transaksi->id, ['total_pembayaran' => $totalPembayaran, 'down_payment' => $totalPembayaran]);

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($id, 9);
            if (!$checkTimestamp) {
                $dataTimestamp = [
                    'case_id' => $id,
                    'jenis_status_id' => 9,
                    'tanggal_waktu' => $tglWaktu,
                ];
                $checkTimestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);
            }

            $payloadPembukuan = [
                'statusSC' => true,
                'files' => $filesFinance,
                'source' => 'Repair',
                'inOut' => 'In',
                'keterangan' => $keteranganDp,
                'idEksternal' => "R$id",
                'idCustomer' => $dataCase->customer->first_name . "-" . $dataCase->customer->last_name . "-" . $dataCase->customer->id,
                'totalNominal' => $totalPembayaran,
                'nilaiJasa' => 0,
                'nilaiReparasi' => 0,
                'nilaiResiko' => 0,
                'nilaiSparepartBaru' => 0,
                'nilaiSparepartBekas' => 0,
                'nilaiLainnya' => 0,
                'nilaiDiskon' => 0,
                'nilaiKerugian' => 0,
                'saldoCustomer' => $totalPembayaran,
                'metodePembayaran' => $namaAkunFinance,
                'nilaiMP' => $nilaiAkunFinance,
            ];

            $urlJurnalTransit = 'https://script.google.com/macros/s/AKfycbz1A7V7pNuzyuIPCBVqtZjoMy1TvVG2Gx2Hh_16eifXiOpdWtzf1WKjqSpQ0YEdbmk5/exec';
            $responseFinance = Http::post($urlJurnalTransit, $payloadPembukuan);

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 1,
                'timestamps_status_id' => $checkTimestamp->id,
                'isi_jurnal' => 'Melakukan pembayaran Down Payment.',
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);
            $this->repairCase->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil melakukan pembayaran.'];

        } catch (Exception $e) {
            $this->repairCase->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createPelunasan(Request $request, $id)
    {
        $this->repairCase->beginTransaction();
        $this->transactionGudang->beginTransaction();

        try {
            $employeeId = auth()->user()->id;
            $tglWaktu = Carbon::now();
            $linkDrive = $request->input('link_doc');
            $keteranganLunas = $request->input('keterangan_lunas');
            $saldoTerpakai = preg_replace("/[^0-9]/", "", $request->input('nominal_saldo_customer_terpakai')) ?: 0;
            $nominalDiscount = preg_replace("/[^0-9]/", "", $request->input('nominal_discount')) ?: 0;
            $nominalKerugian = preg_replace("/[^0-9]/", "", $request->input('nominal_kerugian')) ?: 0;
            $nominalDikembalikan = preg_replace("/[^0-9]/", "", $request->input('nominal_dikembalikan')) ?: 0;
            $pendapatanLainLain = preg_replace("/[^0-9]/", "", $request->input('nominal_pll')) ?: 0;
            $tambahSaldoCustomer = preg_replace("/[^0-9]/", "", $request->input('nominal_save_saldo_customer')) ?: 0;
            $totalOngkir = $request->input('nominal_ongkir');

            $dataCase = $this->repairCase->findCase($id);
            $idEstimasi = $dataCase->estimasi->id;
            $findEstimasi = $this->estimasi->ensureHaveEstimasi($id);

            $nilaiPJasa = 0;
            $nilaiPReparasi = 0;
            $nilaiPResiko = 0;
            $nilaiSparepartBaru = 0;
            $nilaiSparepartBekas = 0;
            $modalGudangBaru = 0;
            $modalGudangBekas = 0;
            $nilaiGudangPartBaru = 0;
            $nilaiGudangPartBekas = 0;
            
            if ($findEstimasi) {
                $estimasiPartActive = $findEstimasi->estimasiPart()->where('active', 'Active');
                $estimasiJRRActive = $findEstimasi->estimasiJrr()->where('active', 'Active');

                if ($estimasiPartActive->exists()) {
                    $getEstimasiPart = $estimasiPartActive->get();
                    $cekTanggalPenerimaan = $getEstimasiPart->contains(function ($item) {
                        return is_null($item->tanggal_diterima);
                    });
                    if ($cekTanggalPenerimaan) {
                        $this->repairCase->rollBackTransaction();
                        $this->transactionGudang->rollbackTransaction();
                        return ['status' => 'error', 'message' => 'Gagal melakukan pelunasan. Terdapat part yang belum di konfirmasi.'];
                    }

                    foreach ($getEstimasiPart as $estimasiPart) {
                        $idItemID = $estimasiPart->id_item;
                        $jenisTPart = $estimasiPart->jenisTransaksi->jenis_transaksi;
                        $modalGudang = $estimasiPart->modal_gudang;
                        $labaPartRepair = $estimasiPart->harga_customer - $estimasiPart->harga_repair;
                        $labaPartGudang = $estimasiPart->harga_repair - $modalGudang;

                        if ($jenisTPart === 'Pendapatan Repair Part Baru') {
                            $nilaiSparepartBaru += $labaPartRepair;
                            $nilaiGudangPartBaru += $labaPartGudang;
                            $modalGudangBaru += $modalGudang;
                        } elseif ($jenisTPart === 'Pendapatan Repair Part Bekas') {
                            $nilaiSparepartBekas += $labaPartRepair;
                            $nilaiGudangPartBekas += $labaPartGudang;
                            $modalGudangBekas += $modalGudang;
                        }

                        $this->idItemGudang->updateIdItem($idItemID, ['status_inventory' => 'Sold']);
                    }
                    $estimasiPartActive->update(['tanggal_lunas' => $tglWaktu]);
                }

                if ($estimasiJRRActive->exists()) {
                    foreach ($estimasiJRRActive->get() as $estimasiJRR) {
                        $jenisTransaksi = $estimasiJRR->jenisTransaksi->jenis_transaksi;
                        $nominal = $estimasiJRR->harga_customer;

                        if ($jenisTransaksi === 'Pendapatan Repair Jasa') {
                            $nilaiPJasa += $nominal;
                        } elseif ($jenisTransaksi === 'Pendapatan Repair Resiko') {
                            $nilaiPResiko += $nominal;
                        } elseif ($jenisTransaksi === 'Pendapatan Repair Reparasi') {
                            $nilaiPReparasi += $nominal;
                        }
                    }
                }
            } else {
                $this->repairCase->rollBackTransaction();
                $this->transactionGudang->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Tidak bisa menemukan estimasi.'];
            }

            $saldoCustomer = [];
            $statusSC = [];
            if ($saldoTerpakai > 0) {
                $saldoCustomer[] = $saldoTerpakai;
                $statusSC[] = true;
            }
            if ($tambahSaldoCustomer > 0) {
                $saldoCustomer[] = $tambahSaldoCustomer + $nominalDikembalikan;
                $statusSC[] = false;
            }
            
            $checkTransaksi = $this->repairCase->findTransaksiByCase($id);

            if (!empty($checkTransaksi)) {
                $transaksi = $checkTransaksi;
            } else {
                $dataTransaksi = [
                    'case_id' => $id,
                    'total_pembayaran' => 0,
                    'status_pembayaran' => 'Lunas',
                ];
                $transaksi = $this->repairCase->createTransaksi($dataTransaksi);
            }

            $totalPembayaran = $transaksi->total_pembayaran;
            $filesFinance = [];
            $namaAkunFinance = [];
            $nilaiAkunFinance = [];
            
            $namaCustomer = $dataCase->customer->first_name . "-" . $dataCase->customer->id;

            $dataView = [
                'title' => 'Preview Pelunasan',
                'dataCase' => $dataCase,
            ];

            $pdf = Pdf::loadView('repair.csr.invoice.invoice-pelunasan', $dataView);
            $pdfContent = $pdf->output();
            $pdfEncode = base64_encode($pdfContent);
            $filesFinance[] = $pdfEncode;

            $payload = [
                'nama_customer' => $namaCustomer,
                'link_drive' => $linkDrive,
                'pdf' => $pdfEncode,
                'status_payment' => 'Lunas',
            ];

            $urlApi = 'https://script.google.com/macros/s/AKfycbxN1mlhPrtrnbyiWJSVdcA1YCkV6tBUhlSTcf9pQca4hKozqcwrrupxM_f0wJJrNh99kA/exec';
            $response = Http::post($urlApi, $payload);

            if ($response->failed()) {
                throw new Exception('Terjadi kesalahan ketika upload invoice. Error: ' . $response->body());
            }

            foreach ($request->input('metode_pembayaran_pembayaran') as $index => $metodePembayaran) {
                $nominalPembayaran = preg_replace("/[^0-9]/", "", $request->input('nominal_pembayaran')[$index]);
                $filesFinance[] = base64_encode($request->file('file_bukti_transaksi')[$index]->get());

                $totalPembayaran += $nominalPembayaran;
                
                $dataPembayaran = [
                    'transaksi_id' => $transaksi->id,
                    'metode_pembayaran_id' => $metodePembayaran,
                    'employee_id' => $employeeId,
                    'jumlah_pembayaran' => $nominalPembayaran,
                ];
                $namaAkun = $this->daftarAkun->find($metodePembayaran);
                $namaAkunFinance[] = $namaAkun->nama_akun;
                $nilaiAkunFinance[] = $nominalPembayaran;
                $this->repairCase->createPembayaran($dataPembayaran);
            }

            $dataUpdateTransaksi = [
                'total_pembayaran' => $totalPembayaran,
                'down_payment' => $saldoTerpakai,
                'discount' => $nominalDiscount,
                'kerugian' => $nominalKerugian,
                'nominal_dikembalikan' => $nominalDikembalikan,
                'pendapatan_lain' => $pendapatanLainLain,
                'status' => 'Lunas'
            ];

            $this->repairCase->updateTransaksi($transaksi->id, $dataUpdateTransaksi);

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

            $payloadPembukuan = [
                'statusSC' => $statusSC,
                'files' => $filesFinance,
                'source' => 'Repair',
                'inOut' => 'In',
                'keterangan' => $keteranganLunas,
                'idEksternal' => "R$id",
                'idCustomer' => $dataCase->customer->first_name . " " . $dataCase->customer->last_name . "-" . $dataCase->customer->id,
                'totalNominal' => $totalPembayaran,
                'nilaiJasa' => $nilaiPJasa,
                'nilaiReparasi' => $nilaiPReparasi,
                'nilaiResiko' => $nilaiPResiko,
                'modalGudangBaru' => $modalGudangBaru,
                'modalGudangBekas' => $modalGudangBekas,
                'nilaiGudangPartBaru' => $nilaiGudangPartBaru,
                'nilaiGudangPartBekas' => $nilaiGudangPartBekas,
                'nilaiSparepartBaru' => $nilaiSparepartBaru,
                'nilaiSparepartBekas' => $nilaiSparepartBekas,
                'nilaiLainnya' => $pendapatanLainLain,
                'nilaiDiskon' => $nominalDiscount,
                'nilaiKerugian' => $nominalKerugian,
                'saldoCustomer' => $saldoCustomer,
                'metodePembayaran' => $namaAkunFinance,
                'nilaiMP' => $nilaiAkunFinance,
                'saldoOngkir' => $totalOngkir
            ];

            $urlJurnalTransit = 'https://script.google.com/macros/s/AKfycbz1A7V7pNuzyuIPCBVqtZjoMy1TvVG2Gx2Hh_16eifXiOpdWtzf1WKjqSpQ0YEdbmk5/exec';
            $responseFinance = Http::post($urlJurnalTransit, $payloadPembukuan);

            $this->estimasi->updateEstimasi(['status' => 'Lunas'], $idEstimasi);
            $this->repairTimeJurnal->addJurnal($dataJurnal);
            $this->repairCase->updateCase($id, $updateCase);
            $this->repairCase->commitTransaction();
            
            return ['status' => 'success', 'message' => 'Berhasil melakukan pelunasan.'];

        } catch (Exception $e) {
            $this->repairCase->rollBackTransaction();
            $this->transactionGudang->rollbackTransaction();
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
        return $this->daftarAkun->where('kode_akun', 'like', '111%')->get();
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
