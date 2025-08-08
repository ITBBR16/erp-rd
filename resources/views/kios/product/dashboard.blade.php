@extends('kios.layouts.main')

@section('container')
    <div class="w-full mx-auto mt-4">
        <div class="flex flex-wrap -mx-3">
            {{-- Box Total Modal --}}
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600 relative">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">monetization_on</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Total Modal</span>
                                </div>
                                <div class="px-3 py-0">
                                    <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">Rp. {{ number_format($totalmodal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="absolute bottom-2 right-2">
                                <a href="#" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-blue-700 sm:text-sm hover:bg-gray-100 dark:text-blue-500 dark:hover:bg-gray-700">
                                    Lihat Produk
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Box Total Produk Baru --}}
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600 relative">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">store</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Total Produk Baru</span>
                                </div>
                                <div class="px-3 py-0">
                                    <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">{{ $totalpbaru }} Unit</div>
                                </div>
                            </div>
                            <div class="absolute bottom-2 right-2">
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
            </div>
            {{-- Box Produk Bekas --}}
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600 relative">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">recycling</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Total Produk Bekas</span>
                                </div>
                                <div class="px-3 py-0">
                                    <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">{{ $totalpbekas }} Unit</div>
                                </div>
                            </div>
                            <div class="absolute bottom-2 right-2">
                                <a href="/kios/product/list-product-second" class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-blue-700 sm:text-sm hover:bg-gray-100 dark:text-blue-500 dark:hover:bg-gray-700">
                                    Lihat Produk
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid gap-4 xl:grid-cols-2 2xl:grid-cols-3 mt-4">
        {{-- Analytic --}}
        <div class="p-4 border border-gray-200 bg-white rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-shrink-0">
                    <span class="text-xl font-bold leading-none text-gray-900 sm:text-xl dark:text-white">Rp. {{ number_format($totalSales, 0, ',', '.') }}</span>
                    <h3 class="text-base font-light text-gray-500 dark:text-gray-400">Sales minggu ini</h3>
                </div>
                @if ($percentSales >= 0)
                    <div class="flex items-center justify-end flex-1 text-base font-medium text-green-500 dark:text-green-400">
                        <span>+{{ $percentSales }}%</span>
                        <span class="material-symbols-outlined flex whitespace-nowrap text-sm">north</span>
                    </div>
                @else
                    <div class="flex items-center justify-end flex-1 text-base font-medium text-red-500 dark:text-red-400">
                        <span>{{ $percentSales }}%</span>
                        <span class="material-symbols-outlined flex whitespace-nowrap text-sm">south</span>
                    </div>
                @endif
            </div>
            <div style="min-height: 385px;">
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
        {{-- Data Transaksi Bulan Ini --}}
        <div class="p-4 border border-gray-200 bg-white rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                Transaksi Bulan Ini
                <button data-tooltip-target="statistic" data-tooltip-placement="right" type="button" class="items-center">
                    <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div id="statistic" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Transaksi yang terjadi pada bulan ini
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </h3>

            <div class="relative border border-gray-200 rounded-lg">
                <div class="overflow-y-auto max-h-[420px]">
                    <table class="w-full text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <thead class="sticky top-0 bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3">Jenis Transaksi</th>
                                <th scope="col" class="px-6 py-3">Paket Penjualan</th>
                                <th scope="col" class="px-6 py-3">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataTransaksi as $item)
                                <tr class="bg-white border-b border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-3">{{ $item->jenis_transaksi }}</td>
                                    <td class="px-6 py-3 break-words whitespace-normal max-w-xs">
                                        {{ $item->paket_penjualan }}
                                    </td>
                                    <td class="px-6 py-3">{{ $item->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="border px-6 py-3 text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="grid gap-4 xl:grid-cols-3 mt-6">
        <div class="p-4 border border-gray-200 bg-white rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
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
                        @foreach ($listBelanja as $belanja)
                            <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <th class="px-6 py-2">
                                    N.{{ $belanja->id }}
                                </th>
                                <td class="px-6 py-2">
                                    {{ $belanja->supplier->nama_perusahaan }}
                                </td>
                                <td class="px-6 py-2">
                                    <span class="bg-{{ ($belanja->status == 'InRD') ? 'green' : 'orange' }}-400 rounded-md px-2 py-0 text-white">{{ $belanja->status }}</span>
                                </td>
                            </tr>
                        @endforeach
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
        <div class="p-4 border border-gray-200 bg-white rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
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
                        @foreach ($produkPromo as $promo)
                            <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <th class="px-6 py-2">
                                    {{ $promo->subjenis->paket_penjualan }}
                                </th>
                                <td class="px-6 py-2">
                                    Rp. {{ number_format($promo->harga_promo, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-2">
                                    <span class="bg-red-500 text-white font-medium me-2 px-2.5 py-0.5 rounded-full">{{ $promo->status }}</span>
                                </td>
                            </tr>
                        @endforeach
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
        <div class="p-4 border border-gray-200 bg-white rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
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
                        @foreach ($listTransaksi as $transaksi)
                            <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <th class="px-6 py-2">
                                    K-{{ $transaksi->created_at->format('Ymd') }}{{ $transaksi->id }}
                                </th>
                                <td class="px-6 py-2">
                                    {{ $transaksi->customer->first_name }} {{ $transaksi->customer->last_name }}
                                </td>
                                <td class="px-6 py-2">
                                    Rp. {{ number_format($transaksi->total_transaksi, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
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

    <script>
        const thisWeekData = @json($thisWeek);
        const lastWeekData = @json($lastWeek);
    </script>
@endsection
