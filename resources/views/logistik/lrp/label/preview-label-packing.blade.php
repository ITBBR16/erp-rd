<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Label Pengiriman</title>
        <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
        <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}" type="text/css">
    </head>

    <body>

        <h2 style="text-transform: uppercase; font-weight: bold; text-align: center; margin-bottom: 10px;">
            <img src="{{ public_path('img/Logo Rumah Drone Black.png') }}" alt="Logo" style="width: 260px; vertical-align: middle; margin-right: 10px;">
        </h2>

        <strong>Penerima :</strong>
        <table class="width: 100%; font-size: 14px; margin-bottom: 16px;">
            <tr>
                <td style="text-align: left; vertical-align: top; width: 10%;">
                    <h2 style="font-size: 16px; font-weight: 600; color: black;"><strong>Nama :</strong></h2>
                </td>
                <td style="text-align: left; vertical-align: top; width: 90%;">
                    <h2 style="font-size: 14px;">{{ $dataReq->customer->first_name }} {{ $dataReq->customer->last_name ?? '' }} - {{ $dataReq->customer->id }}</h2>
                </td>
            </tr>
            <tr>
                <td style="text-align: left; vertical-align: top; width: 10%;">
                    <h2 style="font-size: 16px; font-weight: 600; color: black;"><strong>No Tlp :</strong></h2>
                </td>
                <td style="text-align: left; vertical-align: top; width: 90%;">
                    <h2 style="font-size: 14px;">{{ $dataReq->customer->no_telpon }}</h2>
                </td>
            </tr>
            <tr>
                <td style="text-align: left; vertical-align: top; width: 10%;">
                    <h2 style="font-size: 16px; font-weight: 600; color: black;"><strong>Alamat :</strong></h2>
                </td>
                <td style="text-align: left; vertical-align: top; width: 90%;">
                    <h2 style="font-size: 14px;">{{ $alamat }}</h2>
                </td>
            </tr>
        </table>

        <strong>Lion Parcel, Regpack{{ ($dataReq->biaya_customer_packing > 0) ? ', Pack Kayu' : '' }}{{ ($dataReq->nominal_produk == 0) ? '' : ($dataReq->nominal_produk < 10000000 
            ? ', RD' . substr($dataReq->nominal_produk, 0, 1) 
            : ', RD' . substr($dataReq->nominal_produk, 0, 2)) }}</strong>

        <table style="width: 100%; font-size: 16px; margin-bottom: 10px">
            <tr>
                <td style="text-align: left; vertical-align: middle; width: 30%;"><strong>Barcode For Ekspedisi =></strong></td>
                <td style="text-align: center; vertical-align: top; width: 30%;">
                    <img src="{{ $barcode }}" 
                    alt="QR Code" style="width: 160px;">
                </td>
                <td style="text-align: left; vertical-align: top; width: 40%;">
                    <strong>Pengirim :</strong>
                    <p><strong>PT. Odo Multi Aero</strong></p>
                    <p>Jl. Kwoka Q2 No.6 Kec. Sukun, Kota Malang - Jatim, Kode Pos 65146</p>
                    <p><strong>Hp.</strong> +62 813-3430-0706</p>
                </td>
            </tr>
        </table>

        <p style="font-weight: bold; font-size: 18px; text-align: center; color: red;">
            WAJIB!! Harap melakukan Video Unboxing paket hingga video saat melakukan 
            penyalaan pada drone (dalam satu take video) !!
        </p>

    </body>

</html>
