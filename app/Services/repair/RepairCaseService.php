<?php

namespace App\Services\repair;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;

class RepairCaseService
{
    protected $customerRepository, $repairCase, $product;

    public function __construct(RepairCustomerRepository $customerRepository, RepairCaseRepository $repairCase, ProdukRepository $product)
    {
        $this->customerRepository = $customerRepository;
        $this->repairCase = $repairCase;
        $this->product = $product;
    }

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

}
