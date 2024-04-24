@extends('kios.layouts.main')

@section('container')
    <div class="flex text-3xl font-bold mb-8 text-gray-700 border-b border-gray-400 py-3 dark:text-gray-300">
        <span>Daftar Produk Second</span>
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
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search. . .">
            </div>
        </div>
    </div>
    
    <div class="relative">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3" style="width: 35%;">
                        Paket Penjualan
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 16%">
                        Serial Number
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 5%">
                        CC Produk
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 20%">
                        Harga Jual Produk
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 10%">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 20%">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produkseconds as $key => $pd)
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600 customer-row">
                    <td class="px-6 py-2">
                        {{ $pd->subjenis->produkjenis->jenis_produk }} {{ $pd->subjenis->paket_penjualan }}
                    </td>
                    <td class="px-6 py-2">
                        {{ $pd->serial_number }}
                    </td>
                    <td class="px-6 py-2">
                        {{ $pd->cc_produk_second }}
                    </td>
                    <td class="px-6 py-2">
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-bold text-gray-700 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-300 dark:border-gray-600">RP</span>
                            <input type="text" id="srp-daftar-produk-second-{{ $pd->id }}" data-id="{{ $pd->id }}" class="srp-daftar-produk-second rounded-none rounded-e-lg bg-gray-50 border text-base text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-12 border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($pd->srp, 0, ',', '.') }}">
                        </div>
                    </td>
                    <td class="px-6 py-2">
                        <span class="bg-{{ ($pd->status == 'Ready') ? 'green' : (($pd->status == 'Promo') ? 'red' : 'gray') }}-500 text-white font-medium me-2 px-2.5 py-0.5 rounded-full">{{ $pd->status }}</span>
                    </td>
                    <td class="px-6 py-2">
                        {{-- <div class="flex flex-wrap">
                            <button type="button" data-modal-target="view-detail-produk" data-modal-toggle="view-detail-produk{{ $pd->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">visibility</i>
                            </button>
                            @if (auth()->user()->is_admin === 1 || auth()->user()->is_admin === 2)
                                <button type="button" data-modal-target="update-produk" data-modal-toggle="update-produk{{ $pd->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                    <i class="material-symbols-outlined text-base">edit</i>
                                </button>
                                <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                    <i class="material-symbols-outlined text-base">delete</i>
                                </button>
                            @endif
                        </div> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 ">
            {{-- {{ $dataCustomer->links() }} --}}
        </div>
    </div>

@endsection
