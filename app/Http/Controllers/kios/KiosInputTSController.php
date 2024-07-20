<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Models\kios\KiosDailyRecap;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosTechnicalSupport;
use App\Repositories\kios\KiosRepository;
use App\Models\kios\KiosKategoriPermasalahan;

class KiosInputTSController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $dataRecapTS = KiosDailyRecap::where('keperluan_id', 3)
                      ->where('status', 'Unprocess')
                      ->orderByDesc('id')
                      ->get();
        $dataTs = KiosTechnicalSupport::all();
        $produkJenis = ProdukJenis::all();
        $kategoriPermasalahan = KiosKategoriPermasalahan::all();

        return view('kios.technical_support.input-technical-support', [
            'title' => 'Input TS',
            'active' => 'input-ts',
            'navActive' => 'technical-support',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
            'dataRecapTs' => $dataRecapTS,
            'dataTs' => $dataTs,
            'jenisProduk' => $produkJenis,
            'kategoriPermasalahan' => $kategoriPermasalahan,
        ]);
    }

    public function store(Request $request)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try {
            $request->validate([
                'add_permasalahan' => ['required', Rule::unique('rumahdrone_kios.kios_technical_support', 'nama')],
            ]);

            $picId = auth()->user()->id;
            $kategoriPermasalahan = $request->input('keperluan_ts');
            $jenisProduk = $request->input('add_jenis_produk');
            $namaPermasalahan = ucwords($request->input('add_permasalahan'));
            $deskripsi = $request->input('deskrisi_ts');
            $linkVideo = $request->input('add_link_video');

            $recapPermasalahan = KiosTechnicalSupport::create([
                'employee_id' => $picId,
                'kategori_permasalahan_id' => $kategoriPermasalahan,
                'nama' => $namaPermasalahan,
                'deskripsi' => $deskripsi,
                'link_video' => $linkVideo,
            ]);

            foreach($jenisProduk as $jenis) {
                $searchJenisProduk = ProdukJenis::findOrFail($jenis);
                $searchJenisProduk->produkpermasalahan()->sync($recapPermasalahan->id);
            }

            $connectionKios->commit();
            return back()->with('success', 'Success add new data technical support.');

        } catch (Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

}
