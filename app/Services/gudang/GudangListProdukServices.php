<?php

namespace App\Services\gudang;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\umum\UmumRepository;
use App\Repositories\gudang\repository\GudangProdukRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;

class GudangListProdukServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private GudangProdukRepository $produk
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataProduk = $this->produk->getAllProduk();
        
        return view('gudang.produk.list-produk.list-produk', [
            'title' => 'Gudang Produk',
            'active' => 'gudang-produk',
            'navActive' => 'produk',
            'divisi' => $divisiName,
            'dataProduk' => $dataProduk,
        ]);
    }

    public function updatePromoProduk($id, Request $request)
    {
        try {
            $this->transaction->beginTransaction();

            $hargaPromo = preg_replace("/[^0-9]/", "", $request->input('harga_promo')) ?: 0;
            $startTanggalInput = $request->input('tanggal_start_promo');
            $endTanggalInput = $request->input('tanggal_end_promo');
            $formatedStart = Carbon::createFromFormat('m/d/Y', $startTanggalInput)->format('Y-m-d');
            $formatedEnd = Carbon::createFromFormat('m/d/Y', $endTanggalInput)->format('Y-m-d');

            $dataPromo = [
                'tanggal_start_promo' => $formatedStart,
                'tanggal_end_promo' => $formatedEnd,
                'harga_promo' => $hargaPromo,
                'status' => 'Promo'
            ];
            
            $this->produk->updateProduk($id, $dataPromo);
            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Promo berhasil dibuat.'];
            
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateHargaJual($id, Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            
            $findProduk = $this->produk->findProduk($id);
            $hargaInternal = preg_replace("/[^0-9]/", "", $request->input('harga_internal')) ?: 0;
            $hargaGlobal = preg_replace("/[^0-9]/", "", $request->input('harga_global')) ?: 0;

            if ($findProduk->harga_internal != $hargaInternal) {
                $this->produk->updateProduk($id, ['harga_internal' => $hargaInternal]);
            }

            if ($findProduk->harga_global != $hargaGlobal) {
                $this->produk->updateProduk($id, ['harga_global' => $hargaGlobal]);
            }
            $this->transaction->commitTransaction();
            
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

}