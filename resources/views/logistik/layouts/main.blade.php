<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | RD</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/logistik.js')
</head>
<body>

@include('logistik.layouts.header')
@include('logistik.layouts.sidebar')

<div class="p-4 h-screen sm:ml-64 mt-14 dark:bg-gray-800 overflow-y-scroll">
    @yield('container')
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</body>
</html>