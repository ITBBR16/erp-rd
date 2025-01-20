<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | RD</title>
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}" type="text/css">
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-2xl mx-auto bg-white shadow-lg p-8">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <img src="logo.png" alt="Logo" class="h-12">
            <div class="text-right">
                <h1 class="text-2xl font-bold">Invoice Penerimaan</h1>
                <p class="text-gray-600">#R-2676</p>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="font-semibold">Nama Customer</p>
                <p>Gabriel Septian</p>
                <p class="font-semibold">Jenis Drone</p>
                <p>DJI Spark</p>
                <p class="font-semibold">No Telpon</p>
                <p>6282229992524</p>
                <p class="font-semibold">Kota</p>
                <p>-</p>
            </div>
            <div class="text-right">
                <p class="font-semibold">Tanggal</p>
                <p>2025-01-03 20:31:47</p>
                <p class="font-semibold">Status</p>
                <p>Reguler Online</p>
            </div>
        </div>

        <!-- Table -->
        <table class="w-full border-collapse border border-gray-300 mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nama Kelengkapan</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Qty</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Serial Number</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">Remote Controller</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">1</td>
                    <td class="border border-gray-300 px-4 py-2">0J0CF6G001KSMJ</td>
                    <td class="border border-gray-300 px-4 py-2">-</td>
                </tr>
            </tbody>
        </table>

        <!-- Keluhan -->
        <div class="mb-6">
            <p class="font-semibold">Keluhan :</p>
            <p>Di cas bisa (Muncul indikator). Tapi tidak bisa dinyalakan</p>
        </div>

        <!-- Notes -->
        <div class="text-sm mb-6">
            <ol class="list-decimal pl-4">
                <li>Untuk tingkat kerusakan yang cukup parah dan drone dengan assembly susah akan dikenakan biaya Troubleshooting kerusakan sebesar Rp. 300.000 (Bila repair dibatalkan).</li>
                <li>Bila proses Repair di batalkan, pengembalian Drone paling cepat 1 minggu setelah konfirmasi pembatalan.</li>
            </ol>
        </div>

        <!-- Footer -->
        <div class="text-center border-t pt-4">
            <p class="font-semibold">Hasan RD</p>
            <p class="text-gray-600">Rumahdrone</p>
            <p class="text-sm text-gray-500 mt-2">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karangbesuki, Kec. Sukun, Kota Malang,<br>Kode Pos 65146 Telp. 0813-3430-0706</p>
        </div>
    </div>
</body>
</html>
