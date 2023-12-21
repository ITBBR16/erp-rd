<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Models\kios\KiosOrder;
use App\Models\kios\SupplierKios;
use App\Models\kios\KiosOrderList;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\produk\ProdukSubJenis;
use App\Models\kios\KiosHistoryOrderList;
use App\Models\kios\KiosPayment;
use App\Repositories\kios\KiosRepository;

class KiosShopController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $supplier = SupplierKios::all();
        $jenisProduk = ProdukJenis::all();
        $paketPenjualan = ProdukSubJenis::all();
        $orders = KiosOrder::with('orderLists.paket', 'supplier')->get();

        return view('kios.shop.index', [
            'title' => 'Shop',
            'active' => 'shop',
            'dropdown' => '',
            'dropdownShop' => true,
            'divisi' => $divisiName,
            'supplier' => $supplier,
            'jenisProduk' => $jenisProduk,
            'paketPenjualan' => $paketPenjualan,
            'data' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_kios' => 'required',
            'jenis_produk' => 'required|array',
            'paket_penjualan' => 'required|array',
            'quantity' => 'required|array'
        ]);

        try{
            // Identifikasi Supplier
            $supplierId = $request->input('supplier_kios');
            $searchSupplier = SupplierKios::findOrFail($supplierId);
            $supplierName = $searchSupplier->nama_perusahaan;

            // Save order ke table order
            $order = new KiosOrder();
            $order->supplier_kios_id = $request->input('supplier_kios');
            $order->status = 'Belum Validasi';
            $order->save();

            // Send data to api
            $apiUrl = "https://script.google.com/macros/s/AKfycbwFGLi6XLWUKPvxiEqC8jQDJtynpwZWoYTW4Gqc_M2smqiU_nNYyHlalYUq1_jaUlGQOQ/exec";
            $response = Http::post($apiUrl, [
                'orderId' => 'K.' . $order->id,
                'supplier' => $supplierName,
            ]);
            
            $quantities = $request->input('quantity');
            $jenisProduk = $request->input('jenis_produk');
            $paket_penjualan = $request->input('paket_penjualan');
            foreach($paket_penjualan as $key => $item) {
                $orderList = new KiosOrderList();
                $orderList->order_id = $order->id;
                $orderList->produk_jenis_id = $jenisProduk[$key];
                $orderList->sub_jenis_id = $item;
                $orderList->quantity = $quantities[$key];
                $orderList->save();

                $history = new KiosHistoryOrderList();
                $history->order_id = $order->id;
                $history->produk_jenis_id = $jenisProduk[$key];
                $history->sub_jenis_id = $item;
                $history->quantity = $quantities[$key];
                $history->save();
            }

            return back()->with('success', 'Success Add New Order List.');

        } catch(Exception $e) {
            if(isset($order) && $order->id){
                $order->delete();
            }
            return back()->with('error', $e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_kios' => 'required',
            'invoice' => 'required',
            'jenis_paket' => 'required|array',
            'quantity' => 'required|array',
            'nilai' => 'required|array',
        ]);
        
        try{
            $order = KiosOrder::findOrFail($id);
            $order->status = 'Tervalidasi';
            $order->invoice = $request->input('invoice');
            $order->save();

            $supplier = SupplierKios::findOrFail($request->input('supplier_id'));
            $totalNilai = 0;

            foreach($request->input('jenis_paket') as $index => $jenisPaket) {
                $orderList = $order->orderLists()
                            ->where('order_id', $id)
                            ->where('sub_jenis_id', $jenisPaket)
                            ->first();

                $historiOrder = $order->histories()
                            ->where('order_id', $id)
                            ->where('sub_jenis_id', $jenisPaket)
                            ->first();

                if($orderList) {
                    $orderList->produk_jenis_id = $request->input('jenis_produk')[$index];
                    $orderList->sub_jenis_id = $request->input('jenis_paket')[$index];
                    $orderList->quantity = $request->input('quantity')[$index];
                    $orderList->nilai = $request->input('nilai')[$index];
                    $orderList->save();

                    $historiOrder->produk_jenis_id = $request->input('jenis_produk')[$index];
                    $historiOrder->sub_jenis_id = $request->input('jenis_paket')[$index];
                    $historiOrder->quantity = $request->input('quantity')[$index];
                    $historiOrder->nilai = $request->input('nilai')[$index];
                    $historiOrder->save();

                    $total = $request->input('quantity')[$index] * $request->input('nilai')[$index];
                    $totalNilai += $total;

                    $supplier->subjenis()->attach($jenisPaket, ['nilai' => $request->input('nilai')[$index]]);

                } else {
                    $newOrderList = new KiosOrderList([
                        'produk_jenis_id' => $request->input('jenis_produk')[$index],
                        'sub_jenis_id' => $request->input('jenis_paket')[$index],
                        'quantity' => $request->input('quantity')[$index],
                        'nilai' => $request->input('nilai')[$index],
                    ]);

                    $newHistory = new KiosHistoryOrderList([
                        'produk_jenis_id' => $request->input('jenis_produk')[$index],
                        'sub_jenis_id' => $request->input('jenis_paket')[$index],
                        'quantity' => $request->input('quantity')[$index],
                        'nilai' => $request->input('nilai')[$index],
                    ]);

                    $order->orderLists()->save($newOrderList);
                    $order->histories()->save($newHistory);
                }

            }

            $payment = new KiosPayment([
                'order_id' => $id,
                'nilai' => $totalNilai,
                'status' => 'Unpaid',
            ]);

            $payment->save();

            return back()->with('success', 'Success Validasi Order.');
            
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        
    }

    public function destroy($id)
    {
        try{
            $order = KiosOrder::findOrFail($id);
            KiosOrderList::where('order_id', $id)->delete();

            $order->delete();

            return back()->with('success', 'Success Delete Order.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
