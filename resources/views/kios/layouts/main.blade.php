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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
<body>

@include('kios.layouts.header')
@include('kios.layouts.sidebar')

<div class="p-4 h-screen sm:ml-64 mt-14 dark:bg-gray-800 overflow-hidden">
    @yield('container')
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="/js/toggle.js"></script>
<script src="/js/search.js"></script>
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>
</html>