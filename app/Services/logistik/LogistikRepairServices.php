<?php

namespace App\Services\logistik;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Repositories\umum\UmumRepository;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;
use App\Repositories\logistik\repository\LogistikTransactionRepository;
use App\Repositories\logistik\repository\LogistikAPIFormRepairRepository;
use App\Repositories\logistik\repository\LogistikRequestPackingRepository;

class LogistikRepairServices
{
    public function __construct(
        private UmumRepository $umum,
        private LogistikTransactionRepository $transaction,
        private LogistikAPIFormRepairRepository $formRepair,
        private ProdukRepository $product,
        private RepairCustomerRepository $customerRepository,
        private RepairCaseRepository $repairCase,
    ){}

    // Page Penerimaan
    public function indexPenerimaan()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataFormRepair = $this->formRepair->getDataForm();
        $dataProvinsi = $this->customerRepository->getProvinsi();

        return view('logistik.main.index', [
            'title' => 'Penerimaan Barang',
            'active' => 'penerimaan',
            'divisi' => $divisiName,
            'dataFormRepair' => $dataFormRepair,
            'dataProvinsi' => $dataProvinsi,
        ]);
    }

    public function manualForm(Request $request)
    {
        try {
            $this->transaction->beginTransaction();

            $dataForm = [
                'no_register' => $request->input('no_register'),
                'nama_lengkap' => $request->input('nama_lengkap'),
                'no_wa' => preg_replace('/^0/', '62', $request->input('no_whatsapp')),
                'provinsi' => $request->input('provinsi'),
                'kabupaten_kota' => $request->input('kota_kabupaten'),
                'kecamatan' => $request->input('kecamatan'),
                'kelurahan' => $request->input('kelurahan'),
                'kode_pos' => $request->input('kode_pos'),
                'alamat' => $request->input('alamat'),
                'tipe_produk' => $request->input('jenis_drone'),
                'fungsional_produk' => $request->input('fungsional_drone'),
                'keluhan' => $request->input('keluhan'),
                'kronologi_kerusakan' => $request->input('kronologi_kerusakan'),
                'penanganan_after_crash' => $request->input('penanganan_crash'),
                'riwayat_penggunaan' => $request->input('riwayat_penggunaan'),
                'dokumen_customer' => $request->input('dokumen_customer'),
                'ekspedisi' => $request->input('ekspedisi'),
                'no_resi' => $request->input('no_resi'),
                'tanggal_dikirim' => Carbon::parse($request->input('tanggal_dikirim'))->format('Y-m-d H:i:s'),
                'status' => 'On Shipping'
            ];

            $this->formRepair->createDataFormRepair($dataForm);
            $this->transaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil menyimpan data penerimaan barang.'];

        } catch (Exception $e) {
            Log::error('Error in manualForm: ' . $e->getMessage());
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function konfirmasiPenerimaan($noRegister)
    {
        try {
            $this->transaction->beginTransaction();
            
            $timestamp = Carbon::now()->format('Y-m-d H:i:s');
            $dataCustomer = $this->formRepair->findRegister($noRegister);
            $jenisDrone = $dataCustomer->tipe_produk;
            $namaCustomer = $dataCustomer->nama_lengkap;
            $noTelpon = $dataCustomer->no_wa;

            $header = "Yth. {$namaCustomer},\n\n";
            $tipe = "Dengan Tipe Produk :\n{$jenisDrone}\n\n";
            $body = "Produk Anda Sudah Kami Terima Dengan Aman\n";
            $footer = 'Kami Akan Secepatnya Memberitahu Progress Selanjutnya 🙂';
            $message = $header. $tipe . $body . $footer;

            $payload = [
                'no_telpon' => $noTelpon,
                'pesan' => $message,
            ];

            $url = 'https://script.google.com/macros/s/AKfycbyC2ojngj6cSxq2kqW3H_wT-FjFBQrCL7oGW9dsFMwIC-JV89B-8gvwp54qX-pvnNeclg/exec';
            $response = Http::post($url, $payload);

            if ($response->failed()) {
                throw new Exception('Gagal mengirim pesan penerimaan ke customer. Error: ' . $response->body());
            }

            $dataUpdate = [
                'tanggal_diterima' => $timestamp,
                'status' => 'Diterima'
            ];

            $this->formRepair->updateDataFormRepair($noRegister, $dataUpdate);
            $this->transaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Pesan pemberitahuan & update data berhasil.'];
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            Log::error('Error in storeFromFormGoogleRepair: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Page Sent To Repair
    public function indexSentRepair()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataFormRepair = $this->formRepair->getDataForm();

        return view('logistik.main.indexSentRepair', [
            'title' => 'Sent to Repair',
            'active' => 'sent-repair',
            'divisi' => $divisiName,
            'dataFormRepair' => $dataFormRepair
        ]);
    }

    public function pageValidasi($encryptId)
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $idForm = decrypt($encryptId);
        $dataCustomer = $this->formRepair->findDataForm($idForm);
        $dataProvinsi = $this->customerRepository->getProvinsi();
        $jenisDrone = $this->product->getAllJenisProduct();
        $dataJenisDrone = $jenisDrone->map(function ($jenis) {
            return [
                'id' => $jenis->id,
                'display' => $jenis->jenis_produk,
            ];
        });
        $dataDD = $this->repairCase->getAllDataNeededNewCase();
        $fungsionalDrone = $dataDD['fungsional_drone'];

        return view('logistik.main.pages.validasi-to-repair', [
            'title' => 'Sent to Repair',
            'active' => 'sent-repair',
            'divisi' => $divisiName,
            'dataCustomer' => $dataCustomer,
            'jenisDrone' => $dataJenisDrone,
            'dataProvinsi' => $dataProvinsi,
            'fungsionalDrone' => $fungsionalDrone,
        ]);
    }

    public function sentToRepair($id, Request $request)
    {
        try {
            $this->repairCase->beginTransaction();
            $this->transaction->beginTransaction();
            $this->customerRepository->beginTransaction();

            // Get or Create Customer
            $request->merge([
                'no_telpon' => preg_replace('/^0/', '62', $request->input('no_telpon')),
            ]);

            $request->validate([
                'first_name' => 'required|max:50',
                'no_telpon' => 'required',
                'email' => 'nullable|email:dns',
                'instansi' => 'max:50',
                'provinsi' => 'required',
                'nama_jalan' => 'max:255'
            ]);

            $existingCustomer = $this->customerRepository->findByPhoneNumber($request->input('no_telpon'));
            $employeeId = auth()->user()->id;

            if ($existingCustomer) {
                $dataCustomer = $existingCustomer;
            } else {
                $dataInput = [
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'asal_informasi' => 1,
                    'no_telpon' => $request->input('no_telpon'),
                    'by_divisi' => 2,
                    'email' => $request->input('email'),
                    'instansi' => $request->input('instansi'),
                    'provinsi_id' => $request->input('provinsi'),
                    'kota_kabupaten_id' => $request->input('kota_kabupaten'),
                    'kecamatan_id' => $request->input('kecamatan'),
                    'kelurahan_id' => $request->input('kelurahan'),
                    'kode_pos' => $request->input('kode_pos'),
                    'nama_jalan' => $request->input('nama_jalan')
                ];

                $dataCustomer = $this->customerRepository->createCustomer($dataInput);

                // Kirim data ke App Script
                $appScriptUrl = 'https://script.google.com/macros/s/AKfycbwmH6xCZ9XCY4FOJ9V8_p3VwNLi8IRid6hF-Vkfho8RvPeZ1F-nXYdg0e5FinHt6NJS/exec';
                $response = Http::post($appScriptUrl, [
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name') . ' - ' . $dataCustomer->id,
                    'email' => $request->input('email'),
                    'no_telpon' => '+' . $request->input('no_telpon'),
                ]);
    
                if ($response->failed()) {
                    throw new Exception('Something Went Wrong. Error: ' . $response->body());
                }
    
                $responseBody = $response->body();
                Log::info("Response from App Script: " . $responseBody);
            }

            // Input to case repair
            $jenisDroneId = $request->input('str_jenis_drone');
            $fungsional = $request->input('str_fungsional');
            $keluhan = $request->input('str_keluhan');
            $kronologiKerusakan = $request->input('str_kronologi');
            $penggunaanAfterCrash = $request->input('str_penggunaan');
            $riwayatPengguna = $request->input('str_riwayat');

            $dataKelengkapan = $request->input('str_kelengkapan');
            $dataQty = $request->input('str_quantity');
            $dataSN = $request->input('str_sn');
            $dataKeterangan = $request->input('str_keterangan');

            $dataInput = [
                'produk_jenis_id' => $jenisDroneId,
                'jenis_fungsional_id' => $fungsional,
                'jenis_status_id' => 1,
                'jenis_case_id' => 1,
                'employee_id' => $employeeId,
                'customer_id' => $dataCustomer->id,
                'keluhan' => $keluhan,
                'kronologi_kerusakan' => $kronologiKerusakan,
                'penanganan_after_crash' => $penggunaanAfterCrash,
                'riwayat_penggunaan' => $riwayatPengguna,
            ];
            $newCase = $this->repairCase->createNewCase($dataInput);

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
                
                $linkFile = $request->input('link_files');
                $urlMoveFile = 'https://script.google.com/macros/s/AKfycbxxfZMzR_IfSptajZ4yfGZ9zyjEUTHREpq-DQwadcBfWlEOLva4KpaFy8yfkFyjfEmr/exec';
                Http::post($urlMoveFile, [
                    'namaCustomer' => $dataCustomer->first_name . ' ' . $dataCustomer->last_name,
                    'linkCustomer' => $linkDoc,
                    'linkFileCustomer' => $linkFile,
                ]);

                $urlSheetLabel = 'https://script.google.com/macros/s/AKfycbzNiCCCcEbod0Gdkk46UqwKt6D0dM63K5hQaY8po5kz43oRV80bK_LBCGoD9eLNbhntRQ/exec';
                Http::post($urlSheetLabel, [
                    'namaCustomer' => $dataCustomer->first_name . '-' . $dataCustomer->id . '-' . $newCase->id,
                    'jenisDrone' => $dataProduct->jenis_produk,
                ]);

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
                $this->formRepair->updateDataForm($id, ['status' => 'Done InRD']);

                $this->repairCase->commitTransaction();
                $this->transaction->commitTransaction();
                $this->customerRepository->commitTransaction();
                return ['status' => 'success', 'message' => 'Berhasil Mengirimkan Data to Repair'];
            } else {
                $this->repairCase->rollBackTransaction();
                $this->transaction->rollbackTransaction();
                $this->customerRepository->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Terjadi kesalahan silahkan coba lagi.'];
            }

        } catch (Exception $e) {
            $this->repairCase->rollBackTransaction();
            $this->transaction->rollbackTransaction();
            $this->customerRepository->rollbackTransaction();
            Log::error('Error in sentToRepair: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

}