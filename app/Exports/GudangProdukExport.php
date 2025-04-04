<?php

namespace App\Exports;

use App\Models\gudang\GudangProduk;
use App\Models\kios\KiosTransaksiPart;
use App\Models\produk\ProdukSparepart;
use App\Models\repair\RepairEstimasiPart;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class GudangProdukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $dataSparepart = ProdukSparepart::with('gudangIdItem.estimasiRepair', 'gudangIdItem.transaksiKios', 'gudangProduk')->get();

        return $dataSparepart->map(function ($items) {
            // Menghitung piutang
            $stockPiutang = $items->gudangIdItem->where('status_inventory', 'Piutang')->count();
            $totalPiutang = $items->gudangIdItem->where('status_inventory', 'Piutang')->sum(function ($gudang) {
                return $gudang->estimasiRepair->modal_gudang ?? 0;
            });

            // Menghitung rata-rata modal saat ini
            $dataGudangEstimasi = RepairEstimasiPart::where('gudang_produk_id', $items->id)
                ->whereNotNull('tanggal_dikirim')
                ->where('tanggal_dikirim', '!=', '')
                ->where('active', 'Active')
                ->sum('modal_gudang');

            $dataGudangTransaksi = KiosTransaksiPart::where('gudang_produk_id', $items->id)
                ->sum('modal_gudang');

            $totalSN = 0;
            $modalGudang = 0;

            $dataGudang = GudangProduk::where('produk_sparepart_id', $items->id)
                ->whereIn('status', ['Ready', 'Promo'])
                ->first();

            if ($dataGudang) {
                $dataSubGudang = $dataGudang->produkSparepart->gudangIdItem()->where('status_inventory', 'Ready')->get();
                $totalSN = $dataSubGudang->count();

                if ($totalSN > 0) {
                    $modalAwal = $dataGudang->modal_awal ?? 0;
                    $modalGudang = ($modalAwal - ($dataGudangEstimasi + $dataGudangTransaksi)) / $totalSN;
                }
            }

            return [
                'ID Produk' => $items->id,
                'Nama Internal' => $items->nama_internal,
                'Stock Piutang' => $stockPiutang ?? 0,
                'Modal Piutang' => number_format($totalPiutang, 10, ',', ''),
                'Modal Sold' => number_format($dataGudangTransaksi, 10, ',', ''),
                'Rata-rata Modal' => number_format($modalGudang, 10, ',', ''),
                'Harga Internal' => $items->gudangProduk->harga_internal ?? 0,
                'Harga Global' => $items->gudangProduk->harga_global ?? 0,
                'Modal Awal' => number_format($items->gudangProduk->modal_awal, 10, ',', ''),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID Produk',
            'Nama Internal',
            'Stock Piutang',
            'Modal Piutang',
            'Modal Sold',
            'Rata-rata Modal',
            'Harga Internal',
            'Harga Global',
            'Modal Awal',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
