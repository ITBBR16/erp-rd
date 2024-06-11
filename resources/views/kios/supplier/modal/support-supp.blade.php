@extends('kios.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("supplier.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">account_box</span>
                    List Supplier
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Support {{ $suppliers->nama_perusahaan }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <form action="#" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="relative overflow-x-auto pt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-900 border-b-2 uppercase dark:text-white">
                    <tr>
                        <th scope="col" class="px-4 py-3" style="width: 30%;">
                            Nama Produk
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 25%;">
                            Start - End Promo
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Nominal Promo
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Nominal Support
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 5%;">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="pelunasan-container">
                    <tr id="" class="bg-white dark:bg-gray-800">
                        <td class="px-4 py-4">
                            <select name="nama_produk[]" id="nama_produk" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Select Produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->subjenis->produkjenis->jenis_produk }} {{ $product->subjenis->paket_penjualan }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-4">
                            <div date-rangepicker class="flex items-center">
                                <div class="relative">
                                    <input name="start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Start Date">
                                </div>
                                <span class="mx-4 text-gray-500">to</span>
                                <div class="relative">
                                    <input name="end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="End Date">
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <input type="text" name="nominal_promo[]" id="nominal_promo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp. 0" oninput="this.value = this.value.replace(/\D/g, '')" required>
                        </td>
                        <td class="px-4 py-4">
                            <input type="text" name="nominal_support[]" id="nominal_support" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp. 0" oninput="this.value = this.value.replace(/\D/g, '')" required>
                        </td>
                        <td class="px-4 py-4">
                            <button type="button" class="#" data-id="">
                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-gray-900 dark:text-white">
                        <td class="px-4 py-3">
                            <div class="flex justify-between text-rose-600">
                                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                                    <button type="button" id="" class="flex flex-row justify-between gap-2">
                                        <span class="material-symbols-outlined">add_circle</span>
                                        <span class="">Tambah Item</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </form>

@endsection