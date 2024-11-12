<?php

namespace App\Services\gudang;

use App\Repositories\gudang\repository\GudangSupplierRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\umum\UmumRepository;
use Exception;
use Illuminate\Http\Request;

class GudangSupplierServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private GudangSupplierRepository $supplier,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $suppliers = $this->supplier->getSuppliers();
        
        return view('gudang.purchasing.supplier.supplier', [
            'title' => 'Gudang Supplier',
            'active' => 'gudang-supplier',
            'navActive' => 'purchasing',
            'divisi' => $divisiName,
            'suppliers' => $suppliers
        ]);
    }

    public function createSupplier(Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            $dataSupplier = [
                'nama' => strtoupper($request->input('nama_supplier')),
                'negara' => ucwords($request->input('negara')),
                'provinsi' => ucwords($request->input('provinsi')),
                'kota' => ucwords($request->input('kota')),
                'alamat' => $request->input('alamat'),
                'kontak_person' => ucwords($request->input('contact_person')),
                'no_telpon' => $request->input('no_telpon'),
                'email' => $request->input('email'),
                'status' => 'Active',
            ];

            $this->supplier->createSupplier($dataSupplier);
            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil menambahkan supplier baru.'];
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateSupplier($id, Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            $dataSupplier = [
                'nama' => strtoupper($request->input('nama_supplier')),
                'negara' => ucwords($request->input('negara')),
                'provinsi' => ucwords($request->input('provinsi')),
                'kota' => ucwords($request->input('kota')),
                'alamat' => $request->input('alamat'),
                'kontak_person' => ucwords($request->input('contact_person')),
                'no_telpon' => $request->input('no_telpon'),
                'email' => $request->input('email'),
                'status' => 'Active',
            ];

            $this->supplier->updateSupplier($id, $dataSupplier);
            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Data supplier berhasil terupdate.'];
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}