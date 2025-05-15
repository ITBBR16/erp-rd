@extends('kios.layouts.main')

@section('container')

    <nav class="flex">
        <ol class="inline-flex items-center mt-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("list-product-second.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">helicopter</span>
                    List Produk Second
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Ubah Data Produk {{ $produkSecond->subjenis->paket_penjualan }} {{ $produkSecond->id }}</span>
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

    <form action="{{ route('list-product-second.update', $produkSecond->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-3 gap-6 mt-6">

            <div class="col-span-2 flex flex-col gap-6 h-fit">
                <div class="border bg-white shadow-lg p-4 rounded-lg">
                    <div class="flex mb-4 items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">Form Data Paket Penjualan</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div>
                            <div x-data="dropdownPaketPenjualanSecond('{{ $produkSecond->subjenis->id }}', '{{ $produkSecond->subjenis->paket_penjualan }}')" class="relative text-start">
                                <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Paket Penjualan :</label>
                                <div class="relative">
                                    <input x-model="search" 
                                        @focus="open = true" 
                                        @keydown.escape="open = false" 
                                        @click.outside="open = false"
                                        type="text" 
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Search or select varian product...">
                                        <svg :class="{ 'rotate-180': open }" class="absolute inset-y-0 right-2 top-2.5 w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    <input type="hidden" name="paket_penjualan_produk_second" :value="selected" required>
                                </div>
        
                                <ul x-show="open" 
                                    x-transition 
                                    class="absolute z-30 bg-white border border-gray-300 rounded-lg mt-1 max-h-60 w-full overflow-y-auto shadow-md dark:bg-gray-700 dark:border-gray-600">
                                    <template x-for="varian in filteredVarians" :key="varian.id">
                                        <li @click="select(varian.id, varian.display)" 
                                            class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white">
                                            <span x-text="varian.display" class="text-black dark:text-white"></span>
                                        </li>
                                    </template>
                                    <li 
                                        x-show="filteredVarians.length === 0" 
                                        class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                        Data paket penjualan tidak ditemukan.
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <label for="edit-cc-produk-second" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">CC Produk</label>
                            <input type="text" name="edit_cc_produk_second" id="edit-cc-produk-second" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CC Produk" value="{{ $produkSecond->cc_produk_second }}" oninput="this.value = this.value.replace(/\D/g, '')">
                        </div>

                        <div>
                            <label for="serial-number-second" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Serial Number :</label>
                            <input type="text" name="edit_serial_number_second" id="serial-number-second" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="SN123456QWERT" value="{{ $produkSecond->serial_number }}" required>
                        </div>

                        <div>
                            <label for="garansi-produk-second" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Garansi Produk :</label>
                            <div class="flex">
                                <input type="text" name="garansi_produk_second" id="garansi-produk-second" class="rounded-none rounded-l-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="6" value="{{ $produkSecond->garansi ?? '' }}" oninput="this.value = this.value.replace(/\D/g, '')" required>
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-l border-gray-300 rounded-r-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Bulan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border bg-white shadow-lg p-4 rounded-lg">
                    <div class="flex mb-4 items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">Form Kelengkapan</p>
                        </div>
                    </div>

                    <div id="container-edit-kelengkapan-second">
                        @foreach ($produkSecond->kelengkapanSeconds as $index => $item)
                            <div id="form-edit-kelengkapan-second-{{ $index }}" class="form-edit-kelengkapan-second grid grid-cols-7 gap-4 mb-4 md:gap-6">
                                <div class="relative z-0 col-span-2 w-full group">
                                    <label for="select-edit-kelengkapan-second-{{ $index }}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Kelengkapan Produk :</label>
                                    <select name="kelengkapan_second[]" id="select-edit-kelengkapan-second-{{ $index }}" data-id="{{ $index }}" class="select-edit-kelengkapan-second bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih Kelengkapan Produk</option>
                                        @foreach ($kelengkapanSecond as $option)
                                            <option value="{{ $option->produk_kelengkapan_id }}" {{ ($option->produk_kelengkapan_id == $item->id) ? 'selected' : '' }}>{{ $option->kelengkapans->kelengkapan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="relative z-0 col-span-2 w-full group">
                                    <label for="edit-sn-second-{{ $index }}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Serial Number :</label>
                                    <select name="sn_second[]" id="edit-sn-second-{{ $index }}" data-id="{{ $index }}" class="edit-sn-second bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih Serial Number</option>
                                        <option value="{{ $item->pivot->pivot_qc_id }}" selected>{{ $item->pivot->serial_number }}</option>
                                    </select>
                                </div>
                                <div class="relative z-0 col-span-2 w-full group items-center">
                                    <label for="edit-harga-satuan-{{ $index }}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Harga Satuan :</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                        <input type="text" name="harga_satuan_second[]" id="edit-harga-satuan-{{ $index }}" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($item->pivot->harga_satuan, 0, ',', '.') }}" readonly>
                                    </div>
                                </div>
                                <div class="flex col-span-1 justify-center items-center">
                                    <button type="button" class="remove-edit-kelengkapan-second" data-id="{{ $index }}">
                                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Button tambah kelengkapan --}}
                    <div class=" flex justify-between text-rose-600">
                        <div class="flex cursor-pointer mt-4 hover:text-red-400">
                            <button type="button" id="add-edit-kelengkapan-second" class="flex flex-row justify-between gap-2">
                                <span class="material-symbols-outlined">add_circle</span>
                                <span class="">Tambah Kelengkapan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Harga Jual --}}
            <div class="sticky top-16 flex flex-col gap-6 w-fit h-fit mx-auto">
                <div class="border bg-white shadow-lg p-4 rounded-lg">
                    <div class="flex mb-4 items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">Form Harga Jual</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mb-4 gap-x-4">
                        <div class="flex justify-start">
                            <label for="edit-modal-awal-second" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Modal :</label>
                        </div>
                        <div class="justify-end ml-auto">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="modal_awal_second" id="edit-modal-awal-second" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($produkSecond->modal_bekas, 0, ',', '.') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mb-4 gap-x-4">
                        <div class="flex justify-start">
                            <label for="edit-harga-jual-second" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Penjualan :</label>
                        </div>
                        <div class="justify-end ml-auto">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="harga_jual_second" id="edit-harga-jual-second" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($produkSecond->srp, 0, ',', '.') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" id="edit-data-produk-second" class="submit-button-form cursor-not-allowed text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-bold rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800 w-full" disabled>Submit</button>
                    <div class="loader-button-form" style="display: none">
                        <button class="cursor-not-allowed text-white border border-purple-700 bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-purple-500 dark:text-white dark:bg-purple-500 dark:focus:ring-purple-800 w-full" disabled>
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

    <script>
        function dropdownPaketPenjualanSecond(selectedId = null, selectedDisplay = '') {
            return {
                open: false,
                search: selectedDisplay,
                selected: selectedId,
                varians: Object.values(@json($kiosproduks)),
                filteredVarians: [],
                debounceSearch: null,
                init() {
                    if (!Array.isArray(this.varians)) {
                        this.varians = [];
                    }
                    this.filteredVarians = this.varians;

                    if (this.selected && !this.search) {
                        const found = this.varians.find(varian => varian.id == this.selected);
                        if (found) {
                            this.search = found.display;
                        }
                    }

                    this.$watch('search', (value) => {
                        clearTimeout(this.debounceSearch);
                        this.debounceSearch = setTimeout(() => {
                            this.filteredVarians = this.varians.filter(varian =>
                                varian.display.toLowerCase().includes(value.toLowerCase())
                            );
                        }, 300);
                    });
                },
                select(id, display) {
                    this.selected = id;
                    this.search = display;
                    this.open = false;
                }
            }
        }
    </script>

@endsection