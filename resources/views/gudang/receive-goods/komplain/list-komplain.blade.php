@extends('gudang.layouts.main')

@section('container')
    <div class="grid grid-cols-2 gap-8 mb-8 border-b border-gray-400 py-3">
        <div class="flex text-3xl font-bold text-gray-700 dark:text-gray-300">
            List Label Sparepart
        </div>
    </div>

    @if (session()->has('success'))
        <div id="alert-success-input" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
            <span class="material-symbols-outlined flex-shrink-0 w-4 h-4">task_alt</span>
            <div class="ml-3 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-success-input" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            </button>
        </div>
    @endif

    <div class="relative overflow-x-auto">
        <div class="flex items-center justify-between py-4">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="list-case-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search. . .">
            </div>
        </div>
    </div>

    <div class="relative">
        <div class="overflow-y-auto max-h-[580px]">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Order ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            SKU
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Produk
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $groupedItems = $listKomplain->filter(function ($item) {
                            return $item->qualityControll !== null;
                        })->groupBy(function ($item) {
                            return $item->gudang_belanja_id . '-' . $item->gudang_produk_id;
                        });
                    @endphp
    
                    @foreach ($groupedItems as $items)
                        @php
                            $qc = $items->first();
                            $quantityCount = $items->count();
                        @endphp

                        @if ($qc->qualityControll->status_validasi == 'Komplain')
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <th class="px-6 py-2">
                                    N.{{ $qc->gudang_belanja_id }}
                                </th>
                                <td class="px-6 py-2">
                                    @php
                                        $sku = $qc->gudangProduk->produkSparepart->produkType->code . "." . $qc->gudangProduk->produkSparepart->partModel->code . "." . 
                                                $qc->gudangProduk->produkSparepart->produk_jenis_id . "." . $qc->gudangProduk->produkSparepart->partBagian->code . "." . 
                                                $qc->gudangProduk->produkSparepart->partSubBagian->code . "." . $qc->gudangProduk->produkSparepart->produk_part_sifat_id . "." .
                                                $qc->gudangProduk->produkSparepart->id;
                                    @endphp
                                    {{ $sku }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $qc->gudangProduk->produkSparepart->nama_internal }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $quantityCount }}
                                </td>
                                <td class="px-6 py-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $qc->qualityControll->status_validasi }}</span>
                                </td>
                                <td class="px-6 py-2">
                                    <button id="dropdownKomplain{{ $qc->id }}{{ $qc->produk_gudang_id }}" data-dropdown-toggle="ddKomplain{{ $qc->id }}{{ $qc->produk_gudang_id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">
                                        Atur
                                        <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <!-- Dropdown menu -->
                            <div id="ddKomplain{{ $qc->id }}{{ $qc->produk_gudang_id }}" class="z-10 hidden bg-white rounded-lg shadow w-40 dark:bg-gray-700">
                                <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownKomplain{{ $qc->id }}{{ $qc->produk_gudang_id }}">
                                    <li>
                                        <a href="#" target="_blank" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                            <i class="material-symbols-outlined text-xl mr-3">sms</i>
                                            <span class="whitespace-nowrap">Komplain</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection