<?php

namespace App\Http\Controllers\wilayah;

use App\Http\Controllers\Controller;
use App\Models\wilayah\Kota;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function getKota($provinsiId)
    {
        $kota = Kota::where('provinsi_id', $provinsiId)->get();

        if(count($kota) > 0) {
            return response()->json($kota);
        }
    }
}
