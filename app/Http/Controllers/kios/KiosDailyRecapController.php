<?php

namespace App\Http\Controllers\kios;

use Exception;
use App\Models\kios\KiosWTB;
use App\Models\kios\KiosWTS;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Models\kios\KiosDailyRecap;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosRecapKeperluan;
use App\Models\kios\KiosTechnicalSupport;
use App\Repositories\kios\KiosRepository;
use App\Repositories\umum\UmumRepository;
use App\Models\kios\KiosKategoriPermasalahan;
use App\Models\kios\KiosRecapTechnicalSupport;
use App\Models\customer\CustomerInfoPerusahaan;
use App\Repositories\repair\repository\RepairCustomerRepository;

class KiosDailyRecapController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private RepairCustomerRepository $customerRepository,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $provinsi = Provinsi::all();
        $customer = Customer::orderByDesc('id')->get();
        $dataCustomers = $customer->map(function ($cust) {
            return [
                'id' => $cust->id,
                'display' => "{$cust->first_name} {$cust->last_name} - {$cust->id}"
            ];
        });
        $dailyRecap = KiosDailyRecap::orderByDesc('id')->paginate(50);
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
            'dataProvinsi' => $provinsi,
            'dataCustomers' => $dataCustomers,
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

        try {
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
                $keperluanTs = KiosTechnicalSupport::findOrFail($keperluanTsId);

                $tableKeperluan = KiosRecapTechnicalSupport::create([
                    'kategori_permasalahan_id' => $request->input('kategori_permasalahan'),
                    'kios_ts_id' => $request->input('permasalahan'),
                    'jenis_id' => $request->input('jenis_produk'),
                    'keterangan' => $keterangan,
                ]);
                $status = ($keperluanTs->nama == 'Belum Terdata') ? 'Unprocess' : 'Case Done';

            } else {
                $connectionKios->rollBack();
                return back()->with('error', 'Something went wrong.');
            }

            $today = now()->format('Y-m-d');
            $existingRecap = KiosDailyRecap::where('customer_id', $request->input('nama_customer'))
                ->where('keperluan_id', $request->input('keperluan_recap'))
                ->whereDate('created_at', $today)
                ->first();

            if ($existingRecap) {
                $connectionKios->rollBack();
                return back()->with('error', 'Data customer dengan keperluan yang sama tidak dapat di input ulang.');
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

                $request->merge([
                    'no_telpon' => preg_replace('/^0/', '62', $request->input('no_telpon')),
                ]);

                $request->validate([
                    'first_name' => 'required|max:50',
                    'no_telpon' => 'required',
                    'email' => 'nullable|email:dns',
                    'instansi' => 'max:50',
                    'provinsi' => 'required',
                    'nama_jalan' => 'max:255'
                ]);

                $existingCustomer = $this->customerRepository->findByPhoneNumber($request->input('no_telpon'));

                if ($existingCustomer) {
                    $dataCustomer = $existingCustomer;
                    $namaCustomer = $dataCustomer->first_name . ' ' . $dataCustomer->last_name . ' - ' . $dataCustomer->id;
                    return back()->with('success', 'No telpon sudah tersimpan dengan nama: ' . $namaCustomer);
                } else {
                    $dataInput = [
                        'first_name' => $request->input('first_name'),
                        'last_name' => $request->input('last_name'),
                        'asal_informasi' => 1,
                        'no_telpon' => $request->input('no_telpon'),
                        'by_divisi' => $divisiId,
                        'email' => $request->input('email'),
                        'instansi' => $request->input('instansi'),
                        'provinsi_id' => $request->input('provinsi'),
                        'kota_kabupaten_id' => $request->input('kota_kabupaten'),
                        'kecamatan_id' => $request->input('kecamatan'),
                        'kelurahan_id' => $request->input('kelurahan'),
                        'kode_pos' => $request->input('kode_pos'),
                        'nama_jalan' => $request->input('nama_jalan')
                    ];

                    $dataCustomer = $this->customerRepository->createCustomer($dataInput);
                    $appScriptUrl = 'https://script.google.com/macros/s/AKfycbyFTLvq0HaGhnZBjSWH3JLKuRntth2wBKoltkFrGwWQM0UHjG6BMLeaM3guaz9mLCS8/exec';
                    $response = Http::post($appScriptUrl, [
                        'first_name' => $dataInput['first_name'],
                        'last_name' => $dataInput['last_name'] . ' - ' . $dataCustomer->id,
                        'email' => $dataInput['email'],
                        'no_telpon' => $dataInput['no_telpon'],
                    ]);
        
                    if ($response->failed()) {
                        throw new Exception('Something Went Wrong. Error: ' . $response->body());
                    }
        
                    $responseBody = $response->body();
                    Log::info("Response from App Script: " . $responseBody);
                    $connectionCustomer->commit();
                    return back()->with('success', 'Contact berhasil di simpan');
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
                $dailyRecapSearch->recapTs()->delete();
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
        if ($kondisiProduk == 'Drone Baru' || $kondisiProduk == 'Drone Bekas') {
            $items = ProdukJenis::all();
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
        if ($kondisiProduk == 'Drone Baru' || $kondisiProduk == 'Drone Bekas') {
            $items = ProdukJenis::findOrFail($id)->subjenis()->get();
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

    public function getListProduk($kondisiProduk, $id)
    {
        $itemSearch = ProdukJenis::findOrFail($id);
        if ($kondisiProduk == 'Drone Baru') {
            $items = $itemSearch->subjenis()->with('kiosproduk')->get();
        } elseif ($kondisiProduk == 'Drone Bekas') {
            $items = $itemSearch->subjenis()->with('kiosproduksecond')->get();
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
        $itemSearch = ProdukJenis::findOrFail($id);
        $items = $itemSearch->subjenis()->get();
        return response()->json($items);
    }

    public function getPermasalahan($jenisId, $kategoriId)
    {
        $produkSearch = ProdukJenis::findOrFail($jenisId);
        $dataPermasalahan = $produkSearch->produkpermasalahan()->where('kategori_permasalahan_id', $kategoriId)->get();
        return response()->json($dataPermasalahan);
    }

    public function getDeskripsiPermasalahan($id)
    {
        $deskripsi = KiosTechnicalSupport::findOrFail($id);
        return response()->json($deskripsi);
    }

}
