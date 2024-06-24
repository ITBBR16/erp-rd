<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | RD</title>
    <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>
<body>

    @include('repair.layouts.header')
    @include('repair.layouts.sidebar')

    <div class="p-4 h-screen sm:ml-64 mt-14 dark:bg-gray-800 scrollbar-none">
        @yield('container')
    </div>

</body>
</html>