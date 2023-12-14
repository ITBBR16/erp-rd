<?php

namespace App\Repositories\kios;

use App\Models\divisi\Divisi;
use Illuminate\Support\Facades\DB;

class KiosRepository implements KiosInterface
{
    public function getKategoriSupplier(){
        try {
            $kategoriSupplier = DB::connection('rumahdrone_produk')->table('produk_kategori')->get()->all();
            return $kategoriSupplier;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getDivisi($user){
        $divisiId = $user->divisi_id;
        if($divisiId != 0){
            $divisiName = Divisi::find($divisiId);
        } else {
            $divisiName = 'Super Admin';
        }

        return $divisiName;
    }
}