<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;
use App\Models\ekspedisi\PenerimaanProduk;
use App\Models\ekspedisi\PengirimanEkspedisi;

class KiosUnboxingQCBaruController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $sideBar = 'kios.layouts.sidebarProduct';
        $dataIncoming = PengirimanEkspedisi::with( 'order.supplier', 'pelayanan.ekspedisi')
                        ->where('status', 'Incoming')
                        ->orWhere('status', 'InRD')
                        ->get();
        $historyPenerimaan = PenerimaanProduk::with('pengiriman.order.supplier', 'pengiriman.pelayanan.ekspedisi')->get();


        return view('kios.product.pengecekkan.index-unboxing-qc-baru', [
            'title' => 'Unboxing & QC',
            'active' => 'unboxing-qc',
            'navActive' => 'product',
            'dropdown' => 'pengecekkan-baru',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'dataIncoming' => $dataIncoming,
            'historyPenerimaan' => $historyPenerimaan,
        ])
        ->with('sidebarLayout', $sideBar);
    }

}
