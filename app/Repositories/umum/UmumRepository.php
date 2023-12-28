<?php

namespace App\Repositories\umum;

use App\Models\divisi\Divisi;

class UmumRepository implements UmumInterface
{
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