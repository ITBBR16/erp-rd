<!DOCTYPE html>
<html lang="en" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stagging Super Admin</title>

        @vite('resources/css/app.css')

    </head>
    <body>

    <h2 class="mt-10 mb-10 text-center font-bold text-3xl text-slate-700">Choose Division</h2>

    <div class="columns-3">
        <div class="mx-auto px-6 sm:flex sm:flex-wrap sm:gap-4 sm:justify-evenly">
            <div class="rounded-lg shadow-lg overflow-hidden mb-10 sm:w-64 bg-white">
                <a href="/gudang" target="_blank">
                    <img src="https://source.unsplash.com/600x400?warehouse" alt="Gudang" class="w-full">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2 text-slate-700">Dashboard Gudang</div>
                    </div>
                </a>
            </div>
            <div class="rounded-lg shadow-lg overflow-hidden mb-10 sm:w-64 bg-white">
                <a href="/repair" target="_blank">
                    <img src="https://source.unsplash.com/600x400?repair" alt="Repair" class="w-full">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2 text-slate-700">Dashboard Repair</div>
                    </div>
                </a>
            </div>
            <div class="rounded-lg shadow-lg overflow-hidden mb-10 sm:w-64 bg-white">
                <a href="/battery" target="_blank">
                    <img src="https://source.unsplash.com/600x400?battery" alt="Battery" class="w-full">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2 text-slate-700">Dashboard Battery</div>
                    </div>
                </a>
            </div>
            <div class="rounded-lg shadow-lg overflow-hidden mb-10 sm:w-64 bg-white">
                <a href="/logistik" target="_blank">
                    <img src="https://source.unsplash.com/600x400?packing" alt="Logistik" class="w-full">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2 text-slate-700">Dashboard Logistik</div>
                    </div>
                </a>
            </div>
            <div class="rounded-lg shadow-lg overflow-hidden mb-10 sm:w-64 bg-white">
                <a href="/content" target="_blank">
                    <img src="https://source.unsplash.com/600x400?content" alt="Konten" class="w-full">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2 text-slate-700">Dashboard Konten</div>
                    </div>
                </a>
            </div>
            <div class="rounded-lg shadow-lg overflow-hidden mb-10 sm:w-64 bg-white">
                <a href="/kios" target="_blank">
                    <img src="https://source.unsplash.com/600x400?kios" alt="Konten" class="w-full">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2 text-slate-700">Dashboard Kios</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

</body>
</html>
