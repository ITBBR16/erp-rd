<?php

namespace App\Http\Controllers\logistik;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Repositories\umum\UmumRepository;
use App\Models\ekspedisi\PenerimaanProduk;
use App\Models\ekspedisi\PengirimanEkspedisi;

class LogistikPenerimaanController extends Controller
{
    public function __construct(private UmumRepository $umumRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umumRepo->getDivisi($user);
        $dataIncoming = PengirimanEkspedisi::with( 'order.supplier', 'pelayanan.ekspedisi')
                        ->where('status', 'Incoming')
                        ->orWhere('status', 'InRD')
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

            // Send data to api upload file unboxing
            $urlApi = 'https://script.google.com/macros/s/AKfycbwEGIug4RlkPWDKZLjwZKQYughyiNIaYveGRKR4WXD3y-HM6jRcrsvfBkXjFJNR7V1o/exec';

            $linkDrive = $request->input('link_drive');
            $fileData = base64_encode($request->file('file_upload')->get());

            $payload = [
                'no_resi' => $request->input('no_resi'),
                'link_drive' => $linkDrive,
                'file_upload' => $fileData,
                'file_upload_name' => $request->file('file_upload')->getClientOriginalName(),
            ];

            $response = Http::post($urlApi, $payload);
            $linkFile = json_decode($response->body(), true);

            $pengiriman = PengirimanEkspedisi::findOrFail($id);
            $pengiriman->update([
                'status' => 'Diterima'
            ]);

            PenerimaanProduk::create([
                'employee_id' => $userId,
                'pengiriman_ekspedisi_id' => $id,
                'kondisi_barang' => $request->input('kondisi_paket'),
                'total_paket' => $request->input('total_paket'),
                'tanggal_diterima' => $request->input('tanggal_diterima'),
                'link_img' => $linkFile[0],
            ]);

            return back()->with('success', 'Success Terima Produk.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
