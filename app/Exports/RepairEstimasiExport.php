<?php

namespace App\Exports;

use App\Models\produk\ProdukSparepart;
use App\Models\repair\RepairEstimasiPart;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class RepairEstimasiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $dataEstimasi = RepairEstimasiPart::with('sparepartGudang.produkSparepart')->get();
        $stokSpareparts = ProdukSparepart::with('gudangIdItem')
            ->get()
            ->mapWithKeys(function ($produk) {
                $stokReady = $produk->gudangIdItem->where('status_inventory', 'Ready')->count();
                return [$produk->id => $stokReady];
            });
        $groupedData = $dataEstimasi->groupBy('gudang_produk_id');

        $formattedData = $groupedData->map(function ($items, $gudangProdukId) use ($stokSpareparts) {
            $firstItem = $items->first();

            $totalEstimasi = $items->where('active', 'Active')->whereNull('tanggal_konfirmasi')->count();
            $totalBelumDikirim = $items->where('active', 'Active')->whereNotNull('tanggal_konfirmasi')->whereNull('tanggal_dikirim')->count();

            if ($totalEstimasi > 0 || $totalBelumDikirim > 0) {
                return [
                    'Nama Sparepart'      => optional($firstItem->sparepartGudang->produkSparepart)->nama_internal,
                    'Total Estimasi'      => $totalEstimasi,
                    'Total Belum Dikirim' => $totalBelumDikirim,
                    'Stock Saat Ini'      => $stokSpareparts[$gudangProdukId] ?? 0, 
                ];
            }

            return null;
        })->filter()->values();

        return collect($formattedData);
    }

    public function headings(): array
    {
        return [
            'Nama Sparepart',
            'Total Estimasi',
            'Total Belum Dikirim',
            'Stock Saat Ini',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}

