<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Models\kios\KiosDailyRecap;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosRecapKeperluan;
use App\Models\kios\KiosRecapStatus;
use App\Models\produk\ProdukStatus;
use App\Models\produk\ProdukSubJenis;
use Illuminate\Support\Facades\Http;
use App\Repositories\kios\KiosRepository;

class KiosDailyRecapController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $provinsi = Provinsi::all();
        $customer = Customer::all();
        $statusProduk = ProdukStatus::all();
        $subjenisProduk = ProdukSubJenis::all();
        $dailyRecap = KiosDailyRecap::orderByDesc('id')->get();
        $recapStatus = KiosRecapStatus::all();
        $recapKeperluan = KiosRecapKeperluan::all();

        return view('kios.main.recap', [
            'title' => 'Daily Recap',
            'active' => 'daily-recap',
            'navActive' => 'customer',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'provinsi' => $provinsi,
            'customer' => $customer,
            'statusProduk' => $statusProduk,
            'subjenisProduk' => $subjenisProduk,
            'dailyRecap' => $dailyRecap,
            'statusrecap' => $recapStatus,
            'keperluanrecap' => $recapKeperluan,
        ]);
    }

    public function store(Request $request)
    {
        $picId = auth()->user()->id;
        $divisiId = auth()->user()->divisi_id;

        if($request->has('nama_customer')) {
            
            try{
                $dailyRecap = new KiosDailyRecap([
                    'employee_id' => $picId,
                    'customer_id' => $request->input('nama_customer'),
                    'jenis_id' => $request->input('jenis_produk'),
                    'sub_jenis_id' => $request->input('sub_jenis_produk'),
                    'keperluan_id' => $request->input('keperluan_recap'),
                    'barang_cari' => $request->input('barang_cari'),
                    'keterangan' => $request->input('keterangan'),
                    'status_id' => $request->input('status_recap'),
                ]);
    
                $dailyRecap->save();
    
                return back()->with('success', 'Success Add Daily Recap.');
    
            } catch (Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        
        } elseif($request->has('first_name')) {
            
            $validate = $request->validate([
                'first_name' => 'required|max:50',
                'last_name' => 'required|max:50',
                'no_telpon' => ['required', 'regex:/^62\d{9,}$/', Rule::unique('rumahdrone_customer.customer', 'no_telpon')],
                'email' => 'nullable|email:dns',
                'instansi' => 'max:50',
                'provinsi' => 'required',
                'kota_kabupaten' => 'required',
                'kecamatan' => 'required',
                'kelurahan' => 'required',
                'kode_pos' => 'required|numeric|digits:5',
                'nama_jalan' => 'required|max:255'
            ]);
    
            $validate['by_divisi'] = $divisiId;
    
            $appScriptUrl = 'https://script.google.com/macros/s/AKfycbyFTLvq0HaGhnZBjSWH3JLKuRntth2wBKoltkFrGwWQM0UHjG6BMLeaM3guaz9mLCS8/exec';
            $response = Http::post($appScriptUrl, [
                'first_name' => $validate['first_name'],
                'last_name' => $validate['last_name'],
                'email' => $validate['email'],
                'no_telpon' => $validate['no_telpon'],
            ]);
    
            if($response->successful()) {
                Customer::create($validate);
                return back()->with('success', 'Success Add New Customer.');
            } else {
                return back()->with('error', 'Failed to Save Contact. Please try again.');
            }
        
        }

    }

    public function update(Request $request, $id)
    {
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

            return back()->with('success', 'Success Update Data Recap.');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $dailyRecapId = KiosDailyRecap::findOrFail($id);
            $dailyRecapId->delete();

            return back()->with('success', 'Success Delete Data Recap.');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
