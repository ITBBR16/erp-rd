<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Repositories\kios\KiosRepository;

class KiosFileUpload extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $jenisDrone = ProdukJenis::with('subjenis.kelengkapans')->get();

        return view('kios.product.file-upload', [
            'title' => 'File Upload',
            'active' => 'file-upload',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'jenisdrone' => $jenisDrone,
        ]);
    }

    public function uploadbaru(Request $request)
    {
        $request->validate([
            'fu_nama_produk' => 'required',
            'file_paket_produk' => 'image|mimes:jpeg,png,jpg',
            'file_kelengkapan_produk' => 'image|mimes:jpeg,png,jpg',
        ]);

        try {
            $urlApiProdukBaru = '';
            $namaProdukBaru = $request->input('fu_nama_produk');
            $fileData = base64_encode($request->file('file_paket_produk')->get());

            $payload = [
                'nama_produk' => $namaProdukBaru,
                'file_upload' => $fileData,
                'file_paket_produk' => $request->file('file_paket_produk')->getClientOriginalName(),
            ];

            $response = Http::post($urlApiProdukBaru, $payload);
            $linkFileBaru = json_decode($response->body(), true);

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function uploadsecond(Request $request)
    {
        $request->validate([
            'fu_nama_produk_second' => 'required',
            'file_paket_produk_second' => 'image|mimes:jpeg,png,jpg',
            'file_kelengkapan_produk_second' => 'image|mimes:jpeg,png,jpg',
        ]);

        try {
            $urlApiProdukSecond = '';
            $namaProdukSecond = $request->input('fu_nama_produk_second');
            $fileDataSecond = base64_encode($request->file('file_paket_produk_second')->get());

            $payload = [
                'nama_produk' => $namaProdukSecond,
                'file_upload' => $fileDataSecond,
                'file_paket_produk' => $request->file('file_paket_produk')->getClientOriginalName(),
            ];

            $response = Http::post($urlApiProdukSecond, $payload);
            $linkFileSecond = json_decode($response->body(), true);

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
