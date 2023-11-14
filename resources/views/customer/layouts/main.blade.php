<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | RD</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/loading.css">
    @vite('resources/css/app.css')
</head>
<body>

@include('customer.layouts.header')
@include('customer.layouts.sidebar')

<div class="p-4 h-screen sm:ml-64 mt-14 dark:bg-gray-800 overflow-hidden">
    @yield('container')
</div>

<div id="loader" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
    <div class="loader top-1/2 transform"></div>
    <div class="loader-text font-bold ml-2 text-white">Loading . . .</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
<script src="/js/toggle.js"></script>
<script src="/js/dropdown_wilayah.js"></script>
<script src="/js/search.js"></script>
<script src="/js/loader.js"></script>
</body>
</html>