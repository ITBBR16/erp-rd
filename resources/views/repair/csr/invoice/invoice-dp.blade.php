<!DOCTYPE html>
<html lang="en" class="scrollbar-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | RD</title>
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}" type="text/css">
</head>
<body>
    <div style="margin-bottom: 16px; text-align: center;">
        <div style="display: flex; justify-content: center; text-align: center;">
            <img src="{{ public_path('img/Logo Rumah Drone Black.png') }}" style="width: 160px;" alt="Logo RD">
        </div>
        <p style="font-size: 10px; color: #6b7280;">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karang Besuki Kec. Sukun Kota Malang Kode Pos 65146</p>
        <p style="font-size: 10px; color: #6b7280;">Telp. 0813-3430-0706</p>
    </div>
    
    <table style="width: 100%; padding-bottom: 8px; margin-bottom: 8px;">
        <tr>
            <td style="text-align: left; vertical-align: top; width: 50%;">
                <h2 style="font-size: 14px; font-weight: 600;">Detail Transaksi / <span style="font-size: 14px; color: #4b5563;">R-{{ $dataCase->id }} <span style="font-size: 12px; margin-left: 8px; color: #ef4444; background-color: #fee2e2; padding: 2px 8px; border-radius: 9999px;">Down Payment</span></span></h2>
            </td>
            <td style="text-align: right; vertical-align: top; width: 50%;">
                <h2 style="font-size: 14px; font-weight: 600;">{{ $dataCase->jenisProduk->jenis_produk }}</h2>
            </td>
        </tr>
    </table>
    
    <table style="width: 100%; font-size: 12px; margin-bottom: 16px; border-spacing: 0 8px">
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
                <h3 style="font-weight: 600; margin: 0;">{{ $dataCase->customer->kota->name }}</h3>
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

    <table style="font-size: 10px; margin-top: 24px; width: 100%; background-color: #f3f4f6; border-radius: 8px; border-collapse: collapse;">
        <thead style="text-align: left; color: #111827;">
            <tr>
                <th style="padding: 8px; width: 80%; text-align: left;">Analisa Kerusakan</th>
                <th style="padding: 8px; width: 20%; text-align: left;">Harga</th>
            </tr>
        </thead>
        <tbody style="color: #4b5563;">
            @php
                $totalTagihan = 0;
                $totalOngkir = 0;
                $biayaOngkir = 0;
                $biayaPacking = 0;
                $nominalAsuransi = 0;
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
                        $biayaOngkir += $dataCase->logRequest->biaya_customer_ongkir ?? 0;
                        $biayaPacking += $dataCase->logRequest->biaya_customer_packing ?? 0;
                        $totalOngkir += $biayaOngkir + $biayaPacking;
                    @endphp
                    <td style="padding: 8px;">Total Ongkir</td>
                    <td style="padding: 8px;">Rp. {{ number_format($totalOngkir, 0, ',', '.') }}</td>
                </tr>
            @endif
            @if (!empty($dataCase->logRequest->nominal_asuransi))
            <tr style="border-top: 1px solid #e5e7eb;">
                @php
                    $nominalAsuransi += $dataCase->logRequest->nominal_asuransi;
                    $totalOngkir += $nominalAsuransi;
                @endphp
                <td style="padding: 8px;">Asuransi</td>
                <td style="padding: 8px;">Rp. {{ number_format($nominalAsuransi, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr style="border-top: 2px solid #1f2937;">
                @php
                    $totalAkhir = $totalTagihan + $totalOngkir;
                @endphp
                <td style="padding: 8px; font-weight: 600;">Total Tagihan</td>
                <td style="padding: 8px;">Rp. {{ number_format($totalAkhir, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table style="font-size: 10px; margin-top: 24px; width: 100%; background-color: #f3f4f6; border-radius: 8px; border-collapse: collapse;">
        <thead style="text-align: left; color: #111827;">
            <tr>
                <th style="padding: 8px; width: 35%; text-align: left;">Kelengkapan</th>
                <th style="padding: 8px; width: 10%; text-align: left;">Quantity</th>
                <th style="padding: 8px; width: 20%; text-align: left;">Serial Number</th>
                <th style="padding: 8px; width: 35%; text-align: left;">Keterangan</th>
            </tr>
        </thead>
        <tbody style="color: #4b5563;">
            @foreach ($dataCase->detailKelengkapan as $kelengkapan)
                <tr style="border-top: 1px solid #e5e7eb;">
                    <td style="padding: 8px;">{{ ($kelengkapan->item_kelengkapan_id == null) ? $kelengkapan->nama_data_lama : $kelengkapan->itemKelengkapan->kelengkapan }}</td>
                    <td style="padding: 8px;">{{ $kelengkapan->quantity }}</td>
                    <td style="padding: 8px;">{{ $kelengkapan->serial_number }}</td>
                    <td style="padding: 8px;">{{ ($kelengkapan->keterangan) ? $kelengkapan->keterangan : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 12px; border: 1px solid #e5e7eb;">
            <tbody>
                <tr>
                    <td style="padding: 12px; border: 1px solid #e5e7eb; vertical-align: top;" colspan="2">
                        <div style="border-bottom: 1px solid #e5e7eb; font-weight: 600;">Keluhan Kerusakan</div>
                        <div>{{ $dataCase->keluhan }}</div>
                    </td>
                    <td style="padding: 12px; border: 1px solid #e5e7eb; width: 30%; vertical-align: top;">
                        <table style="width: 100%; font-size: 12px;">
                            <tbody>
                                <tr>
                                    @php
                                        $totalDp = $dataCase->transaksi->total_pembayaran ?? 0
                                    @endphp
                                    <th style="text-align: left; font-weight: 600; color: #374151;">Down Payment</th>
                                    <td style="color: #6b7280; text-align: right;">Rp. 0</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; font-weight: 600; color: #374151;">Discount</th>
                                    <td style="color: #6b7280; text-align: right;">Rp. 0</td>
                                </tr>
                                <tr>
                                    @php
                                        $sisaTagihan = $totalTagihan + $biayaOngkir + $biayaPacking + ($nominalAsuransi ?? 0) - $totalDp
                                    @endphp
                                    <th style="text-align: left; font-weight: 600; color: #374151;">Sisa Tagihan</th>
                                    <td style="color: #6b7280; text-align: right;">Rp. {{ number_format($sisaTagihan, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        <table style="width: 70%; border-collapse: collapse; font-size: 12px; border: 1px solid #e5e7eb;">
            <tbody>
                <tr>
                    <td style="padding: 12px; border: 1px solid #e5e7eb; vertical-align: top;" colspan="2">
                        <div style="border-bottom: 1px solid #e5e7eb; font-weight: 600;">Ketentuan Garansi</div>
                        <div>
                            <p style="font-size: 10px; color: #6b7280">- Garansi hanya termasuk bagian yang direpair / direplace</p>
                            <p style="font-size: 10px; color: #6b7280">- Garansi tidak berlaku jika human error, overheat, overvoltage, overclocking</p>
                            <p style="font-size: 10px; color: #6b7280">- Garansi tidak berlaku jika segel rusak</p>
                            <p style="font-size: 10px; color: #6b7280">- Garansi berlaku 1 bulan setelah barang diterima</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px">
        <table style="width: 100%; padding-bottom: 8px; margin-bottom: 8px;">
            <tr>
                <td style="text-align: center; vertical-align: top; width: 50%;">
                    <h1 style="font-size: 12px; font-weight: 600; margin: 0; margin-bottom: 40px">Penerima</h1>
                    <p style="font-size: 10px; margin: 0;">( {{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }} )</p>
                </td>
                <td style="text-align: center; vertical-align: top; width: 50%;">
                    <h1 style="font-size: 12px; font-weight: 600; margin: 0; margin-bottom: 40px">Hormat Kami</h1>
                    <p style="font-size: 10px; margin: 0;">( Rumah Drone )</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>