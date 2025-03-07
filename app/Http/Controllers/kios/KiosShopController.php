<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Models\kios\KiosOrder;
use App\Models\kios\KiosPayment;
use App\Models\kios\SupplierKios;
use App\Models\kios\KiosOrderList;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\produk\ProdukSubJenis;
use App\Models\kios\KiosHistoryOrderList;
use App\Models\kios\KiosMetodePembayaran;
use App\Repositories\umum\UmumRepository;

class KiosShopController extends Controller
{
    public function __construct(
        private UmumRepository $umum
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
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

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $supplier = SupplierKios::all();
        $jenisProduk = ProdukJenis::all();
        $paketPenjualan = ProdukSubJenis::all();
        $orders = KiosOrder::find($id);

        return view('kios.shop.edit.edit-belanja-baru', [
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
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionProduct = DB::connection('rumahdrone_produk');
        $connectionKios->beginTransaction();
        $connectionProduct->beginTransaction();

        try{
            $request->validate([
                'supplier_kios' => 'required',
                'paket_penjualan' => 'required|array',
                'quantity' => 'required|array'
            ]);

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
                $productName = $productPacket->paket_penjualan . " * " . $quantities[$key] ."\n";
                $message .= $productName;
            }

            $urlMessage = 'https://script.google.com/macros/s/AKfycbxX0SumzrsaMm-1tHW_LKVqPZdIUG8sdp07QBgqmDsDQDIRh2RHZj5gKZMhAb-R1NgB6A/exec';
            $messageGroupSupplier = [
                'no_telp' => '6285143003374',
                'pesan' => $message,
            ];

            $responseMessage = Http::post($urlMessage, $messageGroupSupplier);

            $connectionKios->commit();
            $connectionProduct->commit();
            return back()->with('success', 'Success Add New Order List.');

        } catch(Exception $e) {
            $connectionKios->rollBack();
            $connectionProduct->rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try{
            $request->validate([
                'supplier_kios' => 'required',
                'jenis_paket' => 'required|array',
                'quantity' => 'required|array',
                'nilai' => 'required|array',
            ]);
            
            $suppId = $request->input('supplier_id');
            $supplier = SupplierKios::findOrFail($suppId);
            $supplierName = $supplier->nama_perusahaan;
            $searchPayment = KiosMetodePembayaran::where('supplier_id', $suppId)->latest()->first();
            $paymentSupplier = $searchPayment ? $searchPayment->id : null;
            $nilaiBeli = preg_replace("/[^0-9]/", "", $request->input('nilai'));
            $totalNilai = 0;
            
            $order = KiosOrder::findOrFail($id);
            $order->status = 'Tervalidasi';
            $order->save();
            $message = "Fix List Purchase " . $supplierName . " :\n\n";

            $quantities = $request->input('quantity');
            $paketPenjualan = $request->input('jenis_paket');
            
            foreach($paketPenjualan as $index => $jenisPaket) {
                $orderList = $order->orderLists()
                            ->where('order_id', $id)
                            ->where('sub_jenis_id', $jenisPaket)
                            ->first();

                $historiOrder = $order->histories()
                            ->where('order_id', $id)
                            ->where('sub_jenis_id', $jenisPaket)
                            ->first();

                $productPacket = ProdukSubJenis::findOrFail($jenisPaket);
                $productName = $productPacket->paket_penjualan . " * " . $quantities[$index] ."\n";
                $message .= $productName;

                $existingSubJenisIds = $order->orderLists()->pluck('sub_jenis_id')->toArray();
                $newSubJenisIds = array_map('intval', $request->input('jenis_paket'));

                $idsToDelete = array_diff($existingSubJenisIds, $newSubJenisIds);

                if (!empty($idsToDelete)) {
                    $order->orderLists()->whereIn('sub_jenis_id', $idsToDelete)->delete();
                    $order->histories()->whereIn('sub_jenis_id', $idsToDelete)->delete();
                }

                if($orderList) {
                    $orderList->sub_jenis_id = $jenisPaket;
                    $orderList->quantity = $quantities[$index];
                    $orderList->nilai = $nilaiBeli[$index];
                    $orderList->status = 'Belum Validasi';
                    $orderList->save();

                    $historiOrder->sub_jenis_id = $jenisPaket;
                    $historiOrder->quantity = $quantities[$index];
                    $historiOrder->nilai = $nilaiBeli[$index];
                    $historiOrder->save();

                    $total = $quantities[$index] * $nilaiBeli[$index];
                    $totalNilai += $total;

                    $supplier->subjenis()->attach($jenisPaket, ['nilai' => $nilaiBeli[$index]]);

                } else {
                    $newOrderList = new KiosOrderList([
                        'sub_jenis_id' => $jenisPaket,
                        'quantity' => $quantities[$index],
                        'nilai' => $nilaiBeli[$index],
                        'status' => 'Belum Validasi',
                    ]);

                    $newHistory = new KiosHistoryOrderList([
                        'sub_jenis_id' => $jenisPaket,
                        'quantity' => $quantities[$index],
                        'nilai' => $nilaiBeli[$index],
                    ]);

                    $totalNilai += $quantities[$index] * $nilaiBeli[$index];

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

            $message .= "\nTotal Nominal : Rp. " . number_format($totalNilai, 0, ',', '.');
            $urlMessage = 'https://script.google.com/macros/s/AKfycbxX0SumzrsaMm-1tHW_LKVqPZdIUG8sdp07QBgqmDsDQDIRh2RHZj5gKZMhAb-R1NgB6A/exec';
            $messageGroupSupplier = [
                'no_telp' => '6285156519066',
                'pesan' => $message,
            ];

            $responseMessage = Http::post($urlMessage, $messageGroupSupplier);

            $payment->save();
            $connectionKios->commit();

            return redirect()->route('shop.index')->with('success', 'Success Validasi Order.');
            
        } catch(Exception $e) {
            $connectionKios->rollBack();
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
