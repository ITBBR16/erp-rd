<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\kios\KiosDailyRecap;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KiosDailyRecapExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $dailyRecap = KiosDailyRecap::with('keperluan', 'recapTs', 'kiosWtb', 'kiosWts')
                        ->whereDate('created_at', '>=', Carbon::now()->subDays(7)->toDateString())
                        ->get();
        return $dailyRecap->map(function ($recap) {
            return [
                $recap->keperluan->nama,
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
                    $recap->kiosWts->keterangan : '-'
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Keperluan',
            'Recap TS',
            'Kios WTB',
            'Kios WTS'
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
