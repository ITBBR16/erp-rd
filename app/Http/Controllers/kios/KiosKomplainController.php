<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ekspedisi\PengirimanEkspedisi;
use App\Models\kios\KiosAkunRD;
use App\Models\kios\KiosKomplainSupplier;
use App\Models\kios\KiosOrderList;
use App\Models\kios\KiosStatusKomplain;
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
        $statusKomplain = KiosStatusKomplain::all();
        $dataKomplain = KiosKomplainSupplier::all();
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
        ]);
    }

    public function update(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionEkspedisi = DB::connection('rumahdrone_ekspedisi');
        $connectionKios->beginTransaction();
        $connectionEkspedisi->beginTransaction();

        try {
            $user = auth()->user();
            $divisiId = $user->divisi_id;
            $rules = [
                'status_komplain' => 'required',
                'keterangan' => 'required|min:1|max:255',
            ];
            
            if($request->input('status_komplain') == 'Refund Transfer') {
                $rules['bank-transfer'] = ['required'];
            }
            
            $request->validate($rules);
            
            $status = $request->input('status_komplain');
            $keterangan = $request->input('keterangan');
            $bankReturn = $request->input('bank');
            $supplierId = $request->input('id_supplier');
            $deposit = $request->input('nilai_kurang');
            $orderId = $request->input('order_id');
            $orderListId = $request->input('order_list_id');

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
                    'status_order' => 'Baru',
                    'status' => $status,
                ]);
            }

            $komplainSupplier->keterangan = $keterangan;
            $komplainSupplier->status = $status;
            $komplainSupplier->save();

            $connectionKios->commit();
            $connectionEkspedisi->commit();
            return back()->with('success', 'Success Validasi Komplain.');

        } catch(Exception $e) {
            $connectionKios->rollBack();
            $connectionEkspedisi->rollBack();
            return back()->with('error', $e->getMessage());
        }

    }
}
