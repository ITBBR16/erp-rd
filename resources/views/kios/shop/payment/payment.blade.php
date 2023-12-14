@extends('kios.layouts.main')

@section('container')
    <div class="flex text-3xl font-bold mb-8 text-gray-700 border-b border-gray-400 py-3 dark:text-gray-300">
        <span>Pembayaran</span>
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
    <div class="flex flex-nowrap relative overflow-x-auto">
        <div class="flex flex-row justify-between w-full">
            <div class="flex flex-row gap-6">
                <div class="relative">
                    <button type="button" class="text-rose-600 border border-rose-600 hover:text-white hover:bg-rose-700 focus:ring-4 focus:outline-none focus:ring-rose-400 font-medium rounded-xl text-base py-1.5 px-5 text-center">Belum Terbayar</button>
                </div>
                <div class="relative">
                    <button type="button" class="text-rose-600 border border-rose-600 hover:text-white hover:bg-rose-700 focus:ring-4 focus:outline-none focus:ring-rose-400 font-medium rounded-xl text-base py-1.5 px-5 text-center">Sudah Terbayar</button>
                </div>
            </div>
            <div class="flex flex-row gap-6">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search. . .">
                </div>
                <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input type="text" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="relative">
                    <button type="button" class="p-2 text-blue-700 border border-blue-700 hover:text-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-400 font-medium rounded-lg text-sm py-2.5 px-5 text-center dark:border-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Add Payment</button>
                </div>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto mt-6">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Order ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Invoice
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Pembayaran
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nominal
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
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-2">
                        K.666
                    </th>
                    <td class="px-6 py-2">
                        INV/20230908/MPL/3446962446
                    </td>
                    <td class="px-6 py-2">
                        Pembelian Produk Baru
                    </td>
                    <td class="px-6 py-2">
                        Rp. 5.407.200
                    </td>
                    <td class="px-6 py-2">
                        <span class="bg-orange-400 rounded-md px-2 py-0 text-white">Unpaid</span>
                    </td>
                    <td class="px-6 py-2">
                        <div class="flex flex-wrap">
                            <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">visibility</i>
                            </button>
                            <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">edit</i>
                            </button>
                            <button type="button" data-modal-target="delete-belanja" data-modal-toggle="delete-belanja" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mt-4 ">
            {{-- {{ $dataCustomer->links() }} --}}
        </div>
    </div>

@endsection
