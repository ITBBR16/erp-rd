<?php

namespace App\Http\Controllers\logistik;

use Exception;
use Illuminate\Http\Request;
use App\Models\kios\KiosProduk;
use Illuminate\Validation\Rule;
use App\Models\kios\KiosOrderList;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosSerialNumber;
use App\Models\ekspedisi\ValidasiProduk;
use App\Models\kios\KiosKomplainSupplier;
use App\Repositories\umum\UmumRepository;
use App\Models\ekspedisi\PengirimanEkspedisi;
use App\Repositories\logistik\repository\LogistikAPIFormRepairRepository;

class LogistikValidasiProdukController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private LogistikAPIFormRepairRepository $form
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
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
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionEkspedisi = DB::connection('rumahdrone_ekspedisi');
        $connectionKios->beginTransaction();
        $connectionEkspedisi->beginTransaction();

        try {
            $request->validate([
                'validasi-sn' => ['required', 'array', 'min:1', Rule::unique('rumahdrone_kios.serial_number', 'serial_number')],
            ]);

            $validasiQty = $request->input('validasi-qty');
            $validasiSubJenisId = $request->input('paket_id');
            $validasiIdPengiriman = $request->input('validasi_resi');
            $validasiListProdukId = $request->input('list_order');
            $validasiSerialNumber = $request->input('validasi-sn');
            $validasiOrderId = $request->input('order_id');

            $serialNumber = array_filter($validasiSerialNumber, function ($item) {
                return $item !== null;
            });
            $uniqueSN = array_unique($serialNumber);
            $status = '';
            
            if(count($serialNumber) === count($uniqueSN)) {

                $validasiBarang = new ValidasiProduk();
                $validasiBarang->order_list_id = $validasiListProdukId;
                $validasiBarang->pengiriman_barang_id = $validasiIdPengiriman;
                $validasiBarang->quantity_received = count($serialNumber);
                $validasiBarang->save();

                $validasiId = $validasiBarang->id;

                if ($validasiQty != count($serialNumber)) {
                    $status = 'Kurang';
                    KiosKomplainSupplier::create([
                        'validasi_id' => $validasiId,
                        'quantity' => $validasiQty - count($serialNumber),
                        'status' => 'Unprocessed',
                    ]);
                } else {
                    $status = 'Done';
                }

                $validasiBarang->status = $status;
                $validasiBarang->save();

            } else {
                if(isset($validasiBarang) && $validasiBarang->id){
                    $validasiBarang->delete();
                }
                return back()->with('error', 'Serial Number Tidak Boleh Sama.');
            }

            KiosOrderList::where('id', $validasiListProdukId)->update(['status' => $status]);
            $cekJenisPaket = KiosProduk::where('sub_jenis_id', $validasiSubJenisId)->first();
            $orderLists = KiosOrderList::where('order_id', $validasiOrderId)->get();
            $allDone = $orderLists->every(function ($orderList) {
                return $orderList->status == 'Done' || $orderList->status == 'Kurang';
            });

            if($allDone) {
                PengirimanEkspedisi::where('id', $validasiIdPengiriman)->update(['status' => 'InRD']);
            }

            if(!$cekJenisPaket) {
                $newProduk = KiosProduk::create([
                                'sub_jenis_id' => $validasiSubJenisId,
                                'status' => 'Ready',
                            ]);

                $produkId = $newProduk->id;
            } else {
                $produkId = $cekJenisPaket->id;
            }

            foreach($serialNumber as $vsn) {
                $newSN = new KiosSerialNumber();
                $newSN->produk_id = $produkId;
                $newSN->validasi_id = $validasiId;
                $newSN->serial_number = $vsn;
                $newSN->status = 'Ready';
                $newSN->save();
            }

            $connectionKios->commit();
            $connectionEkspedisi->commit();
            return back()->with('success', 'Success Validasi Data.');

        } catch(Exception $e) {
            $connectionKios->rollBack();
            $connectionEkspedisi->rollBack();
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

    public function testFormId($register)
    {
        $data = $this->form->findRegister($register);
        return response()->json($data);
    }

}
