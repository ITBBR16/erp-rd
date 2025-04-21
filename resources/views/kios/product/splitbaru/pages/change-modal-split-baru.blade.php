@extends('kios.layouts.main')

@section('container')
    <nav class="flex mb-6">
        <ol class="inline-flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route('split-produk-baru.index') }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">compare_arrows</span>
                    Split Produk
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Rubah Hasil Split Baru {{ $dataSplit->kiosproduk->subjenis->paket_penjualan }}</span>
                </div>
            </li>
        </ol>
    </nav>

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

    <form action="{{ route('split-produk-baru.update', $dataSplit->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <div class="rounded-lg shadow-md border bg-white p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">
                                List Kelengkapan Produk Baru
                            </p>
                        </div>
                    </div>
                    <div class="relative mt-6">
                        <div class="overflow-y-auto max-h-[540px]">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="sticky top-0 z-10 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" style="width: 50%">
                                            Nama Kelengkapan
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="width: 25%">
                                            Serial Number
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="width: 25%">
                                            Nominal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="container-split-produk-baru">
                                    @php
                                        $totalModalAwal = 0;
                                    @endphp

                                    @foreach ($dataSplit->listKelengkapanSplit as $item)
                                    @php
                                        $totalModalAwal += $item->nominal;
                                        $isOnSell = $item->status === 'On Sell';
                                    @endphp
                                    <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <input type="hidden" name="id_kelengkapan[]" value="{{ $item->id }}">
                                            <input type="text"
                                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 appearance-none dark:text-white focus:outline-none focus:ring-0"
                                                value="{{ $item->kelengkapanProduk->kelengkapan }}" readonly>
                                        </th>
                                        <td class="px-6 py-4">
                                            <input type="text" name="serial_number[]"
                                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                                placeholder="SN123456789"
                                                value="{{ $item->serial_number_split }}"
                                                @if($isOnSell) readonly @endif>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="relative z-0 w-full group flex items-center">
                                                <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                                <input type="text" name="nilai_split[]"
                                                    class="nilai-split-baru split-formated-rupiah block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                    value="{{ number_format($item->nominal, 0, ',', '.') }}"
                                                    @if($isOnSell) readonly @endif required>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-1 flex flex-col gap-6 w-fit h-fit mx-auto">
                <div class="rounded-lg shadow-md border bg-white p-4">
                    <div class="flex mb-4 items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">
                                Detail Produk Baru
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Nilai Modal :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <input type="hidden" name="modal_awal_produk_baru" id="modal-awal-produk-baru" value="{{ $totalModalAwal }}">
                            <p id="modal-awal-split" class="text-gray-900 font-normal dark:text-white">Rp. {{ number_format($totalModalAwal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex justify-start">
                            <p class="font-bold text-lg text-purple-600 dark:text-white">Sisa Nominal :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="sisa-nominal-split-kios" class="text-purple-600 text-lg font-bold dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                </div>
                <div>
                    <button id="btn-split-kios" type="submit" class="submit-button-form cursor-not-allowed text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-bold rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800 w-96 mx-auto" disabled>Submit</button>
                    <div class="loader-button-form" style="display: none">
                        <button class="cursor-not-allowed text-white border border-purple-700 bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-purple-500 dark:text-white dark:bg-purple-500 dark:focus:ring-purple-800 w-96 mx-auto" disabled>
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            Loading . . .
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection