<?php

namespace App\Services\repair;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\repair\repository\RepairEstimasiRepository;
use App\Repositories\repair\repository\RepairTimeJurnalRepository;

class RepairEstimasiService
{
    protected $repairCase, $repairEstimasi, $repairTimeJurnal;

    public function __construct(RepairCaseRepository $repairCaseRepository, RepairEstimasiRepository $repairEstimasiRepository, RepairTimeJurnalRepository $repairTimeJurnalRepository)
    {
        $this->repairCase = $repairCaseRepository;
        $this->repairEstimasi = $repairEstimasiRepository;
        $this->repairTimeJurnal = $repairTimeJurnalRepository;
    }

    public function dataJenisTransaksi()
    {
        return $this->repairEstimasi->getJenisTransaksi();
    }

    public function addJurnalEstimasi(Request $request)
    {
        $this->repairEstimasi->beginTransaction();

        try {

            $employeeId = auth()->user()->id;
            $caseId = $request->input('case_id');
            $isiJurnal = $request->input('jurnal_estimasi');
            $tglWaktu = Carbon::now();

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($caseId, 3);

            if ($checkTimestamp) {
                $timestamp = $checkTimestamp;
            } else {
                $dataTimestamp = [
                    'case_id' => $caseId,
                    'jenis_status_id' => 3,
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
            $jenisPartJasa = $request->input('jenis_part_jasa');
            $namaPartJasa = $request->input('nama_part_jasa');
            $namaAlias = $request->input('nama_alias');
            $hargaCustomer = preg_replace("/[^0-9]/", "",$request->input('harga_customer'));
            $namaPartGudang = $request->input('nama_part');
            $dataEstimasiJRR = [];
        
            // Data Part
            $hargaRepair = preg_replace("/[^0-9]/", "",$request->input('harga_repair'));
            $hargaGudang = preg_replace("/[^0-9]/", "",$request->input('harga_gudang'));
            $modalGudang = preg_replace("/[^0-9]/", "",$request->input('modal_gudang'));
            $dataEstimasiPart = [];
        
            foreach ($jenisTransaksi as $index => $jt) {
                if ($jt == 1) {
                    $dataEstimasiPart[] = [
                        'estimasi_id' => $createEstimasi->id,
                        'jenis_transaksi_id' => $jt,
                        'sku' => $namaPartJasa[$index],
                        'jenis_produk' => $jenisPartJasa[$index],
                        'nama_produk' => $namaPartGudang[$index],
                        'nama_alias' => $namaAlias[$index],
                        'harga_customer' => $hargaCustomer[$index],
                        'harga_repair' => $hargaRepair[$index],
                        'harga_gudang' => $hargaGudang[$index],
                        'modal_gudang' => $modalGudang[$index],
                        'status_proses_id' => 3,
                        'active' => 'Active'
                    ];
                } else {
                    $dataEstimasiJRR[] = [
                        'estimasi_id' => $createEstimasi->id,
                        'jenis_transaksi_id' => $jt,
                        'jenis_jasa' => $jenisPartJasa[$index],
                        'nama_jasa' => $namaPartJasa[$index],
                        'harga_customer' => $hargaCustomer[$index],
                        'active' => 'Active'
                    ];
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

            $this->repairEstimasi->createEstimasiPart($dataEstimasiPart);
            $this->repairEstimasi->createEstimasiJrr($dataEstimasiJRR);
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

            $employeeId = auth()->user()->id;
            $tglWaktu = Carbon::now();
            $pesanHasilTs = $request->input('pesan_hasil_ts');
    
            // Data Estimasi JRR
            $jenisTransaksi = $request->input('jenis_transaksi');
            $jenisPartJasa = $request->input('jenis_part_jasa');
            $namaPartJasa = $request->input('nama_part_jasa');
            $namaAlias = $request->input('nama_alias');
            $hargaCustomer = preg_replace("/[^0-9]/", "",$request->input('harga_customer'));
            $namaPartGudang = $request->input('nama_part');
            $dataEstimasiJRR = [];
            
            // Data Part
            $hargaRepair = preg_replace("/[^0-9]/", "",$request->input('harga_repair'));
            $hargaGudang = preg_replace("/[^0-9]/", "",$request->input('harga_gudang'));
            $modalGudang = preg_replace("/[^0-9]/", "",$request->input('modal_gudang'));
            $dataEstimasiPart = [];
            
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
                            'nama_alias' => $namaAliasLama[$index],
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
                        $dataEstimasiPart[] = [
                            'estimasi_id' => $id,
                            'jenis_transaksi_id' => $jt,
                            'sku' => $namaPartJasa[$index],
                            'jenis_produk' => $jenisPartJasa[$index],
                            'nama_produk' => $namaPartGudang[$index],
                            'nama_alias' => $namaAlias[$index],
                            'harga_customer' => $hargaCustomer[$index],
                            'harga_repair' => $hargaRepair[$index],
                            'harga_gudang' => $hargaGudang[$index],
                            'modal_gudang' => $modalGudang[$index],
                            'status_proses_id' => 3,
                            'active' => 'Active',
                            'created_at' => $tglWaktu,
                            'updated_at' => $tglWaktu,
                        ];
                    } else {
                        $dataEstimasiJRR[] = [
                            'estimasi_id' => $id,
                            'jenis_transaksi_id' => $jt,
                            'jenis_jasa' => $jenisPartJasa[$index],
                            'nama_jasa' => $namaPartJasa[$index],
                            'harga_customer' => $hargaCustomer[$index],
                            'active' => 'Active',
                            'created_at' => $tglWaktu,
                            'updated_at' => $tglWaktu,
                        ];
                    }
                }
            }

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

            $dataChatEstimasi = [
                'isi_chat' => $pesanHasilTs,
            ];
    
            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 2,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Rubah hasil estimasi.',
            ];
    
            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $this->repairEstimasi->updateEstimasiChat($dataChatEstimasi, $id);
            
            if($dataEstimasiJRR != '') {
                $this->repairEstimasi->createEstimasiJrr($dataEstimasiJRR);
            }

            if ($dataEstimasiPart != '') {
                $this->repairEstimasi->createEstimasiPart($dataEstimasiPart);
            }

            $this->repairEstimasi->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil merubah hasil estimasi.'];

        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

    public function getJenisDrone($jenisTransaksi)
    {
        $urlAPi = 'https://script.google.com/macros/s/AKfycbx0RQkM6hdlvBlaO6Hyt1NpK5e3c5Mbj5m-3u4AoZsgtSF49e5MHfNK6mSnzU_8mpB5/exec';
        $response = Http::post($urlAPi, [
            'status' => $jenisTransaksi,
            'jenisDrone' => '',
            'sku' => '',
        ]);

        $data = $response->json();
        $resultData = [];

        foreach ($data['data'] as $part) {
            $dataPart = [
                'jenisDrone' => $part,
            ];
            $resultData[] = $dataPart;
        }

        return response()->json($resultData);
    }

    public function getNamaPart($jenisTransaksi, $jenisDrone)
    {
        $urlAPi = 'https://script.google.com/macros/s/AKfycbx0RQkM6hdlvBlaO6Hyt1NpK5e3c5Mbj5m-3u4AoZsgtSF49e5MHfNK6mSnzU_8mpB5/exec';
        $response = Http::post($urlAPi, [
            'status' => $jenisTransaksi,
            'jenisDrone' => $jenisDrone,
            'sku' => '',
        ]);

        $data = $response->json();
        $resultData = [];

        foreach ($data['data'] as $part) {
            $dataPart = [
                'sku' => $part[0],
                'namaPart' => $part[2],
            ];
            $resultData[] = $dataPart;
        }

        return response()->json($resultData);
    }

    public function getDetailPart($jenisTransaksi, $sku)
    {
        $urlAPi = 'https://script.google.com/macros/s/AKfycbx0RQkM6hdlvBlaO6Hyt1NpK5e3c5Mbj5m-3u4AoZsgtSF49e5MHfNK6mSnzU_8mpB5/exec';
        $response = Http::post($urlAPi, [
            'status' => $jenisTransaksi,
            'jenisDrone' => '',
            'sku' => $sku,
        ]);

        $data = $response->json();
        $resultData = [
            'stok' => $data['stok'],
            'modal' => $data['modalPart'],
            'srpRepair' => $data['hargaRepair'],
            'srpGudang' => $data['hargaGudang'],
        ];

        return response()->json($resultData);
    }
    
}