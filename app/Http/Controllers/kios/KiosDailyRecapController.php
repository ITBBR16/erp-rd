<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Models\kios\KiosDailyRecap;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosRecapStatus;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosRecapKeperluan;
use App\Repositories\kios\KiosRepository;
use App\Models\kios\KiosRecapPermasalahan;
use App\Models\kios\KiosKategoriPermasalahan;
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
        $permasalahan = KiosRecapPermasalahan::all();

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
        $connectionCustomer = DB::connection('rumahdrone_customer');
        $connectionKios = DB::connection('rumahdrone_kios');

        $picId = auth()->user()->id;
        $divisiId = auth()->user()->divisi_id;

        if($request->has('nama_customer')) {
            $connectionKios->beginTransaction();
            try{
                $dailyRecap = new KiosDailyRecap([
                    'employee_id' => $picId,
                    'customer_id' => $request->input('nama_customer'),
                    'jenis_produk_id' => $request->input('jenis_produk'),
                    'permasalahan_id' => $request->input('permasalahan'),
                    'keperluan_id' => $request->input('keperluan_recap'),
                    'keterangan' => $request->input('keterangan'),
                    'kategori_permasalahan_id' => $request->input('kategori_permasalahan'),
                ]);

                $status = ($request->input('permasalahan') == 1) ? 'Unprocessed' : 'Done Case';
                $dailyRecap->status = $status;

                $dailyRecap->save();
                $connectionKios->commit();

                return back()->with('success', 'Success Add Daily Recap.');

            } catch (Exception $e) {
                $connectionKios->rollBack();
                return back()->with('error', $e->getMessage());
            }

        } elseif($request->has('first_name')) {

            $connectionCustomer->beginTransaction();

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
            dd($payloadContact);
            $statusContact = $payloadContact['status'];
            
            if($statusContact === 'success') {
                $connectionCustomer->commit();
                return back()->with('success', 'Success Add New Customer.');
            } else {
                $connectionCustomer->rollBack();
                return back()->with('error', 'Failed to Save Contact. Please try again.');
            }

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

    public function destroy($id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try{
            $dailyRecapId = KiosDailyRecap::findOrFail($id);
            $dailyRecapId->delete();

            $connectionKios->commit();
            return back()->with('success', 'Success Delete Data Recap.');
        } catch(Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
