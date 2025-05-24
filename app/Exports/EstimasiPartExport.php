<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\repair\RepairEstimasiPart;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EstimasiPartExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $dataEstimasi = RepairEstimasiPart::with('sparepartGudang.produkSparepart')
            ->whereYear('tanggal_konfirmasi', 2025)
            ->whereIn(DB::raw('MONTH(tanggal_konfirmasi)'), [4, 5])
            ->get()
            ->groupBy('gudang_produk_id')
            ->map(function ($items) {
                $namaPart = optional(optional($items->first())->sparepartGudang->produkSparepart)->nama_internal;

                return [
                    'List Part'                => $namaPart,

                    'Total Part Dikirim'       => $items->filter(fn($item) => 
                                                        !is_null($item->tanggal_dikirim) && 
                                                        $item->tanggal_dikirim !== ''
                                                    )->count(),

                    'Total Part Belum Dikirim' => $items->filter(fn($item) => 
                                                        !is_null($item->tanggal_konfirmasi) && 
                                                        $item->tanggal_konfirmasi !== '' && 
                                                        (is_null($item->tanggal_dikirim) || $item->tanggal_dikirim === '')
                                                    )->count(),
                ];
            })
            ->values();

        return collect($dataEstimasi);
    }

    public function headings(): array
    {
        return [
            'List Part',
            'Total Part Dikirim',
            'Total Part Belum Dikirim',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}