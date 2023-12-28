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

class KiosPengirimanController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $dataIncoming = PengirimanEkspedisi::with( 'order.supplier', 'pelayanan.ekspedisi', 'divisi')->get();
        $ekspedisi = Ekspedisi::all();
        $layanan = JenisPelayanan::all();

        return view('kios.pengiriman.index', [
            'title' => 'Shipment',
            'active' => 'shipment',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'dataIncoming' => $dataIncoming,
            'ekspedisi' => $ekspedisi,
            'jenisLayanan' => $layanan,
        ]);
    }

    public function update(Request $request, $id)
    {
        try{
            $pengiriman = PengirimanEkspedisi::findOrFail($id);
            $dataUpdate = [
                'jenis_layanan_id' => $request->input('layanan'),
                'no_resi' => $request->input('no_resi'),
                'no_faktur' => $request->input('no_faktur'),
                'tanggal_kirim' => $request->input('tanggal_dikirim'),
                'status' => 'Incoming'
            ];

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
