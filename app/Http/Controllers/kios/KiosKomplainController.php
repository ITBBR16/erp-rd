<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ekspedisi\PengirimanEkspedisi;
use App\Models\kios\KiosAkunRD;
use App\Models\kios\KiosKomplainSupplier;
use App\Models\kios\KiosOrderList;
use App\Models\kios\SupplierKios;
use App\Repositories\kios\KiosRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class KiosKomplainController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $sideBar = 'kios.layouts.sidebarProduct';
        $statusKomplain = DB::connection('rumahdrone_kios')->table('kios_status_komplain')->get();
        $dataKomplain = KiosKomplainSupplier::with('validasi.orderLists.order', 'validasi.orderLists.paket.produkjenis')->get();
        $bankAkun = KiosAkunRD::all();

        return view('kios.supplier.komplain.komplain', [
            'title' => 'Komplain',
            'active' => 'komplain',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'dataKomplain' => $dataKomplain,
            'statusKomplain' => $statusKomplain,
            'bankAkun' => $bankAkun,
        ])
        ->with('sidebarLayout', $sideBar);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $divisiId = $user->divisi_id;
            $rules = [
                'status-komplain' => 'required',
                'keterangan' => 'required|min:1|max:255',
            ];
            
            if($request->input('status-komplain') == 'Refund Transfer') {
                $rules['bank-transfer'] = ['required'];
            }
            
            $request->validate($rules);
            
            $status = $request->input('status-komplain');
            $keterangan = $request->input('keterangan');
            $bankReturn = $request->input('bank');
            $supplierId = $request->input('id-supplier');
            $deposit = $request->input('nilai-kurang');
            $orderId = $request->input('order-id');
            $orderListId = $request->input('order-list-id');

            $komplainSupplier = KiosKomplainSupplier::findOrFail($id);
            $orderList = KiosOrderList::findOrFail($orderListId);
            $qQty = $orderList->quantity;
            $kQty = $komplainSupplier->quantity;
            $hasilQuantityOrderList = $qQty - $kQty;
            
            if($status == 'Refund Transfer') {
                $komplainSupplier->bank_transfer = $bankReturn;
                $orderList->update([
                    'quantity' => $hasilQuantityOrderList,
                    'status' => 'Done',
                ]);
                // Kurang kirim ke akuntan

            }

            if($status == 'Refund Deposit') {
                $supplierKios = SupplierKios::findOrFail($supplierId);
                $depositSupp = $supplierKios->deposit;
                $totalDeposit = $depositSupp + $deposit;
                $supplierKios->update(['deposit' => $totalDeposit]);
                $orderList->update([
                    'quantity' => $hasilQuantityOrderList,
                    'status' => 'Done',
                ]);
            }

            if($status == 'Pengiriman Balik') {
                PengirimanEkspedisi::create([
                    'divisi_id' => $divisiId,
                    'order_id' => $orderId,
                    'status' => $status,
                ]);
            }

            $komplainSupplier->keterangan = $keterangan;
            $komplainSupplier->status = $status;
            $komplainSupplier->save();

            return back()->with('success', 'Success Validasi Komplain.');

        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }
}
