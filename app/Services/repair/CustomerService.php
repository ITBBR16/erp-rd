<?php

namespace App\Services\repair;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $this->customerRepository->beginTransaction();
        $divisiId = auth()->user()->divisi_id;

        try {
            $request->merge([
                'no_telpon' => preg_replace('/^0/', '62', $request->input('no_telpon')),
            ]);

            $validate = $request->validate([
                'first_name' => 'required|max:50',
                'last_name' => 'required|max:50',
                'asal_informasi' => 'required',
                'no_telpon' => ['required', Rule::unique('rumahdrone_customer.customer', 'no_telpon')],
                'email' => 'nullable|email:dns',
                'instansi' => 'max:50',
                'provinsi' => 'required',
                'nama_jalan' => 'max:255'
            ]);

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

            $appScriptUrl = 'https://script.google.com/macros/s/AKfycbyFTLvq0HaGhnZBjSWH3JLKuRntth2wBKoltkFrGwWQM0UHjG6BMLeaM3guaz9mLCS8/exec';
            $response = Http::post($appScriptUrl, [
                'first_name' => $validate['first_name'],
                'last_name' => $validate['last_name'] . ' - ' . $dataCustomer->id,
                'email' => $validate['email'],
                'no_telpon' => $validate['no_telpon'],
            ]);

            $payloadContact = json_decode($response->body(), true);
            $statusContact = $payloadContact['status'];

            if ($statusContact === 'success') {
                $this->customerRepository->commitTransaction();
                return ['status' => 'success', 'message' => 'Berhasil membuat data customer baru.'];
            } else {
                $this->customerRepository->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Gagal menyimpan kontak. Silahkan coba lagi'];
            }

        } catch (Exception $e) {
            $this->customerRepository->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}