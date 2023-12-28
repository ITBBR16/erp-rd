<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | RD</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/loading.css">
    @vite('resources/css/app.css')
</head>
<body>

@include('kios.layouts.header')
@include('kios.layouts.sidebar')

<div class="p-4 h-screen sm:ml-64 mt-14 dark:bg-gray-800 overflow-y-scroll">
    @yield('container')
</div>

<div id="loader" style="display: none;">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="loader absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
    <div class="loader-text font-bold">Loading . . .</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="/js/toggle.js"></script>
<script src="/js/search.js"></script>
<script src="/js/loader.js"></script>
<script src="/js/add-form-kelengkapan.js"></script>
<script src="/js/add-form-jk.js"></script>
<script src="/js/dd-new-belanja.js"></script>
<script src="/js/dd-checkbox-second.js"></script>
<script src="/js/toggle-payment-kios.js"></script>
<script src="/js/dropdown_wilayah.js"></script>
<script src="/js/dd-daily-recap.js"></script>
<script src="/js/dd-layanan-pengiriman.js"></script>
</body>
</html>