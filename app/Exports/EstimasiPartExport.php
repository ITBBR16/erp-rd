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
                            $namaPart = optional(optional($items->first())->sparepartGudang->produkSparepart)->nama_internal;

                            $stockPartSystem = $items->first()?->sparepartGudang?->produkSparepart?->gudangIdItem
                                            ->where('status_inventory', 'Ready')
                                            ->count();

                            return [
                                'List Part'                => $namaPart,
                                'Total Part Laku'          => $items->filter(fn($item) => 
                                                                !is_null($item->tanggal_lunas) && 
                                                                $item->tanggal_lunas !== ''
                                                            )->count(),

                                'Total Part Dikirim'       => $items->filter(fn($item) => 
                                                                !is_null($item->tanggal_dikirim) && 
                                                                $item->tanggal_dikirim !== '' && 
                                                                (is_null($item->tanggal_lunas) || $item->tanggal_lunas === '')
                                                            )->count(),

                                'Total Part Belum Dikirim' => $items->filter(fn($item) => 
                                                                !is_null($item->tanggal_konfirmasi) && 
                                                                $item->tanggal_konfirmasi !== '' && 
                                                                (is_null($item->tanggal_dikirim) || $item->tanggal_dikirim === '')
                                                            )->count(),

                                'Total Part Estimasi'      => $items->filter(fn($item) => 
                                                                is_null($item->tanggal_konfirmasi) || 
                                                                $item->tanggal_konfirmasi === ''
                                                            )->count(),

                                'Stock Part System'        => $stockPartSystem ?? 0,
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