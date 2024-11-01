<?php

namespace App\Services\gudang;

use App\Repositories\gudang\repository\GudangBelanjaRepository;
use App\Repositories\gudang\repository\GudangSupplierRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\management\repository\AkuntanTransaksiRepository;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\umum\UmumRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GudangBelanjaServices
{

    public function __construct(
        private UmumRepository $nameDivisi,
        private ProdukRepository $produk,
        private GudangTransactionRepository $transaction,
        private GudangSupplierRepository $supplier,
        private GudangBelanjaRepository $belanja,
        private AkuntanTransaksiRepository $akunBank,
        ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $suppliers = $this->supplier->getSuppliers();
        $jenisProduk = $this->produk->getAllJenisProduct();
        $namaAkunBank = $this->akunBank->getNamaBank();
        $listBelanja = $this->belanja->indexBelanja();
        
        return view('gudang.purchasing.belanja.belanja', [
            'title' => 'Gudang Belanja',
            'active' => 'gudang-belanja',
            'navActive' => 'purchasing',
            'divisi' => $divisiName,
            'suppliers' => $suppliers,
            'jenisProduk' => $jenisProduk,
            'namaBank' => $namaAkunBank,
            'listBelanja' => $listBelanja
        ]);
    }

    public function editBelanja($id)
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $suppliers = $this->supplier->getSuppliers();
        $jenisProduk = $this->produk->getAllJenisProduct();
        $namaAkunBank = $this->akunBank->getNamaBank();
        $listBelanja = $this->belanja->findBelanja($id);
        
        return view('gudang.purchasing.edit.edit-belanja', [
            'title' => 'Gudang Belanja',
            'active' => 'gudang-belanja',
            'navActive' => 'purchasing',
            'divisi' => $divisiName,
            'suppliers' => $suppliers,
            'jenisProduk' => $jenisProduk,
            'namaBank' => $namaAkunBank,
            'belanja' => $listBelanja
        ]);
    }

    public function createBelanja(Request $request)
    {
        
        try {
            $this->transaction->beginTransaction();
            $employeeId = auth()->user()->id;

            $supplierId = $request->input('supplier');
            $invoice = $request->input('invoice_supplier');
            $nominalOngkir = preg_replace("/[^0-9]/", "", $request->input('nominal_ongkir')) ?: 0;
            $nominalPajak = preg_replace("/[^0-9]/", "", $request->input('nominal_pajak')) ?: 0;
            
            $jenisDrone = $request->input('jenis_drone');
            $sparepart = $request->input('spareparts');
            $sparepartQty = $request->input('sparepart_qty');
            $sparepartNominal = array_map(function($value) {
                return preg_replace("/[^0-9]/", "", $value) ?? 0;
            }, $request->input('nominal_pcs'));

            $dataDetailBelanja = [];
            $totalQty = 0;
            $totalBiaya = 0;

            $mediaTransaksi = $request->input('media_transaksi');
            $namaAkun = $request->input('nama_akun');
            $bankPembayaran = $request->input('bank_pembayaran');
            $idAkun = $request->input('id_akun');
            
            foreach ($jenisDrone as $index => $jenis) {
                
                $dataDetailBelanja[] = [
                    'sparepart_id' => $sparepart[$index],
                    'quantity' => $sparepartQty[$index],
                    'nominal_pcs' => $sparepartNominal[$index],
                ];

                $totalQty += $sparepartQty[$index];
                $totalTransaksi = $sparepartQty[$index] * $sparepartNominal[$index];
                $totalBiaya += $totalTransaksi;
            }

            $dataMetodePembayaran = [
                'nama_bank_id' => $bankPembayaran,
                'gudang_supplier_id' => $supplierId,
                'media_transaksi' => $mediaTransaksi,
                'nama_akun' => $namaAkun,
                'id_akun' => $idAkun
            ];

            $metodePembayaran = $this->belanja->createMetodePembayaran($dataMetodePembayaran);

            $dataBelanja = [
                'employee_id' => $employeeId,
                'gudang_supplier_id' => $supplierId,
                'gudang_metode_pembayaran_id' => $metodePembayaran->id,
                'total_quantity' => $totalQty,
                'total_pembelian' => $totalBiaya,
                'total_ongkir' => $nominalOngkir,
                'total_pajak' => $nominalPajak,
                'invoice' => $invoice,
                'status' => 'Menunggu Konfirmasi Belanja'
            ];

            $newBelanja = $this->belanja->createBelanja($dataBelanja, $dataDetailBelanja);

            $urlCreateFolder = 'https://script.google.com/macros/s/AKfycbxrS4V5we769TaBJqwHC_1pHcCmzVkDuFA9ikgNteKJOFhxWCptgobmaOJ63jVwxiVz/exec';
            $response = Http::post($urlCreateFolder, [
                'orderId' => 'N.' . $newBelanja->id,
            ]);
            $decaodeResponse = json_decode($response->body(), true);
            $status = $decaodeResponse['status'];
            $linkDrive = $decaodeResponse['folderUrl'];

            if ($status == 'success') {
                $newBelanja->update(['link_drive' => $linkDrive]);
                $this->transaction->commitTransaction();
                return ['status' => 'success', 'message' => 'Berhasil membuat belanja baru.'];
            } else {
                return ['status' => 'error', 'message' => 'Terjadi kesalahan ketika membuat folder belanja'];
            }

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateBelanja($id, Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            
            $employeeId = auth()->user()->id;
            $supplierId = $request->input('supplier');
            $invoice = $request->input('invoice_supplier');
            $nominalOngkir = preg_replace("/[^0-9]/", "", $request->input('nominal_ongkir')) ?: 0;
            $nominalPajak = preg_replace("/[^0-9]/", "", $request->input('nominal_pajak')) ?: 0;

            $dataMetodePembayaran = [
                'nama_bank_id' => $request->input('bank_pembayaran'),
                'gudang_supplier_id' => $supplierId,
                'media_transaksi' => $request->input('media_transaksi'),
                'nama_akun' => $request->input('nama_akun'),
                'id_akun' => $request->input('id_akun')
            ];

            $metodePembayaran = $this->belanja->updateOrCreateMP(
                ['gudang_supplier_id' => $supplierId, 'media_transaksi' => $dataMetodePembayaran['media_transaksi']],
                $dataMetodePembayaran
            );

            $dataBelanja = [
                'employee_id' => $employeeId,
                'gudang_supplier_id' => $supplierId,
                'gudang_metode_pembayaran_id' => $metodePembayaran->id,
                'total_quantity' => 0,
                'total_pembelian' => 0,
                'total_ongkir' => $nominalOngkir,
                'total_pajak' => $nominalPajak,
                'invoice' => $invoice,
            ];

            $belanja = $this->belanja->findBelanja($id);
            if (!$belanja) {
                throw new \Exception("Belanja not found.");
            }
            $belanja->update($dataBelanja);

            $totalQty = 0;
            $totalBiaya = 0;
            $existingDetailIds = [];

            foreach ($request->input('jenis_drone') as $index => $jenis) {
                $detailData = [
                    'sparepart_id' => $request->input('spareparts')[$index],
                    'quantity' => $request->input('sparepart_qty')[$index],
                    'nominal_pcs' => preg_replace("/[^0-9]/", "", $request->input('nominal_pcs')[$index]) ?: 0,
                    'belanja_id' => $belanja->id
                ];

                $totalQty += $detailData['quantity'];
                $totalTransaksi = $detailData['quantity'] * $detailData['nominal_pcs'];
                $totalBiaya += $totalTransaksi;

                $detailBelanja = $belanja->detailBelanja()->updateOrCreate(
                    ['id' => $request->input('id_detail')[$index] ?? null],
                    $detailData
                );

                $existingDetailIds[] = $detailBelanja->id;
            }

            $belanja->detailBelanja()->whereNotIn('id', $existingDetailIds)->delete();

            $belanja->update([
                'total_quantity' => $totalQty,
                'total_pembelian' => $totalBiaya,
            ]);

            $this->transaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil memperbarui belanja.'];

        } catch (\Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    public function getDataSparepart($id)
    {
        return $this->produk->getSparepartbyJenis($id);
    }

    public function getTransaksiSupplier($id)
    {
        
    }
}