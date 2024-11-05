<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\gudang\GudangPengirimanServices;

class GudangPengirimanBelanjaController extends Controller
{
    public function __construct(
        private GudangPengirimanServices $pengiriman
        ){}

    public function index()
    {
        return $this->pengiriman->index();
    }

    public function store(Request $request)
    {
        $resultResiBaru = $this->pengiriman->resiTambahan($request);

        if ($resultResiBaru['status'] == 'success') {
            return back()->with('success', $resultResiBaru['message']);
        } else {
            return back()->with('error', $resultResiBaru['message']);
        }
    }

    public function update($id, Request $request)
    {
        $resultAddResi = $this->pengiriman->addResiPembelanjaan($id, $request);

        if ($resultAddResi['status'] == 'success') {
            return back()->with('success', $resultAddResi['message']);
        } else {
            return back()->with('error', $resultAddResi['message']);
        }
    }
}
