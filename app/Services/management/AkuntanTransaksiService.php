<?php

namespace App\Services\management;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\management\repository\AkuntanTransaksiRepository;

class AkuntanTransaksiService
{
    public function __construct(
        private AkuntanTransaksiRepository $akuntanTransaksiRepository,
        private RepairCaseRepository $repairCase
    ){}

    public function createPencocokan(Request $request)
    {
        $this->akuntanTransaksiRepository->beginTransaction();
        $this->repairCase->beginTransaction();

        try {
            $today = Carbon::now();
            $namaBulan = $today->format('F Y');
            $formatTanggal = $today->format('d-m-Y');
            $formatTanggalJam = $today->format('d-m-Y H:i:s');
            $employeeId = auth()->user()->id;
            $mutasiSId = $request->input('data_mutasi');
            $transaksiId = $request->input('data_transaksi');
            $catatan = $request->input('catatan_pencocokan');

            $collectedData = [
                'mutasi' => [],
                'document' => [],
                'transaksi' => [],
                'detailTransaksi' => [],
                'pencocokan' => [],
            ];

            $addedNamaAkun = [];
            $transaksiCreated = null;

            foreach ($mutasiSId as $idMutasi) {
                $mutasi = $this->akuntanTransaksiRepository->findMutasiSementara($idMutasi);
                // Data Mutasi Sementara
                $akunId = $mutasi->akun_id;
                $jenisMutasi = $mutasi->jenis_mutasi;
                $nominal = $mutasi->nominal;
                $keterangan = $mutasi->keterangan;

                // Data Document Sementara
                $documentMutasi = $mutasi->documentSementara;
                $sourceDoc = $documentMutasi->source;
                $tableId = $documentMutasi->table_id;
                $jenisDoc = $documentMutasi->jenis_document;
                $linkDoc = $documentMutasi->link_doc;
                $splitLink = explode('/', $linkDoc);
                $idLinkDoc = $splitLink[5];
            
                $findNamaAkunMutasi = $this->akuntanTransaksiRepository->findNamaAkun($akunId);
                $namaAkunMutasi = $findNamaAkunMutasi->nama_akun;
                $findSaldoAkun = $this->akuntanTransaksiRepository->getSaldoAkhirAkun($akunId);
                $decideSaldo = ($findSaldoAkun->saldo_akhir) ? $findSaldoAkun->saldo_akhir : $findSaldoAkun->saldo_awal;
                $saldoAkhir = $decideSaldo + $nominal;
            
                $dataRealMutasi = [
                    'employee_id' => $employeeId,
                    'akun_id' => $akunId,
                    'jenis_mutasi' => $jenisMutasi,
                    'nominal' => $nominal,
                    'saldo_awal' => $decideSaldo,
                    'saldo_akhir' => $saldoAkhir,
                    'keterangan' => $keterangan,
                ];

                $updateMutasiSementara = ['status' => 'Done'];
                $this->akuntanTransaksiRepository->updateMutasiSementara($updateMutasiSementara, $idMutasi);

                $commitMutasi = $this->akuntanTransaksiRepository->createMutasi($dataRealMutasi);
                $idNewMutasi[] = $commitMutasi->id;

                $dataDocMutasi = [
                    'fileIdMutasi' => $idLinkDoc,
                    'bulan' => $namaBulan,
                    'tanggal' => $formatTanggal,
                    'akunMutasi' => $namaAkunMutasi,
                ];
                $urlApiDoc = 'https://script.google.com/macros/s/AKfycbx6RAxHpfJdWWJpy7tBIj1Ow164V_oems5FedYzoYvy9dceNpxDj5QkFAZmFb-pShvwdQ/exec';
                $responseMutasi = Http::post($urlApiDoc, $dataDocMutasi);

                if ($responseMutasi->successful()) {
                    $resultMutasi = $responseMutasi->json();
                    if ($resultMutasi['status'] === 'success') {
                        $dataDocument = [
                            'source' => 'Mutasi',
                            'table_id' => $commitMutasi->id,
                            'jenis_document' => 'Mutasi',
                            'link_doc' => $resultMutasi['fileMutasiUrl'],
                        ];
                        $createDocMutasi = $this->akuntanTransaksiRepository->createDocument($dataDocument);
                        $collectedData['document'][] = $createDocMutasi;
                    } else {
                        $this->akuntanTransaksiRepository->rollbackTransaction();
                        $this->repairCase->rollBackTransaction();
                        return ['status' => 'error', 'message' => 'Gagal mengunggah file mutasi.'];
                    }
                } else {
                    $this->akuntanTransaksiRepository->rollbackTransaction();
                    $this->repairCase->rollBackTransaction();
                    return ['status' => 'error', 'message' => 'Terjadi kesalahan kletika menghubungkan ke API.'];
                }

                $commitMutasi->nama_akun = $namaAkunMutasi;
                $commitMutasi->tanggal = $formatTanggalJam;
                $collectedData['mutasi'][] = $commitMutasi;

                foreach ($transaksiId as $idTransaksi) {
                    preg_match('/[A-Za-z]+/', $idTransaksi, $jenisInvoice);
                    preg_match('/\d+/', $idTransaksi, $noInvoice);

                    if ($jenisInvoice[0] == 'R') {
                        $findCaseRepair = $this->repairCase->findCase($noInvoice[0]);
                        $idCustomer = $findCaseRepair->customer->id;
                        
                        $transaksiRepair = $this->repairCase->findTransaksiByCase($noInvoice[0]);
                        $transaksiRepairId = $transaksiRepair->id;
                        $totalPembayaran = $transaksiRepair->total_pembayaran;
                        $keteranganTransaksi = $transaksiRepair->keterangan;
                        $linkTransaksi = $transaksiRepair->link_invoice;
                        $splitLinkInvoice = explode('/', $linkTransaksi);
                        $idLinkInvoice = $splitLinkInvoice[5];

                        $estimasi = $this->akuntanTransaksiRepository->findeEstimasiRepair($noInvoice);

                        $estimasiPart = $estimasi->estimasiPart;
                        $estimasiJasa = $estimasi->estimasiJrr;

                        $totalPendapatan = [];
                        $totalSaldoPartGudang = 0;
                        $totalPendapatanPartGudang = 0;

                        if (!empty($estimasiPart)) {
                            foreach ($estimasiPart as $epart) {
                                if ($epart->active == 'Active') {
                                    $saldoPartGudang = $epart->modal_gudang;
                                    $pendapatanPartGudang = $epart->harga_gudang - $saldoPartGudang;
                                    $pendapatanRepairPart = $epart->harga_customer - $epart->harga_repair;

                                    $totalSaldoPartGudang += $saldoPartGudang;
                                    $totalPendapatanPartGudang += $pendapatanPartGudang;

                                    if (isset($totalPendapatan[$epart->jenisTransaksi->jenis_transaksi])) {
                                        $totalPendapatan[$epart->jenisTransaksi->jenis_transaksi] += $pendapatanRepairPart;
                                    } else {
                                        $totalPendapatan[$epart->jenisTransaksi->jenis_transaksi] = $pendapatanRepairPart;
                                    }
                                }
                            }
                        }

                        if (!empty($estimasiJasa)) {
                            foreach ($estimasiJasa as $ejasa) {
                                if ($ejasa->active == 'Active') {
                                    $pendapatanJasa = $ejasa->harga_customer;

                                    if (isset($totalPendapatan[$ejasa->jenisTransaksi->jenis_transaksi])) {
                                        $totalPendapatan[$ejasa->jenisTransaksi->jenis_transaksi] += $pendapatanJasa;
                                    } else {
                                        $totalPendapatan[$ejasa->jenisTransaksi->jenis_transaksi] = $pendapatanJasa;
                                    }
                                }
                            }
                        }

                        if (!$transaksiCreated) {
                            $dataTransaksi = [
                                'divisi_id' => 2,
                                'invoice_id' => $noInvoice[0],
                                'asal_transaksi' => 'Kasir',
                                'jenis_transaksi' => 'Masuk',
                                'total_nominal' => $totalPembayaran,
                                'keterangan' => $keteranganTransaksi,
                            ];

                            $transaksiCreated = $this->akuntanTransaksiRepository->createTransaksi($dataTransaksi);
                            $this->repairCase->updateTransaksi($transaksiRepairId, ['status_recap' => 'Done']);
                            
                            $transaksiCreated->increment_customer = $idCustomer;
                            $transaksiCreated->nama_divisi = 'Repair';
                            $transaksiCreated->tanggal = $formatTanggalJam;
                            $collectedData['transaksi'][] = $transaksiCreated;

                            $dataDocTransaksi = [
                                'fileIdInvoice' => $idLinkInvoice,
                                'bulan' => $namaBulan,
                                'tanggal' => $formatTanggal,
                            ];
                            $responseTransaksi = Http::post($urlApiDoc, $dataDocTransaksi);

                            if ($responseTransaksi->successful()) {
                                $resultTransaksi = $responseTransaksi->json();
                                if ($resultTransaksi['status'] === 'success') {
                                    $docTransaksi = [
                                        'source' => 'Transaksi',
                                        'table_id' => $transaksiCreated->id,
                                        'jenis_document' => 'Invoice',
                                        'link_doc' => $resultTransaksi['fileTransaksiUrl'],
                                    ];
                                    $createDocTransaksi = $this->akuntanTransaksiRepository->createDocument($docTransaksi);
                                    $collectedData['document'][] = $createDocTransaksi;
                                } else {
                                    $this->akuntanTransaksiRepository->rollbackTransaction();
                                    $this->repairCase->rollBackTransaction();
                                    return ['status' => 'error', 'message' => 'Gagal mengunggah file mutasi.'];
                                }
                            } else {
                                $this->akuntanTransaksiRepository->rollbackTransaction();
                                $this->repairCase->rollBackTransaction();
                                return ['status' => 'error', 'message' => 'Terjadi kesalahan kletika menghubungkan ke API.'];
                            }
                        }

                        foreach ($totalPendapatan as $jenisTransaksi => $nominal) {
                            $findNamaAkun = $this->akuntanTransaksiRepository->findTransaksiNamaAkun($transaksiCreated->id, $jenisTransaksi);

                            if ($findNamaAkun) {
                                $this->akuntanTransaksiRepository->updateTransaksiDetail(['nominal' => $nominal], $findNamaAkun->id);
                            } else {
                                $dataDetailTransaksi = [
                                    'transaksi_id' => $transaksiCreated->id,
                                    'nama_akun' => $jenisTransaksi,
                                    'nominal' => $nominal,
                                ];

                                $createdDetailTransaksi = $this->akuntanTransaksiRepository->createDetailTransaksi($dataDetailTransaksi);
                                $collectedData['detailTransaksi'][] = $createdDetailTransaksi;
                                $addedNamaAkun[] = $jenisTransaksi;
                            }
                        }

                        $akunTambahan = [
                            ['nama_akun' => 'Saldo Gudang Sparepart Baru', 'nominal' => $totalSaldoPartGudang],
                            ['nama_akun' => 'Pendapatan Gudang Sparepart Baru', 'nominal' => $totalPendapatanPartGudang],
                        ];

                        foreach ($akunTambahan as $akun) {
                            $findAkunTambahan = $this->akuntanTransaksiRepository->findTransaksiNamaAkun($transaksiCreated->id, $akun['nama_akun']);

                            if ($findAkunTambahan) {
                                $this->akuntanTransaksiRepository->updateTransaksiDetail(['nominal' => $akun['nominal']], $findAkunTambahan->id);
                            } else {
                                $dataDetailTransaksiTambahan = [
                                    'transaksi_id' => $transaksiCreated->id,
                                    'nama_akun' => $akun['nama_akun'],
                                    'nominal' => $akun['nominal'],
                                ];

                                $createdDetailTransaksiTambahan = $this->akuntanTransaksiRepository->createDetailTransaksi($dataDetailTransaksiTambahan);
                                $collectedData['detailTransaksi'][] = $createdDetailTransaksiTambahan;
                            }
                        }

                        $commitMutasi->mergeMutasiTransaksiRepair()->attach([
                            $transaksiCreated->id => [
                                'status_penjurnalan' => 0,
                                'catatan' => $catatan,
                            ]
                        ]);

                        $dataPencocokan = [
                            'mutasi_id' => $commitMutasi->id,
                            'transaksi_id' => $transaksiCreated->id,
                            'status_penjurnalan' => 0,
                            'catatan' => $catatan,
                        ];
                        $collectedData['pencocokan'][] = $dataPencocokan;
                    }
                }
            }

            $urlApiDataKasir = 'https://script.google.com/macros/s/AKfycbwrhuSx9dvbCs-UU18_TvzX7me_uQkNaaLWkAuA8QH1vy7-Inp1Xy1nQa_dwZGmWPzCGA/exec';
            $responseDataKasir = Http::post($urlApiDataKasir, $collectedData);

            if ($responseDataKasir->successful()) {
                $resultDK = $responseDataKasir->json();
                if ($resultDK['status'] == 'success') {
                    $this->akuntanTransaksiRepository->commitTransaction();
                    $this->repairCase->commitTransaction();
                } else {
                    $this->akuntanTransaksiRepository->rollbackTransaction();
                    $this->repairCase->rollBackTransaction();
                    return ['status' => 'error', 'message' => 'Terjadi kesalahan saat melakukan transfer data ke spreadsheet.'];
                }
            } else {
                $this->akuntanTransaksiRepository->rollbackTransaction();
                $this->repairCase->rollBackTransaction();
                return ['status' => 'error', 'message' => 'Terjadi kesalahan kletika menghubungkan ke API.'];
            }

            return [
                'status' => 'success', 
                'message' => 'Berhasil melakukan pencocokan mutasi transaksi.'
            ];

        } catch (Exception $e) {
            $this->akuntanTransaksiRepository->rollbackTransaction();
            $this->repairCase->rollBackTransaction();
            return [
                'status' => 'error', 
                'message' => 'Gagal melakukan pencocokan mutasi transaksi: ' . $e->getMessage()
            ];
        }
    }

    public function createMutasiSementara(Request $request)
    {
        $this->akuntanTransaksiRepository->beginTransaction();

        try {
            $today = Carbon::now();
            $formatTanggal = $today->format('dmY');
            $employeeId = auth()->user()->id;
            $akunId = $request->input('nama_akun');
            $jenisMutasi = $request->input('jenis_mutasi');
            $nominalMutasi = preg_replace("/[^0-9]/", "",$request->input('nominal_mutasi'));
            $keteranganMutasi = $request->input('keterangan_mutasi');
            $saldoAkhirSebelum = preg_replace("/[^0-9]/", "",$request->input('saldo_akhir_sebelum'));
            $fileMutasi = base64_encode($request->file('file_mutasi')->get());
            $findAkun = $this->akuntanTransaksiRepository->findNamaAkun($akunId);
            $namaAkun = $findAkun->nama_akun;

            $dataMutasiSementara = [
                'employee_id' => $employeeId,
                'akun_id' => $akunId,
                'jenis_mutasi' => $jenisMutasi,
                'nominal' => $nominalMutasi,
                'keterangan' => $keteranganMutasi,
            ];

            $createMS = $this->akuntanTransaksiRepository->createMutasiSementara($dataMutasiSementara);

            $dataPayload = [
                'namaFile' => $formatTanggal . '_ms_' . $namaAkun,
                'file' => $fileMutasi,
            ];
            $urlApiMutasi = 'https://script.google.com/macros/s/AKfycbyHpcjXIwS1zaM9un59eVfjjAM4Q9zs_wN-fBTsGl51Fu4ngZMkQs72uAw7SZpL-eFV/exec';
            $response = Http::post($urlApiMutasi, $dataPayload);

            if ($response->successful()) {
                $result = $response->json();
                if ($result['status'] === 'success') {
                    $dataDocument = [
                        'source' => 'Mutasi',
                        'table_id' => $createMS->id,
                        'jenis_document' => 'Mutasi',
                        'link_doc' => $result['fileUrl'],
                    ];
                    $this->akuntanTransaksiRepository->createDocumentasiSementara($dataDocument);
                    $this->akuntanTransaksiRepository->commitTransaction();

                    return ['status' => 'success', 'message' => 'Berhasil membuat mutasi baru.'];
                } else {
                    $this->akuntanTransaksiRepository->rollbackTransaction();
                    return ['status' => 'error', 'message' => 'Gagal mengunggah file mutasi.'];
                }
            } else {
                $this->akuntanTransaksiRepository->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Terjadi kesalahan kletika menghubungkan ke API.'];
            }

        } catch (Exception $e) {
            $this->akuntanTransaksiRepository->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getAkunKasir()
    {
        return $this->akuntanTransaksiRepository->getAkunKasir();
    }

    public function getMutasi()
    {
        return $this->akuntanTransaksiRepository->getDataMutasi();
    }

    public function getMutasiSementara()
    {
        return $this->akuntanTransaksiRepository->getDataMutasiSementara();
    }

    public function getDataTransaksi()
    {
        return $this->akuntanTransaksiRepository->getDataTransaksi();
    }

    public function getSaldoAkhirAkun($id)
    {
        return $this->akuntanTransaksiRepository->getSaldoAkhirAkun($id);
    }

    public function findMutasiSementara($id)
    {
        return $this->akuntanTransaksiRepository->findMutasiSementara($id);
    }

    public function findTransaksi($source, $id)
    {
        if ($source == 'R') {
            return $this->repairCase->findTransaksiByCase($id);
        } elseif ($source == 'K') {

        } else {
            
        }
    }
}