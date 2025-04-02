<?php

namespace App\Exports;

use App\Models\gudang\GudangProdukIdItem;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class GudangIdItemExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $dataIdItem = GudangProdukIdItem::with('produkSparepart')->get();
        return $dataIdItem->map(function ($items) {
            return [
                'Nama Internal' => $items->produkSparepart->nama_internal,
                'Status' => $items->status_inventory,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Internal',
            'Status',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
