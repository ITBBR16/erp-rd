<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\gudang\GudangSupplierServices;

class GudangSupplierController extends Controller
{
    public function __construct(
        private GudangSupplierServices $supplier
    ){}

    public function index()
    {
        return $this->supplier->index();
    }

    public function store(Request $request)
    {
        $resultSupplier = $this->supplier->createSupplier($request);

        if ($resultSupplier['status'] == 'success') {
            return back()->with('success', $resultSupplier['message']);
        } else {
            return back()->with('error', $resultSupplier['message']);
        }
    }

    public function update($id, Request $request)
    {
        $resultSupplier = $this->supplier->updateSupplier($id, $request);

        if ($resultSupplier['status'] == 'success') {
            return back()->with('success', $resultSupplier['message']);
        } else {
            return back()->with('error', $resultSupplier['message']);
        }
    }
}
