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

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($caseId, 4);

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
                        'active' => 'Active',
                        'created_at' => $tglWaktu,
                        'updated_at' => $tglWaktu,
                    ];
                } else {
                    $dataEstimasiJRR[] = [
                        'estimasi_id' => $createEstimasi->id,
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
            $createJrr = [];
            
            // Data Part
            $hargaRepair = preg_replace("/[^0-9]/", "",$request->input('harga_repair'));
            $hargaGudang = preg_replace("/[^0-9]/", "",$request->input('harga_gudang'));
            $modalGudang = preg_replace("/[^0-9]/", "",$request->input('modal_gudang'));
            $createPart = [];
            
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
                        $createPart[] = [
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
                        $createJrr[] = [
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
                    'jenis_status_id' => 4,
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
            
            if(!empty($createJrr) ) {
                $this->repairEstimasi->createEstimasiJrr($createJrr);
            }

            if (!empty($createPart) ) {
                $this->repairEstimasi->createEstimasiPart($createPart);
            }

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
            $isiJurnal = ($status == 'lanjut') ? 'Lanjut menunggu konfirmasi pengerjaan' : 'Cancel customer tidak lanjut';
            $jenisStatusId = ($status == 'lanjut') ? 5 : 10;

            if ($status == 'cancel') {
                $dataUpdateCase = [
                    'jenis_status_id' => $jenisStatusId,
                ];

                $this->repairCase->updateCase($id, $dataUpdateCase);
            } else {
                $dataUpdateCase = [
                    'jenis_status_id' => $jenisStatusId,
                ];

                $this->repairCase->updateCase($id, $dataUpdateCase);
            }

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
                'jenis_status_id' => 6,
                'tanggal_waktu' => $tglWaktu,
            ];
            $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 1,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Mulai Proses Pengerjaan',
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $dataUpdateCase = [
                'jenis_status_id' => 6,
            ];

            $this->repairCase->updateCase($id, $dataUpdateCase);

            $this->repairEstimasi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil konfirmasi pengerjaan'];
        } catch (Exception $e) {
            $this->repairEstimasi->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function kirimPesanKonfirmasiEstimasi(Request $request, $greeting)
    {
        try {
            $noTelpon = $request->input('no_customer');
            $namaCustomer = $request->input('nama_customer');
            $namaNota = $request->input('nama_nota');
            $jenisDrone = $request->input('jenis_drone');
            $SN = $request->input('serial_number');
            $hasilAnalisaTs = $request->input('hasil_analisa_ts');
            $dataEstimasi = $request->input('data_estimasi');
            $hargaCustomer = $request->input('estimasi_harga_customer');
            $linkDoc = $request->input('link_doc');

            $greetingMessage = "*Selamat " . $greeting . " " . $namaCustomer . "* 😊\n\n";
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
                'no_telpon' => '6285156519066',
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