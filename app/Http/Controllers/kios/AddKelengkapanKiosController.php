<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\produk\ProdukType;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosImageProduk;
use App\Models\kios\KiosProduk;
use Illuminate\Support\Facades\Http;
use App\Models\produk\ProdukKategori;
use App\Models\produk\ProdukSubJenis;
use App\Models\produk\ProdukKelengkapan;
use App\Repositories\kios\KiosRepository;

class AddKelengkapanKiosController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $jenis_produk = ProdukJenis::all();
        $kategori = ProdukKategori::all();
        $kelengkapan = ProdukKelengkapan::all();
        $types = ProdukType::all();

        return view('kios.product.add-produk', [
            'title' => 'Add Product',
            'active' => 'add-product',
            'navActive' => 'product',
            'dropdown' => 'add-product',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'kategori' => $kategori,
            'jenis_produk' => $jenis_produk,
            'kelengkapan' => $kelengkapan,
            'types' => $types,
        ]);
    }

    public function store(Request $request)
    {
        if($request->has('kategori_id')) {

            $validate = $request->validate([
                'kategori_id' => 'required',
                'jenis_produk' => ['required', Rule::unique('rumahdrone_produk.produk_jenis', 'jenis_produk')],
            ]);
            
            $validate['jenis_produk'] = strtoupper($validate['jenis_produk']);
            
            try {
                $type = ProdukJenis::create($validate);
            
                $jenisKelengkapan = collect($request->jenis_kelengkapan)->map(function ($jk) {
                    return ['kelengkapan' => ucwords(strtolower($jk))];
                });
            
                $type->kelengkapans()->createMany($jenisKelengkapan->toArray());
            
                return back()->with('success', 'Success Add New Product.');
            
            } catch (Exception $e) {
                return back()->with('error', $e->getMessage());
            }
            
        } elseif($request->has('paket_penjualan')) {

            $validatePenjualan = $request->validate([
                'kategori_paket' => 'required',
                'jenis_id' => 'required',
                'berat_paket' => 'required',
                'paket_penjualan' => 'required',
                'kelengkapan' => 'required|array',
                'quantity' => 'required|array',
                'file_paket_produk' => 'image|mimes:jpeg,png,jpg',
                'file_kelengkapan_produk.*' => 'image|mimes:jpeg,png,jpg',
                'length' => 'required',
                'width' => 'required',
                'height' => 'required',
            ]);

            $validatePenjualan['paket_penjualan'] = strtoupper($validatePenjualan['paket_penjualan']);

            try{
                $produkJenis = ProdukSubJenis::create([
                    'jenis_id' => $request->jenis_id,
                    'produk_type_id' => $request->kategori_paket,
                    'paket_penjualan' => $validatePenjualan['paket_penjualan'],
                    'berat' => $request->berat_paket,
                    'panjang' => $request->length,
                    'lebar' => $request->width,
                    'tinggi' => $request->height,
                ]);

                $kelengkapanId = $request->input('kelengkapan');
                $quantityVal = $request->input('quantity');

                foreach ($kelengkapanId as $index => $id) {
                    $produkJenis->kelengkapans()->attach($id, ['quantity' => $quantityVal[$index]]);
                }

                $urlApiProdukBaru = 'https://script.google.com/macros/s/AKfycbwzPkDQn1MbdVOHLRfozYviDzoIl3UwfvTeCLyIuLo--_azk7oqNitRFBt6XAlhpKB3bg/exec';
                $idProdukBaru = $request->jenis_id;
                $findNama = ProdukJenis::findOrFail($idProdukBaru);
                $namaProdukBaru = $findNama->jenis_produk . " " . $validatePenjualan['paket_penjualan'];

                $fileData = base64_encode($request->file('file_paket_produk')->get());
                $filesDataKelengkapan = $request->file('file_kelengkapan_produk');
                $originFileName = $request->file('file_paket_produk')->getClientOriginalName();

                $payload = [
                    'status' => 'Baru',
                    'nama_produk' => $namaProdukBaru,
                    'file_upload' => $fileData,
                    'file_paket_produk' => $originFileName,
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

                $statusFile = $linkFileBaru['status'];
                $paketFile = $linkFileBaru['file_url'];
                $kelengkapanFile = $linkFileBaru['additional_file_urls'];

                if ($statusFile === 'success') {
                    $imageProdukKios = new KiosImageProduk();
                    $imageProdukKios->sub_jenis_id = $produkJenis->id;
                    $imageProdukKios->use_for = 'Paket';
                    $imageProdukKios->nama = $originFileName;
                    $imageProdukKios->link_drive = $paketFile;
                    $imageProdukKios->save();

                    foreach ($kelengkapanFile as $kelengkapan) {
                        $kelengkapanImage = new KiosImageProduk();
                        $kelengkapanImage->sub_jenis_id = $produkJenis->id;
                        $kelengkapanImage->use_for = 'Kelengkapan';
                        $kelengkapanImage->nama = $kelengkapan['nama'];
                        $kelengkapanImage->link_drive = $kelengkapan['url'];
                        $kelengkapanImage->save();
                    }

                    KiosProduk::create([
                        'sub_jenis_id' => $produkJenis->id,
                        'produk_img_id' => $imageProdukKios->id,
                        'status' => 'Not Ready',
                    ]);

                }

                return back()->with('success', 'Success Add Paket Penjualan.');

            } catch(Exception $e){
                return back()->with('error', $e->getMessage());
            }

        } else {
            return back()->with('error', 'Something Went Wrong.');
        }
    }

    public function getKelengkapan($jenisId)
    {
        $ddKelengkapan = ProdukKelengkapan::where('produk_jenis_id', $jenisId)->get();

        return response()->json($ddKelengkapan);
    }

}
