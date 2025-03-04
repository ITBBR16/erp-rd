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
        // Kolom Pertama
        $orderListBaru = KiosOrderList::with([
            'order.supplier',
            'paket',
            'order.paymentkios' => function ($query) {
                $query->where('order_type', 'Baru');
            },
            'order.paymentkios.metodepembayaran.akunBank'
        ])->get();
        $orderListSecond = KiosOrderSecond::with(['customer', 'subjenis']);

        // Kolom Kedua
        $dataTransaksi = KiosTransaksiDetail::with(['kiosSerialnumbers', 'transaksi.customer', 'produkKiosBekas']);
    }
    public function headings(): array
    {
        return [
            'Jenis Transaksi',
            'Order Id Pembelanjaan',
            'Supplier',
            'Paket Penjualan',
            'Quantity',
            'Nilai Satuan',
            '',
            'Jenis Transaksi',
            'Transaksi ID Kasir',
            'Customer',
            'Paket Penjualan',
            'Serial Number',
            'Harga Jual'
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
