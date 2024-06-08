<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Models\kios\KiosDailyRecap;
use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;
use App\Models\kios\KiosRecapPermasalahan;

class KiosInputTSController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $dailyRecap = KiosDailyRecap::where('keperluan_id', 3)
                      ->where('status', 'Unprocessed')
                      ->orderByDesc('id')
                      ->get();
        $permasalahans = KiosRecapPermasalahan::all();
        $produkJenis = ProdukJenis::all();

        return view('kios.technical_support.input-technical-support', [
            'title' => 'Input TS',
            'active' => 'input-ts',
            'navActive' => 'technical-support',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
            'dataTS' => $dailyRecap,
            'permasalahans' => $permasalahans,
            'jenisProduk' => $produkJenis,
        ]);
    }

    public function store(Request $request)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try {
            $request->validate([
                'add_permasalahan' => ['required', Rule::unique('rumahdrone_kios.kios_recap_permasalahan', 'nama')],
            ]);

            $picId = auth()->user()->id;
            $jenisProduk = $request->input('add_jenis_produk');
            $permasalahan = ucwords($request->input('add_permasalahan'));
            $linkPermasalahan = $request->input('add_link_permasalahan');

            $recapPermasalahan = KiosRecapPermasalahan::create([
                'employee_id' => $picId,
                'nama' => $permasalahan,
                'link_permasalahan' => $linkPermasalahan,
            ]);

            $recapPermasalahan->permasalahanproduk()->sync($jenisProduk);

            $connectionKios->commit();
            return back()->with('success', 'Success add new data technical support.');

        } catch (Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

}
