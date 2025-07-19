<?php

namespace App\Exports;

use App\Models\repair\RepairCase;
use Illuminate\Support\Facades\DB;
use App\Models\produk\ProdukSparepart;
use App\Models\repair\RepairEstimasiPart;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class RepairEstimasiExport implements FromCollection, WithHeadings
{
    // Data Drone Masuk Repair
    public function collection()
    {
        $dataCase = RepairCase::with(['jenisProduk', 'jenisStatus', 'timestampStatus.jenisStatus'])
            ->whereYear('created_at', 2025)
            ->whereIn(DB::raw('MONTH(created_at)'), [5, 6])
            ->get()
            ->map(function ($item) {
                return [
                    'Tangal Masuk'     => $item->created_at->format('d-m-Y'),
                    'Bulan Masuk'      => $item->created_at->format('F'),
                    'No Increment'     => 'R' . $item->id,
                    'Jenis Drone'      => optional($item->jenisProduk)->jenis_produk,
                    'Teknisi'          => optional($item->teknisi)->first_name . ' ' . optional($item->teknisi)->last_name,
                    'Status Saat Ini'  => optional($item->jenisStatus)->jenis_status,
                    'Tanggal Selesai'  => optional(
                        $item->timestampStatus->firstWhere('jenisStatus.jenis_status', 'Close Case (Done)')
                    )?->created_at,
                ];
            });

        return collect($dataCase);
    }

    public function headings(): array
    {
        return [
            'Tangal Masuk',
            'Bulan Masuk',
            'No Increment',
            'Jenis Drone',
            'Status Saat Ini',
            'Tanggal Selesai',
        ];
    }

    // Data Timestamp Proses Repair
    // public function collection()
    // {
    //     $dataCase = RepairCase::with(['jenisProduk', 'timestampStatus.jenisStatus'])
    //         ->whereYear('created_at', 2025)
    //         ->whereIn(DB::raw('MONTH(created_at)'), [3, 4, 5])
    //         ->get()
    //         ->map(function ($item) {
    //             return $item->timestampStatus->map(function ($timestamp) use ($item) {
    //                 return [
    //                     'No Increment' => 'R' . $item->id,
    //                     'Jenis Drone'  => optional($item->jenisProduk)->jenis_produk,
    //                     'Status Proses' => optional($timestamp->jenisStatus)->jenis_status,
    //                     'Timestamp'    => $timestamp->created_at,
    //                 ];
    //             });
    //         })->flatten(1);
    //     return collect($dataCase);
    // }

    // public function headings(): array
    // {
    //     return [
    //         'No Increment',
    //         'Jenis Drone',
    //         'Status Proses',
    //         'Timestamp',
    //     ];
    // }

    // Data Estimasi Part Export
    // public function collection()
    // {
    //     $dataEstimasi = RepairEstimasiPart::with('sparepartGudang.produkSparepart')->get();
    //     $stokSpareparts = ProdukSparepart::with('gudangIdItem')
    //         ->get()
    //         ->mapWithKeys(function ($produk) {
    //             $stokReady = $produk->gudangIdItem->where('status_inventory', 'Ready')->count();
    //             return [$produk->id => $stokReady];
    //         });
    //     $groupedData = $dataEstimasi->groupBy('gudang_produk_id');

    //     $formattedData = $groupedData->map(function ($items, $gudangProdukId) use ($stokSpareparts) {
    //         $firstItem = $items->first();

    //         $totalEstimasi = $items->where('active', 'Active')->whereNull('tanggal_konfirmasi')->count();
    //         $totalBelumDikirim = $items->where('active', 'Active')->whereNotNull('tanggal_konfirmasi')->whereNull('tanggal_dikirim')->count();

    //         if ($totalEstimasi > 0 || $totalBelumDikirim > 0) {
    //             return [
    //                 'Nama Sparepart'      => optional($firstItem->sparepartGudang->produkSparepart)->nama_internal,
    //                 'Total Estimasi'      => $totalEstimasi,
    //                 'Total Belum Dikirim' => $totalBelumDikirim,
    //                 'Stock Saat Ini'      => $stokSpareparts[$gudangProdukId] ?? 0, 
    //             ];
    //         }

    //         return null;
    //     })->filter()->values();

    //     return collect($formattedData);
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Nama Sparepart',
    //         'Total Estimasi',
    //         'Total Belum Dikirim',
    //         'Stock Saat Ini',
    //     ];
    // }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
