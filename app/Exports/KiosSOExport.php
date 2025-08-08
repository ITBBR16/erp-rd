<?php

namespace App\Exports;

use App\Models\kios\KiosOrderList;
use App\Models\kios\KiosOrderSecond;
use App\Models\kios\KiosTransaksiDetail;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KiosSOExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $orderListBaru = KiosOrderList::with([
            'order.supplier',
            'paket',
        ])
            ->whereMonth('created_at', 7)
            ->get()
            ->map(function ($item) {
                return [
                    'Paket Penjualan' => $item->paket->paket_penjualan ?? 'N/A',
                    'Nama Supplier' => $item->order->supplier->nama_perusahaan ?? 'N/A',
                    'Quantity' => $item->quantity ?? 0,
                    'Harga Satuan' => $item->nilai,
                ];
            });

        return collect($orderListBaru);
    }
    public function headings(): array
    {
        return [
            'Paket Penjualan',
            'Nama Supplier',
            'Quantity',
            'Harga Satuan',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
