<?php

namespace App\Exports;

use App\Models\repair\RepairEstimasiPart;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EstimasiPartExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $dataEstimasi = RepairEstimasiPart::with('sparepartGudang.produkSparepart')
                        ->get()
                        ->groupBy('gudang_produk_id')
                        ->map(function ($items) {
                            $namaPart = optional($items->first()->sparepartGudang->produkSparepart)->nama_internal;

                            return [
                                'List Part'                => $namaPart,
                                'Total Part Laku'          => $items->whereNotNull('tanggal_lunas')->count(),
                                'Total Part Dikirim'       => $items->whereNotNull('tanggal_dikirim')->count(),
                                'Total Part Belum Dikirim' => $items->whereNull('tanggal_dikirim')->count(),
                                'Total Part Estimasi'      => 0,
                                'Stock Part System'        => 0,
                                'Part SO'                  => 0,
                            ];
                        })
                        ->values();

        return collect($dataEstimasi);
    }

    public function headings(): array
    {
        return [
            'List Part',
            'Total Part Laku',
            'Total Part Dikirim',
            'Total Part Belum Dikirim',
            'Total Part Estimasi',
            'Stock Part System',
            'Part SO',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}