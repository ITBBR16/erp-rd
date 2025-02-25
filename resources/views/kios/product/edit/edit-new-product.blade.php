@extends('kios.layouts.main')

@section('container')

    <nav class="flex">
        <ol class="inline-flex items-center mt-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("list-product.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">list_alt</span>
                    List Produk Baru
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Ubah Data Produk {{ $dataProduk->subjenis->paket_penjualan }} </span>
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

    <div class="grid grid-cols-2 gap-6 mt-6">
        <div class="flex flex-col gap-6 mx-auto">
            <div class="border bg-white shadow-lg p-4 rounded-lg h-fit">
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Product : </h3>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Kompatibel Jenis Produk :</label>
                    <div class="flex flex-wrap border rounded-lg items-center w-full h-40 border-gray-300 mb-6 gap-3 p-2 text-sm overflow-y-auto">
                        @foreach ($dataProduk->subjenis->produkjenis as $item)
                            <div class="flex items-center text-gray-800 border-gray-300 bg-transparent dark:text-white dark:border-gray-800">
                                <div class="text-sm">
                                    <input type="hidden" name="edit_jenis_produk_baru[]" id="selected-jenis" value="{{ $item->id }}">
                                    <input type="hidden" id="selected-text-jenis" value="{{ $item->jenis_produk }}">
                                    <input type="hidden" id="selected-id-jenis" value="{{ $item->id }}">
                                    {{ $item->jenis_produk }}
                                </div>
                                <button type="button" data-id="{{ $item->id }}" class="button-delete-selected-jenis ml-auto -mx-1.5 -my-1.5 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-7 w-7 bg-transparent dark:text-gray-400 dark:hover:bg-gray-700" aria-label="Close">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="grid grid-cols-2 mb-4 gap-4">
                    <div class="relative w-full mb-6 group">
                        <select id="edit-jenis-produk-baru" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                            <option value="" hidden>Jenis Produk</option>
                            @foreach ($jenisproduks as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->jenis_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        {{-- <input type="hidden" name="edit_paket_penjualan_produk_baru_id" id="edit-pppb-id" value="{{ $produk->sub_jenis_id }}"> --}}
                        <input type="text" name="edit_paket_penjualan_produk_baru" id="edit-paket-penjualan-baru" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $dataProduk->subjenis->paket_penjualan }}" required>
                        <label for="edit-paket-penjualan-baru" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Paket Penjualan</label>
                    </div>
                    <div class="relative z-0 w-full group">
                        <input type="text" name="berat_edit_produk_baru" id="edit-berat-produk-baru" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $dataProduk->subjenis->berat }}" oninput="this.value = this.value.replace(/\D/g, '')" required>
                        <label for="edit-berat-produk-baru" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Berat Produk</label>
                        <span class="absolute bottom-8 end-0 font-bold text-gray-500 dark:text-gray-400">g</span>
                    </div>
                    <div class="flex flex-row border rounded-lg items-center w-full border-gray-300 mb-6 dark:border-gray-400">
                        <label class="absolute ml-2 mt-1 -translate-y-6 text-xs font-medium text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-700">Dimensions (P x L x T)</label>
                        <input type="text" name="length" placeholder="0" class="input-field py-2.5 mr-1 px-3 w-full text-sm text-gray-900 bg-transparent border-none focus:outline-none focus:border-transparent focus:ring-0 dark:text-white" value="{{ $dataProduk->subjenis->panjang }}" oninput="this.value = this.value.replace(/\D/g, '')">
                        <div class="text-black items-center">
                            <span class="material-symbols-outlined text-base dark:text-gray-400">close</span>
                        </div>
                        <input type="text" name="width" placeholder="0" class="input-field py-2.5 mx-1 px-3 w-full text-sm text-gray-900 bg-transparent border-none focus:outline-none focus:border-transparent focus:ring-0 dark:text-white" value="{{ $dataProduk->subjenis->lebar }}" oninput="this.value = this.value.replace(/\D/g, '')">
                        <div class="text-black items-center">
                            <span class="material-symbols-outlined text-base dark:text-gray-400">close</span>
                        </div>
                        <input type="text" name="height" placeholder="0" class="input-field py-2.5 mx-1 px-3 w-full text-sm text-gray-900 bg-transparent border-none focus:outline-none focus:border-transparent focus:ring-0 dark:text-white" value="{{ $dataProduk->subjenis->tinggi }}" oninput="this.value = this.value.replace(/\D/g, '')">
                        <span class="inline-flex items-center px-3 text-base font-semibold rounded-r-lg text-gray-900 bg-gray-100 border-l border-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-600 grow h-full">Cm</span>
                    </div>
                </div>
            </div>
            <div class="border bg-white shadow-lg p-4 rounded-lg h-fit">
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Kelengkapan : </h3>
                </div>
                <div class="grid grid-cols-3 gap-4" style="grid-template-columns: 5fr 2fr 1fr">
                    @foreach ($dataProduk->subjenis->kelengkapans as $item)
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="hidden" name="edit_kelengkapan[]" value="{{ $item->id }}">
                            <input type="text" id="edit-kelengkapan-{{ $item->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $item->kelengkapan }}" required>
                            <label for="edit-kelengkapan-{{ $item->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kelengkapan</label>
                        </div>
                        <div class="relative w-full">
                            <input type="text" name="edit_quantity_produk_baru[]" id="edit-quantity-produk-baru-{{ $item->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $item->pivot->quantity }}" oninput="this.value = this.value.replace(/\D/g, '')" required>
                            <label for="edit-quantity-produk-baru-{{ $item->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Kelengkapan</label>
                        </div>
                        <div class="flex justify-center items-center">
                            <button type="button" class="remove-edit-kelengkapan-produk-baru" data-id="{{ $item->id }}">
                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="border bg-white shadow-lg p-4 rounded-lg h-fit">
            <div class="mb-4 pb-2">
                <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Files : </h3>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-4 md:gap-6">
                <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">File Utama Produk :</label>
                <div class="flex items-center justify-center w-full">
                    <label for="edit-file-paket-produk" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div id="default-img-edit-paket" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 w text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG or JPG</p>
                        </div>
                        <div id="selected-img-paktet" class="flex flex-col items-center justify-center pt-5 pb-6" style="display: none"></div>
                        <input name="file_paket_produk" id="edit-file-paket-produk" type="file" class="hidden files-paket-penjualan">
                    </label>
                </div>
                <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Files Kelengkapan :</label>
                <div class="flex items-center justify-center w-full">
                    <label for="edit-file-kelengkapan" class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div id="default-img-edit-kelengkapan" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG or JPG</p>
                        </div>
                        <div id="selected-img-kelengkapan" class="flex flex-wrap justify-evenly" style="display: none"></div>
                        <input name="file_kelengkapan_produk[]" id="edit-file-kelengkapan" type="file" class="hidden files-kelengkapan-produk" multiple>
                    </label>
                </div>
            </div>
        </div>
    </div>

@endsection