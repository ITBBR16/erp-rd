<!DOCTYPE html>
<html lang="en" class="scrollbar-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | RD</title>
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}" type="text/css">
    <style>
        body {
            position: relative;
            margin: 0;
            padding: 0;
            background-image: url('{{ public_path('img/invoice/Pattern.png') }}');
            background-size: contain;
            background-position: center bottom;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        @media print {
            body {
                background-image: url('{{ public_path('img/invoice/Pattern.png') }}');
                background-size: contain;
                background-position: center bottom;
                background-repeat: no-repeat;
                -webkit-print-color-adjust: exact;
            }
        }

        .invoice {
            width: 148mm;
            height: 210mm;
            margin: 0 auto;
            padding: 0 auto;
            box-sizing: border-box;
            background: white;
        }
    </style>
</head>
<body>
    <div>
        <!-- Header -->
        <table style="width: 100%; border-bottom: 1px solid black; padding-bottom: 8px; margin-bottom: 8px;">
            <tr>
                <!-- Kolom Kiri -->
                <td style="text-align: left; vertical-align: top; width: 50%;">
                    <h1 style="font-size: 16px; font-weight: 600; margin: 0;">Rumah Drone</h1>
                    <p style="font-size: 8px; margin: 0;">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karang Besuki Kec. Sukun Kota Malang Kode Pos 65146</p>
                    <p style="font-size: 8px; margin: 0;">Telp. 0813-3430-0706</p>
                </td>
                <!-- Kolom Kanan -->
                <td style="text-align: right; vertical-align: top; width: 50%;">
                    <p style="font-size: 8px; color: gray; margin: 0;">Tanggal : {{ $case->created_at }}</p>
                    <p style="font-size: 8px; color: gray; margin: 0;">Status : {{ $case->jenisCase->jenis_case }}</p>
                </td>
            </tr>
        </table>
        <div style="text-align: center; margin-bottom: 8px;">
            <h2 style="font-size: 12px; font-weight: bold; margin-bottom: 4px;">Invoice Penerimaan</h2>
            <p style="color: gray; font-size: 10px;"># R-{{ $case->id }}</p>
        </div>
        <table style="width: 100%; font-size: 10px; margin-bottom: 16px; border-spacing: 0 8px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">Nama Customer</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ $case->customer->first_name }} {{ $case->customer->last_name }}</h3>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">No Telpon</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ $case->customer->no_telpon }}</h3>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">Jenis Drone</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ $case->jenisProduk->jenis_produk }}</h3>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="color: gray; margin: 0;">Kota</p>
                    <h3 style="font-weight: 600; margin: 0;">{{ $case->customer->kota->name ?? '' }}</h3>
                </td>
            </tr>
        </table>
        <!-- Body -->
        <div style="position: relative;">
            <div style="border-top: 4px solid black;">
                <div style="position: absolute; left: 50%; transform: translateX(-50%); top: -12px; background-color: white; padding: 0 16px;">
                    <img src="{{ public_path('img/RD Tab Icon.png') }}" alt="Logo RD" style="width: 24px;">
                </div>
            </div>
            <div style="padding: 4px; border-bottom: 4px solid black; margin-bottom: 8px;">
                <table style="font-size: 8px; width: 100%; text-align: left; margin-bottom: 8px;">
                    <thead style="font-size: 8px; color: gray;">
                        <tr style="border-bottom: 1px solid black;">
                            <th style="padding-right: 8px; padding-bottom: 4px; width: 35%;">Nama Kelengkapan</th>
                            <th style="padding-right: 8px; padding-bottom: 4px; width: 5%;">Qty</th>
                            <th style="padding-right: 8px; padding-bottom: 4px; width: 15%;">Serial Number</th>
                            <th style="padding-right: 8px; padding-bottom: 4px; width: 45%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($case->detailKelengkapan as $detail)
                            <tr style="border-bottom: 1px solid black;">
                                <td style="padding-right: 8px; padding-bottom: 4px;">{{ ($detail->item_kelengkapan_id == null) ? $detail->nama_data_lama : $detail->itemKelengkapan->kelengkapan }}</td>
                                <td style="padding-right: 8px; padding-bottom: 4px;">{{ $detail->quantity }}</td>
                                <td style="padding-right: 8px; padding-bottom: 4px;">{{ ($detail->serial_number) ? $detail->serial_number : '-' }}</td>
                                <td style="padding-right: 8px; padding-bottom: 4px;">{{ $detail->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    
        <div style="border: 1px solid black; padding-bottom: 8px; font-size: 10px; padding-left: 4px;">
            <p style="font-size: 8px;">Keluhan : </p>
            <p style="font-size: 9px;">{{ $case->keluhan }}</p>
        </div>
    
        <table style="width: 100%; color: gray; font-size: 8px; margin-top: 8px; border-collapse: collapse;">
            <tr>
                <!-- Kolom untuk paragraf -->
                <td style="width: 66.67%; vertical-align: top; padding-right: 8px;">
                    <p style="margin: 0;">1. Untuk tingkat kerusakan yang cukup parah dan drone dengan assembly susah akan dikenakan biaya Troubleshooting kerusakan sebesar Rp 300,000 (Bila Repair di batalkan).</p>
                    <p style="margin: 0; margin-top: 4px;">2. Bila proses Repair di batalkan, pengembalian Drone dilakukan paling cepat 1 minggu setelah konfirmasi pembatalan.</p>
                </td>
                <!-- Kolom untuk gambar dan tanda tangan -->
                <td style="width: 33.33%; vertical-align: top; text-align: center;">
                    <img src="{{ public_path('img/Logo Rumah Drone Black.png') }}" alt="Stempel RD" style="width: 80px; display: block; margin: 0 auto;">
                    <p style="font-size: 8px; margin: 4px 0 0;">{{ $employee }}</p>
                </td>
            </tr>
        </table>

        <div style="text-align: center; font-size: 8px; margin-top: 30px;">
            <p style="margin: 0;">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karangbesuki, Kec. Sukun, Kota Malang, Kode Pos 65146</p>
            <p style="margin: 0;">Telp. 0813-3430-0706</p>
        </div>
    </div>    
</body>
</html>