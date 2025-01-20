<?php

namespace App\Services\repair;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Repositories\repair\repository\RepairCustomerRepository;

class CustomerService
{
    protected $customerRepository;

    public function __construct(RepairCustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllProvinsi()
    {
        return $this->customerRepository->getProvinsi();
    }

    public function createNewCustomer(Request $request)
    {
        try {
            $this->customerRepository->beginTransaction();
            $divisiId = auth()->user()->divisi_id;

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

            if ($existingCustomer) {
                $dataCustomer = $existingCustomer;
                $namaCustomer = $dataCustomer->first_name . ' ' . $dataCustomer->last_name . '-' . $dataCustomer->id;
                
                return ['status' => 'error', 'message' => 'No telpon customer sudah terdaftar dengan nama: ' . $namaCustomer];
            } else {
                $dataInput = [
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'asal_informasi' => $request->input('asal_informasi'),
                    'no_telpon' => $request->input('no_telpon'),
                    'by_divisi' => $divisiId,
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
                $this->customerRepository->commitTransaction();
                return ['status' => 'success', 'message' => 'Berhasil menambahkan customer baru.'];
            }

        } catch (Exception $e) {
            $this->customerRepository->rollbackTransaction();
            Log::error('Error in createNewCustomer: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}