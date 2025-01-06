<?php

namespace App\Services\gudang;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\umum\UmumRepository;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\gudang\repository\GudangProdukRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\gudang\repository\GudangAddNewSparepartRepository;

class GudangAddNewSparepartServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private ProdukRepository $produk,
        private GudangAddNewSparepartRepository $sparepart,
        private GudangProdukRepository $produkGudang,
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
            $insertedIds = []; // Untuk menyimpan ID yang di-insert
            foreach ($request->input('type_part') as $index => $type) {
                $data = [
                    'produk_type_id' => $type,
                    'produk_part_model_id' => $request->input('model_part')[$index],
                    'produk_jenis_id' => $request->input('jenis_produk')[$index],
                    'produk_part_bagian_id' => $request->input('bagian_part')[$index],
                    'produk_part_sub_bagian_id' => $request->input('sub_bagian_part')[$index],
                    'produk_part_sifat_id' => $request->input('sifat_part')[$index],
                    'nama_internal' => $request->input('nama_internal')[$index],
                    'sku_origin' => $request->input('sku_external')[$index],
                    'nama_origin' => $request->input('nama_eksternal')[$index],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];

                // Insert data dan ambil ID
                $sparepart = $this->sparepart->createNewSparepart($data);
                $insertedIds[] = $sparepart->id;
            }

            $dataProduk = [];
            foreach ($insertedIds as $idPart) {
                $dataProduk[] = [
                    'produk_sparepart_id' => $idPart,
                    'status' => 'Not Ready',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }

            $this->produkGudang->insertProduk($dataProduk);
            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Berhasil menambahkan sparepart baru.'];

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            Log::error('Error creating sparepart', ['error' => $e->getMessage()]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

}