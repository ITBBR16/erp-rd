<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Models\kios\KiosProduk;
use Illuminate\Validation\Rule;
use App\Models\produk\ProdukType;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosImageProduk;
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
            'dropdown' => '',
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
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionProduk = DB::connection('rumahdrone_produk');
        $connectionKios->beginTransaction();
        $connectionProduk->beginTransaction();

        if($request->has('kategori_id')) {

            try {
                $validate = $request->validate([
                    'kategori_id' => 'required',
                    'jenis_produk' => ['required', Rule::unique('rumahdrone_produk.produk_jenis', 'jenis_produk')],
                ]);

                $validate['jenis_produk'] = strtoupper($validate['jenis_produk']);

                ProdukJenis::create($validate);

                $connectionProduk->commit();
                return back()->with('success', 'Success Add New Product.');

            } catch (Exception $e) {
                $connectionProduk->rollBack();
                return back()->with('error', $e->getMessage());
            }

        } elseif($request->has('edit_kelengkapan_produk') || $request->has('jenis_kelengkapan')) {

            try {
                $editKelengkapanProduk = $request->edit_kelengkapan_produk;
                $addKelengkapanProduk = $request->jenis_kelengkapan;
                $filterDataEditKelengkapan = array_filter($editKelengkapanProduk, function($value) {
                                                 return !is_null($value);
                                             });
                $filterDataAddKelengkapan = array_filter($addKelengkapanProduk, function($value) {
                                                 return !is_null($value);
                                             });

                if(!empty($filterDataAddKelengkapan)) {
                    $request->validate([
                        'jenis_kelengkapan' => ['required', Rule::unique('rumahdrone_produk.produk_kelengkapan', 'kelengkapan')],
                    ]);

                    $jenisKelengkapan = collect($request->jenis_kelengkapan)->map(function ($jk) {
                        return ['kelengkapan' => ucwords(strtolower($jk))];
                    });

                    $jenisKelengkapan->each(function ($kelengkapan, $index) use ($request) {
                        $kelengkapanBaru = ProdukKelengkapan::create($kelengkapan);
                
                        $kelengkapanBaru->jenisProduks()->attach($request->add_jenis_id[$index]);
                    });
                }

                if(!empty($filterDataEditKelengkapan)) {
                    $editKelengkapan = $request->edit_kelengkapan_produk;
                    $editJenis = $request->ek_jenis_id;

                    foreach($editKelengkapan as $index => $ek) {
                        $findKelengkapan = ProdukKelengkapan::findOrFail($ek);
                        foreach($editJenis as $jenisId) {
                            if($findKelengkapan->jenisProduks()->where('produk_jenis_id', $jenisId)->exists()){}

                            $findKelengkapan->jenisProduks()->syncWithoutDetaching($jenisId);
                        }
                    }
                }

                $connectionProduk->commit();
                return back()->with('success', 'Success Add or Edit Product.');

            } catch (Exception $e) {
                $connectionProduk->rollBack();
                return back()->with('error', $e->getMessage());
            }

        } elseif($request->has('paket_penjualan')) {
            
            try{
                $validatePenjualan = $request->validate([
                    'kategori_paket' => 'required',
                    'jenis_id' => 'required',
                    'berat_paket' => 'required',
                    'paket_penjualan' => 'required',
                    'kelengkapan' => 'required|array',
                    'quantity' => 'required|array',
                    'file_paket_produk' => 'image|mimes:jpeg,png,jpg',
                    'file_kelengkapan_produk.*' => 'image|mimes:jpeg,png,jpg',
                ]);
    
                $validatePenjualan['paket_penjualan'] = strtoupper($validatePenjualan['paket_penjualan']);
    
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
                $namaProdukBaru = $validatePenjualan['paket_penjualan'];

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

                $connectionKios->commit();
                $connectionProduk->commit();
                return back()->with('success', 'Success Add Paket Penjualan.');

            } catch(Exception $e){
                $connectionKios->rollBack();
                $connectionProduk->rollBack();
                return back()->with('error', $e->getMessage());
            }

        } else {
            return back()->with('error', 'Something Went Wrong.');
        }
    }

    public function getKelengkapan($jenisId)
    {
        $produkSearch = ProdukJenis::findOrFail($jenisId);
        $dataKelengkapan = $produkSearch->kelengkapans()->get();
        return response()->json($dataKelengkapan);
    }

}
