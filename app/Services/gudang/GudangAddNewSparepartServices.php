<?php

namespace App\Services\gudang;

use App\Repositories\umum\UmumRepository;
use App\Repositories\gudang\repository\GudangProdukRepository;
use App\Repositories\gudang\repository\GudangAddNewSparepartRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\umum\repository\ProdukRepository;
use Exception;
use Illuminate\Http\Request;

class GudangAddNewSparepartServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private ProdukRepository $produk,
        private GudangAddNewSparepartRepository $sparepart
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $jenisProduk = $this->produk->getAllJenisProduct();
        $typePart = $this->sparepart->getTypePart();
        $modelPart = $this->sparepart->getModelPart();
        $bagianPart = $this->sparepart->getBagianPart();
        $subBagianPart = $this->sparepart->getSubBagianPart();
        $sifatPart = $this->sparepart->getSifatPart();

        return view('gudang.produk.add-sparepart.main-sparepart', [
            'title' => 'Gudang Sparepart',
            'active' => 'gudang-sparepart',
            'navActive' => 'produk',
            'divisi' => $divisiName,
            'jenisProduk' => $jenisProduk,
            'typePart' => $typePart,
            'modelPart' => $modelPart,
            'bagianPart' => $bagianPart,
            'subBagianPart' => $subBagianPart,
            'sifatPart' => $sifatPart,
        ]);
    }

    public function createSparepart(Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            
            $timestamp = now();
            $typePart = $request->input('model_part');
            $modelPart = $request->input('jenis_produk');
            $jenisProduk = $request->input('type_part');
            $bagianPart = $request->input('bagian_part');
            $subBagianPart = $request->input('sub_bagian_part');
            $sifatPart = $request->input('sifat_part');
            $skuExternal = $request->input('sku_external');
            $namaExternal = $request->input('nama_eksternal');
            $namaInternal = $request->input('nama_internal');
            $dataSparepart = [];

            foreach ($typePart as $index => $type) {
                $dataSparepart[] = [
                    'produk_type_id' => $typePart[$index],
                    'produk_part_model_id' => $modelPart[$index],
                    'produk_jenis_id' => $jenisProduk[$index],
                    'produk_part_bagian_id' => $bagianPart[$index],
                    'produk_part_sub_bagian_id' => $subBagianPart[$index],
                    'produk_part_sifat_id' => $sifatPart[$index],
                    'nama_internal' => $skuExternal[$index],
                    'sku_origin' => $namaExternal[$index],
                    'nama_origin' => $namaInternal[$index],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }

            $this->sparepart->insertSparepart($dataSparepart);
            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil menambahkan sparepart baru.'];

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}