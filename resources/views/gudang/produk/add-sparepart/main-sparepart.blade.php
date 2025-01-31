@extends('gudang.layouts.main')

@section('container')
    <div class="my-4 border-b-2 border-gray-400 pb-2">
        <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Form Tambah Sparepart</h3>
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

    {{-- <div class="col-span-1 p-4 border rounded-lg shadow-md">
        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Panduan Pembuatan Sparepart Baru :</h2>
        <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
            <li class="flex items-center">
                <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                Panduan satu
            </li>
            <li class="flex items-center">
                <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                Panduan dua
            </li>
        </ul>
    </div> --}}

    <form action="{{ route('add-sparepart.store') }}" method="POST" autocomplete="off">
        @csrf
        <div id="container-form-add-sparepart" class="space-y-3">
            <div id="form-add-sparepart" class="grid grid-cols-[repeat(7,3fr)_repeat(2,5fr)_1fr] gap-4">
                <div>
                    <label for="type-part-1" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Type Part :</label>
                    <select name="type_part[]" id="type-part-1" class="type-part bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Type Part</option>
                        @foreach ($typePart as $item)
                            <option value="{{ $item->id }}">{{ $item->type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="model-part" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Model Part :</label>
                    <select name="model_part[]" id="model-part" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Model Part</option>
                        @foreach ($modelPart as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="jenis-produk" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Produk :</label>
                    <select name="jenis_produk[]" id="jenis-produk" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Produk</option>
                        @foreach ($jenisProduk as $item)
                            <option value="{{ $item->id }}">{{ $item->jenis_produk }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="bagian-part" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Bagian Part :</label>
                    <select name="bagian_part[]" id="bagian-part" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Bagian Part</option>
                        @foreach ($bagianPart as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="sub-bagian-part" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sub Bagian Part :</label>
                    <select name="sub_bagian_part[]" id="sub-bagian-part" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Sub Bagian Part</option>
                        @foreach ($subBagianPart as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="sifat-part" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sifat Part :</label>
                    <select name="sifat_part[]" id="sifat-part" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Sifat Part</option>
                        @foreach ($sifatPart as $item)
                            <option value="{{ $item->id }}">{{ $item->sifat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="sku-external" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">SKU Eksternal : </label>
                    <input type="text" name="sku_external[]" id="sku-external" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="SKU External">
                </div>
                <div>
                    <label for="nama-eksternal" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Eksternal : </label>
                    <input type="text" name="nama_eksternal[]" id="nama-eksternal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama External">
                </div>
                <div>
                    <label for="nama-internal" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Internal : </label>
                    <input type="text" name="nama_internal[]" id="nama-internal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Internal" required>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 mt-4">
            <div class="flex justify-start text-red-500 mt-6">
                <div class="flex cursor-pointer my-2 hover:text-rose-700">
                    <button type="button" id="tambah-sparerpart-baru" class="flex flex-row justify-between gap-2">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span>Tambah Sparepart</span>
                    </button>
                </div>
            </div>
            <div class="mt-6 text-end">
                <button type="submit" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                <div class="loader-button-form" style="display: none">
                    <button class="cursor-not-allowed text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                        </svg>
                        Loading . . .
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        let typePart = @json($typePart);
        let modelPart = @json($modelPart);
        let jenisProduk = @json($jenisProduk);
        let bagianPart = @json($bagianPart);
        let subBagianPart = @json($subBagianPart);
        let sifatPart = @json($sifatPart);
    </script>
    
@endsection