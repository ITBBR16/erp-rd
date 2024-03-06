<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosOrderSecond;
use App\Models\kios\KiosQcProdukSecond;
use App\Repositories\kios\KiosRepository;

class KiosFilterProdukSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $secondOrder = KiosOrderSecond::with('customer', 'subjenis.produkjenis', 'qcsecond.kelengkapans', 'statuspembayaran', 'buymetodesecond')
        ->where('status', 'Done QC')
        ->get();
        
        return view('kios.product.pengecekkan.filter-produk-seconds', [
            'title' => 'Filter Produk Second',
            'active' => 'filter-produk-second',
            'navActive' => 'product',
            'dropdown' => 'pengecekkan-second',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'orderSecond' => $secondOrder,
        ]);
    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $kos = KiosOrderSecond::findOrFail($id);
        return view('kios.product.pengecekkan.filtersecond.filter-produk-second', [
            'title' => 'Filter Product Second',
            'active' => 'filter-produk-second',
            'navActive' => 'product',
            'divisi' => $divisiName,
            'dropdown' => 'pengecekkan-second',
            'dropdownShop' => '',
            'kos' => $kos,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $statusQc = 'Ready';
            $pivotIds = $request->input('pivot_id');
            $kiosQcPS = KiosQcProdukSecond::find($id);

            foreach ($pivotIds as $index => $pivotId) {
                $data = [
                    'harga_satuan' => '0',
                ];

                $kiosQcPS->kelengkapans()->where('pivot_qc_id', $pivotId)->update($data);
            }

            $kiosQcPS->ordersecond->status = $statusQc;
            $kiosQcPS->ordersecond->save();

            return redirect()->route('pengecekkan-produk-second.index')->with('success', 'Success Input QC Result.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
