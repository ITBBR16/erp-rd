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
    <div style="background-color: white; padding: 2px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: 1px solid #E5E7EB;">
        <div style="margin-bottom: 16px; display: flex; justify-content: center; text-align: center;">
            <div style="display: flex; justify-content: center; text-align: center;">
                <img src="{{ public_path('img/Logo Rumah Drone Black.png') }}" style="width: 160px;" alt="Logo RD">
            </div>
            <p style="font-size: 10px;">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karang Besuki Kec. Sukun Kota Malang Kode Pos 65146</p>
            <p style="font-size: 10px;">Telp. 0813-3430-0706</p>
        </div>
        <div style="display: flex; justify-content: space-between; margin: 16px 0;">
            <div style="text-align: start;">
                <h2 style="font-size: 18px; font-weight: 600; color: black;">Detail Transaksi / <span style="font-size: 18px; color: gray;">R-{{ $dataCase->id }} <span style="font-size: 12px; margin-left: 8px; color: green; background-color: #D1FAE5; padding: 4px 8px; border-radius: 9999px;">Lunas</span></span></h2>
            </div>
            <div style="text-align: end;">
                <h2 style="font-size: 18px; font-weight: 600; color: black;">{{ $dataCase->jenisProduk->jenis_produk }}</h2>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
            <div>
                <p style="font-size: 12px; color: gray;">Nama Customer</p>
                <h3 style="font-size: 14px; font-weight: 600; color: black;">{{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: gray;">No Telpon</p>
                <h3 style="font-size: 14px; font-weight: 600; color: black;">{{ $dataCase->customer->no_telpon }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: gray;">Alamat</p>
                <h3 style="font-size: 14px; font-weight: 600; color: black;">{{ $dataCase->customer->kota->name ?? "-" }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: gray;">Status Case</p>
                <h3 style="font-size: 14px; font-weight: 600; color: black;">{{ $dataCase->jenisCase->jenis_case }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: gray;">Tanggal Masuk</p>
                <h3 style="font-size: 14px; font-weight: 600; color: black;">{{ \Carbon\Carbon::parse($dataCase->created_at)->isoFormat('D MMMM YYYY') }}</h3>
            </div>
            <div>
                <p style="font-size: 12px; color: gray;">Tanggal Keluar</p>
                <h3 style="font-size: 14px; font-weight: 600; color: black;">{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</h3>
            </div>
        </div>
    
        <table style="font-size: 14px; margin-top: 24px; width: 100%; background-color: #F9FAFB; border-radius: 8px; color: #9CA3AF;">
            <thead style="text-align: left; color: #111827;">
                <tr>
                    <th style="padding: 8px; width: 80%;">Analisa Kerusakan</th>
                    <th style="padding: 8px; width: 20%;">Harga</th>
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
    
        <table style="font-size: 14px; margin-top: 24px; width: 100%; background-color: #F9FAFB; border-radius: 8px; color: #9CA3AF;">
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

        <table style="font-size: 0.875rem; margin-top: 1.5rem; width: 100%; background-color: #F9FAFB; border-radius: 0.5rem; color: #9CA3AF;">
            <thead style="text-align: left; color: #1F2937;">
                <tr>
                    <th style="padding: 0.5rem; width: 35%;">
                        Kelengkapan
                    </th>
                    <th style="padding: 0.5rem; width: 10%;">
                        Quantity
                    </th>
                    <th style="padding: 0.5rem; width: 20%;">
                        Serial Number
                    </th>
                    <th style="padding: 0.5rem; width: 35%;">
                        Keterangan
                    </th>
                </tr>
            </thead>
            <tbody style="color: #374151;">
                @foreach ($dataCase->detailKelengkapan as $kelengkapan)
                    <tr style="border-top: 1px solid #E5E7EB;">
                        <td style="padding: 0.5rem;">
                            {{ ($kelengkapan->item_kelengkapan_id == null) ? $kelengkapan->nama_data_lama : $kelengkapan->itemKelengkapan->kelengkapan }}
                        </td>
                        <td style="padding: 0.5rem;">
                            {{ $kelengkapan->quantity }}
                        </td>
                        <td style="padding: 0.5rem;">
                            {{ $kelengkapan->serial_number }}
                        </td>
                        <td style="padding: 0.5rem;">
                            {{ ($kelengkapan->keterangan) ? $kelengkapan->keterangan : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); margin-top: 1rem;">
            <div style="grid-column: span 2; font-size: 0.875rem; border: 1px solid #E5E7EB; padding: 0.75rem;">
                <div style="border-bottom: 1px solid #E5E7EB; font-weight: 600;">Keluhan Kerusakan</div>
                <div style="padding-top: 0.5rem;">{{ $dataCase->keluhan }}</div>
            </div>
            <div style="grid-column: span 1;">
                <div style="font-size: 0.875rem; width: 100%; max-width: 40rem; padding-left: 0.75rem;">
                    <dl style="display: grid; grid-template-columns: repeat(5, 1fr); gap-left: 0.75rem;">
                        <dt style="grid-column: span 3; font-weight: 600; color: #1F2937;">Down Payment</dt>
                        @php
                            $totalDp = $dataCase->transaksi->total_pembayaran ?? 0
                        @endphp
                        <dd style="grid-column: span 2; color: #6B7280;">Rp. {{ number_format($totalDp, 0, ',', '.') }}</dd>
                    </dl>
                    <dl style="display: grid; grid-template-columns: repeat(5, 1fr); gap-left: 0.75rem;">
                        <dt style="grid-column: span 3; font-weight: 600; color: #1F2937;">Discount</dt>
                        <dd style="grid-column: span 2; color: #6B7280;">Rp. 0</dd>
                    </dl>
                    <dl style="margin: 0.25rem 0; border-bottom: 1px solid #E5E7EB;"></dl>
                    <dl style="display: grid; grid-template-columns: repeat(5, 1fr); gap-left: 0.75rem;">
                        <dt style="grid-column: span 3; font-weight: 600; color: #1F2937;">Total Pembayaran</dt>
                        <dd id="total-pembayaran-dp" style="grid-column: span 2; color: #6B7280;">Rp 0</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); margin-top: 1rem;">
            <div style="grid-column: span 2; font-size: 0.875rem; border: 1px solid #E5E7EB; padding: 0.75rem;">
                <div style="border-bottom: 1px solid #E5E7EB; font-weight: 600;">Ketentuan Garansi</div>
                <div>
                    <p style="font-size: 0.75rem; color: #6B7280;">- Garansi hanya termasuk bagian yang direpair / direplace</p>
                    <p style="font-size: 0.75rem; color: #6B7280;">- Garansi tidak berlaku jika human error, overheat, overvoltage, overclocking</p>
                    <p style="font-size: 0.75rem; color: #6B7280;">- Garansi tidak berlaku jika segel rusak</p>
                    <p style="font-size: 0.75rem; color: #6B7280;">- Garansi berlaku 1 bulan setelah barang diterima</p>
                </div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); margin-top: 1rem; text-align: center;">
            <div>
                <h3 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 3rem;">Penerima</h3>
                <p style="font-size: 0.75rem;">( {{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }} )</p>
            </div>
            <div>
                <h3 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 3rem;">Hormat Kami</h3>
                <p style="font-size: 0.75rem;">( {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} )</p>
            </div>
        </div>        
    </div>      
</body>
</html>