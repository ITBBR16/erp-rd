<?php

namespace App\Services\management;

use App\Repositories\management\repository\AkuntanTransaksiRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AkuntanTransaksiService
{
    public function __construct(
        private AkuntanTransaksiRepository $akuntanTransaksiRepository
    ){}

    public function createPencocokan(Request $request)
    {
        $this->akuntanTransaksiRepository->beginTransaction();

        try {
            $employeeId = auth()->user()->id;
            $mutasiSId = $request->input('data_mutasi');
            $transaksiId = $request->input('data_transaksi');
            $catatan = $request->input('catatan_pencocokan');

            foreach ($mutasiSId as $idMutasi) {
                $mutasi = $this->akuntanTransaksiRepository->findMutasiSementara($idMutasi);
                $akunId = $mutasi->akun_id;
                $jenisMutasi = $mutasi->jenis_mutasi;
                $nominal = $mutasi->nominal;
                $keterangan = $mutasi->keterangan;
            
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
            
                foreach ($transaksiId as $idTransaksi) {
                    preg_match('/[A-Za-z]+/', $idTransaksi, $jenisInvoice);
                    preg_match('/\d+/', $idTransaksi, $noInvoice);
            
                    if ($jenisInvoice[0] == 'R') {
                        $transaksiRepair = $this->akuntanTransaksiRepository->findTransaksiRepair($noInvoice[0]);
                        $totalPembayaran = $transaksiRepair->total_pembayaran;
                        $keteranganTransaksi = $transaksiRepair->keterangan;
                        $estimasi = $this->akuntanTransaksiRepository->findeEstimasiRepair($noInvoice);
            
                        $estimasiPart = $estimasi->estimasiPart;
                        $estimasiJasa = $estimasi->estimasiJrr;
            
                        $totalPendapatan = [];
                        $totalSaldoPartGudang = 0;
                        $totalPendapatanPartGudang = 0;
            
                        if (!empty($estimasiPart)) {
                            foreach ($estimasiPart as $epart) {
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
            
                        if (!empty($estimasiJasa)) {
                            foreach ($estimasiJasa as $ejasa) {
                                $pendapatanJasa = $ejasa->harga_customer;
            
                                if (isset($totalPendapatan[$ejasa->jenisTransaksi->jenis_transaksi])) {
                                    $totalPendapatan[$ejasa->jenisTransaksi->jenis_transaksi] += $pendapatanJasa;
                                } else {
                                    $totalPendapatan[$ejasa->jenisTransaksi->jenis_transaksi] = $pendapatanJasa;
                                }
                            }
                        }
            
                        $dataTransaksi = [
                            'divisi_id' => 2,
                            'invoice_id' => $noInvoice[0],
                            'asal_transaksi' => 'Kasir',
                            'jenis_transaksi' => 'Masuk',
                            'total_nominal' => $totalPembayaran,
                            'keterangan' => $keteranganTransaksi,
                        ];
            
                        $createTransaksi = $this->akuntanTransaksiRepository->createTransaksi($dataTransaksi);
            
                        foreach ($totalPendapatan as $jenisTransaksi => $nominal) {
                            $findNamaAkun = $this->akuntanTransaksiRepository->findTransaksiNamaAkun($createTransaksi->id, $jenisTransaksi);
            
                            if ($findNamaAkun) {
                                $this->akuntanTransaksiRepository->updateTransaksiDetail(['nominal' => $nominal], $findNamaAkun->id);
                            } else {
                                $dataDetailTransaksi = [
                                    'transaksi_id' => $createTransaksi->id,
                                    'nama_akun' => $jenisTransaksi,
                                    'nominal' => $nominal,
                                ];
            
                                $this->akuntanTransaksiRepository->createDetailTransaksi($dataDetailTransaksi);
                            }
                        }

                        $akunTambahan = [
                            ['nama_akun' => 'Saldo Gudang Sparepart Baru', 'nominal' => $totalSaldoPartGudang],
                            ['nama_akun' => 'Pendapatan Gudang Sparepart Baru', 'nominal' => $totalPendapatanPartGudang],
                        ];

                        foreach ($akunTambahan as $akun) {
                            $dataDetailTransaksiTambahan = [
                                'transaksi_id' => $createTransaksi->id,
                                'nama_akun' => $akun['nama_akun'],
                                'nominal' => $akun['nominal'],
                            ];
            
                            $this->akuntanTransaksiRepository->createDetailTransaksi($dataDetailTransaksiTambahan);
                        }
            
                        $commitMutasi->mergeMutasiTransaksiRepair()->attach($createTransaksi, [
                            'status_penjurnalan' => 0,
                            'catatan' => $catatan
                        ]);
                    }
                }
            }

            $this->akuntanTransaksiRepository->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil melakukan pencocokan mutasi transaksi.'];

        } catch (Exception $e) {
            $this->akuntanTransaksiRepository->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
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
            return $this->akuntanTransaksiRepository->findTransaksiRepair($id);
        } elseif ($source == 'K') {

        } else {
            
        }
    }
}