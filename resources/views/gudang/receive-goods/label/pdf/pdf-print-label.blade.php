<!DOCTYPE html>
<html lang="en" class="scrollbar-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | RD</title>
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            div[id^="print-label-"] {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    @foreach ($dataLabel as $item)
        @if ($item->qualityControll->status_validasi == 'Pass')
            @php
                $sku = $item->gudangProduk->produkSparepart->produkType->code . "." . 
                                            $item->gudangProduk->produkSparepart->partModel->code . "." . 
                                            $item->gudangProduk->produkSparepart->produk_jenis_id . "." . 
                                            $item->gudangProduk->produkSparepart->partBagian->code . "." . 
                                            $item->gudangProduk->produkSparepart->partSubBagian->code . "." . 
                                            $item->gudangProduk->produkSparepart->produk_part_sifat_id . "." . 
                                            $item->gudangProduk->produkSparepart->id;
                $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate($sku));
            @endphp
            
            <div id="print-label-{{ $item->id }}" style="page-break-before: always; border: 1px solid black; border-radius: 4px; padding: 8px; width: 8cm;">
                <!-- Header -->
                <table style="width: 100%; border-bottom: 1px solid black; border-collapse: collapse;">
                    <tr>
                        <td style="font-size: 12pt; font-weight: bold;">{{ $item->gudangProduk->produkSparepart->ProdukJenis->jenis_produk }}</td>
                        <td style="text-align: right;">
                            <img src="{{ public_path('img/Logo Rumah Drone Black.png') }}" alt="Rumahdrone Logo" style="height: 16px;">
                        </td>
                    </tr>
                </table>
            
                <!-- Isi -->
                <table style="width: 100%; margin-top: 6px; border-collapse: collapse;">
                    <tr>
                        <!-- Nama Produk -->
                        <td colspan="2" style="font-size: 10pt; font-weight: bold;">{{ $item->gudangProduk->produkSparepart->nama_internal }}</td>
                        <!-- QR Code -->
                        <td rowspan="3" style="text-align: right; width: 2.5cm;">
                            <img src="data:image/svg+xml;base64,{{ $qrCode }}" style="width: 2.5cm; height: 2.5cm;">
                        </td>
                    </tr>
                    <tr>  
                        <!-- SKU -->
                        <td style="font-size: 8pt; width: 20%"><strong>SKU :</strong></td>
                        <td style="font-size: 8pt; text-align: right; padding-right: 10px; font-weight: bold;">
                            N.{{ $item->gudang_belanja_id }}.{{ $item->gudangBelanja->gudang_supplier_id }}.{{ $item->id }}
                        </td>
                    </tr>
                    <tr>
                        <!-- SKU Code -->
                        <td colspan="2" style="font-size: 8pt; font-weight: bold;">
                            {{ $sku }}
                        </td>
                    </tr>
                </table>
            </div>
        @endif
    @endforeach
</body>
</html>