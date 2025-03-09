<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\repair\RepairCase;
use App\Models\kios\KiosTransaksi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class GudangProdukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $dataEstimasi = RepairCase::with('estimasi.estimasiPart')->get();
        $filteredCases = $dataEstimasi->filter(function ($case) {
            return $case->estimasi 
                && $case->estimasi->estimasiPart
                    ->filter(function ($part) {
                        if (!$part->tanggal_lunas) {
                            return false;
                        }
                        $tanggalLunas = Carbon::parse($part->tanggal_lunas);
                        return $tanggalLunas->month == 3 && $tanggalLunas->year == 2025;
                    })->isNotEmpty();
        })->map(function ($case) {
            $totalModalAwal = $case->estimasi->estimasiPart
                ->filter(function ($part) {
                    if (!$part->tanggal_lunas) {
                        return false;
                    }
                    $tanggalLunas = Carbon::parse($part->tanggal_lunas);
                    return $tanggalLunas->month == 3 && $tanggalLunas->year == 2025;
                })
                ->sum('modal_gudang');
        
            return [
                'transaksi_id' => "R" . $case->id,
                'total_modal_gudang' => round($totalModalAwal)
            ];
        })->where('total_modal_gudang', '>', 0);

        $dataKios = KiosTransaksi::with('transaksiPart')->get();
        $filteredTransaksi = $dataKios->filter(function ($transaksi) {
            return $transaksi->transaksiPart 
                    && $transaksi->transaksiPart->isNotEmpty()
                    && $transaksi->created_at
                    && Carbon::parse($transaksi->created_at)->month == 3
                    && Carbon::parse($transaksi->created_at)->year == 2025;
        })->map(function ($transaksi) {
            $totalModalAwal = $transaksi->transaksiPart->sum('modal_gudang');
        
            return [
                'transaksi_id' => "K".$transaksi->id,
                'total_modal_gudang' => round($totalModalAwal)
            ];
        })->where('total_modal_gudang', '>', 0);

        return collect($filteredCases->merge($filteredTransaksi));
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Total Modal',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}