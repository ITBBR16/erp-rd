@extends('kios.layouts.main')

@section('container')
    <div class="flex flex-row justify-between items-center border-b border-gray-400 py-3">
        <div class="font-semibold mr-4 text-xl text-gray-700 dark:text-gray-300">Upload File</div>
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

    <form action="#" method="POST" autocomplete="off" class="mt-6">
        @csrf
        <div class="w-10/12">
            <div class="grid grid-cols-2 gap-4 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="nama_product"></label>
                    <select name="nama_product" id="nama_product" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama_product') border-red-600 dark:border-red-500 @enderror">
                        <option hidden>Jenis Produk</option>
                        <option value="" class="dark:bg-gray-700">DJI MAVIC MINI</option>
                        <option value="" class="dark:bg-gray-700">DJI MINI 2</option>
                        <option value="" class="dark:bg-gray-700">DJI MINI 3 PRO</option>
                        <option value="" class="dark:bg-gray-700">DJI MAVIC PRO</option>
                    </select>
                    @error('nama_product')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="paket_penjualan"></label>
                    <select name="paket_penjualan" id="paket_penjualan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('paket_penjualan') border-red-600 dark:border-red-500 @enderror">
                        <option hidden>Paket Penjualan</option>
                        <option value="" class="dark:bg-gray-700">DJI MAVIC PRO BASIC</option>
                        <option value="" class="dark:bg-gray-700">DJI MAVIC 2 PRO BASIC</option>
                        <option value="" class="dark:bg-gray-700">DJI MAVIC AIR 2 FLY MORE COMBO</option>
                        <option value="" class="dark:bg-gray-700">DJI MINI 2 FLY MORE COMBO</option>
                    </select>
                    @error('paket_penjualan')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="my-4 border-b-2 border-gray-400 pb-2">
                <h3 class="text-gray-900 dark:text-white font-semibold text-xl">Foto Kelengkapan</h3>
            </div>
            <div class="mt-5 space-y-6">
                <div class="grid grid-cols-2 gap-4 md:gap-6">
                    <div class="flex items-center">
                        <input id="kelengkapan-cb1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="kelengkapan-cb1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">DJI Mavic 3</label>
                    </div>
                    <div class="relative z-0 w-full items-center">
                        <input type="file" id="small_size" class="block w-full text-xs text-gray-900 rounded-lg cursor-pointer dark:text-gray-400 focus:outline-none dark:placeholder-gray-400">
                        @error('quantity')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 md:gap-6">
                    <div class="flex items-center">
                        <input id="kelengkapan-cb2" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="kelengkapan-cb2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Charger Adapter</label>
                    </div>
                    <div class="relative z-0 w-full items-center">
                        <input type="file" id="small_size" class="block w-full text-xs text-gray-900 rounded-lg cursor-pointer dark:text-gray-400 focus:outline-none dark:placeholder-gray-400">
                        @error('quantity')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
            </div>
        </div>
        {{-- <div class="flex flex-row justify-between text-rose-600 hover:text-red-400">
            <div class="flex gap-3 cursor-pointer mt-4">
                <button type="button">
                    <span class="material-symbols-outlined">add_circle</span>
                </button>
                <span>Tambah Kelengkapan</span>
            </div>
        </div> --}}
        
    </form>

@endsection
