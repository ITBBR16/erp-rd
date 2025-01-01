@extends('kios.layouts.main')

@section('container')
    <nav class="flex mt-6">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route('shop.index') }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">storefront</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Pembelanjaan Produk Baru</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Validasi Belanja Order ID N.{{ $data->id }}</span>
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

    <form action="{{ route('shop.update', $data->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-3 gap-6 pt-6 border-t mt-4">
            {{-- Bagian Kiri --}}
            <div class="col-span-2 mt-4">
                <div class="grid grid-cols-2">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="hidden" name="supplier_id" value="{{ $data->supplier_kios_id }}">
                        <input type="text" name="supplier_kios" id="supplier-kios" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $data->supplier->nama_perusahaan }}" readonly>
                        <label for="supplier-kios" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Supplier</label>
                    </div>
                    <div>
                        
                    </div>
                </div>
                <h3 class="my-3 font-semibold text-gray-900 dark:text-white">Daftar Barang</h3>
                <div id="form-validasi">
                    @php
                        $totalQty = 0;
                    @endphp
                    @foreach ($data->orderLists as $orderList)
                        @php
                            $totalQty += $orderList->quantity;
                        @endphp
                        <div id="container-form-validasi-{{ $orderList->id }}" class="container-form-val grid grid-cols-4 mb-4 gap-4" style="grid-template-columns: 5fr 2fr 4fr 1fr">
                            <div class="relative z-0 w-full group">
                                <select name="jenis_paket[]" id="jenis-paket{{ $orderList->id }}" class="val-seri-drone block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                                    <option value="" hidden>Pilih Seri Drone</option>
                                    @foreach ($paketPenjualan as $pp)
                                        @if ($orderList->sub_jenis_id == $pp->id)
                                            <option value="{{ $pp->id }}" selected class="bg-white dark:bg-gray-700">{{ $pp->paket_penjualan }}</option>
                                        @else
                                            <option value="{{ $pp->id }}" class="bg-white dark:bg-gray-700">{{ $pp->paket_penjualan }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative z-0 w-full group">
                                <input type="text" name="quantity[]" id="val-qty-buy-baru-{{ $orderList->id }}" class="val-qty-baru block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $orderList->quantity }}" oninput="this.value = this.value.replace(/\D/g, '')" required>
                                <label for="val-qty-buy-baru-{{ $orderList->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                            </div>
                            <div class="relative z-0 w-full group flex items-center">
                                <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                <input type="text" name="nilai[]" id="val-nilai-buy-baru{{ $orderList->id }}" class="val-nilai-buy-baru block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $orderList->nilai }}" required>
                                <label for="val-nilai-buy-baru{{ $orderList->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Harga /pcs</label>
                            </div>
                            <div class="flex justify-center items-center col-span-1">
                                <button type="button" class="remove-form-validasi" data-id="{{ $orderList->id }}">
                                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between my-3 text-rose-600">
                    <div class="flex cursor-pointer mt-4 hover:text-red-400">
                        <button type="button" id="add-form-validasi-belanja" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span class="">Tambah Produk</span>
                        </button>
                    </div>
                </div>

            </div>
            {{-- Bagian Kanan --}}
            <div class="col-span-1 h-[240px] bg-white p-6 rounded-lg border border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-600 sticky top-4">
                <h2 class="text-lg font-semibold mb-4 text-black dark:text-white pb-2 border-b">Order Summary :</h2>
                <div class="grid grid-cols-2 gap-6 mb-4">
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold italic text-black dark:text-white">Total Item :</p>
                        </div>
                        <div class="flex text-end">
                            <p id="validasi-item-total" class="font-normal text-black dark:text-white">{{ $data->orderLists->count() }} Unit</p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold italic text-black dark:text-white">Total Nominal :</p>
                        </div>
                        <div class="flex text-end">
                            <p id="validasi-total-nominal" class="font-normal text-black dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold italic text-black dark:text-white">Total Qty :</p>
                        </div>
                        <div class="flex text-end">
                            <p id="validasi-total-qty" class="font-normal text-black dark:text-white">{{ $totalQty }} Unit</p>
                        </div>
                    </div>
                </div>
                <div class="text-start mt-6">
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
    </form>

    <script>
        let paketPenjualan = @json($paketPenjualan);
    </script>

@endsection
