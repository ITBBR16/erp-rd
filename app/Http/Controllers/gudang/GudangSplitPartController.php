<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangSplitSKUServices;
use Illuminate\Http\Request;

class GudangSplitPartController extends Controller
{
    public function __construct(
        private GudangSplitSKUServices $split
    ){}

    public function index()
    {
        return $this->split->index();
    }

    public function store(Request $request)
    {
        $resultSplit = $this->split->createSplit($request);

        return back()->with($resultSplit['status'], $resultSplit['message']);
    }

    public function getListIdItem($idSparepart)
    {
        return $this->split->getIdItem($idSparepart);
    }

    public function detailBelanjaIdItem($idItem)
    {
        return $this->split->getDetailBelanjaSplit($idItem);
    }
}
