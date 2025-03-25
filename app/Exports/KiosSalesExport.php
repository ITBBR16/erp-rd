<?php

namespace App\Exports;

use App\Models\kios\KiosTransaksiDetail;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KiosSalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $transactions = KiosTransaksiDetail::with('kiosSerialnumbers', 'produkKios.subjenis', 'produkKiosBnob', 'transaksi.transaksiPembayaran.daftarAkunManagement')
            ->whereIn('jenis_transaksi', ['drone_baru', 'drone_bnob', 'drone_bekas'])
            ->whereYear('created_at', 2025)
            ->whereMonth('created_at', 3)
            ->get();

        return $transactions->map(function ($transaction) {
            if ($transaction->jenis_transaksi == 'drone_baru') {
                $jenis_drone = 'Drone Baru';
                $nama_unit = $transaction->produkKios->subjenis->paket_penjualan ?? 'N/A';
                $tanggal_masuk = $transaction->kiosSerialnumbers->validasiproduk->orderLists->created_at ?? 'N/A';
            } elseif ($transaction->jenis_transaksi == 'drone_bnob') {
                $jenis_drone = 'Drone BNOB';
                $nama_unit = $transaction->produkKios->subjenis->paket_penjualan ?? 'N/A';
                $tanggal_masuk = $transaction->produkKiosBnob->created_at ?? 'N/A';
            } else {
                $jenis_drone = 'Drone Bekas';
                $nama_unit = $transaction->produkKios->subjenis->paket_penjualan ?? 'N/A';
                $tanggal_masuk = $transaction->produkKiosBekas->created_at ?? 'N/A';
            }

            $metodePembayaran = $transaction->transaksi->transaksiPembayaran->map(function ($pembayaran) {
                return $pembayaran->daftarAkunManagement->nama_akun ?? 'N/A';
            })->implode(', ');
        
            return [
                'Jenis Drone' => $jenis_drone,
                'Nama Unit' => $nama_unit,
                'Tanggal Masuk' => $tanggal_masuk,
                'Tanggal Laku' => $transaction->created_at,
                'Metode Pembayaran' => $metodePembayaran ?: 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Jenis Drone',
            'Nama Unit',
            'Tanggal Masuk',
            'Tanggal Laku',
            'Metode Pembayaran',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
