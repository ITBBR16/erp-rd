<!DOCTYPE html>
<html lang="en" class="scrollbar-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | RD</title>
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}" type="text/css">

</head>
<body>
    <div style="background-color: white; padding: 2px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); solid #E5E7EB;">
        <div style="margin-bottom: 16px; display: flex; justify-content: center; text-align: center;">
            <div style="display: flex; justify-content: center; text-align: center;">
                <img src="{{ public_path('img/Logo Rumah Drone Black.png') }}" style="width: 80px;" alt="Logo RD">
            </div>
            <p style="font-size: 7px;">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karang Besuki Kec. Sukun Kota Malang Kode Pos 65146</p>
            <p style="font-size: 7px;">Telp. 0813-3430-0706</p>
        </div>
        <table style="width: 100%; padding-bottom: 8px; margin-bottom: 8px;">
            <tr>
                <!-- Kolom Kiri -->
                <td style="text-align: left; vertical-align: top; width: 50%;">
                    <h2 style="font-size: 8px; font-weight: 600; color: black;">Detail Transaksi / <span style="font-size: 8px; color: gray;">R-{{ $dataCase->id }} <span style="font-size: 6px; margin-left: 8px; color: green; background-color: #D1FAE5; padding: 4px 8px; border-radius: 9999px;">Lunas</span></span></h2>
                </td>
                <!-- Kolom Kanan -->
                <td style="text-align: right; vertical-align: top; width: 50%;">
                    <h2 style="font-size: 8px; font-weight: 600; color: black;">Jenis Drone : {{ $dataCase->jenisProduk->jenis_produk }}</h2>
                </td>
            </tr>
        </table>

        <table style="width: 100%; font-size: 10px; margin-bottom: 16px; border-spacing: 0 8px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">Nama Customer</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }}</h3>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">No Telpon</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ $dataCase->customer->no_telpon }}</h3>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">Alamat</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ $dataCase->customer->kota->name ?? "-" }}</h3>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">Status Case</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ $dataCase->jenisCase->jenis_case }}</h3>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">Tanggal Masuk</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ \Carbon\Carbon::parse($dataCase->created_at)->isoFormat('D MMMM YYYY') }}</h3>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">Tanggal Keluar</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</h3>
                </td>
            </tr>
        </table>
    
        <table style="font-size: 8px; width: 100%; text-align: left; margin-bottom: 8px; background-color: #F9FAFB; border-radius: 8px; color: #9CA3AF;">
            <thead style="font-size: 8px; color: gray;">
                <tr style="border-bottom: 1px solid black;">
                    <th style="padding-right: 8px; padding-bottom: 4px; width: 80%;">Analisa Kerusakan</th>
                    <th style="padding-right: 8px; padding-bottom: 4px; width: 20%;">Harga</th>
                </tr>
            </thead>
            <tbody style="color: #374151;">
                @php
                    $totalTagihan = 0;
                    $totalOngkir = 0;
                    $biayaOngkir = 0;
                    $biayaPacking = 0;
                @endphp
                
                @foreach (array_merge($dataCase->estimasi->estimasiPart->all(), $dataCase->estimasi->estimasiJrr->all()) as $index => $estimasi)
                    @if ($estimasi->active == 'Active')
                        @php
                            $totalTagihan += $estimasi->harga_customer 
                        @endphp
                        <tr style="border-top: 1px solid;">
                            <td style="padding: 8px;">
                                {{ 
                                    (isset($estimasi->gudang_produk_id)) ? 
                                        ($estimasi->nama_alias != '' ? $estimasi->nama_alias :
                                            $estimasi->sparepartGudang->produkSparepart->nama_internal) :
                                                $estimasi->nama_jasa 
                                }}
                            </td>
                            <td style="padding: 8px;">
                                Rp. {{ number_format($estimasi->harga_customer, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endif
                @endforeach
    
                @if (!empty($dataCase->logRequest->biaya_customer_ongkir) && !empty($dataCase->logRequest->biaya_customer_packing))
                    <tr style="border-top: 1px solid;">
                        <td style="padding: 8px;">Total Ongkir</td>
                        <td style="padding: 8px;">
                            @php
                                $biayaOngkir = $dataCase?->logRequest->biaya_customer_ongkir ?? 0;
                                $biayaPacking = $dataCase?->logRequest->biaya_customer_packing ?? 0;
                                $totalOngkir += $biayaOngkir + $biayaPacking;
                            @endphp
                            Rp. {{ number_format($totalOngkir, 0, ',', '.') }}
                        </td>
                    </tr>
                @endif
                @if (!empty($dataCase->logRequest->nominal_asuransi))
                    @php
                        $nominalAsuransi = $dataCase->logRequest->nominal_asuransi;
                        $totalOngkir += $nominalAsuransi;
                    @endphp
                    <tr style="border-top: 1px solid;">
                        <td style="padding: 8px;">Asuransi</td>
                        <td style="padding: 8px;">Rp. {{ number_format($nominalAsuransi, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr style="border-top: 2px solid #1F2937;">
                    <td style="padding: 8px; font-weight: bold;">Total Tagihan</td>
                    <td style="padding: 8px;">
                        @php
                            $totalAkhir = $totalTagihan + $totalOngkir;
                        @endphp
                        Rp. {{ number_format($totalAkhir, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    
        <table style="font-size: 8px; width: 100%; text-align: left; margin-bottom: 8px; background-color: #F9FAFB; border-radius: 8px; color: #9CA3AF;">
            <thead style="text-align: left; color: #111827;">
                <tr>
                    <th style="padding: 8px; width: 35%;">Kelengkapan</th>
                    <th style="padding: 8px; width: 10%;">Quantity</th>
                    <th style="padding: 8px; width: 20%;">Serial Number</th>
                    <th style="padding: 8px; width: 35%;">Keterangan</th>
                </tr>
            </thead>
            <tbody style="color: #374151;">
                @foreach ($dataCase->detailKelengkapan as $kelengkapan)
                    <tr style="border-top: 1px solid;">
                        <td style="padding: 8px;">
                            {{ ($kelengkapan->item_kelengkapan_id == null) ? $kelengkapan->nama_data_lama : $kelengkapan->itemKelengkapan->kelengkapan }}
                        </td>
                        <td style="padding: 8px;">{{ $kelengkapan->quantity }}</td>
                        <td style="padding: 8px;">{{ $kelengkapan->serial_number }}</td>
                        <td style="padding: 8px;">{{ $kelengkapan->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <table style="width: 100%; color: gray; font-size: 8px; margin-top: 8px; border-collapse: collapse;">
            <tr>
                <!-- Kolom untuk paragraf -->
                <td style="width: 66.67%; vertical-align: top; padding-right: 8px; border: 1px solid #9CA3AF;">
                    <p style="margin: 0; border-bottom: 1px solid #9CA3AF; color: black;">Keluhan Kerusakan</p>
                    <p style="margin: 0; margin-top: 4px;">{{ $dataCase->keluhan }}</p>
                </td>
                <!-- Kolom untuk gambar dan tanda tangan -->
                <td style="width: 33.33%; vertical-align: top; text-align: center;">
                    <table style="width: 100%; color: gray; font-size: 8px; margin-top: 8px; border-collapse: collapse;">
                        <tr>
                            <td>Down Payment</td>
                            @php
                                $totalDp = $dataCase->transaksi->total_pembayaran ?? 0
                            @endphp
                            <td>Rp. {{ number_format($totalDp, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td>Rp. 0</td>
                        </tr>
                        <tr style="border-top: 1px solid #27292b;">
                            <td>Total Pembayaran</td>
                            <td>Rp. 0</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>        

        <table style="width: 100%; color: gray; border: #9CA3AF; font-size: 8px; margin-top: 8px; border-collapse: collapse;">
            <tr>
                <!-- Kolom untuk paragraf -->
                <td style="width: 66.67%; vertical-align: top; padding-right: 8px; border: 1px solid #9CA3AF;">
                    <p style="color: #6B7280;">- Garansi hanya termasuk bagian yang direpair / direplace</p>
                    <p style="color: #6B7280;">- Garansi tidak berlaku jika human error, overheat, overvoltage, overclocking</p>
                    <p style="color: #6B7280;">- Garansi tidak berlaku jika segel rusak</p>
                    <p style="color: #6B7280;">- Garansi berlaku 1 bulan setelah barang diterima</p>
                </td>
                <td></td>
            </tr>
        </table>        
        
        <table style="width: 100%; color: black; font-size: 8px; margin-top: 14px; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: middle; text-align: center; padding-right: 8px;">
                    <h3 style="font-weight: 600; margin-bottom: 2rem;">Penerima</h3>
                    <p style="color: gray;">( {{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }} )</p>
                </td>
                <td style="width: 50%; vertical-align: middle; text-align: center;">
                    <h3 style="font-weight: 600; margin-bottom: 2rem;">Hormat Kami</h3>
                    <p style="color: gray;">( {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} )</p>
                </td>
            </tr>
        </table>        
    </div>      
</body>
</html>