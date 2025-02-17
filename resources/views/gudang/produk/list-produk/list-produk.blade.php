@extends('gudang.layouts.main')

@section('container')
    <div class="grid grid-cols-2 gap-8 mb-8 border-b border-gray-400 py-3">
        <div class="flex text-3xl font-bold text-gray-700 dark:text-gray-300">
            List Sparepart Gudang
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

    @if (session()->has('error'))
        <div id="alert-failed-input" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
            <span class="material-symbols-outlined flex-shrink-0 w-5 h-5">info</span>
            <div class="ml-3 text-sm font-medium">
                {{ session('error') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-failed-input" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <div class="relative overflow-x-auto mt-6">
        <div class="flex items-center justify-between py-4">
            <div class="flex flex-row gap-6">
                <label for="search-list-produk-gudang" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="search-list-produk-gudang" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search. . .">
                </div>
            </div>
        </div>
    </div>

    <div class="relative mt-2">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs sticky text-gray-700 uppercase tracking-wider bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3" style="width: 14%;">
                        SKU
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 30%;">
                        Nama Sparepart
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 10%;">
                        Stok
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 13%;">
                        Harga Internal
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 13%;">
                        Harga Global
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 10%;">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 10%;">
                        Action
                    </th>
                </tr>
            </thead>
        </table>
        <!-- Scrollable body -->
        <div class="overflow-y-auto max-h-[550px]">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <tbody>
                    @foreach ($dataProduk as $produk)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600 customer-row">
                            <td class="px-6 py-2">
                                @php
                                    $sku = $produk->produkSparepart->produkType->code . "." . $produk->produkSparepart->partModel->code . "." . 
                                            $produk->produkSparepart->produkJenis->code . "." . $produk->produkSparepart->partBagian->code . "." . 
                                            $produk->produkSparepart->partSubBagian->code . "." . $produk->produkSparepart->produk_part_sifat_id;
                                @endphp
                                {{ $sku }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $produk->produkSparepart->nama_internal }}
                            </td>
                            <td class="px-6 py-2">
                                @php
                                    $stock = $produk->gudangIdItem->where('status_inventory', 'Ready')->count()
                                @endphp
                                {{ $stock }}
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 text-base font-bold text-gray-700 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-300 dark:border-gray-600">RP</span>
                                    <input type="text" id="harga-internal-{{ $produk->id }}" data-id="{{ $produk->id }}" class="format-angka-rupiah harga-internal rounded-none rounded-e-lg bg-gray-50 border text-base text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-12 border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($produk->harga_internal, 0, ',', '.') }}">
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 text-base font-bold text-gray-700 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-300 dark:border-gray-600">RP</span>
                                    <input type="text" id="harga-global-{{ $produk->id }}" data-id="{{ $produk->id }}" class="format-angka-rupiah harga-global rounded-none rounded-e-lg bg-gray-50 border text-base text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-12 border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($produk->harga_global, 0, ',', '.') }}">
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                @php
                                    $statusColors = [
                                        'Ready' => 'bg-green-500',
                                        'Promo' => 'bg-red-500',
                                        'Pending' => 'bg-orange-500'
                                    ];
                                @endphp
                                <span class="{{ $statusColors[$produk->status] ?? 'bg-gray-500' }} text-white font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $produk->status }}
                                </span>
                            </td>
                            <td class="px-6 py-2">
                                <button id="dropdownListProduk{{ $produk->id }}" data-dropdown-toggle="dropdownLP{{ $produk->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Dropdown menu -->
                        <div id="dropdownLP{{ $produk->id }}" class="z-10 hidden bg-white rounded-lg shadow w-40 dark:bg-gray-700">
                            <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownListProduk{{ $produk->id }}">
                                <li>
                                    <button type="button" data-modal-target="detail-produk-{{ $produk->id }}" data-modal-toggle="detail-produk-{{ $produk->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">visibility</i>
                                        <span class="whitespace-nowrap">Detail Produk</span>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" data-modal-target="promo-sparepart-{{ $produk->id }}" data-modal-toggle="promo-sparepart-{{ $produk->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">confirmation_number</i>
                                        <span class="whitespace-nowrap">Add Promo</span>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" data-modal-target="disabled-part" data-modal-toggle="disabled-part" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">block</i>
                                        <span class="whitespace-nowrap">Disable</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 ">
            {{ $dataProduk->links() }}
        </div>
    </div>
    

    {{-- Modal --}}
    @include('gudang.produk.list-produk.modal.detail-produk')
    @include('gudang.produk.list-produk.modal.promo-produk')
    @include('gudang.produk.list-produk.modal.disabled')
    
@endsection