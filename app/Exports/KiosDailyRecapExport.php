<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\kios\KiosDailyRecap;
use App\Models\kios\KiosTransaksiDetail;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KiosDailyRecapExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $startOfMonth = Carbon::createFromDate(2025, 2, 8)->startOfDay();
        $endOfMonth = Carbon::createFromDate(2025, 3, 10)->endOfMonth();
        $last7Day = Carbon::now()->subDays(7)->toDateString();

        $dailyRecap = KiosDailyRecap::with('customer', 'keperluan', 'recapTs', 'kiosWtb', 'kiosWts')
                        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->get();
        return $dailyRecap->map(function ($recap) {
            return [
                $recap->created_at,
                $recap->keperluan->nama,
                $recap->customer_id,
                !empty($recap->recapTs) && $recap->keperluan->nama == 'Technical Support' ?
                    $recap->recapTs->technicalSupport->nama . "#" . 
                    $recap->recapTs->produkjenis->jenis_produk . "#" . 
                    $recap->recapTs->keterangan : '-',
                !empty($recap->kiosWtb) && $recap->keperluan->nama == 'Want to Buy' ?
                    $recap->kiosWtb->kondisi_produk . "#" . 
                    $recap->kiosWtb->subjenis->paket_penjualan . "#" . 
                    $recap->kiosWtb->keterangan : '-',
                !empty($recap->kiosWts) && $recap->keperluan->nama == 'Want to Sell' ?
                    $recap->kiosWts->subjenis->paket_penjualan . "#" . 
                    $recap->kiosWts->produk_worth . "#" . 
                    $recap->kiosWts->keterangan : '-',
                $recap->status
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal Created',
            'Keperluan',
            'Incremen Contact',
            'Recap TS',
            'Kios WTB',
            'Kios WTS',
            'Status'
        ];
    }

    // public function collection()
    // {
    //     $transactions = KiosTransaksiDetail::with('kiosSerialnumbers', 'produkKios.subjenis', 'produkKiosBnob')
    //         ->whereIn('jenis_transaksi', ['drone_baru', 'drone_bnob'])
    //         ->whereYear('created_at', 2025)
    //         ->whereMonth('created_at', 3)
    //         ->get();

    //     return $transactions->map(function ($transaction) {
    //         return [
    //             $transaction->created_at,
    //             $transaction->produkKios->subjenis->paket_penjualan,
    //             $transaction->kiosSerialnumbers->serial_number,
    //         ];
    //     });
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Tanggal Laku',
    //         'Paket Penjualan',
    //         'Serial Number',
    //     ];
    // }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
