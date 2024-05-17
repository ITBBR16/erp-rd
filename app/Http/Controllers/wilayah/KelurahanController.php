<?php

namespace App\Http\Controllers\wilayah;

use App\Http\Controllers\Controller;
use App\Models\wilayah\Kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    public function getKelurahan($kecamatanId) 
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $kecamatanId)->get();

        if(count($kelurahan) > 0) {
            return response()->json($kelurahan);
        } 
    }
}
