<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\kios\KiosProduk;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosListKelengkapanSplit;
use App\Models\kios\KiosProdukBnob;
use App\Models\kios\KiosSerialNumber;
use App\Models\produk\ProdukSubJenis;
use App\Repositories\umum\UmumRepository;

class KiosSplitDroneBaruController extends Controller
{
    public function __construct(
        private UmumRepository $umum
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $produk = KiosProduk::where('status', ['Ready', 'Promo'])->get();
        $dataProduk = $produk->map(function ($produk) {
            return [
                'id' => $produk->id,
                'display' => $produk->subjenis->paket_penjualan
            ];
        });
        $kelengkapanSplit = KiosListKelengkapanSplit::orderByRaw("
                                CASE 
                                    WHEN status = 'Ready' THEN 1 
                                    WHEN status = 'On Sell' THEN 2 
                                    ELSE 3 
                                END
                            ")
                            ->get();
        $paketPenjualan = ProdukSubJenis::all();
        $dataBnob = $paketPenjualan->map(function ($subJenis) {
            return [
                'id' => $subJenis->id,
                'display' => $subJenis->paket_penjualan
            ];
        });

        return view('kios.product.splitbaru.index', [
            'title' => 'Split Drone Baru',
            'active' => 'splitdb',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'produks' => $dataProduk,
            'dataKelengkapanSplit' => $kelengkapanSplit,
            'dataBnob' => $dataBnob
        ]);
    }

    public function store(Request $request)
    {
        try {
            $connectionKios = DB::connection('rumahdrone_kios');
            $connectionKios->beginTransaction();

            $employeeId = auth()->user()->id;
            $paketPenjualanId = $request->input('paket_penjualan_awal_split');
            $serialNumberAwal = $request->input('sn_awal_split');
            $kelengkapanId = $request->input('id_kelengkapan');
            $serialNumberBaru = $request->input('serial_number');
            $nilaiSplit = $request->input('nilai_split');

            foreach ($kelengkapanId as $index => $kelengkapan) {
                $randString = Str::random(10);
                $snProduk = 'N.' . $randString;

                $dataKelengkapanSplit = [
                    'employee_id' => $employeeId,
                    'serial_number_id' => $serialNumberAwal,
                    'produk_kelengkapan_id' => $kelengkapan,
                    'serial_number_split' => ($serialNumberBaru[$index] != "") ? $serialNumberBaru[$index] : $snProduk,
                    'nominal' => preg_replace("/[^0-9]/", "", $nilaiSplit[$index]),
                    'status' => 'Ready'
                ];

                KiosListKelengkapanSplit::create($dataKelengkapanSplit);
            }

            KiosSerialNumber::find($serialNumberAwal)->update(['status' => 'Split']);

            $cekReadySN = KiosSerialNumber::where('produk_id', $paketPenjualanId)
                            ->where('status', 'Ready')
                            ->exists();

            if (!$cekReadySN) {
                KiosProduk::where('id', $paketPenjualanId)->update(['status' => 'Not Ready']);
            }

            $connectionKios->commit();
            return back()->with('success', 'Berhasil melakukan split produk baru.');
            
        } catch (Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function createPaketPenjualanBnob(Request $request)
    {
        try {
            $connectionKios = DB::connection('rumahdrone_kios');
            $connectionKios->beginTransaction();

            $paketPenjualan = $request->input('paket_penjualan_bnob');
            $hargaJual = preg_replace("/[^0-9]/", "", $request->input('harga_srp'));
            $totalModal = preg_replace("/[^0-9]/", "", $request->input('total_modal_bnob'));
            $randString = Str::random(10);
            $snProduk = 'BNOB-' . $randString;

            $produkBnob = KiosProdukBnob::create([
                'sub_jenis_id' => $paketPenjualan,
                'modal_bnob' => $totalModal,
                'srp' => $hargaJual,
                'serial_number' => $snProduk,
                'status' => 'Ready'
            ]);

            $snBnob = $request->input('sn_bnob');

            foreach ($snBnob as $sn) {
                $dataUpdate = [
                    'kios_produk_bnob_id' => $produkBnob->id,
                    'status' => 'On Sell'
                ];
                KiosListKelengkapanSplit::find($sn)->update($dataUpdate);
            }

            $connectionKios->commit();
            return back()->with('success', 'Berhasil membuat produk bnob baru.');

        } catch (Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function getSnSplit($id)
    {
        $dataSN = KiosSerialNumber::where('produk_id', $id)->where('status', 'Ready')->get();

        return response()->json($dataSN);
    }

    public function getKelengkapanSplitBaru($id, $idSn)
    {
        $produkBaru = KiosProduk::find($id);
        $kelengkapanBaru = $produkBaru->subjenis->kelengkapans;

        $findSn = KiosSerialNumber::find($idSn);
        $nilaiModal = $findSn->validasiproduk->orderLists->nilai;

        return response()->json(['dataKelengkapan' => $kelengkapanBaru, 'modalAwal' => $nilaiModal]);
    }

    public function getKelengkapanSplitBnob()
    {
        $dataKelengkapan = KiosListKelengkapanSplit::where('status', 'Ready')->with('kelengkapanProduk')->get();
        return response()->json($dataKelengkapan);
    }

    public function getSerialNumberSplitBnob($kelengkapanId)
    {
        $dataSerialNumber = KiosListKelengkapanSplit::where('produk_kelengkapan_id', $kelengkapanId)->where('status', 'Ready')->get();
        return response()->json($dataSerialNumber);
    }

    public function getNominalKelengkapanSplit($id)
    {
        $dataModal = KiosListKelengkapanSplit::where('id', $id)->where('status', 'Ready')->pluck('nominal');
        return response()->json($dataModal);
    }

}
