<!DOCTYPE html>
<html lang="en" class="scrollbar-none">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }} | RD</title>
        <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
        @vite('resources/css/app.css')
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                #print-invoice-kios, #print-invoice-kios * {
                    visibility: visible;
                }
                #print-invoice-kios {
                    padding: 0px;
                    margin-top: -70px;
                    margin-left: -50px;
                    margin-right: -50px;
                }
                @page {
                    margin: 0;
                }
            }
        </style>
    </head>
    <body>
        @include('kios.layouts.header')

        @if (Request::is('kios/analisa/*'))
            @include('kios.layouts.sidebarAnalisa')
        @elseif (Request::is('kios/customer/*'))
            @include('kios.layouts.sidebarCustomer')
        @elseif (Request::is('kios/product/*'))
            @include('kios.layouts.sidebarProduct')
        @elseif (Request::is('kios/kasir/*'))
            @include('kios.layouts.sidebarKasir')
        @elseif (Request::is('kios/technical-support/*'))
            @include('kios.layouts.sidebarTechnicalSupport')
        @endif

        <div class="p-4 h-screen sm:ml-64 mt-14 dark:bg-gray-800 overflow-y-scroll scrollbar-none">
            @yield('container')
        </div>

        @vite('resources/js/app.js')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </body>
</html>