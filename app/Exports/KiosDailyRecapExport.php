<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\kios\KiosDailyRecap;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KiosDailyRecapExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = Carbon::parse($startDate);
        $this->endDate = Carbon::parse($endDate);
    }

    public function collection()
    {
        $dailyRecap = KiosDailyRecap::with('customer', 'keperluan', 'recapTs', 'kiosWtb', 'kiosWts')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
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
