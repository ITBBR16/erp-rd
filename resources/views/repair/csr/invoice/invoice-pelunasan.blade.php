<!DOCTYPE html>
<html lang="en" class="scrollbar-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | RD</title>
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    {{-- <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}" type="text/css"> --}}
    @vite('resources/css/app.css')
</head>
<body>
    <div style="background-color: #ffffff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb">
        <div style="margin-bottom: 16px; text-align: center;">
            <div style="display: flex; justify-content: center; text-align: center;">
                <img src="/img/Logo Rumah Drone Black.png" style="width: 160px;" alt="Logo RD">
            </div>
            <p style="font-size: 10px; color: #6b7280;">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karang Besuki Kec. Sukun Kota Malang Kode Pos 65146</p>
            <p style="font-size: 10px; color: #6b7280;">Telp. 0813-3430-0706</p>
        </div>
        <div style="display: flex; justify-content: space-between; margin: 16px 0;">
            <div style="text-align: left;">
                <h2 style="font-size: 18px; font-weight: 600;">Detail Transaksi / <span style="font-size: 18px; color: #4b5563;">R-{{ $dataCase->id }} <span style="font-size: 12px; margin-left: 8px; color: #10b981; background-color: #d1fae5; padding: 2px 8px; border-radius: 9999px;">Lunas</span></span></h2>
            </div>
            <div style="text-align: right;">
                <h2 style="font-size: 18px; font-weight: 600;">{{ $dataCase->jenisProduk->jenis_produk }}</h2>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
            <div>
                <p style="font-size: 12px; color: #4b5563;">Nama Customer</p>
                <h3 style="font-size: 14px; font-weight: 600;">{{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: #4b5563;">No Telpon</p>
                <h3 style="font-size: 14px; font-weight: 600;">{{ $dataCase->customer->no_telpon }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: #4b5563;">Alamat</p>
                <h3 style="font-size: 14px; font-weight: 600;">{{ $dataCase->customer->kota->name }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: #4b5563;">Status Case</p>
                <h3 style="font-size: 14px; font-weight: 600;">{{ $dataCase->jenisCase->jenis_case }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: #4b5563;">Tanggal Masuk</p>
                <h3 style="font-size: 14px; font-weight: 600;">{{ \Carbon\Carbon::parse($dataCase->created_at)->isoFormat('D MMMM YYYY') }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: #4b5563;">Tanggal Keluar</p>
                <h3 style="font-size: 14px; font-weight: 600;">{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</h3>
            </div>
        </div>
    
        <table style="font-size: 14px; margin-top: 24px; width: 100%; background-color: #f3f4f6; border-radius: 8px; border-collapse: collapse;">
            <thead style="text-align: left; color: #111827;">
                <tr>
                    <th style="padding: 8px; width: 80%;">Analisa Kerusakan</th>
                    <th style="padding: 8px; width: 20%;">Harga</th>
                </tr>
            </thead>
            <tbody style="color: #4b5563;">
                @php
                    $totalTagihan = 0;
                @endphp
                @foreach (array_merge($dataCase->estimasi->estimasiPart->all(), $dataCase->estimasi->estimasiJrr->all()) as $index => $estimasi)
                    @if ($estimasi->active == 'Active')
                        @php
                            $totalTagihan += $estimasi->harga_customer 
                        @endphp
                        <tr style="border-top: 1px solid #e5e7eb;">
                            <td style="padding: 8px;">
                                {{ 
                                    (isset($estimasi->sku)) ? 
                                        ($estimasi->nama_alias != '' ? $estimasi->nama_alias :
                                            $estimasi->nama_produk) :
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
                    <tr style="border-top: 1px solid #e5e7eb;">
                        @php
                            $biayaOngkir = $dataCase->logRequest->biaya_customer_ongkir ?? 0;
                            $biayaPacking = $dataCase->logRequest->biaya_customer_packing ?? 0;
                            $totalOngkir = $biayaOngkir + $biayaPacking;
                        @endphp
                        <td style="padding: 8px;">Total Ongkir</td>
                        <td style="padding: 8px;">Rp. {{ number_format($totalOngkir, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if (!empty($dataCase->logRequest->nominal_asuransi))
                <tr style="border-top: 1px solid #e5e7eb;">
                    @php
                        $nominalAsuransi = $dataCase->logRequest->nominal_asuransi;
                        $totalOngkir += $nominalAsuransi;
                    @endphp
                    <td style="padding: 8px;">Asuransi</td>
                    <td style="padding: 8px;">Rp. {{ number_format($nominalAsuransi, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr style="border-top: 2px solid #1f2937;">
                    <td style="padding: 8px; font-weight: 600;">Total Tagihan</td>
                    <td style="padding: 8px;">Rp. {{ number_format($totalTagihan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    
        <table style="font-size: 14px; margin-top: 24px; width: 100%; background-color: #f3f4f6; border-radius: 8px; border-collapse: collapse;">
            <thead style="text-align: left; color: #111827;">
                <tr>
                    <th style="padding: 8px; width: 35%;">Kelengkapan</th>
                    <th style="padding: 8px; width: 10%;">Quantity</th>
                    <th style="padding: 8px; width: 20%;">Serial Number</th>
                    <th style="padding: 8px; width: 35%;">Keterangan</th>
                </tr>
            </thead>
            <tbody style="color: #4b5563;">
                @foreach ($dataCase->detailKelengkapan as $kelengkapan)
                    <tr style="border-top: 1px solid #e5e7eb;">
                        <td style="padding: 8px;">{{ $kelengkapan->itemKelengkapan->kelengkapan }}</td>
                        <td style="padding: 8px;">{{ $kelengkapan->quantity }}</td>
                        <td style="padding: 8px;">{{ $kelengkapan->serial_number }}</td>
                        <td style="padding: 8px;">{{ ($kelengkapan->keterangan) ? $kelengkapan->keterangan : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); margin-top: 16px;">
            <div style="grid-column: span 2; font-size: 14px; border: 1px solid #e5e7eb; padding: 12px;">
                <div style="border-bottom: 1px solid #e5e7eb; font-weight: 600;">Keluhan Kerusakan</div>
                <div>{{ $dataCase->keluhan }}</div>
            </div>
            <div style="grid-column: span 1;">
                <div style="font-size: 14px; width: 100%; max-width: 320px; padding-left: 12px;">
                    <dl style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px;">
                        <dt style="grid-column: span 3; font-weight: 600; color: #374151;">Down Payment</dt>
                        <dd style="grid-column: span 2; color: #6b7280;">Rp. 0</dd>
                    </dl>
                    <dl style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px;">
                        <dt style="grid-column: span 3; font-weight: 600; color: #374151;">Discount</dt>
                        <dd style="grid-column: span 2; color: #6b7280;">Rp. 0</dd>
                    </dl>
                    <dl style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px;">
                        <dt style="grid-column: span 3; font-weight: 600; color: #374151;">Sisa Tagihan</dt>
                        <dd style="grid-column: span 2; color: #6b7280;">Rp. {{ number_format($totalTagihan, 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    
    
</body>
</html>