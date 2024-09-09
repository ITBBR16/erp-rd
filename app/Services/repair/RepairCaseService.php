<?php

namespace App\Services\repair;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;
use App\Repositories\repair\repository\RepairTimeJurnalRepository;

class RepairCaseService
{
    protected $customerRepository, $repairCase, $product, $repairTimeJurnal;

    public function __construct(RepairCustomerRepository $customerRepository, RepairCaseRepository $repairCase, ProdukRepository $product, RepairTimeJurnalRepository $repairTimeJurnalRepository)
    {
        $this->repairTimeJurnal = $repairTimeJurnalRepository;
        $this->customerRepository = $customerRepository;
        $this->repairCase = $repairCase;
        $this->product = $product;
    }

    // Input New Case
    public function getDataDropdown()
    {
        $dataDD = $this->repairCase->getAllDataNeededNewCase();
        return [
            'data_customer' => $this->customerRepository->getDataCustomer(),
            'data_provinsi' => $this->customerRepository->getProvinsi(),
            'jenis_drone' => $this->product->getAllProduct(),
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
            $dataProduct = $this->product->findProduct($jenisDroneId);
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

    // Sparepart
    public function createReqSparepart(Request $request, $id)
    {
        try {
            $tglRequest = Carbon::now();
            $statusCaseId = $request->input('status_case_id');
            $jenisProduk = $request->input('jenis_produk');
            $namaPart = $request->input('nama_part');
            $skuPart = $request->input('sku_part');
            $qtyReq = $request->input('qty_req');
            $dataSendGudang = [];

            foreach ($jenisProduk as $index => $produk) {
                $qtyItem = $qtyReq[$index];
                for ($i = 0; $i < $qtyItem; $i++) {
                    $dataSendGudang[] = [
                        'case_id' => $id,
                        'sku' => $skuPart[$index],
                        'jenis_produk' => $produk,
                        'nama_produk' => $namaPart[$index],
                        'status_proses_id' => $statusCaseId,
                        'tanggal_request' => $tglRequest,
                        'status' => 'Request',
                    ];

                }
            }

            return ['status' => 'success', 'message' => 'Berhasil melakukan request sparepart.'];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getDataRequest()
    {
        return $this->repairCase->getDataRequestPart();
    }

}
