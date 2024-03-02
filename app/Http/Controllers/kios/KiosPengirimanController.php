<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ekspedisi\Ekspedisi;
use App\Http\Controllers\Controller;
use App\Models\ekspedisi\JenisPelayanan;
use App\Repositories\kios\KiosRepository;
use App\Models\ekspedisi\PengirimanEkspedisi;
use App\Models\kios\KiosOrder;
use App\Models\kios\KiosOrderSecond;

class KiosPengirimanController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $dataIncoming = PengirimanEkspedisi::with( 'order.supplier', 'divisi', 'penerimaan', 'ekspedisi')->get();
        $ekspedisi = Ekspedisi::all();

        return view('kios.pengiriman.index', [
            'title' => 'Shipment',
            'active' => 'shipment',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'dataIncoming' => $dataIncoming,
            'ekspedisi' => $ekspedisi,
        ]);
    }

    public function update(Request $request, $id)
    {
        try{
            $pengiriman = PengirimanEkspedisi::findOrFail($id);
            $tanggal = $request->input('tanggal_dikirim');
            $tanggalKirim = Carbon::parse($tanggal)->format('d-m-Y');
            $statusOrder = $request->input('status_order');
            $orderId = $request->input('order_id');
            
            if($statusOrder == 'Baru') {
                $order = KiosOrder::findOrFail($orderId);
            } else {
                $order = KiosOrderSecond::findOrFail($orderId);
            }

            $dataUpdate = [
                'ekspedisi_id' => $request->input('ekspedisi'),
                'no_resi' => $request->input('no_resi'),
                'no_faktur' => $request->input('no_faktur'),
                'tanggal_kirim' => $tanggalKirim,
                'status' => 'Incoming'
            ];

            $order->status = 'Incoming';
            $order->save();
            $pengiriman->update($dataUpdate);

            return back()->with('success', 'Success Update Data.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getLayanan($ekspedisiId)
    {
        $ddLayanan = JenisPelayanan::where('ekspedisi_id', $ekspedisiId)->get();
        return response()->json($ddLayanan);
    }
}
