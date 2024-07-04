<?php

namespace App\Http\Controllers\kios;

use Exception;
use App\Models\kios\KiosWTB;
use App\Models\kios\KiosWTS;
use Illuminate\Http\Request;
use App\Models\kios\KiosProduk;
use Illuminate\Validation\Rule;
use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Models\kios\KiosDailyRecap;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosProdukSecond;
use App\Models\produk\ProdukSubJenis;
use App\Models\kios\KiosRecapKeperluan;
use App\Models\kios\KiosTechnicalSupport;
use App\Repositories\kios\KiosRepository;
use App\Models\kios\KiosKategoriPermasalahan;
use App\Models\kios\KiosRecapTechnicalSupport;
use App\Models\customer\CustomerInfoPerusahaan;

class KiosDailyRecapController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $provinsi = Provinsi::all();
        $customer = Customer::all();
        $dailyRecap = KiosDailyRecap::orderByDesc('id')->get();
        $produkJenis = ProdukJenis::all();
        $infoPerusahaan = CustomerInfoPerusahaan::all();
        $recapKeperluan = KiosRecapKeperluan::all();
        $kategoriPermasalahan = KiosKategoriPermasalahan::all();
        $permasalahan = KiosTechnicalSupport::all();

        return view('kios.main.recap', [
            'title' => 'Daily Recap',
            'active' => 'daily-recap',
            'navActive' => 'customer',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'provinsi' => $provinsi,
            'customer' => $customer,
            'produkJenis' => $produkJenis,
            'dailyRecap' => $dailyRecap,
            'keperluanrecap' => $recapKeperluan,
            'infoPerusahaan' => $infoPerusahaan,
            'kategoriPermasalahan' => $kategoriPermasalahan,
            'permasalahan' => $permasalahan,
        ]);
    }

    public function store(Request $request)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        $picId = auth()->user()->id;

        try{
            $idKeperluan = $request->input('keperluan_recap');
            $keperluanRecap = KiosRecapKeperluan::findOrFail($idKeperluan);
            $inputStatus = $request->input('status_produk');
            $keterangan = $request->input('keterangan');

            if ($keperluanRecap->nama == 'Want to Buy') {
                $tableKeperluan = KiosWTB::create([
                    'kondisi_produk' => $request->input('kondisi_produk'),
                    'paket_penjualan_id' => $request->input('paket_penjualan'),
                    'keterangan' => $keterangan,
                ]);

                $status = ($inputStatus == 'Ready' || $inputStatus == 'Promo') ? 'Sudah Ditawari Produk' : 'Produk Tidak Tersedia';

            } elseif ($keperluanRecap->nama == 'Want to Sell') {
                $tableKeperluan = KiosWTS::create([
                    'paket_penjualan_id' => $request->input('paket_penjualan'),
                    'produk_worth' => $request->input('produk_worth'),
                    'keterangan' => $keterangan,
                ]);

                $status = ($inputStatus == 'Ready') ? 'Produk dibutuhkan' : 'Produk tidak dibutuhkan';

            } elseif ($keperluanRecap->nama == 'Technical Support') {
                $keperluanTsId = $request->input('permasalahan');
                $keperluanTs = KiosKategoriPermasalahan::findOrFail($keperluanTsId);

                $tableKeperluan = KiosRecapTechnicalSupport::create([
                    'kategori_permasalahan_id' => $request->input('kategori_permasalahan'),
                    'kios_ts_id' => $request->input('permasalahan'),
                    'jenis_id' => $request->input('jenis_produk'),
                    'keterangan' => $keterangan,
                ]);
                
                $status = ($keperluanTs == 'Belum Terdata') ? 'Unprocess' : 'Case Done';
                
            } else {
                $connectionKios->rollBack();
                return back()->with('error', 'Something went wrong.');
            }

            $dailyRecap = new KiosDailyRecap([
                'employee_id' => $picId,
                'customer_id' => $request->input('nama_customer'),
                'keperluan_id' => $request->input('keperluan_recap'),
                'table_id' => $tableKeperluan->id,
                'status' => $status,
            ]);

            $dailyRecap->save();
            $connectionKios->commit();

            return back()->with('success', 'Success Add Daily Recap.');

        } catch (Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    public function newCustomer(Request $request)
    {
        $connectionCustomer = DB::connection('rumahdrone_customer');
        $connectionCustomer->beginTransaction();

        $divisiId = auth()->user()->divisi_id;

            try {
                $validate = $request->validate([
                    'first_name' => 'required|max:50',
                    'last_name' => 'required|max:50',
                    'asal_informasi' => 'required',
                    'no_telpon' => ['required', 'regex:/^62\d{9,}$/', Rule::unique('rumahdrone_customer.customer', 'no_telpon')],
                    'email' => 'nullable|email:dns',
                    'instansi' => 'max:50',
                    'provinsi' => 'required',
                    'nama_jalan' => 'required|max:255'
                ]);
    
                $validate['by_divisi'] = $divisiId;
    
                $dataCustomer = Customer::create($validate);
                $appScriptUrl = 'https://script.google.com/macros/s/AKfycbyFTLvq0HaGhnZBjSWH3JLKuRntth2wBKoltkFrGwWQM0UHjG6BMLeaM3guaz9mLCS8/exec';
                $response = Http::post($appScriptUrl, [
                    'first_name' => $validate['first_name'],
                    'last_name' => $validate['last_name'] . ' - ' . $dataCustomer->id,
                    'email' => $validate['email'],
                    'no_telpon' => $validate['no_telpon'],
                ]);
    
                $payloadContact = json_decode($response->body(), true);
                $statusContact = $payloadContact['status'];
                
                if($statusContact === 'success') {
                    $connectionCustomer->commit();
                    return back()->with('success', 'Success Add New Customer.');
                } else {
                    $connectionCustomer->rollBack();
                    return back()->with('error', 'Failed to Save Contact. Please try again.');
                }

            } catch (Exception $e) {
                $connectionCustomer->rollBack();
                return back()->with('error', $e->getMessage());
            }
    }

    public function update(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try {
            $dataRecap = KiosDailyRecap::findOrFail($id);
            $dataRecap->update([
                'customer_id' => $request->input('edit_recap_nama_customer'),
                'jenis_id' => $request->input('edit_recap_jenis_produk'),
                'sub_jenis_id' => $request->input('edit_recap_sub_jenis_produk'),
                'keperluan_id' => $request->input('edit_recap_keperluan'),
                'barang_cari' => $request->input('edit_recap_barang_cari'),
                'keterangan' => $request->input('edit_recap_keterangan'),
                'status_id' => $request->input('edit_recap_status'),
            ]);

            $connectionKios->commit();
            return back()->with('success', 'Success Update Data Recap.');
        } catch(Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try{
            $keperluanName = $request->input('keperluan_id');
            $dailyRecapSearch = KiosDailyRecap::findOrFail($id);

            if ($keperluanName == 'Want to Buy') {
                $dailyRecapSearch->kiosWtb()->delete();
            } elseif ($keperluanName == 'Want to Sell') {
                $dailyRecapSearch->kiosWts()->delete();
            } elseif ($keperluanName == 'Technical Support') {
                $dailyRecapSearch->technicalSupport()->delete();
            } else {
                $connectionKios->rollBack();
                return back()->with('error', 'Something Went Wrong.');
            }

            $dailyRecapSearch->delete();

            $connectionKios->commit();
            return back()->with('success', 'Success Delete Data Recap.');
        } catch(Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function getProduk($kondisiProduk)
    {
        if ($kondisiProduk == 'Drone Baru') {
            $items = KiosProduk::with('subjenis.produkjenis')->get();
        } elseif ($kondisiProduk == 'Drone Bekas') {
            $items = KiosProdukSecond::with('subjenis.produkjenis')->get();
        } elseif ($kondisiProduk == 'Part Baru' || $kondisiProduk == 'Part Bekas') {
            
            $urlApiGudang = 'https://script.google.com/macros/s/AKfycbyGbMFkZyhJAGgZa4Tr8bKObYrNxMo4h-uY1I-tS_SbtmEOKPeCcxO2aU6JjLWedQlFVw/exec';
            $response = Http::post($urlApiGudang, [
                'status' => $kondisiProduk
            ]);

            $data = $response->json();
            $resultData = [];
            foreach ($data['data'] as $dataNeed) {
                $neededData = [
                    'sku' => $dataNeed[0],
                    'nama_part' => $dataNeed[2],
                    'srp_part' => $dataNeed[8],
                ];
                $resultData[] = $neededData;
            }

            $items = $resultData;

        }

        return response()->json($items);

    }

    public function getSubjenis($kondisiProduk, $id)
    {
        if ($kondisiProduk == 'Drone Baru') {
            $items = ProdukSubJenis::with('kiosproduk', 'produkjenis')->where('jenis_id', $id)->get();
        } elseif ($kondisiProduk == 'Drone Bekas') {
            $items = ProdukSubJenis::with('kiosproduksecond', 'produkjenis')->where('jenis_id', $id)->get();
        } elseif ($kondisiProduk == 'Part Baru' || $kondisiProduk == 'Part Bekas') {
            
            $urlApiGudang = 'https://script.google.com/macros/s/AKfycbyGbMFkZyhJAGgZa4Tr8bKObYrNxMo4h-uY1I-tS_SbtmEOKPeCcxO2aU6JjLWedQlFVw/exec';
            $response = Http::post($urlApiGudang, [
                'status' => $kondisiProduk
            ]);

            $data = $response->json();
            $resultData = [];
            foreach ($data['data'] as $dataNeed) {
                $neededData = [
                    'sku' => $dataNeed[0],
                    'nama_part' => $dataNeed[2],
                    'srp_part' => $dataNeed[8],
                ];
                $resultData[] = $neededData;
            }

            $items = $resultData;

        }

        return response()->json($items);

    }

    public function getPaketPenjualan($id)
    {
        $items = ProdukJenis::with('subjenis')->where('id', $id)->get();
        return response()->json($items);
    }

    public function getPermasalahan($jenisId)
    {
        $produkSearch = ProdukJenis::findOrFail($jenisId);
        $dataPermasalahan = $produkSearch->produkpermasalahan()->get();
        return response()->json($dataPermasalahan);
    }


}
