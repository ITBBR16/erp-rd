<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosImageSecond;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosProdukSecond;
use App\Models\produk\KiosKelengkapanSecondList;
use App\Models\produk\ProdukSubJenis;
use App\Repositories\kios\KiosRepository;

class KiosBuatPaketSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $kiosProduks = ProdukSubJenis::all();
        $dataPaketPenjualan = $kiosProduks->map(function ($produk) {
            return [
                'id' => $produk->id,
                'display' => $produk->paket_penjualan,
            ];
        });
        $dataKelengkapan = KiosKelengkapanSecondList::orderByRaw("
                                    CASE 
                                        WHEN status = 'Ready' THEN 1 
                                        WHEN status = 'Done QC' THEN 2 
                                        WHEN status = 'On Sell' THEN 3 
                                        ELSE 4 
                                    END
                                ")
                                ->get();

        return view('kios.product.add-produk-second', [
            'title' => 'Create Paket Second',
            'active' => 'create-paket-second',
            'navActive' => 'product',
            'dropdown' => 'pengecekkan-second',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'dataKelengkapan' => $dataKelengkapan,
            'kiosproduks' => $dataPaketPenjualan,
        ]);
    }

    public function store(Request $request)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try {
            $request->validate([
                'paket_penjualan_produk_second' => 'required',
                'modal_produk_second' => 'required|min:1',
                'harga_jual_produk_second' => 'required',
                'kelengkapan_second' => 'required|array',
            ]);

            $srpSecond = preg_replace("/[^0-9]/", "", $request->input('harga_jual_produk_second'));
            $modalSecond = preg_replace("/[^0-9]/", "", $request->input('modal_produk_second'));
            $snSecond = $request->input('sn_second');

            if(count(array_unique($snSecond)) !== count($snSecond)) {
                return back()->with('error', 'Serial Number tidak boleh ada yang sama.');
            }

            $snProduk = $request->input('serial_number_second');

            $urlApiProdukSecond = 'https://script.google.com/macros/s/AKfycbwzPkDQn1MbdVOHLRfozYviDzoIl3UwfvTeCLyIuLo--_azk7oqNitRFBt6XAlhpKB3bg/exec';
            $idProdukSecond = $request->paket_penjualan_produk_second;
            $findNama = ProdukSubJenis::findOrFail($idProdukSecond);
            $namaProdukSecond = $findNama->paket_penjualan;

            $fileData = base64_encode($request->file('file_paket_produk')->get());
            $filesDataKelengkapan = $request->file('file_kelengkapan_produk');
            $originFileName = $request->file('file_paket_produk')->getClientOriginalName();

            $payload = [
                'status' => 'Second',
                'nama_produk' => $namaProdukSecond,
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

            $response = Http::post($urlApiProdukSecond, $payload);
            $linkFileSecond = json_decode($response->body(), true);

            $statusFile = $linkFileSecond['status'];
            $paketFile = $linkFileSecond['file_url'];
            $kelengkapanFile = $linkFileSecond['additional_file_urls'];

            if( $statusFile == 'success' ) {

                $imageProductSecond = new KiosImageSecond();
                $imageProductSecond->sub_jenis_id = $idProdukSecond;
                $imageProductSecond->use_for = 'Paket';
                $imageProductSecond->nama = $namaProdukSecond;
                $imageProductSecond->link_drive = $paketFile;
                $imageProductSecond->save();

                foreach($kelengkapanFile as $kelengkapan) {
                    $kelengkapanImage = new KiosImageSecond();
                    $kelengkapanImage->sub_jenis_id = $idProdukSecond;
                    $kelengkapanImage->use_for = 'Kelengkapan';
                    $kelengkapanImage->nama = $kelengkapan['nama'];
                    $kelengkapanImage->link_drive = $kelengkapan['url'];
                    $kelengkapanImage->save();
                }

                $produkSecond = KiosProdukSecond::create([
                    'sub_jenis_id' => $request->input('paket_penjualan_produk_second'),
                    'produk_image_id' => $imageProductSecond->id,
                    'modal_bekas' => $modalSecond,
                    'srp' => $srpSecond,
                    'cc_produk_second' => $request->input('cc_produk_second'),
                    'serial_number' => $snProduk,
                    'status' => 'Ready',
                ]);

                foreach($snSecond as $item) {
                    DB::connection('rumahdrone_produk')
                            ->table('kios_kelengkapan_second_list')
                            ->where('pivot_qc_id', $item)
                            ->update(['kios_produk_second_id' => $produkSecond->id, 'status' => 'On Sell']);
                }

                $connectionKios->commit();
                return back()->with('success', 'Success Created Product Second.');
            } else {
                $connectionKios->rollBack();
                return back()->with('error', 'Something went wrong.');
            }


        } catch (Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function getKelengkapanSecond()
    {
        $data = KiosKelengkapanSecondList::with('kelengkapans')
                ->where('status', 'Ready')
                ->get()
                ->unique('produk_kelengkapan_id')
                ->values();
    
        return response()->json($data);
    }

    public function getSNSecond($id)
    {
        $data = KiosKelengkapanSecondList::where('produk_kelengkapan_id', $id)
                ->where('status', 'Ready')
                ->get();
    
        return response()->json($data);
    }

    public function getPriceSecond($id)
    {
        $dataPrice = KiosKelengkapanSecondList::where('pivot_qc_id', $id)->pluck('harga_satuan');

        return response()->json($dataPrice);
    }

}
