<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ekspedisi\PengirimanEkspedisi;
use App\Models\ekspedisi\ValidasiProduk;
use App\Models\kios\KiosKomplainSupplier;
use App\Models\kios\KiosOrderList;
use App\Models\kios\KiosProduk;
use App\Models\kios\KiosSerialNumber;
use App\Repositories\umum\UmumRepository;
use Exception;

class LogistikValidasiProdukController extends Controller
{
    public function __construct(private UmumRepository $umumRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umumRepo->getDivisi($user);
        $dataOrderList = PengirimanEkspedisi::with('order.orderLists')
                        ->where('status', 'Diterima')
                        ->get();

        return view('logistik.main.validasi.index', [
            'title' => 'Validasi Barang',
            'active' => 'validasi',
            'divisi' => $divisiName,
            'dataOrderList' => $dataOrderList,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'validasi-sn' => 'required|array|min:1',
            ]);

            $validasiQty = $request->input('validasi-qty');
            $validasiSubJenisId = $request->input('paket_id');
            $validasiIdPengiriman = $request->input('validasi_resi');
            $validasiListProdukId = $request->input('list_order');
            $validasiSerialNumber = $request->input('validasi-sn');

            $serialNumber = array_filter($validasiSerialNumber, function ($item) {
                return $item !== null;
            });
            $uniqueSN = array_unique($serialNumber);
            $status = '';

            if(count($serialNumber) === count($uniqueSN)) {
                
                $validasiBarang = ValidasiProduk::create([
                    'order_list_id' => $validasiListProdukId,
                    'pengiriman_barang_id' => $validasiIdPengiriman,
                    'quantity_received' => count($serialNumber),
                    'status' => $status,
                ]);
                $validasiId = $validasiBarang->id;
                
                if($validasiQty === count($serialNumber)){
                    $status = 'Done';
                } else {
                    $status = 'Kurang';
                    KiosKomplainSupplier::create([
                        'validasi_id' => $validasiId,
                        'status' => 'Not Proccess',
                    ]);
                }
            } else {
                if(isset($validasiBarang) && $validasiBarang->id){
                    $validasiBarang->delete();
                }
                return back()->with('error', 'Serial Number Tidak Boleh Sama.');
            }

            $cekJenisPaket = KiosProduk::where('sub_jenis_id', $validasiSubJenisId)->first();

            if(!$cekJenisPaket) {
                $newProduk = KiosProduk::create([
                                'sub_jenis_id' => $validasiSubJenisId,
                                'status' => 'Ready',
                            ]);

                $produkId = $newProduk->id;
            } else {
                $produkId = $cekJenisPaket->id;
            }

            foreach($validasiSerialNumber as $vsn) {
                $newSN = new KiosSerialNumber();
                $newSN->produk_id = $produkId;
                $newSN->validasi_id = $validasiId;
                $newSN->serial_number = $vsn;
                $newSN->status = 'Ready';
                $newSN->save();
            }

            return back()->with('success', 'Success Validasi Data.');

        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getOrderList($orderId)
    {
        $idOrder = PengirimanEkspedisi::where('id', $orderId)->value('order_id');

        $orderListData = KiosOrderList::whereIn('order_id', [$idOrder])
            ->where('status', 'Belum Validasi')
            ->with('paket.produkjenis')
            ->get();

        return response()->json(['orderData' => $orderListData]);
    }

    public function getQtyOrderList($orderListId)
    {
        $qtyOrderList = KiosOrderList::where('id', $orderListId)->get();
        return response()->json($qtyOrderList);
    }

}
