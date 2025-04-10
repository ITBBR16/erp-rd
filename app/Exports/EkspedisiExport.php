<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\ekspedisi\LogRequest;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EkspedisiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $startOfMonth = Carbon::createFromDate(2025, 1, 1)->startOfDay();
        $endOfMonth = Carbon::createFromDate(2025, 3, 1)->endOfMonth();
        $dataEkspedisi = LogRequest::with('customer')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        return $dataEkspedisi->map(function ($ekspedisi) {
            $namaCustomer = $ekspedisi->customer->first_name . ' ' . $ekspedisi->customer->last_name . ' - ' . $ekspedisi->customer->id;
            return [
                'Tanggal' => $ekspedisi->created_at,
                'Divisi' => $ekspedisi->divisi->nama,
                'Nama Customer' => $namaCustomer,
                'No Resi' => $ekspedisi->no_resi,
                'Ongkir Dibayar Customer' => $ekspedisi->biaya_customer_ongkir,
                'Asuransi Dibayar Customer' => $ekspedisi->nominal_asuransi,
                'Ongkir Awal Ekspedisi' => $ekspedisi->biaya_ekspedisi_ongkir,
                'Ongkir Akhir Ekspedisi' => $ekspedisi->biaya_ekspedisi_ongkir_akhir,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Divisi',
            'Nama Customer',
            'No Resi',
            'Ongkir Dibayar Customer',
            'Asuransi Dibayar Customer',
            'Ongkir Awal Ekspedisi',
            'Ongkir Akhir Ekspedisi',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}