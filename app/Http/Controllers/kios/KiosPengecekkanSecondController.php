<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosOrderSecond;
use App\Models\kios\KiosQcProdukSecond;
use App\Repositories\kios\KiosRepository;

class KiosPengecekkanSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $secondOrder = KiosOrderSecond::with('customer', 'subjenis.produkjenis', 'qcsecond.kelengkapans', 'statuspembayaran', 'buymetodesecond')
        ->where('status', 'Proses QC')
        ->get();
        
        return view('kios.product.pengecekkan.index-pengecekkan-second', [
            'title' => 'Pengecekkan Second',
            'active' => 'pengecekkan-second',
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
        return view('kios.shop.qc-second.qc-second', [
            'title' => 'Quality Control Second',
            'active' => 'pengecekkan-second',
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
            $statusQc = 'Done QC';
            $pivotIds = $request->input('pivot_id');
            $serialNumbers = $request->input('serial_number');
            $keterangan = $request->input('keterangan');
            $kondisi = $request->input('kondisi');
            $kiosQcPS = KiosQcProdukSecond::find($id);

            foreach ($pivotIds as $index => $pivotId) {
                $data = [
                    'kondisi' => $kondisi[$index],
                    'keterangan' => $keterangan[$index],
                    'harga_satuan' => '0',
                    'serial_number' => $serialNumbers[$index],
                    'status' => $statusQc,
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
