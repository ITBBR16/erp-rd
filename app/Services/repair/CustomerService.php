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

            $validate['by_divisi'] = $divisiId;

            $dataCustomer = $this->customerRepository->createCustomer($validate);

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