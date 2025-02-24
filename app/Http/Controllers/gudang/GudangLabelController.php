<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukSparepart;
use App\Repositories\umum\UmumRepository;
use App\Models\gudang\GudangBelanjaDetail;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;

class GudangLabelController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private GudangProdukIdItemRepository $idItem,
        private ProdukSparepart $sparepart,
        private GudangBelanjaDetail $detailBelanja
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $produkSparepart = $this->sparepart->orderByDesc('id')->get();
        $dataSparepart = $produkSparepart->map(function ($part) {
            return [
                'id' => $part->id,
                'display' => $part->nama_internal
            ];
        });
        
        return view('gudang.receive-goods.label.list-label', [
            'title' => 'Gudang Label',
            'active' => 'gudang-label',
            'navActive' => 'receive',
            'divisi' => $divisiName,
            'dataSparepart' => $dataSparepart
        ]);
    }

    public function previewLabelPdf($idBelanja, $idProduk)
    {
        $dataLabel = $this->idItem->getProdukForQc($idBelanja, $idProduk);
        $dataView = [
            'title' => 'Preview Tanda Terima',
            'dataLabel' => $dataLabel,
        ];

        $pdf = Pdf::loadView('gudang.receive-goods.label.pdf.pdf-print-label', $dataView)
                ->setPaper([0, 0, 30, 60], 'landscape');

        return $pdf->stream();
    }

    public function getIdBelanja($id)
    {
        $findBelanja = $this->detailBelanja->where('sparepart_id', $id)->get();
        $findBelanja->transform(function ($item) {
            $item->display = "N." . $item->gudang_belanja_id;
            return $item;
        });

        return response()->json($findBelanja);
    }

    public function getDataBelanja($id)
    {
        $findDetail = $this->detailBelanja->find($id);
        $idBelanja = $findDetail->gudang_belanja_id;
        $orderId = 'N.' . $idBelanja;
        $sku = $findDetail->sparepart->produkType->code . "." . $findDetail->sparepart->partModel->code . "." . 
                $findDetail->sparepart->produk_jenis_id . "." . $findDetail->sparepart->partBagian->code . "." . 
                $findDetail->sparepart->partSubBagian->code . "." . $findDetail->sparepart->produk_part_sifat_id . "." . $findDetail->sparepart->id;
        $idProduk = $findDetail->sparepart_id;
        $namaProduk = $findDetail->sparepart->nama_internal;
        $quantity = $findDetail->quantity;

        $dataLabel = [
            'detailId' => $idBelanja,
            'idProduk' => $idProduk,
            'orderId' => $orderId,
            'sku' => $sku,
            'namaProduk' => $namaProduk,
            'quantity' => $quantity,
        ];

        return response()->json($dataLabel);
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
            'idBelanja' => $idBelanja,
            'idProduk' => $idProduk
        ]);
    }

}
