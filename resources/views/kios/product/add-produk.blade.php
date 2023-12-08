@extends('kios.layouts.main')

@section('container')
    <div class="flex flex-row justify-between items-center border-b border-gray-400 py-3">
        <div class="flex flex-col my-2 w-2/3">
            <div class="flex flex-row">
                <a href="/kios/product" class="w-5 mr-3">
                    <span class="material-symbols-outlined text-red-500">arrow_back</span>
                </a>
                <div class="font-semibold mr-4 text-xl text-gray-700 dark:text-gray-300">Input Produk Baru</div>
            </div>
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

    <form action="#" method="POST" autocomplete="off" class="mt-6">
        @csrf
        <div class="grid grid-cols-3 gap-4 md:gap-6 w-10/12">
            <div class="relative z-0 w-full mb-6 group">
                <label for="produk_kategori"></label>
                <select name="produk_kategori" id="produk_kategori" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('produk_kategori') border-red-600 dark:border-red-500 @enderror">
                    <option hidden>Kategori Produk</option>
                    <option value="" class="dark:bg-gray-700">Consumer</option>
                    <option value="" class="dark:bg-gray-700">Handheld</option>
                    <option value="" class="dark:bg-gray-700">Enterprise</option>
                    <option value="" class="dark:bg-gray-700">Agriculture</option>
                </select>
                @error('produk_kategori')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="nama_produk" id="nama_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama_produk') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('nama_produk') }}" required>
                <label for="nama_produk" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Produk</label>
                @error('nama_produk')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="jenis_penjualan" id="jenis_penjualan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('jenis_penjualan') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('jenis_penjualan') }}" required>
                <label for="jenis_penjualan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Paket Penjualan</label>
                @error('jenis_penjualan')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="my-4 border-b-2 border-gray-400 w-10/12 pb-2">
            <h3 class="text-gray-900 dark:text-white font-semibold text-xl">Kelengkapan</h3>
        </div>
        <div class="grid grid-cols-3 gap-4 md:gap-6 w-10/12 mt-5">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="nama_kelengkapan" id="nama_kelengkapan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama_kelengkapan') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('nama_kelengkapan') }}" required>
                <label for="nama_kelengkapan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Kelengkapan</label>
                @error('nama_kelengkapan')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="quantity" id="quantity" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('quantity') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('quantity') }}" required>
                <label for="quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Barang</label>
                @error('quantity')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="file" class="block w-full mb-5 text-xs text-gray-900 rounded-lg cursor-pointer dark:text-gray-400 focus:outline-none dark:placeholder-gray-400">
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 md:gap-6 w-10/12">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="nama_kelengkapan" id="nama_kelengkapan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama_kelengkapan') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('nama_kelengkapan') }}" required>
                <label for="nama_kelengkapan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Kelengkapan</label>
                @error('nama_kelengkapan')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="quantity" id="quantity" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('quantity') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('quantity') }}" required>
                <label for="quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Barang</label>
                @error('quantity')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="file" class="block w-full mb-5 text-xs text-gray-900 rounded-lg cursor-pointer dark:text-gray-400 focus:outline-none dark:placeholder-gray-400">
            </div>
        </div>
        <div class="flex flex-row justify-between text-rose-600 hover:text-red-400">
            <div class="flex gap-3 cursor-pointer mt-4">
                <button type="button">
                    <span class="material-symbols-outlined">add_circle</span>
                </button>
                <span>Tambah Kelengkapan</span>
            </div>
        </div>
        {{-- <div class="mt-4 text-end">
            <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
        </div> --}}
    </form>

@endsection
