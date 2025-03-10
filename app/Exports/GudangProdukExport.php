<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\repair\RepairCase;
use App\Models\kios\KiosTransaksi;
use App\Models\produk\ProdukSparepart;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class GudangProdukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $dataSparepart = ProdukSparepart::with('gudangIdItem')->get();

        return $dataSparepart->map(function ($items) {
            return [
                $items->nama_internal,
                $items->gudangIdItem->where('status_inventory', 'Ready')->count(),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Internal',
            'Stock',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}