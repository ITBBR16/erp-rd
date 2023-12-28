<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ekspedisi\PenerimaanProduk;
use App\Repositories\umum\UmumRepository;
use App\Models\ekspedisi\PengirimanEkspedisi;
use Exception;

class LogistikPenerimaanController extends Controller
{
    public function __construct(private UmumRepository $umumRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umumRepo->getDivisi($user);
        $dataIncoming = PengirimanEkspedisi::with( 'order.supplier', 'pelayanan.ekspedisi')
                        ->where('status', 'Incoming')
                        ->orWhere('status', 'Diterima')
                        ->get();
        $historyPenerimaan = PenerimaanProduk::with('pengiriman.order.supplier', 'pengiriman.pelayanan.ekspedisi')->get();

        return view('logistik.main.index', [
            'title' => 'Penerimaan Barang',
            'active' => 'penerimaan',
            'divisi' => $divisiName,
            'dataIncoming' => $dataIncoming,
            'historyPenerimaan' => $historyPenerimaan,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $userId = $user->id;
        try {
            $pengiriman = PengirimanEkspedisi::findOrFail($id);
            $pengiriman->update([
                'status' => 'Diterima'
            ]);

            PenerimaanProduk::create([
                'employee_id' => $userId,
                'pengiriman_ekspedisi_id' => $id,
                'kondisi_barang' => $request->input('kondisi_paket'),
                'total_paket' => $request->input('total_paket'),
                'tanggal_diterima' => $request->input('tanggal_diterima')
            ]);

            return back()->with('success', 'Success Terima Produk.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
