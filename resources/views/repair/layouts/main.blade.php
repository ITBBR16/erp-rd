<!DOCTYPE html>
<html lang="en" class="scrollbar-none">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | RD</title>
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/repair/app.js'])

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .invoice-penerimaan-repair, .invoice-penerimaan-repair * {
                visibility: visible;
            }
            .invoice-penerimaan-repair {
                margin-top: -215px;
                padding: 0;
                width: 100%;
                max-width: none;
                height: auto;
                page-break-inside: avoid;
            }
            @page {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    @include('repair.layouts.header')

    @if (Request::is('repair/analisa/*'))
        @include('repair.layouts.sidebarCustomer')
    @elseif (Request::is('repair/customer/*'))
        @include('repair.layouts.sidebarCustomer')
    @elseif (Request::is('repair/csr/*'))
        @include('repair.layouts.sidebarCsr')
    @elseif (Request::is('repair/teknisi/*'))
        @include('repair.layouts.sidebarTeknisi')
    @elseif (Request::is('repair/estimasi/*'))
        @include('repair.layouts.sidebarEstimasi')
    @elseif (Request::is('repair/quality-control/*'))
        @include('repair.layouts.sidebarQC')
    @endif

    <div class="p-4 h-screen sm:ml-64 mt-14 bg-white dark:bg-gray-800 overflow-y-auto scrollbar-none">
        @yield('container')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.min.js"></script>

</body>
</html>