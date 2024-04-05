<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Models\kios\KiosOrder;
use App\Models\kios\KiosPayment;
use App\Models\kios\SupplierKios;
use App\Models\kios\KiosOrderList;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\produk\ProdukSubJenis;
use App\Models\kios\KiosHistoryOrderList;
use App\Models\kios\KiosMetodePembayaran;
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
        $orders = KiosOrder::with('orderLists.paket', 'supplier')->orderBy('created_at', 'desc')->get();

        return view('kios.shop.index', [
            'title' => 'Shop',
            'active' => 'shop',
            'navActive' => 'product',
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
                'statusOrder' => 'Baru',
                'orderId' => 'N.' . $order->id,
                'supplier' => $supplierName,
            ]);

            $linkDrive = json_decode($response->body(), true);
            $order->link_drive = $linkDrive[0];
            $order->save();

            $quantities = $request->input('quantity');
            $paket_penjualan = $request->input('paket_penjualan');
            $message = "List Purchase " . $supplierName . " :\n\n";

            foreach($paket_penjualan as $key => $item) {
                $orderList = new KiosOrderList();
                $orderList->order_id = $order->id;
                $orderList->sub_jenis_id = $item;
                $orderList->quantity = $quantities[$key];
                $orderList->status = 'Belum Validasi';
                $orderList->save();

                $history = new KiosHistoryOrderList();
                $history->order_id = $order->id;
                $history->sub_jenis_id = $item;
                $history->quantity = $quantities[$key];
                $history->save();

                $productPacket = ProdukSubJenis::findOrFail($item);
                $productName = $productPacket->produkjenis->jenis_produk . " " . $productPacket->paket_penjualan . " * " . $quantities[$key] ."\n";
                $message .= $productName;
            }

            $urlMessage = 'https://script.google.com/macros/s/AKfycbxX0SumzrsaMm-1tHW_LKVqPZdIUG8sdp07QBgqmDsDQDIRh2RHZj5gKZMhAb-R1NgB6A/exec';
            $messageGroupSupplier = [
                'no_telp' => '6285156519066',
                'pesan' => $message,
            ];

            $responseMessage = Http::post($urlMessage, $messageGroupSupplier);

            return back()->with('success', 'Success Add New Order List.');

        } catch(Exception $e) {
            if(isset($order) && $order->id){
                $order->orderLists()->delete();
                $order->histories()->delete();
                $order->delete();
            }
            return back()->with('error', $e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_kios' => 'required',
            'jenis_paket' => 'required|array',
            'quantity' => 'required|array',
            'nilai' => 'required|array',
        ]);
        
        try{
            $suppId = $request->input('supplier_id');
            $supplier = SupplierKios::findOrFail($suppId);
            $searchPayment = KiosMetodePembayaran::where('supplier_id', $suppId)->latest()->first();
            $paymentSupplier = ($searchPayment !== null) ? $searchPayment->id : '';
            $nilaiBeli = preg_replace("/[^0-9]/", "", $request->input('nilai'));
            $totalNilai = 0;
            
            $order = KiosOrder::findOrFail($id);
            $order->status = 'Tervalidasi';
            $order->save();
            
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
                    $orderList->sub_jenis_id = $request->input('jenis_paket')[$index];
                    $orderList->quantity = $request->input('quantity')[$index];
                    $orderList->nilai = $nilaiBeli[$index];
                    $orderList->status = 'Belum Validasi';
                    $orderList->save();

                    $historiOrder->sub_jenis_id = $request->input('jenis_paket')[$index];
                    $historiOrder->quantity = $request->input('quantity')[$index];
                    $historiOrder->nilai = $nilaiBeli[$index];
                    $historiOrder->save();

                    $total = $request->input('quantity')[$index] * $nilaiBeli[$index];
                    $totalNilai += $total;

                    $supplier->subjenis()->attach($jenisPaket, ['nilai' => $nilaiBeli[$index]]);

                } else {
                    $newOrderList = new KiosOrderList([
                        'sub_jenis_id' => $request->input('jenis_paket')[$index],
                        'quantity' => $request->input('quantity')[$index],
                        'nilai' => $nilaiBeli[$index],
                        'status' => 'Belum Validasi',
                    ]);

                    $newHistory = new KiosHistoryOrderList([
                        'sub_jenis_id' => $request->input('jenis_paket')[$index],
                        'quantity' => $request->input('quantity')[$index],
                        'nilai' => $nilaiBeli[$index],
                    ]);

                    $totalNilai += $request->input('quantity')[$index] * $nilaiBeli[$index];

                    $order->orderLists()->save($newOrderList);
                    $order->histories()->save($newHistory);
                }

            }

            $payment = new KiosPayment([
                'order_type' => 'Baru',
                'order_id' => $id,
                'metode_pembayaran_id' => $paymentSupplier,
                'jenis_pembayaran' => 'Pembelian Barang',
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
