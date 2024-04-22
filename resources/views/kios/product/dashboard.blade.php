@extends('kios.layouts.main')

@section('container')
    <div class="grid gap-4 xl:grid-cols-2 2xl:grid-cols-3 mt-4">
        {{-- Analytic --}}
        <div class="p-4 border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-shrink-0">
                    <span class="text-xl font-bold leading-none text-gray-900 sm:text-xl dark:text-white">Rp. {{ number_format($totalSales, 0, ',', '.') }}</span>
                    <h3 class="text-base font-light text-gray-500 dark:text-gray-400">Sales minggu ini</h3>
                </div>
                @if ($percentSales > 0)
                    <div class="flex items-center justify-end flex-1 text-base font-medium text-green-500 dark:text-gray-400">
                        <span>+{{ $percentSales }}%</span>
                        <span class="material-symbols-outlined flex whitespace-nowrap text-sm">north</span>
                    </div>
                @else
                    <div class="flex items-center justify-end flex-1 text-base font-medium text-red-500 dark:text-gray-400">
                        <span>{{ $percentSales }}%</span>
                        <span class="material-symbols-outlined flex whitespace-nowrap text-sm">south</span>
                    </div>
                @endif
            </div>
            <div id="main-chart" style="min-height: 385px;">
                <div id="sales-chart" style="height: 420;" class="w-full"></div>
            </div>
            <div class="flex items-center justify-end pt-3 mt-5 border-t border-gray-200 sm:pt-6 dark:border-gray-700">
                <div class="flex-shrink-0">
                    <a href="#" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-blue-700 sm:text-sm hover:bg-gray-100 dark:text-blue-500 dark:hover:bg-gray-700">
                        Lihat Transaksi
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        {{-- Tabs Widget --}}
        <div class="p-4 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                Statistic bulan ini 
                <button data-tooltip-target="statistic" data-tooltip-placement="right" type="button" class="items-center ">
                    <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div id="statistic" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Statistic produk paling laku
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </h3>
            <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400" id="fullWidthTab" data-tabs-toggle="#statisticTabContent" role="tablist">
                <li class="w-full">
                    <button id="statistic-produk-tab" data-tabs-target="#statistic-produk" type="button" role="tab" aria-controls="statistic-produk" aria-selected="true" class="inline-block w-full p-4 rounded-tl-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500">Top products</button>
                </li>
                <li class="w-full">
                    <button id="statistic-customer-tab" data-tabs-target="#statistic-customer" type="button" role="tab" aria-controls="statistic-customer" aria-selected="false" class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300">Top Customers</button>
                </li>
            </ul>
            <div id="statisticTabContent" class="border-t border-gray-200 dark:border-gray-600">
                <div class="pt-4" id="statistic-produk" role="tabpanel" aria-labelledby="statistic-produk-tab">
                    <ul role="list" class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center min-w-0">
                                    <img class="flex-shrink-0 w-10 h-10" src="/img/user.png" alt="imac image">
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900 truncate dark:text-white">
                                            DJI MINI 4 PRO FLY MORE COMBO PLUS WITH RC2
                                        </p>
                                    </div>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    4 Unit
                                </div>
                            </div>
                        </li>
                        <li class="py-2">
                            <div class="flex items-center justify-between">
                            <div class="flex items-center min-w-0">
                                <img class="flex-shrink-0 w-10 h-10" src="/img/user.png" alt="imac image">
                                <div class="ml-3">
                                <p class="font-medium text-gray-900 truncate dark:text-white">
                                    DJI MINI 4 PRO FLY MORE COMBO PLUS WITH RC2
                                </p>
                                </div>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                4 Unit
                            </div>
                            </div>
                        </li>
                        <li class="py-2">
                            <div class="flex items-center justify-between">
                            <div class="flex items-center min-w-0">
                                <img class="flex-shrink-0 w-10 h-10" src="/img/user.png" alt="imac image">
                                <div class="ml-3">
                                <p class="font-medium text-gray-900 truncate dark:text-white">
                                    DJI MINI 4 PRO FLY MORE COMBO PLUS WITH RC2
                                </p>
                                </div>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                4 Unit
                            </div>
                            </div>
                        </li>
                        <li class="py-2">
                            <div class="flex items-center justify-between">
                            <div class="flex items-center min-w-0">
                                <img class="flex-shrink-0 w-10 h-10" src="/img/user.png" alt="imac image">
                                <div class="ml-3">
                                <p class="font-medium text-gray-900 truncate dark:text-white">
                                    DJI MINI 4 PRO FLY MORE COMBO PLUS WITH RC2
                                </p>
                                </div>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                4 Unit
                            </div>
                            </div>
                        </li>
                        <li class="py-2">
                            <div class="flex items-center justify-between">
                            <div class="flex items-center min-w-0">
                                <img class="flex-shrink-0 w-10 h-10" src="/img/user.png" alt="imac image">
                                <div class="ml-3">
                                <p class="font-medium text-gray-900 truncate dark:text-white">
                                    DJI MINI 4 PRO FLY MORE COMBO PLUS WITH RC2
                                </p>
                                </div>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                4 Unit
                            </div>
                            </div>
                        </li>
                        <li class="py-2">
                            <div class="flex items-center justify-between">
                            <div class="flex items-center min-w-0">
                                <img class="flex-shrink-0 w-10 h-10" src="/img/user.png" alt="imac image">
                                <div class="ml-3">
                                <p class="font-medium text-gray-900 truncate dark:text-white">
                                    DJI MINI 4 PRO FLY MORE COMBO PLUS WITH RC2
                                </p>
                                </div>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                4 Unit
                            </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="pt-4 hidden" id="statistic-customer" role="tabpanel" aria-labelledby="statistic-customer-tab">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-3">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="/img/user.png" alt="Neil image">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                    Daniel Imam
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    danielimam@gmail.com
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    Rp. 66.666.000
                                </div>
                            </div>
                        </li>
                        <li class="py-3">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="/img/user.png" alt="Neil image">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                    Daniel Imam
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    danielimam@gmail.com
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    Rp. 66.666.000
                                </div>
                            </div>
                        </li>
                        <li class="py-3">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="/img/user.png" alt="Neil image">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                    Daniel Imam
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    danielimam@gmail.com
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    Rp. 66.666.000
                                </div>
                            </div>
                        </li>
                        <li class="py-3">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="/img/user.png" alt="Neil image">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                    Daniel Imam
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    danielimam@gmail.com
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    Rp. 66.666.000
                                </div>
                            </div>
                        </li>
                        <li class="py-3">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="/img/user.png" alt="Neil image">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                    Daniel Imam
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    danielimam@gmail.com
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    Rp. 66.666.000
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- Footer --}}
            <div class="flex items-center justify-end pt-3 mt-5 border-t border-gray-200 dark:border-gray-700">
                <div class="flex-shrink-0">
                    <a href="/kios/product/list-product" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-blue-700 sm:text-sm hover:bg-gray-100 dark:text-blue-500 dark:hover:bg-gray-700">
                        Lihat Produk
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="grid gap-4 xl:grid-cols-3 mt-6">
        <div class="p-4 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                List belanja bulan ini
                <button data-tooltip-target="list-invoice-belanja" data-tooltip-placement="right" type="button" class="items-center ">
                    <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div id="list-invoice-belanja" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    List belanja produk baru ataupun bekas
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </h3>
            <div class="overflow-auto mt-2 border-gray-200 dark:border-gray-600">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Order ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Supplier
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                
                            </th>
                            <td class="px-6 py-2">
                                
                            </td>
                            <td class="px-6 py-2">
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Footer --}}
            <div class="flex items-center justify-end pt-3 mt-5 border-t border-gray-200 dark:border-gray-700">
                <div class="flex-shrink-0">
                    <a href="/kios/product/shop" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-blue-700 sm:text-sm hover:bg-gray-100 dark:text-blue-500 dark:hover:bg-gray-700">
                        List Belanja
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="p-4 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                List produk promo bulan ini
                <button data-tooltip-target="list-invoice-belanja" data-tooltip-placement="right" type="button" class="items-center ">
                    <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div id="list-invoice-belanja" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    List produk yang sedang promo
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </h3>
            <div class="overflow-auto mt-2 border-gray-200 dark:border-gray-600">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Paket Penjualan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Harga Promo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                
                            </th>
                            <td class="px-6 py-2">
                                
                            </td>
                            <td class="px-6 py-2">
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Footer --}}
            <div class="flex items-center justify-end pt-3 mt-5 border-t border-gray-200 dark:border-gray-700">
                <div class="flex-shrink-0">
                    <a href="/kios/product/list-product" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-blue-700 sm:text-sm hover:bg-gray-100 dark:text-blue-500 dark:hover:bg-gray-700">
                        List Produk
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="p-4 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                List transaksi bulan ini
                <button data-tooltip-target="list-invoice-belanja" data-tooltip-placement="right" type="button" class="items-center ">
                    <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div id="list-invoice-belanja" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    List transaksi yang di lakukan pada bagian kasir
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </h3>
            <div class="overflow-auto mt-2 border-gray-200 dark:border-gray-600">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Invoice
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Customer
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Belanja
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                
                            </th>
                            <td class="px-6 py-2">
                                
                            </td>
                            <td class="px-6 py-2">
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Footer --}}
            <div class="flex items-center justify-end pt-3 mt-5 border-t border-gray-200 dark:border-gray-700">
                <div class="flex-shrink-0">
                    <a href="#" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-blue-700 sm:text-sm hover:bg-gray-100 dark:text-blue-500 dark:hover:bg-gray-700">
                        List Transaksi
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
