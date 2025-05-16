<?php

namespace App\Services\repair;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\gudang\GudangProduk;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosTransaksiPart;
use App\Models\repair\RepairEstimasiPart;
use App\Repositories\umum\UmumRepository;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\gudang\repository\GudangProdukRepository;
use App\Repositories\repair\repository\RepairEstimasiRepository;
use App\Repositories\repair\repository\RepairTimeJurnalRepository;

class RepairEstimasiService
{
    public function __construct(
        private RepairEstimasiPart $estimasiPart,
        private KiosTransaksiPart $transaksiPart,
        private GudangProduk $gudangProduk,
        private UmumRepository $umum,
        private ProdukRepository $produk,
        private GudangProdukRepository $produkGudang,
        private RepairCaseService $repairCaseService,
        private RepairCaseRepository $repairCase,
        private RepairEstimasiRepository $repairEstimasi,
        private RepairTimeJurnalRepository $repairTimeJurnal
    ){}

    // View Estimasi Biaya
    public function index()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $caseService['data_case']->sortByDesc('created_at');

        return view('repair.estimasi.estimasi-biaya', [
            'title' => 'List Estimasi Biaya',
            'active' => 'estimasi-biaya',
            'navActive' => 'estimasi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);
    }

    public function pageDetailEstimasi($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $dataCase = $this->repairCaseService->findCase($id);
        $divisiName = $this->umum->getDivisi($user);

        return view('repair.estimasi.pages.detail-estimasi', [
            'title' => 'Detail Estimasi',
            'active' => 'estimasi-biaya',
            'navActive' => 'estimasi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'case' => $dataCase,
        ]);
    }

    public function pageEstimasi($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $jenisTransaksi = $this->getJenisTransaksi();
        $dataCase = $this->repairCaseService->findCase($id);
        $divisiName = $this->umum->getDivisi($user);

        return view('repair.estimasi.edit.form-estimasi-biaya', [
            'title' => 'List Estimasi Biaya',
            'active' => 'estimasi-biaya',
            'navActive' => 'estimasi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'jenisTransaksi' => $jenisTransaksi,
        ]);

    }

    // View Konfirmasi Estimasi
    public function indexKonfirmasi()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->umum->getDivisi($user);
        $greeting = $this->showTimeForChat();
        $dataCase = $caseService['data_case']->sortByDesc('created_at');

        return view('repair.estimasi.konfirmasi', [
            'title' => 'List Konfirmasi Estimasi',
            'active' => 'konfirmasi-estimasi',
            'navActive' => 'estimasi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'greeting' => $greeting,
        ]);
    }

    public function pageDetailKonfirmasi($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $dataCase = $this->repairCaseService->findCase($id);
        $divisiName = $this->umum->getDivisi($user);

        return view('repair.estimasi.pages.detail-konfirmasi-estimasi', [
            'title' => 'Detail Konfiramsi',
            'active' => 'konfirmasi-estimasi',
            'navActive' => 'estimasi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'case' => $dataCase,
        ]);
    }

    public function pageUbahEstimasi($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $jenisTransaksi = $this->getJenisTransaksi();
        $jenisProduk = $this->getJenisDrone();
        $dataCase = $this->repairCaseService->findCase($id);
        $divisiName = $this->umum->getDivisi($user);

        return view('repair.estimasi.edit.ubah-estimasi-biaya', [
            'title' => 'List Estimasi Biaya',
            'active' => 'konfirmasi-estimasi',
            'navActive' => 'estimasi',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dataCase' => $dataCase,
            'jenisTransaksi' => $jenisTransaksi,
            'jenisProduk' => $jenisProduk,
        ]);
    }

    // View Rubah Estimasi General
    public function indexRubahEstimasi()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->umum->getDivisi($user);

        $dataCase = $caseService['data_case']->filter(function ($case) {
            return in_array($case->jenisStatus->jenis_status, [
                'Proses Pengerjaan', 
                'Proses Quality Control', 
                'Proses Menunggu Pembayaran (Lanjut)'
            ]);
        })->sortByDesc('created_at');

        return view('repair.estimasi.rubah-estimasi-general', [
            'title' => 'List Case Estimasi',
            'active' => 'rubah-estimasi',
            'navActive' => 'estimasi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);
    }

    public function pageGeneralUbah($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $jenisTransaksi = $this->getJenisTransaksi();
        $jenisProduk = $this->getJenisDrone();
        $dataCase = $this->repairCaseService->findCase($id);
        $divisiName = $this->umum->getDivisi($user);

        return view('repair.estimasi.edit.general-rubah-estimasi', [
            'title' => 'List Case Estimasi',
            'active' => 'rubah-estimasi',
            'navActive' => 'estimasi',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dataCase' => $dataCase,
            'jenisTransaksi' => $jenisTransaksi,
            'jenisProduk' => $jenisProduk,
        ]);
    }

    public function ubahEstimasiGeneral(Request $request, $id)
    {
        try {
            $this->repairEstimasi->beginTransaction();

            $employeeId = auth()->user()->id;
            $tglWaktu = Carbon::now();
            $pesanHasilTs = $request->input('pesan_hasil_ts');
    
            // Data Estimasi JRR
            $jenisTransaksi = $request->input('jenis_transaksi');
            $jenisPartJasa = $request->input('jenis_part_jasa');
            $namaPartJasa = $request->input('nama_part_jasa');
            $namaAlias = $request->input('nama_alias');
            $hargaCustomer = preg_replace("/[^0-9]/", "",$request->input('harga_customer'));
            
            // Data Part
            $hargaRepair = preg_replace("/[^0-9]/", "",$request->input('harga_repair'));
            $hargaGudang = preg_replace("/[^0-9]/", "",$request->input('harga_gudang'));

            // Data Lama
            $idEstimasiLama = $request->input('id_hasil_estimasi');
            $jenisTransaksiLama = $request->input('jenis_transaksi_lama');
            $statusActive = $request->input('status');
            $jenisPartJasaLama = $request->input('jenis_part_jasa_lama');
            $namaPartJasaLama = $request->input('nama_part_jasa_lama');
            $namaAliasLama = $request->input('nama_alias_lama');
            $hargaCustomerLama = preg_replace("/[^0-9]/", "",$request->input('harga_customer_lama'));

            if ($jenisTransaksiLama) {
                // Update data lama
                foreach ($jenisTransaksiLama as $index => $jt) {
                    $idHasilEstimasi = $idEstimasiLama[$index];
                    if ($jt == 1) {
                        $dataUpdateEstimasiPart = [
                            'nama_alias' => $namaAliasLama[$index] ?? '',
                            'harga_customer' => $hargaCustomerLama[$index],
                            'active' => $statusActive[$index],
                        ];
                        $this->repairEstimasi->updateEstimasiPart($dataUpdateEstimasiPart, $idHasilEstimasi);
            
                    } else {
                        $dataUpdateEstimasiJrr = [
                            'jenis_jasa' => $jenisPartJasaLama[$index],
                            'nama_jasa' => $namaPartJasaLama[$index],
                            'harga_customer' => $hargaCustomerLama[$index],
                            'active' => $statusActive[$index],
                        ];
                        $this->repairEstimasi->updateEstimasiJrr($dataUpdateEstimasiJrr, $idHasilEstimasi);
                    }
                }
            }

            if ($jenisTransaksi) {
                foreach ($jenisTransaksi as $index => $jt) {
                    // Insert new data
                    if ($jt == 1) {
                        $createPart = [
                        'estimasi_id' => $id,
                        'jenis_transaksi_id' => $jt,
                        'gudang_produk_id' => $namaPartJasa[$index],
                        'nama_alias' => $namaAlias[$index] ?? '',
                        'harga_customer' => $hargaCustomer[$index],
                        'harga_repair' => $hargaRepair[$index],
                        'harga_gudang' => $hargaGudang[$index],
                        'status_proses_id' => 3,
                        'active' => 'Active',
                        ];
                        $this->repairEstimasi->createEstimasiPart($createPart);

                    } else {
                        $createJrr = [
                            'estimasi_id' => $id,
                            'jenis_transaksi_id' => $jt,
                            'jenis_jasa' => $jenisPartJasa[$index],
                            'nama_jasa' => $namaPartJasa[$index],
                            'harga_customer' => $hargaCustomer[$index],
                            'active' => 'Active',
                        ];
                        $this->repairEstimasi->createEstimasiJrr($createJrr);

                    }
                }
            }

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($id, 3);
    
            if ($checkTimestamp) {
                $timestamp = $checkTimestamp;
            } else {
                $dataTimestamp = [
                    'case_id' => $id,
                    'jenis_status_id' => 4,
                    'tanggal_waktu' => $tglWaktu,
                ];
    
                $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);
            }

            $dataChatEstimasi = [
                'isi_chat' => $pesanHasilTs,
            ];

            $existingChat = $this->repairEstimasi->findEstimasiChat($id);

            if ($existingChat) {
                $this->repairEstimasi->updateEstimasiChat($dataChatEstimasi, $id);
            } else {
                $dataChatEstimasi['estimasi_id'] = $id;
                $this->repairEstimasi->createEstimasiChat($dataChatEstimasi);
            }

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 2,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Rubah hasil estimasi.',
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);
            $this->repairEstimasi->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil merubah hasil estimasi.'];

        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

    // Function Proses
    public function addJurnalEstimasi(Request $request)
    {
        $this->repairEstimasi->beginTransaction();

        try {

            $employeeId = auth()->user()->id;
            $caseId = $request->input('case_id');
            $isiJurnal = $request->input('jurnal_estimasi');
            $tglWaktu = Carbon::now();

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($caseId, 4);

            if ($checkTimestamp) {
                $timestamp = $checkTimestamp;
            } else {
                $dataTimestamp = [
                    'case_id' => $caseId,
                    'jenis_status_id' => 4,
                    'tanggal_waktu' => $tglWaktu,
                ];
    
                $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);
            }

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 2,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => $isiJurnal,
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $this->repairEstimasi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil membuat jurnal baru.'];

        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function addJurnalKonfirmasi(Request $request)
    {
        $this->repairEstimasi->beginTransaction();

        try {

            $employeeId = auth()->user()->id;
            $caseId = $request->input('case_id');
            $isiJurnal = $request->input('jurnal_estimasi');
            $tglWaktu = Carbon::now();

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($caseId, 5);

            if ($checkTimestamp) {
                $timestamp = $checkTimestamp;
            } else {
                $dataTimestamp = [
                    'case_id' => $caseId,
                    'jenis_status_id' => 5,
                    'tanggal_waktu' => $tglWaktu,
                ];
    
                $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);
            }

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 2,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => $isiJurnal,
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $this->repairEstimasi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil membuat jurnal baru.'];

        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createEstimasi(Request $request, $id)
    {
        try {
            $this->repairEstimasi->beginTransaction();

            // Data estimasi
            $employeeId = auth()->user()->id;
            $tglWaktu = Carbon::now();
            $pesanHasilTs = $request->input('pesan_hasil_ts');
            $dataEstimasi = [
                'employee_id' => $employeeId,
                'case_id' => $id,
                'status' => 'Estimasi',
            ];
        
            $createEstimasi = $this->repairEstimasi->createEstimasi($dataEstimasi);
        
            // Data Estimasi JRR
            $jenisTransaksi = $request->input('jenis_transaksi');
            $namaPartJasa = $request->input('nama_part_jasa');
            $namaAlias = $request->input('nama_alias');
            $hargaCustomer = preg_replace("/[^0-9]/", "",$request->input('harga_customer'));
        
            // Data Part
            $hargaRepair = preg_replace("/[^0-9]/", "",$request->input('harga_repair'));
            $hargaGudang = preg_replace("/[^0-9]/", "",$request->input('harga_gudang'));
        
            foreach ($jenisTransaksi as $index => $jt) {
                if ($jt == 1) {
                    $dataEstimasiPart = [
                        'estimasi_id' => $createEstimasi->id,
                        'jenis_transaksi_id' => $jt,
                        'gudang_produk_id' => $namaPartJasa[$index],
                        'nama_alias' => $namaAlias[$index],
                        'harga_customer' => $hargaCustomer[$index],
                        'harga_repair' => $hargaRepair[$index],
                        'harga_gudang' => $hargaGudang[$index],
                        'status_proses_id' => 3,
                        'active' => 'Active',
                    ];
                    $this->repairEstimasi->createEstimasiPart($dataEstimasiPart);
                } else {
                    $dataEstimasiJRR = [
                        'estimasi_id' => $createEstimasi->id,
                        'jenis_transaksi_id' => $jt,
                        'nama_jasa' => $namaPartJasa[$index],
                        'nama_alias' => $namaAlias[$index],
                        'harga_customer' => $hargaCustomer[$index],
                        'active' => 'Active',
                    ];
                    $this->repairEstimasi->createEstimasiJrr($dataEstimasiJRR);
                }
            }

            $dataChatEstimasi = [
                'estimasi_id' => $createEstimasi->id,
                'isi_chat' => $pesanHasilTs,
            ];

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($id, 3);

            if ($checkTimestamp) {
                $timestamp = $checkTimestamp;
            } else {
                $dataTimestamp = [
                    'case_id' => $id,
                    'jenis_status_id' => 3,
                    'tanggal_waktu' => $tglWaktu,
                ];
    
                $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);
            }

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 2,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Estimasi Biaya Sudah Dibuat, Perlu Diinformasikan Ke Customer',
            ];

            $dataUpdate = [
                'jenis_status_id' => 4,
            ];

            
            $this->repairCase->updateCase($id, $dataUpdate);
            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $this->repairEstimasi->createEstimasiChat($dataChatEstimasi);
            $this->repairEstimasi->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil membuat estimasi baru.'];

        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

    public function ubahEstimasi(Request $request, $id)
    {
        try {
            $this->repairEstimasi->beginTransaction();

            $employeeId = auth()->user()->id;
            $tglWaktu = Carbon::now();
            $pesanHasilTs = $request->input('pesan_hasil_ts');
    
            // Data Estimasi JRR
            $jenisTransaksi = $request->input('jenis_transaksi');
            $jenisPartJasa = $request->input('jenis_part_jasa');
            $namaPartJasa = $request->input('nama_part_jasa');
            $namaAlias = $request->input('nama_alias');
            $hargaCustomer = preg_replace("/[^0-9]/", "",$request->input('harga_customer'));
            
            // Data Part
            $hargaRepair = preg_replace("/[^0-9]/", "",$request->input('harga_repair'));
            $hargaGudang = preg_replace("/[^0-9]/", "",$request->input('harga_gudang'));

            // Data Lama
            $idEstimasiLama = $request->input('id_hasil_estimasi');
            $jenisTransaksiLama = $request->input('jenis_transaksi_lama');
            $statusActive = $request->input('status');
            $jenisPartJasaLama = $request->input('jenis_part_jasa_lama');
            $namaPartJasaLama = $request->input('nama_part_jasa_lama');
            $namaAliasLama = $request->input('nama_alias_lama');
            $hargaCustomerLama = preg_replace("/[^0-9]/", "",$request->input('harga_customer_lama'));

            if ($jenisTransaksiLama) {
                // Update data lama
                foreach ($jenisTransaksiLama as $index => $jt) {
                    $idHasilEstimasi = $idEstimasiLama[$index];
                    if ($jt == 1) {
                        $dataUpdateEstimasiPart = [
                            'nama_alias' => $namaAliasLama[$index] ?? '',
                            'harga_customer' => $hargaCustomerLama[$index],
                            'active' => $statusActive[$index],
                        ];
                        $this->repairEstimasi->updateEstimasiPart($dataUpdateEstimasiPart, $idHasilEstimasi);
            
                    } else {
                        $dataUpdateEstimasiJrr = [
                            'jenis_jasa' => $jenisPartJasaLama[$index],
                            'nama_jasa' => $namaPartJasaLama[$index],
                            'harga_customer' => $hargaCustomerLama[$index],
                            'active' => $statusActive[$index],
                        ];
                        $this->repairEstimasi->updateEstimasiJrr($dataUpdateEstimasiJrr, $idHasilEstimasi);
                    }
                }
            }

            if ($jenisTransaksi) {
                foreach ($jenisTransaksi as $index => $jt) {
                    // Insert new data
                    if ($jt == 1) {
                        $createPart = [
                        'estimasi_id' => $id,
                        'jenis_transaksi_id' => $jt,
                        'gudang_produk_id' => $namaPartJasa[$index],
                        'nama_alias' => $namaAlias[$index] ?? '',
                        'harga_customer' => $hargaCustomer[$index],
                        'harga_repair' => $hargaRepair[$index],
                        'harga_gudang' => $hargaGudang[$index],
                        'status_proses_id' => 3,
                        'active' => 'Active',
                        ];
                        $this->repairEstimasi->createEstimasiPart($createPart);

                    } else {
                        $createJrr = [
                            'estimasi_id' => $id,
                            'jenis_transaksi_id' => $jt,
                            'jenis_jasa' => $jenisPartJasa[$index],
                            'nama_jasa' => $namaPartJasa[$index],
                            'harga_customer' => $hargaCustomer[$index],
                            'active' => 'Active',
                        ];
                        $this->repairEstimasi->createEstimasiJrr($createJrr);

                    }
                }
            }

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($id, 3);
    
            if ($checkTimestamp) {
                $timestamp = $checkTimestamp;
            } else {
                $dataTimestamp = [
                    'case_id' => $id,
                    'jenis_status_id' => 4,
                    'tanggal_waktu' => $tglWaktu,
                ];
    
                $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);
            }

            $dataChatEstimasi = [
                'isi_chat' => $pesanHasilTs,
            ];

            $existingChat = $this->repairEstimasi->findEstimasiChat($id);

            if ($existingChat) {
                $this->repairEstimasi->updateEstimasiChat($dataChatEstimasi, $id);
            } else {
                $dataChatEstimasi['estimasi_id'] = $id;
                $this->repairEstimasi->createEstimasiChat($dataChatEstimasi);
            }

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 2,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Rubah hasil estimasi.',
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);
            $this->repairEstimasi->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil merubah hasil estimasi.'];

        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

    public function konfirmasiEstimasi(Request $request, $id)
    {
        $this->repairEstimasi->beginTransaction();
        $employeeId = auth()->user()->id;

        try {

            $tglWaktu = Carbon::now();
            $status = $request->input('konfirmasi_customer');
            
            if ($status == '') {
                $this->repairEstimasi->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Data inputan invalid.'];
            }
            
            $isiJurnal = ($status == 'lanjut') ? 'Mulai Proses Pengerjaan' : 'Cancel customer tidak lanjut';
            $jenisStatusId = ($status == 'lanjut') ? 6 : 10;
            $dataUpdateCase = [
                'jenis_status_id' => $jenisStatusId,
            ];

            if($status == 'lanjut') {
                $case = $this->repairCaseService->findCase($id);
                $case->estimasi->estimasiPart()->update(['tanggal_konfirmasi' => now()]);
            }

            $this->repairCase->updateCase($id, $dataUpdateCase);

            $dataTimestamp = [
                'case_id' => $id,
                'jenis_status_id' => $jenisStatusId,
                'tanggal_waktu' => $tglWaktu,
            ];
            $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 1,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => $isiJurnal
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $this->repairEstimasi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil menunggu konfirmasi pengerjaan'];
        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function konfirmasiPengerjaan($id)
    {
        $this->repairEstimasi->beginTransaction();
        $employeeId = auth()->user()->id;
        try {

            $tglWaktu = Carbon::now();

            $dataTimestamp = [
                'case_id' => $id,
                'jenis_status_id' => 5,
                'tanggal_waktu' => $tglWaktu,
            ];
            $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 1,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Lanjut menunggu konfirmasi pengerjaan',
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $dataUpdateCase = [
                'jenis_status_id' => 5,
            ];

            $this->repairCase->updateCase($id, $dataUpdateCase);

            $this->repairEstimasi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil konfirmasi pengerjaan'];
        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function kirimPesanKonfirmasiEstimasi(Request $request)
    {
        try {
            $greeting = $this->showTimeForChat();
            $noTelpon = $request->input('no_customer');
            $namaCustomer = $request->input('nama_customer');
            $namaNota = $request->input('nama_nota');
            $jenisDrone = $request->input('jenis_drone');
            $SN = $request->input('serial_number');
            $hasilAnalisaTs = $request->input('hasil_analisa_ts');
            $dataEstimasi = $request->input('data_estimasi');
            $hargaCustomer = $request->input('estimasi_harga_customer');
            $linkDoc = $request->input('link_doc');

            $greetingMessage = "*Selamat " . $greeting . " kak " . $namaCustomer . "* 😊\n\n";
            $introMessage = "Kami dari Rumah Drone ingin menginformasikan hasil troubleshooting dari:\n";
            $droneInfo = "Drone Atas Nama: " . $namaNota . "\n";
            $droneType = "Jenis Drone:" . $jenisDrone . " \n";
            $serialNumber = "SN: *" . $SN . "* \n\n";
    
            $analysisMessage = "Berikut hasil analisa dan troubleshooting teknisi kami:\n";
            $analysisDetails = $hasilAnalisaTs . "\n\n";
    
            $estimasiHeader = "*Estimasi Biaya:* \n";
            $totalNilai = $request->input('total_biaya_estimasi');
            $estimasiDetails = "";
    
            foreach ($dataEstimasi as $index => $item) {
                $estimasiDetails .= "- " . $item . "    " . $hargaCustomer[$index] . "\n";
            }
    
            $totalCostMessage = "\n*TOTAL BIAYA:* Rp. " . $totalNilai . "\n\n";
    
            $documentationMessage = "Untuk foto dokumentasi saat troubleshooting dapat dilihat pada link dibawah:\n";
            $documentationLink = $linkDoc . "\n\n";
    
            $conclusionMessage = "Mohon konfirmasi apakah pengerjaan di lanjut atau di batalkan.\nJika ada kerusakan lain di tengah pengerjaan kami akan menginformasikan ulang.\nMisal informasi yang kami sampaikan kurang jelas bisa langsung ngobrol via telfon ya kak 🙏😊\n\n";
    
            $noteMessage = "*Note:* \n- Jasa sudah termasuk include kalibrasi IMU, Gimbal, Vision, pembersihan total dan pergantian pasta.\n- Garansi 1 Bulan *Syarat dan Ketentukan berlaku.\n- Khusus Mavic 3, mavic air 3 dan case masuk air, akan dikenakan biaya minimal Rp 300.000 tergantung penanganan yang telah diberikan (jika dicancel).\n- Jika tidak segera dilakukan konfirmasi maka biaya dapat berubah tergantung harga sparepart saat konfirmasi pengerjaan.\n\n";
    
            $closingMessage = "Terimakasih, Salam satu langit 🙏😊🚁";
    
            $fullMessage = $greetingMessage . $introMessage . $droneInfo . $droneType . $serialNumber . $analysisMessage . $analysisDetails . $estimasiHeader . $estimasiDetails . $totalCostMessage . $documentationMessage . $documentationLink . $conclusionMessage . $noteMessage . $closingMessage;
        
            $urlAPi = 'https://script.google.com/macros/s/AKfycbyC2ojngj6cSxq2kqW3H_wT-FjFBQrCL7oGW9dsFMwIC-JV89B-8gvwp54qX-pvnNeclg/exec';
            $response = Http::post($urlAPi,[
                'no_telpon' => $noTelpon,
                'pesan' => $fullMessage,
            ]);

            $decodePayloads = json_decode($response->body(), true);
            $status = $decodePayloads['status'];
            $message = $decodePayloads['message'];

            if ($status == 'success') {
                return ['status' => 'success', 'message' => $message];
            } else {
                return ['status' => 'error', 'message' => $message];
            }

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    // Penerimaan Part
    public function indexPenerimaanPart()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $repairCase = $this->repairCase->getAllDataNeededNewCase();
        $case = $repairCase['data_case'];
        $sortedCase = $case->sortByDesc(function ($singleCase) {
            return $singleCase->estimasi->updated_at ?? null;
        });

        return view('repair.estimasi.penerimaan-sparepart', [
            'title' => 'Penerimaan Sparepart Estimasi',
            'active' => 'penerimaan-part-estimasi',
            'navActive' => 'estimasi',
            'dropdown' => 'req-part',
            'divisi' => $divisiName,
            'dataCase' => $sortedCase,
        ]);
    }

    public function konfirmasiReqPart(Request $request)
    {
        $this->repairEstimasi->beginTransaction();
        
        try {

            $tanggalKonfirmasi = Carbon::now();
            $tanggalKonfirmasiString = $tanggalKonfirmasi->toDateTimeString();
            $user = auth()->user();
            $namaTeknisi = $user->first_name;
            $employeeId = $user->id;
            $selectCustomer = $request->input('select_customer');
            $statusKonfirmasi = $request->input('status_konfirmasi');
            $statusRequest = $request->input('status_request');
            $findCase = $this->repairCase->findCase($selectCustomer);
            $estimasiId = ($findCase->estimasi) ? $findCase->estimasi->id : '';
            $namaCustomer = $findCase->customer->first_name . ' ' . $findCase->customer->last_name . '-' . $findCase->customer->id . '-' . $findCase->id;
            
            $reqPartId = $request->input('req_part_id');
            $skuPart = $request->input('sku_part');
            $jenisDrone = $request->input('jenis_drone');
            $namaPart = $request->input('nama_part');
            $modalGudang = $request->input('modal_gudang');
            $hargaGudang = $request->input('harga_gudang');
            $hargaRepair = $request->input('harga_repair');
            $hargaCustomer = preg_replace("/[^0-9]/", "",$request->input('harga_customer'));
            $dataReqGudang = [];
            $dataPinjam = [];

            if ($statusKonfirmasi == 'Estimasi') {

                $estimasiData = $this->repairEstimasi->ensureHaveEstimasi($estimasiId);
                if ($estimasiData) {
                    $resultEstimasi = $estimasiData;
                } else {
                    $dataEstimasi = [
                        'employee_id' => $employeeId,
                        'case_id' => $selectCustomer,
                        'status' => 'Estimasi',
                    ];
                    $resultEstimasi = $this->repairEstimasi->createEstimasi($dataEstimasi);
                }

                foreach ($reqPartId as $index => $partId) {
                    $getStatus = $this->repairCase->getNameStatus($statusRequest[$index]);
                    $namaStatus = $getStatus->jenis_status;
                    $dataEstimasiPart = [
                        'estimasi_id' => $resultEstimasi->id,
                        'jenis_transaksi_id' => 1,
                        'sku' => $skuPart[$index],
                        'jenis_produk' => $jenisDrone[$index],
                        'nama_produk' => $namaPart[$index],
                        'nama_alias' => '',
                        'harga_customer' => $hargaCustomer[$index],
                        'harga_repair' => $hargaRepair[$index],
                        'harga_gudang' => $hargaGudang[$index],
                        'modal_gudang' => $modalGudang[$index],
                        'status_proses_id' => $statusRequest[$index],
                        'active' => 'Active',
                    ];

                    $dataReqPart = [
                        'status' => 'Lanjut Estimasi',
                    ];

                    $this->repairEstimasi->updateReqPart($dataReqPart, $partId);
                    $resultEstimasiPart = $this->repairEstimasi->createEstimasiPart($dataEstimasiPart);

                    $dataReqGudang[] = [
                        'idPart' => $resultEstimasiPart->id, 
                        'namaCustomer' => $namaCustomer, 
                        'statusCustomer' => $namaStatus, 
                        'skuPart' => $skuPart[$index], 
                        'jenisDrone' => $jenisDrone[$index], 
                        'namaPart' => $namaPart[$index], 
                        'namaTeknisi' => $namaTeknisi, 
                        'tanggalRequest' => $tanggalKonfirmasiString,
                    ];
                }


                $urlReqPart = 'https://script.google.com/macros/s/AKfycbxGE0TO2PkO3DnyI1f3HtBuKf-3CM-5XJlhXPLtPbiqzILy9iO7Qh_ru7uWcKeoJFa0/exec';
                $responseEstimasi = Http::post($urlReqPart, $dataReqGudang);

            } elseif($statusKonfirmasi == 'Pinjam') {

                foreach ($reqPartId as $index => $partId) {
                    $getStatus = $this->repairCase->getNameStatus($statusRequest[$index]);
                    $namaStatus = $getStatus->jenis_status;
                    $dataPinjam[] = [
                        'idPart' => $partId,
                        'namaCustomer' => $namaCustomer,
                        'statusCustomer' => $namaStatus,
                        'skuPart' => $skuPart[$index],
                        'jenisDrone' => $jenisDrone[$index],
                        'namaPart' => $namaPart[$index],
                        'namaTeknisi' => $namaTeknisi,
                        'tanggalRequest' => $tanggalKonfirmasiString,
                    ];

                    $dataReqPart = [
                        'tanggal_konfirmasi' => $tanggalKonfirmasi,
                        'status' => 'Menunggu Konfirmasi Pinjaman',
                    ];
    
                    $this->repairEstimasi->updateReqPart($dataReqPart, $partId);
                }

                $urlPinjamPart = 'https://script.google.com/macros/s/AKfycbxDbaNfKcE9LHA502clUkSYdX85mHYQgpSGO6z3gdnud_OJsnw7R6LspXeAIJDtxghpgg/exec';
                $response = Http::post($urlPinjamPart, $dataPinjam);

            } else {
                $this->repairEstimasi->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Something Went Wrong.'];
            }

            $this->repairEstimasi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil melakukan konfirmasi request sparepart.'];

        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function requestPartEstimasi(Request $request, $id)
    {
        try {

            $this->repairEstimasi->beginTransaction();

            $user = auth()->user();
            $employeeId = $user->id;
            $tanggal = Carbon::now();
            $tanggalRequest = $tanggal->toDateTimeString();
            $findCase = $this->repairCase->findCase($id);
            $estimasiId = ($findCase->estimasi) ? $findCase->estimasi->id : '';
            $namaCustomer = $findCase->customer->first_name . ' ' . $findCase->customer->last_name . '-' . $findCase->customer->id . '-' . $findCase->id;
            $statusId = $request->input('status_case_id');

            $jenisProduk = $request->input('jenis_produk');
            $namaPart = $request->input('nama_part');
            $skuPart = $request->input('sku_part');
            $namaAlias = $request->input('nama_alias');
            $hargaCustomer = preg_replace("/[^0-9]/", "", $request->input('harga_customer'));
            $hargaRepair = preg_replace("/[^0-9]/", "", $request->input('harga_repair'));
            $hargaGudang = preg_replace("/[^0-9]/", "", $request->input('harga_gudang'));
            $modalGudang = $request->input('modal_gudang');
            $promoGudang = $request->input('promo_gudang');
            $dataToGudang = [];

            $resultEstimasi = $this->repairEstimasi->ensureHaveEstimasi($estimasiId) ?? 
                              $this->repairEstimasi->createEstimasi([
                                  'employee_id' => $employeeId,
                                  'case_id' => $id,
                                  'status' => 'Estimasi',
                              ]);

            foreach ($jenisProduk as $index => $drone) {
                $dataEstimasiPart = [
                    'estimasi_id' => $resultEstimasi->id,
                    'jenis_transaksi_id' => 1,
                    'sku' => $skuPart[$index],
                    'jenis_produk' => $drone,
                    'nama_produk' => $namaPart[$index],
                    'nama_alias' => $namaAlias[$index],
                    'harga_customer' => $hargaCustomer[$index],
                    'harga_repair' => $hargaRepair[$index],
                    'harga_gudang' => $hargaGudang[$index],
                    'modal_gudang' => $modalGudang[$index],
                    'status_proses_id' => $statusId,
                    'active' => 'Wait Send Part',
                ];
                $resultEstimasiPart = $this->repairEstimasi->createEstimasiPart($dataEstimasiPart);

                $dataToGudang[] = [
                    'caseId' => $id,
                    'idPart' => $resultEstimasiPart->id, 
                    'namaCustomer' => $namaCustomer,
                    'skuPart' => $skuPart[$index],
                    'namaProduk' => $drone,
                    'namaPart' => $namaPart[$index],
                    'modalRepair' => $hargaRepair[$index],
                    'hargaCustomer' => $hargaCustomer[$index],
                    'tanggalRequest' => $tanggalRequest,
                ];
            }

            // API request
            try {
                $urlReqPart = 'https://script.google.com/macros/s/AKfycbxSCIwD8QK2scOgjK062KNWY2I7sa0V2bNYVT65HxdaMz_AS5axhRYGdX1szm79Lm2_/exec';
                $responseEstimasi = Http::post($urlReqPart, $dataToGudang);
                $responseDecode = json_decode($responseEstimasi->body(), true);

                if (isset($responseDecode['status']) && $responseDecode['status'] == 'success') {
                    $this->repairEstimasi->commitTransaction();
                    return ['status' => 'success', 'message' => 'Berhasil melakukan request sparepart ke gudang.'];
                } else {
                    Log::error('Gudang API error response', ['response' => $responseDecode]);
                    $this->repairEstimasi->rollbackTransaction();
                    return ['status' => 'error', 'message' => 'Tidak bisa melakukan request ke gudang.'];
                }
            } catch (Exception $e) {
                $this->repairEstimasi->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Failed to send request to Gudang API. Error: ' . $e->getMessage()];
            }

        } catch(Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
        
    }

    public function penerimaanSparepartEstimasi(Request $request)
    {
        try {
            $this->repairEstimasi->beginTransaction();
            $checkboxData = $request->input('checkbox_select_penerimaan');

            foreach ($checkboxData as $id) {
                $dataEstimasiPart = ['tanggal_diterima' => now()];
                $this->repairEstimasi->updateEstimasiPart($dataEstimasiPart, $id);
            }

            $this->repairEstimasi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil melakukan penerimaan part'];

        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function showTimeForChat()
    {
        $hour = date('H');
        $greeting = '';

        if ($hour >= 5 && $hour < 11) {
            $greeting = 'Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Sore';
        } else {
            $greeting = 'Malam';
        }

        return $greeting;
    }

    // Function get data
    public function getJenisTransaksi()
    {
        return $this->repairEstimasi->getJenisTransaksi();
    }

    public function getJenisDrone()
    {
        return $this->produk->getAllJenisProduct();
    }
    
    public function getNamaPart($jenisDrone)
    {
        return $this->produk->getSparepartbyJenis($jenisDrone);
    }

    public function getDetailPart($id)
    {
        $dataGudangEstimasi = $this->estimasiPart
                ->where('gudang_produk_id', $id)
                ->whereNotNull('tanggal_dikirim')
                ->where('active', 'Active')
                ->sum('modal_gudang');

            $dataGudangTransaksi = $this->transaksiPart
                ->where('gudang_produk_id', $id)
                ->sum('modal_gudang');

            $dataGudang = $this->gudangProduk
                ->where('produk_sparepart_id', $id)
                ->first();

            if (!$dataGudang) {
                throw new \Exception("Data gudang tidak ditemukan");
            }

            $dataSubGudang = $dataGudang->produkSparepart->gudangIdItem()->where('status_inventory', 'Ready')->get() ?? 0;
            $totalSN = $dataSubGudang->count();
            $modalAwal = $dataGudang->modal_awal ?? 0;
            $modalGudang = ($totalSN > 0) ? ($modalAwal - ($dataGudangEstimasi + $dataGudangTransaksi)) / $totalSN : 0;
            $hargaJualGudang = ($dataGudang->status == 'Promo') ? $dataGudang->harga_promo : $dataGudang->harga_global;
            $nilai = [
                'modalGudangg' => $modalGudang,
                'hargaGlobal' => $hargaJualGudang,
                'hargaRepair' => $dataGudang->harga_internal,
                'promoGudang' => $dataGudang->harga_promo
            ];
            
        $gudangProduk = $this->produkGudang->findBySparepart($id);
        $stock = $gudangProduk->gudangIdItem->where('status_inventory', 'Ready')->count();
        return response()->json(['stock' => $stock, 'detail' => $gudangProduk]);
    }

    public function getListReqPart($id)
    {
        return $this->repairCase->getListReqPart($id);
    }
    
}