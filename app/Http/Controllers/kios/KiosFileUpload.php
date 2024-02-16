<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosQcProdukSecond;
use App\Models\produk\ProdukSubJenis;
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
            'file_kelengkapan_produk.*' => 'image|mimes:jpeg,png,jpg',
        ]);

        try {
            $urlApiProdukBaru = 'https://script.google.com/macros/s/AKfycbwzPkDQn1MbdVOHLRfozYviDzoIl3UwfvTeCLyIuLo--_azk7oqNitRFBt6XAlhpKB3bg/exec';
            $idProdukBaru = $request->input('fu_nama_produk');
            $findNama = ProdukSubJenis::with('produkjenis')->find($idProdukBaru);
            $namaProdukBaru = $findNama->produkjenis->jenis_produk . " " . $findNama->paket_penjualan;
            $fileData = base64_encode($request->file('file_paket_produk')->get());
            $filesDataKelengkapan = $request->file('file_kelengkapan_produk');

            $payload = [
                'status' => 'Baru',
                'nama_produk' => $namaProdukBaru,
                'file_upload' => $fileData,
                'file_paket_produk' => $request->file('file_paket_produk')->getClientOriginalName(),
                'additional_files' => [],
            ];

            foreach ($filesDataKelengkapan as $fileKelengkapan) {
                $fileData = base64_encode($fileKelengkapan->get());
                $fileName = $fileKelengkapan->getClientOriginalName();
                
                $payload['additional_files'][] = [
                    'file_upload' => $fileData,
                    'file_name' => $fileName,
                ];
            }

            $response = Http::post($urlApiProdukBaru, $payload);
            $linkFileBaru = json_decode($response->body(), true);
            dd($linkFileBaru);

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
            $urlApiProdukSecond = 'https://script.google.com/macros/s/AKfycbwzPkDQn1MbdVOHLRfozYviDzoIl3UwfvTeCLyIuLo--_azk7oqNitRFBt6XAlhpKB3bg/exec';
            $idProdukSecond = $request->input('fu_nama_produk_second');
            $findNama = ProdukSubJenis::with('produkjenis')->find($idProdukSecond);
            $namaProdukSecond = $findNama->produkjenis->jenis_produk . " " . $findNama->paket_penjualan;
            $fileData = base64_encode($request->file('file_paket_produk_second')->get());
            $filesDataKelengkapan = $request->file('file_kelengkapan_produk_second');

            $payload = [
                'status' => 'Second',
                'nama_produk' => $namaProdukSecond,
                'file_upload' => $fileData,
                'file_paket_produk' => $request->file('file_paket_produk_second')->getClientOriginalName(),
                'additional_files' => [],
            ];

            foreach ($filesDataKelengkapan as $fileKelengkapan) {
                $fileData = base64_encode($fileKelengkapan->get());
                $fileName = $fileKelengkapan->getClientOriginalName();
                
                $payload['additional_files'][] = [
                    'file_upload' => $fileData,
                    'file_name' => $fileName,
                ];
            }

            $response = Http::post($urlApiProdukSecond, $payload);
            $linkFileSecond = json_decode($response->body(), true);
            dd($linkFileSecond);

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
