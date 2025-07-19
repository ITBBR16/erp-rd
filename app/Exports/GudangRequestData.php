<?php

namespace App\Exports;

use App\Models\produk\ProdukSparepart;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class GudangRequestData implements FromCollection, WithHeadings
{
    public function collection()
    {
        $dataPart = ProdukSparepart::with([
            'produkJenis',
            'detailBelanja.gudangBelanja',
            'gudangIdItem',
            'gudangProduk.estimasiRepair',
        ])
            ->get()
            ->map(function ($item) {
                $jenisProduk = $item->produkJenis->jenis_produk ?? 'Tidak Diketahui';
                $namaPart = $item->nama_internal ?? 'Tidak Diketahui';

                $stockReady = $item->gudangIdItem
                    ->where('status_inventory', 'Ready')
                    ->count();

                $pendingStock = $item->detailBelanja
                    ->filter(function ($detail) {
                        return in_array(
                            $detail->gudangBelanja->status ?? '',
                            ['Waiting Shipment', 'Process Shipping']
                        );
                    })
                    ->sum('quantity');

                $lanjutBelumDikirim = ($item->gudangProduk?->estimasiRepair ?? collect())
                    ->filter(function ($estimasi) {
                        return empty($estimasi->tanggal_dikirim) && !empty($estimasi->tanggal_konfirmasi);
                    })
                    ->count();

                $estimasi = ($item->gudangProduk?->estimasiRepair ?? collect())
                    ->filter(function ($estimasi) {
                        return empty($estimasi->tanggal_konfirmasi);
                    })
                    ->count();

                return [
                    'jenis_produk'          => $jenisProduk,
                    'nama_part'             => $namaPart,
                    'stock_ready'           => $stockReady,
                    'pending_stock'         => $pendingStock,
                    'lanjut_belum_dikirim'  => $lanjutBelumDikirim,
                    'estimasi'              => $estimasi,
                ];
            });

        return collect($dataPart);
    }

    public function headings(): array
    {
        return [
            'Jenis Produk',
            'Nama Part',
            'Stock Ready',
            'Pending Stock',
            'Lanjut Belum Dikirim',
            'Estimasi',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
