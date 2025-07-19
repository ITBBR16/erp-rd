<?php

namespace App\Exports;

use App\Models\kios\KiosTransaksi;
use App\Models\repair\RepairCase;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AkademiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $startDate = Carbon::createFromDate(2025, 7, 1)->startOfDay();
        $endDate = Carbon::createFromDate(2025, 7, 15)->endOfDay();

        $dataRepair = RepairCase::with(['customer'])
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal' => $item->updated_at->format('Y-m-d'),
                    'Divisi' => 'Repair',
                    'Nama Customer' => optional($item->customer)->first_name . optional($item->customer)->last_name,
                    'No Telepon' => optional($item->customer)->no_telpon,
                ];
            });

        $dataKios = KiosTransaksi::with(['customer'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal' => $item->created_at->format('Y-m-d'),
                    'Divisi' => 'Kios',
                    'Nama Customer' => optional($item->customer)->first_name . optional($item->customer)->last_name,
                    'No Telepon' => optional($item->customer)->no_telpon,
                ];
            });
        return $dataRepair->merge($dataKios);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Divisi',
            'Nama Customer',
            'No Telepon',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
