<?php

namespace App\Exports;

use App\Models\kios\KiosOrderList;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\kios\KiosOrderSecond;
use App\Models\kios\KiosTransaksiDetail;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KiosFinanceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Finance
        // Drone Baru
        $modalAwalBaru = KiosOrderList::whereYear('created_at', 2025)
                            ->whereMonth('created_at', 1)
                            ->sum(DB::raw('nilai * quantity'));

        $totalPenambahanBaruF = KiosOrderList::whereYear('created_at', 2025)
                                ->whereMonth('created_at', 2)
                                ->sum(DB::raw('nilai * quantity'));

        $dataTransaksiDetailbaru = KiosTransaksiDetail::with([
                                    'kiosSerialnumbers.validasiproduk.orderLists'
                                ])
                                ->where('jenis_transaksi', 'drone_baru')
                                ->whereYear('created_at', 2025)
                                ->whereMonth('created_at', 2)
                                ->get();
                            
        $totalPenguranganBaruF = 0;
        foreach ($dataTransaksiDetailbaru as $pengurangan) {
            $nilai = $pengurangan->kiosSerialnumbers->validasiproduk->orderLists->nilai;
            $totalPenguranganBaruF += $nilai;
        }                            

        $totalModalAkhirBaru = $modalAwalBaru + $totalPenambahanBaruF - $totalPenguranganBaruF;

        // Drone Bekas
        $modalAwalBekas = 0;
        $totalPenambahanBekasF = KiosOrderSecond::whereYear('created_at', 2025)
                                    ->whereMonth('created_at', 2)
                                    ->sum('biaya_pembelian');

        $dataTransaksiDetailbekas = KiosTransaksiDetail::with(['produkKiosBekas'])
                                ->where('jenis_transaksi', 'drone_bekas')
                                ->whereYear('created_at', 2025)
                                ->whereMonth('created_at', 2)
                                ->get();
        $totalPenguranganBekasF = 0;

        foreach ($dataTransaksiDetailbekas as $penguranganBekas) {
            $nilaiBekas = $penguranganBekas->produkKiosBekas->modal_bekas;
            $totalPenguranganBekasF += $nilaiBekas;
        }

        $totalModalAkhirBekas = $modalAwalBekas + $totalPenambahanBekasF - $totalPenguranganBekasF;

        return new Collection([
            [
                'Jenis Transaksi'  => 'Drone Baru',
                'Modal Awal'       => $modalAwalBaru,
                'Total Penambahan' => $totalPenambahanBaruF,
                'Total Pengurangan'=> $totalPenguranganBaruF,
                'Modal Akhir'      => $totalModalAkhirBaru
            ],
            [
                'Jenis Transaksi'  => 'Drone Bekas',
                'Modal Awal'       => $modalAwalBekas,
                'Total Penambahan' => $totalPenambahanBekasF,
                'Total Pengurangan'=> $totalPenguranganBekasF,
                'Modal Akhir'      => $totalModalAkhirBekas,
            ],
        ]);

    }
    public function headings(): array
    {
        return [
            'Jenis Transaksi',
            'Modal Awal',
            'Total Penambahan',
            'Total Pengurangan',
            'Modal Akhir',
        ];
    }

    public function writerType(): string
    {
        return \Maatwebsite\Excel\Excel::CSV;
    }
}
