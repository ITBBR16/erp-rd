<!DOCTYPE html>
<html lang="en">
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
    </style>
</head>
<body>
    <table style="width: 100%; border-bottom: 1px solid black; padding-bottom: 8px; margin-bottom: 8px; border-collapse: collapse;">
        <tr>
            <!-- Kolom Kiri -->
            <td style="text-align: left; vertical-align: top; width: 50%; padding: 0;">
                <img src="{{ public_path('img/invoice/Kotak abu.png') }}" alt="Logo Box RD"
                    style="width: 120px; display: block; margin: 0; padding: 0;">
            </td>
            <!-- Kolom Kanan -->
            <td style="text-align: right; vertical-align: top; width: 50%; padding: 0;">
                <p style="font-size: 16px; color: black; margin: 0;">Invoice Penerimaan</p>
                <p style="font-size: 8px; color: gray; margin: 0;">#R-{{ $case->id }}</p>
            </td>
        </tr>
    </table>    
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
    <div style="position: relative;">
        <div style="padding: 4px; border-bottom: 4px solid black; border-top: 4px solid black; margin-bottom: 8px;">
            <table style="font-size: 8px; width: 100%; text-align: left; margin-bottom: 8px;">
                <thead style="font-size: 8px; color: black;">
                    <tr style="border-bottom: 1px solid black;">
                        <th style="padding-right: 8px; padding-bottom: 4px; width: 35%;">Nama Kelengkapan</th>
                        <th style="padding-right: 8px; padding-bottom: 4px; width: 5%;">Qty</th>
                        <th style="padding-right: 8px; padding-bottom: 4px; width: 15%;">Serial Number</th>
                        <th style="padding-right: 8px; padding-bottom: 4px; width: 45%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($case->detailKelengkapan as $detail)
                        <tr style="border-bottom: 1px solid gray;">
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
    <div style="padding-bottom: 8px; padding-left: 4px;">
        <p style="font-size: 8px;">Keluhan : </p>
        <p style="font-size: 9px;">{{ $case->keluhan }}</p>
    </div>
    <table style="width: 100%; color: gray; font-size: 8px; margin-top: 8px; border-collapse: collapse;">
        <tr>
            <td style="width: 66.67%; vertical-align: top; padding-right: 8px;">
                <p style="margin: 0;">1. Untuk tingkat kerusakan yang cukup parah dan drone dengan assembly susah akan dikenakan biaya Troubleshooting kerusakan sebesar Rp 300,000 (Bila Repair di batalkan).</p>
                <p style="margin: 0; margin-top: 4px;">2. Bila proses Repair di batalkan, pengembalian Drone dilakukan paling cepat 1 minggu setelah konfirmasi pembatalan.</p>
            </td>
            <td style="width: 33.33%; vertical-align: top; text-align: center;">
            </td>
        </tr>
    </table>
    <table style="width: 100%; color: gray; font-size: 8px; margin-top: 8px; border-collapse: collapse;">
        <tr>
            <td style="width: 66.67%; vertical-align: top; padding-right: 8px;">
            </td>
            <td style="width: 33.33%; vertical-align: top; text-align: center;">
                <img src="{{ public_path('img/Logo Rumah Drone Black.png') }}" alt="Stempel RD" style="width: 80px; display: block; margin: 0 auto;">
                <p style="font-size: 8px; margin: 4px 0 0;">( Rumah Drone )</p>
            </td>
        </tr>
    </table>
    
</body>
</html>
