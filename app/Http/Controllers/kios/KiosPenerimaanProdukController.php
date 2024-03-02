<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Repositories\kios\KiosRepository;
use App\Models\ekspedisi\PenerimaanProduk;
use App\Models\ekspedisi\PengirimanEkspedisi;

class KiosPenerimaanProdukController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $dataIncoming = PengirimanEkspedisi::with( 'order.supplier', 'ekspedisi')
                        ->where('status', 'Incoming')
                        ->orWhere('status', 'InRD')
                        ->get();
        $historyPenerimaan = PenerimaanProduk::with('pengiriman.order.supplier', 'pengiriman.ekspedisi')->get();

        return view('kios.product.pengecekkan.index-pengecekkan-baru', [
            'title' => 'Unboxing & QC',
            'active' => 'unboxing-qc',
            'navActive' => 'product',
            'dropdown' => 'pengecekkan-baru',
            'dropdownShop' => '',
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
            $fileResi = base64_encode($request->file('file_resi')->get());
            $filePaket = base64_encode($request->file('file_paket')->get());

            $payload = [
                'no_resi' => $request->input('no_resi'),
                'link_drive' => $linkDrive,
                'file_resi' => $fileResi,
                'file_paket' => $filePaket,
                'file_resi_name' => $request->file('file_resi')->getClientOriginalName(),
            ];

            $response = Http::post($urlApi, $payload);
            $dataResponse = json_decode($response->body(), true);

            $statusFile = $dataResponse['status'];
            $paketFile = $dataResponse['url_resi'];
            $kelengkapanFile = $dataResponse['url_paket'];

            if($statusFile == 'success') {

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
                    'link_img' => $paketFile,
                ]);
    
                return back()->with('success', 'Success Terima Produk.');
            
            } else {
                return back()->with('error', 'Something Went Wrong.');
            }

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


}
