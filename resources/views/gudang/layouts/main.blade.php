<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Gudang | RD</title>
        <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        @vite('resources/js/gudang/app.js')
    </head>
    <body>

        @include('gudang.layouts.header')
        @include('gudang.layouts.sidebar')

        <div class="p-4 h-screen sm:ml-64 mt-14 dark:bg-gray-800 overflow-y-auto scrollbar-none">
            @yield('container')
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.min.js"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
    </body>
</html>