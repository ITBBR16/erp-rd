<?php

namespace App\Services\gudang;

use App\Repositories\gudang\repository\GudangKomplainRepository;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\umum\UmumRepository;

class GudangKomplainSupplierServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private GudangKomplainRepository $komplain,
        private GudangProdukIdItemRepository $idItem,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $listKomplain = $this->idItem->getListProdukIdItem();

        return view('gudang.receive-goods.komplain.list-komplain', [
            'title' => 'Gudang Komplain',
            'active' => 'gudang-komplain',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'listKomplain' => $listKomplain
        ]);
    }
}