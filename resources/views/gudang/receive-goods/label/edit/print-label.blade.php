@extends('gudang.layouts.main')

@section('container')
    <nav class="flex justify-between items-center my-6">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route('list-label') }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined w-5 h-5">bookmark</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Identifikasi Barang</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Print Label</span>
                </div>
            </li>
        </ol>
        <div class="flex items-center">
            <button onclick="window.print()" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">
                <span class="material-symbols-outlined">print</span>
                <span class="ml-2"> Print</span>
            </button>
            {{-- <a href="{{ route('pdf-label-gudang', ['idBelanja' => $idBelanja, 'idProduk' => $idProduk]) }}" target="_blank" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">
                <span class="material-symbols-outlined">print</span>
                <span class="ml-2"> Print</span>
            </a> --}}
        </div>
    </nav>

    <div class="pt-4 border-t-2 my-4"></div>

    <div id="print-label-container" class="flex flex-wrap gap-4 items-center justify-center font-bold">
        @foreach ($dataLabel as $item)
            @if ($item->qualityControll->status_validasi == 'Pass')
                @php
                    $sku = $item->gudangProduk->produkSparepart->produkType->code . "." . $item->gudangProduk->produkSparepart->partModel->code . "." . 
                            $item->gudangProduk->produkSparepart->produk_jenis_id . "." . $item->gudangProduk->produkSparepart->partBagian->code . "." . 
                            $item->gudangProduk->produkSparepart->partSubBagian->code . "." . $item->gudangProduk->produkSparepart->produk_part_sifat_id;
                    $idItem = "N." . $item->gudang_belanja_id . "." . $item->gudangBelanja->gudang_supplier_id . "." . $item->id;
                    $forQrCode = $sku . " - " . $idItem;
                @endphp
                <div id="print-label-{{ $item->id }}" class="w-full max-w-md border rounded-md shadow-md p-2">
                    <div class="flex p-2 border-b border-black justify-between">
                        <div class="justify-start">
                            <div class="flex items-center space-x-2">
                                <h3>{{ $item->gudangProduk->produkSparepart->ProdukJenis->jenis_produk }}</h3>
                            </div>
                        </div>
                        <div class="justify-end">
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('/img/Logo Rumah Drone Black.png') }}" alt="Rumahdrone Logo" class="h-6">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-4" style="grid-template-columns: 5fr 1fr">
                        <div class="flex flex-col space-y-1">
                            <div>
                                <p>{{ $item->gudangProduk->produkSparepart->nama_internal }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="text-sm">
                                    <label>SKU :</label>
                                </div>
                                <div class="text-sm">
                                    <label>{{ $idItem }}</label>
                                </div>
                            </div>
                            <div>
                                <p>{{ $sku }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end pr-4">
                            <div class="h-16 w-16 flex items-center justify-center">
                                {!! QrCode::size(200)->generate($forQrCode) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

@endsection