@extends('kios.layouts.main')

@section('container')

    <nav class="flex">
        <ol class="inline-flex items-center mt-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("list-product.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">helicopter</span>
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

    <form action="{{ route('updateProdukBaru') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-2 gap-6 mt-6">
            {{-- Box Data Produk --}}
            <div class="flex gap-6 mx-auto">
                <div class="border bg-white shadow-lg p-4 rounded-lg h-fit">
                    <div class="mb-4 pb-2">
                        <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Product : </h3>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Kompatibel Jenis Produk :</label>
                        <div class="flex flex-wrap border rounded-lg items-center w-full h-20 border-gray-300 mb-6 gap-3 p-2 text-sm overflow-y-auto">
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
                    <div class="flex justify-end">
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
            </div>
    
            {{-- Box Kelengkapan --}}
            <div class="border bg-white shadow-lg p-4 rounded-lg h-fit">
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Kelengkapan : </h3>
                </div>
    
                @foreach ($dataProduk->subjenis->kelengkapans as $item)
                    <div id="container-data-kelengkapan-produk-baru-{{ $item->id }}" class="container-data-kelengkapan-produk-baru grid grid-cols-3 gap-4 mb-4" style="grid-template-columns: 5fr 2fr 1fr">
                        <div class="relative w-full">
                            <select name="edit_kelengkapan_produk_baru[]" id="edit-kelengkapan-produk-baru" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                                <option value="" hidden>Kelengkapan Produk</option>
                                @foreach ($dataProduk->subjenis->produkjenis as $produkKelengkapan)
                                    @foreach ($produkKelengkapan->kelengkapans as $itemKelengkapan)
                                        <option value="{{ $itemKelengkapan->id }}" {{ ($item->id == $itemKelengkapan->id) ? 'selected' : '' }}>{{ $itemKelengkapan->kelengkapan }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="relative z-0 w-full">
                            <input type="text" name="edit_quantity_produk_baru[]" id="edit-quantity-produk-baru-{{ $item->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $item->pivot->quantity }}" oninput="this.value = this.value.replace(/\D/g, '')" required>
                            <label for="edit-quantity-produk-baru-{{ $item->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                        </div>
                        <div class="flex justify-center items-center">
                            <button type="button" class="remove-edit-kelengkapan-produk-baru" data-id="{{ $item->id }}">
                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-between mb-4 text-rose-600">
                    <div class="flex cursor-pointer mt-4 hover:text-red-400">
                        <button type="button" id="add-edit-kelengkapan-produk-baru" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span class="">Tambah Kelengkapan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection