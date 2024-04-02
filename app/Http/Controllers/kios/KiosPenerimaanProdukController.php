<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
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
            'title' => 'Penerimaan',
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
            
            $tanggalDiterima = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_diterima'))->format('d/m/Y');
            $statusFile = $dataResponse['status'];
            $imgResi = $dataResponse['url_resi'];
            $imgPaket = $dataResponse['url_paket'];

            if($statusFile == 'success') {

                $pengiriman = PengirimanEkspedisi::findOrFail($id);
                $pengiriman->status = 'Diterima';

                $statusOrder = $pengiriman->status_order;
                
                if($statusOrder == 'Baru') {
                    $pengiriman->order()->update(['status' => 'Diterima']);
                } else {
                    $pengiriman->ordersecond()->update(['status' => 'Proses QC']);
                }
                
                $pengiriman->save();
                PenerimaanProduk::create([
                    'employee_id' => $userId,
                    'pengiriman_ekspedisi_id' => $id,
                    'kondisi_barang' => $request->input('kondisi_paket'),
                    'total_paket' => $request->input('total_paket'),
                    'tanggal_diterima' => $tanggalDiterima,
                    'link_img_resi' => $imgResi,
                    'link_img_paket' => $imgPaket,
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
