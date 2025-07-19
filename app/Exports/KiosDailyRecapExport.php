<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\kios\KiosTransaksi;
use Illuminate\Support\Facades\DB;
use App\Models\kios\KiosDailyRecap;
use App\Models\kios\KiosTransaksiDetail;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KiosDailyRecapExport implements FromCollection, WithHeadings
{
    // public function collection()
    // {
    //     $connection = (new KiosTransaksi)->getConnection();

    //     $dataLaku = KiosTransaksi::with([
    //         'detailtransaksi.produkKios.subjenis',
    //         'detailtransaksi.kiosSerialnumbers.validasiproduk.orderLists',
    //         'detailtransaksi.produkKiosBekas.subjenis',
    //         'detailtransaksi.produkKiosBnob.subjenis'
    //     ])
    //         ->whereYear('created_at', 2025)
    //         ->whereBetween($connection->raw('MONTH(created_at)'), [4, 6])
    //         ->get()
    //         ->filter(function ($item) {
    //             return $item->detailtransaksi->isNotEmpty();
    //         });


    //     return $dataLaku->map(function ($item) {
    //         return $item->detailtransaksi->map(function ($detail) use ($item) {
    //             $jenisDrone = ucwords(str_replace('_', ' ', $detail->jenis_transaksi));
    //             $namaProduk = '';
    //             $modalAwal = '';

    //             if ($detail->jenis_transaksi === 'drone_baru') {
    //                 $namaProduk = $detail->produkKios->subjenis->paket_penjualan ?? '';
    //                 $modalAwal = $detail->kiosSerialnumbers->validasiproduk->orderLists->nilai ?? '';
    //             } elseif ($detail->jenis_transaksi === 'drone_bekas') {
    //                 $namaProduk = $detail->produkKiosBekas->subjenis->paket_penjualan ?? '';
    //                 $modalAwal = $detail->produkKiosBekas->modal_bekas ?? '';
    //             } elseif ($detail->jenis_transaksi === 'drone_bnob') {
    //                 $namaProduk = $detail->produkKiosBnob->subjenis->paket_penjualan ?? '';
    //                 $modalAwal = $detail->produkKiosBnob->modal_bnob ?? '';
    //             }

    //             return [
    //                 'No Nota' => $item->id,
    //                 'Tanggal' => $item->created_at,
    //                 'Jenis Drone' => $jenisDrone,
    //                 'Nama Produk' => $namaProduk,
    //                 'STP' => $modalAwal,
    //                 'SRP' => $detail->harga_jual ?? '',
    //                 'Discount Transaksi' => $item->discount
    //             ];
    //         });
    //     });
    // }

    // public function headings(): array
    // {
    //     return [
    //         'No Nota',
    //         'Tanggal',
    //         'Jenis Drone',
    //         'Nama Produk',
    //         'STP',
    //         'SRP',
    //     ];
    // }

    public function collection()
    {
        $startOfMonth = Carbon::createFromDate(2025, 7, 12)->startOfDay();
        $endOfMonth = Carbon::createFromDate(2025, 7, 19)->endOfMonth();
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

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
