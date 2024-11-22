<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;

class GudangLabelController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private GudangProdukIdItemRepository $idItem,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $listValidasi = $this->idItem->getListProdukIdItem();
        
        return view('gudang.receive-goods.label.list-label', [
            'title' => 'Gudang Label',
            'active' => 'gudang-label',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'listValidasi' => $listValidasi,
        ]);
    }

    public function printLabel($idBelanja, $idProduk)
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataLabel = $this->idItem->getProdukForQc($idBelanja, $idProduk);
        
        return view('gudang.receive-goods.label.edit.print-label', [
            'title' => 'Gudang Label',
            'active' => 'gudang-label',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'dataLabel' => $dataLabel,
        ]);
    }

}
