<?php

namespace App\Http\Controllers\wilayah;

use App\Http\Controllers\Controller;
use App\Models\wilayah\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function getKecamatan($kotaId) 
    {
        $kecamatan = Kecamatan::where('kabupaten_id', $kotaId)->get();

        if(count($kecamatan) > 0) {
            return response()->json($kecamatan);
        }
    }
}
