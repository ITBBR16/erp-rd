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
    <table style="width: 100%; font-size: 10px; margin-bottom: 16px; border-spacing: 0 8px">
        <tr>
            <td style="vertical-align: top; width: 240px;">
                <img src="{{ public_path('img/Logo Rumah Drone Black.png') }}" alt="Logo Rumah Drone Black">
            </td>
            <td style="vertical-align: top; text-align: right;">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #1F2937;">Invoice #</h2>
                <address style="margin-top: 0.5rem; font-style: normal; color: #1F2937;">
                    PT. Odo Multi Aero<br>
                    Jl. Kwoka Q2 No.6, Kota Malang<br>
                    Telp./Whatsapp 082232377753<br>
                </address>
            </td>
        </tr>
    </table>


    <table style="width: 100%; font-size: 12px;">
        <tr>
            <td style="width: 66%; vertical-align: top;">
                <table style="width: 100%;">
                    <tr>
                        <td style="font-weight: 600; color: #1F2937; width: 10%;">Nama:</td>
                        <td style="color: #6B7280;">{{ $namaCustomer }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: #1F2937;">No Tlp:</td>
                        <td style="color: #6B7280;">{{ $noTelpon }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: #1F2937;">Alamat:</td>
                        <td style="color: #6B7280;">{{ $jalanCustomer }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 34%; vertical-align: top; text-align: right;">
                <table style="width: 100%;">
                    <tr>
                        <td style="font-weight: 600; color: #1F2937; text-align: right;">No Invoice:</td>
                        <td style="color: #6B7280; text-align: right;">{{ $invoiceid }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: #1F2937; text-align: right;">Due date:</td>
                        <td style="color: #6B7280; text-align: right;">{{ $duedate->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="position: relative; padding-top: 1rem; font-size: 12px;">
        <table style="border: 1px solid; width: 100%; text-align: left; color: #6B7280;">
            <thead style="font-size: 0.75rem; color: #111827; border-bottom: 2px solid; text-transform: uppercase;">
                <tr>
                    <th scope="col" style="padding: 0.25rem; width: 30%; font-size: 12px; text-align: left;">Product Name</th>
                    <th scope="col" style="padding: 0.25rem; width: 30%; font-size: 12px; text-align: left;">Description</th>
                    <th scope="col" style="padding: 0.25rem; width: 10%; font-size: 12px; text-align: left;">QTY</th>
                    <th scope="col" style="padding: 0.25rem; width: 15%; font-size: 12px; text-align: left;">Item Price</th>
                    <th scope="col" style="padding: 0.25rem; width: 15%; font-size: 12px; text-align: left;">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    <tr>
                        <td style="padding: 0.25rem; font-size: 12px;">{{ $item['productName'] }}</td>
                        <td style="padding: 0.25rem; font-size: 12px;">{{ $item['description'] }}</td>
                        <td style="padding: 0.25rem; font-size: 12px;">{{ $item['qty'] }}</td>
                        <td style="padding: 0.25rem; font-size: 12px;">{{ $item['itemPrice'] }}</td>
                        <td style="padding: 0.25rem; font-size: 12px;">{{ $item['totalPrice'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <table style="width: 100%; margin-top: 1rem;">
        <tr>
            <td style="width: 66%; vertical-align: top; font-size: 10px;">
                <h4 style="font-weight: 600; color: #1F2937;">PERHATIAN!</h4>
                <p style="color: #6B7280;">- Garansi berlaku setelah penerimaan barang</p>
                <p style="color: #6B7280;">- Garansi tidak berlaku akibat human error</p>
                <p style="color: #6B7280;">- Garansi tidak berlaku apabila barang pernah diperbaiki/dibongkar pemilik/pihak lain</p>
                <p style="color: #6B7280;">- Pembeli Wajib membawa nota dan kartu garansi pada saat klaim garansi</p>
            </td>
            <td style="width: 34%; vertical-align: top; text-align: right;">
                <table style="width: 100%; max-width: 640px; font-size: 12px;">
                    <tr>
                        <td style="font-weight: 600; color: #1F2937; width: 40%; top; text-align: right;">Subtotal:</td>
                        <td id="invoice-subtotal" style="color: #6B7280; top; text-align: right;">{{ $subTotal }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: #1F2937; top; text-align: right;">Discount:</td>
                        <td id="invoice-discount" style="color: #6B7280; top; text-align: right;">{{ $discount }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: #1F2937; top; text-align: right;">Ongkir:</td>
                        <td id="invoice-ongkir" style="color: #6B7280; top; text-align: right;">{{ $ongkir }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; color: #1F2937; top; text-align: right;">Total:</td>
                        <td id="invoice-total" style="color: #6B7280; top; text-align: right;">{{ $total }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>