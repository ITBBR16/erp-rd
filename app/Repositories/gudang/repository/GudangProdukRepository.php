<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangProduk;
use App\Repositories\gudang\interface\GudangProdukInterface;

class GudangProdukRepository implements GudangProdukInterface
{
    public function __construct(
        private GudangProduk $produk
    ){}

    public function getListIdItem($idSparepart)
    {
        $findProduk = $this->produk->where('produk_sparepart_id', $idSparepart)->first();

        if (!$findProduk) {
            return [];
        }

        $listIdItem = $findProduk->gudangIdItem()->with('gudangBelanja', 'gudangProduk.produkSparepart')->where('status_inventory', 'Ready')->get();

        return $listIdItem;
    }

    public function findProduk($id)
    {
        return $this->produk->find($id);
    }

    public function findBySparepart($id)
    {
        return $this->produk->where('produk_sparepart_id', $id)->first();
    }

    public function getAllProduk()
    {
        return $this->produk->paginate(70);
    }
    
    public function createProduk(array $data)
    {
        return $this->produk->create($data);
    }

    public function insertProduk(array $data)
    {
        return $this->produk->insert($data);
    }

    public function updateProduk($id, array $data)
    {
        $produk = $this->produk->find($id);

        if ($produk) {
            $produk->update($data);
            return $produk;
        }

        throw new \Exception('Product not found.');
    }

    public function updateByValidasi($id, array $data)
    {
        $produk = $this->produk->find($id);

        if ($produk) {
            $produk->update($data);
            return $produk;
        }

        throw new \Exception('Sparepart not found.');
    }
}