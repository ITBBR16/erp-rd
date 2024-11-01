@extends('gudang.layouts.main')

@section('container')
    <nav class="flex mt-6">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route('belanja-sparepart.index') }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m17.855 11.273 2.105-7a.952.952 0 0 0-.173-.876 1.042 1.042 0 0 0-.37-.293 1.098 1.098 0 0 0-.47-.104H5.021L4.395.745a.998.998 0 0 0-.376-.537A1.089 1.089 0 0 0 3.377 0H1.053C.773 0 .506.105.308.293A.975.975 0 0 0 0 1c0 .265.11.52.308.707.198.187.465.293.745.293h1.513l.632 2.254v.02l2.105 6.999.785 2.985a3.13 3.13 0 0 0-1.296 1.008 2.87 2.87 0 0 0-.257 3.06c.251.484.636.895 1.112 1.19a3.295 3.295 0 0 0 3.228.12c.5-.258.918-.639 1.208-1.103.29-.465.444-.995.443-1.535a2.834 2.834 0 0 0-.194-1h2.493a2.84 2.84 0 0 0-.194 1c0 .593.186 1.173.533 1.666.347.494.84.878 1.417 1.105a3.314 3.314 0 0 0 1.824.17 3.213 3.213 0 0 0 1.617-.82 2.95 2.95 0 0 0 .864-1.536 2.86 2.86 0 0 0-.18-1.733 3.038 3.038 0 0 0-1.162-1.346 3.278 3.278 0 0 0-1.755-.506h-7.6l-.526-2h9.179c.229 0 .452-.07.634-.201a1 1 0 0 0 .379-.524Zm-2.066 4.725a1.1 1.1 0 0 1 .585.168c.173.11.308.267.388.45.08.182.1.383.06.577a.985.985 0 0 1-.288.512 1.07 1.07 0 0 1-.54.274 1.104 1.104 0 0 1-.608-.057 1.043 1.043 0 0 1-.472-.369.965.965 0 0 1-.177-.555c0-.265.11-.52.308-.707.197-.188.465-.293.744-.293Zm-7.368 1a.965.965 0 0 1-.177.555c-.116.165-.28.293-.473.369a1.104 1.104 0 0 1-.608.056 1.07 1.07 0 0 1-.539-.273.985.985 0 0 1-.288-.512.953.953 0 0 1 .06-.578c.08-.182.214-.339.388-.448a1.092 1.092 0 0 1 1.329.124.975.975 0 0 1 .308.707Zm5.263-8.999h-1.053v1c0 .265-.11.52-.308.707a1.081 1.081 0 0 1-.744.293c-.28 0-.547-.106-.745-.293a.975.975 0 0 1-.308-.707v-1H9.474a1.08 1.08 0 0 1-.745-.293A.975.975 0 0 1 8.421 7c0-.265.11-.52.308-.707.198-.187.465-.293.745-.293h1.052V5c0-.265.111-.52.309-.707.197-.187.465-.292.744-.292.279 0 .547.105.744.292a.975.975 0 0 1 .308.707v1h1.053c.28 0 .547.106.744.293a.975.975 0 0 1 .309.707c0 .265-.111.52-.309.707a1.081 1.081 0 0 1-.744.293Z"/>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Belanja Sparepart</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Ubah Belanja Order ID N.{{ $belanja->id }}</span>
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

    <form action="{{ route('belanja-sparepart.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-3 gap-6 pt-6 border-t mt-4">
            {{-- Bagian Kiri --}}
            <div class="col-span-2 mt-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="supplier-gudang" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Supplier :</label>
                        <select name="supplier" id="supplier-gudang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ $belanja->gudang_supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="invoice-supplier" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Supplier :</label>
                        <input type="text" name="invoice_supplier" id="invoice-supplier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Invoice Supplier" value="{{ $belanja->invoice }}" required>
                    </div>
                    <div>
                        <label for="nominal-ongkir-bg" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Ongkir :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="nominal_ongkir" id="nominal-ongkir-bg" class="format-angka-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($belanja->total_ongkir, 0, ',', '.') }}">
                        </div>
                    </div>
                    <div>
                        <label for="nominal-pajak-bg" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Pajak :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="nominal_pajak" id="nominal-pajak-bg" class="format-angka-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($belanja->total_pajak, 0, ',', '.') }}">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="my-4 border-t-2 border-gray-400 pt-2">
                        <h3 class="text-gray-900 font-semibold text-xl dark:text-white">List Belanja</h3>
                    </div>
                    <div id="container-list-belanja">
                        @foreach ($belanja->detailBelanja as $index => $detail)
                            <div id="form-list-belanja-{{ $index }}" class="form-lb grid grid-cols-5 gap-6" style="grid-template-columns: 5fr 5fr 2fr 3fr 1fr">
                                <div>
                                    <input type="hidden" name="id_detail[]" value="{{ $detail->id }}">
                                    <label for="belanja-jenis-drone-{{ $index }}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                                    <select name="jenis_drone[]" id="belanja-jenis-drone-0" data-id="{{ $index }}" class="jd-belanja bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih Jenis Drone</option>
                                        @foreach ($jenisProduk as $jenis)
                                            <option value="{{ $jenis->id }}" {{ $detail->sparepart->produk_jenis_id == $jenis->id ? 'selected' : '' }}>{{ $jenis->jenis_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="belanja-spareparts-{{ $index }}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sparepart :</label>
                                    <select name="spareparts[]" id="belanja-spareparts-0" data-id="{{ $index }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih Sparepart</option>
                                        <option value="{{ $detail->sparepart_id }}" selected>{{ $detail->sparepart->nama_internal }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="belanja-sparepart-qty-{{ $index }}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                                    <input type="text" name="sparepart_qty[]" id="belanja-sparepart-qty-{{ $index }}" class="number-format belanja-sparepart-qty bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ $detail->quantity }}" required>
                                </div>
                                <div>
                                    <label for="belanja-nominal-pcs-{{ $index }}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Harga / Pcs :</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                        <input type="text" name="nominal_pcs[]" id="belanja-nominal-pcs-{{ $index }}" class="format-angka-rupiah belanja-nominal-pcs rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($detail->nominal_pcs, 0, ',', '.') }}" required>
                                    </div>
                                </div>
                                <div class="flex justify-center mt-10">
                                    <button type="button" class="remove-list-belanja" data-id="{{ $index }}">
                                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-start text-red-500 mt-6">
                    <div class="flex cursor-pointer my-2 hover:text-rose-700">
                        <button type="button" id="add-list-belanja" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span>Tambah Belanja</span>
                        </button>
                    </div>
                </div>
            </div>
            {{-- Bagian Kanan --}}
            <div class="col-span-1 h-[400px] bg-white p-6 mt-4 rounded-lg border shadow-lg dark:bg-gray-800 dark:border-gray-600 sticky top-4">
                <h2 class="text-lg font-semibold mb-4 dark:text-white pb-2 border-b">Order Summary :</h2>
                <div class="grid grid-cols-2 gap-6 mb-4">
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold italic dark:text-white">Total Item :</p>
                        </div>
                        <div class="flex text-end">
                            <p id="total-item-belanja" class="font-normal dark:text-white">{{ $belanja->total_quantity }} Unit</p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold italic dark:text-white">Total Biaya :</p>
                        </div>
                        <div class="flex text-end">
                            @php
                                $totalNominal = $belanja->total_pembelian + $belanja->total_ongkir + $belanja->total_pajak;
                            @endphp
                            <p id="total-biaya-belanja" class="font-normal dark:text-white">Rp. {{ number_format($totalNominal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 border-t py-2">
                    <div>
                        <label for="media-transaksi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Media Transaksi :</label>
                        <input type="text" name="media_transaksi" id="media-transaksi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Media Transaksi" value="{{ $belanja->gudangMetodePembayaran->media_transaksi }}" required>
                    </div>
                    <div>
                        <label for="nama_akun" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Akun :</label>
                        <input type="text" name="nama_akun" id="nama_akun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Akun" value="{{ $belanja->gudangMetodePembayaran->nama_akun }}" required>
                    </div>
                    <div>
                        <label for="bank-pembayaran" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Bank Pembayaran :</label>
                        <select name="bank_pembayaran" id="bank-pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Akun Bank</option>
                            @foreach ($namaBank as $bank)
                                <option value="{{ $bank->id }}" {{ $belanja->gudangMetodePembayaran->nama_bank_id == $bank->id ? 'selected' : '' }}>{{ $bank->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="id-akun" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">ID Akun :</label>
                        <input type="text" name="id_akun" id="id-akun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ID Akun" value="{{ $belanja->gudangMetodePembayaran->id_akun }}">
                    </div>
                </div>
                <div class="text-end mt-4">
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
        let jenisProduk = @json($jenisProduk);
    </script>

@endsection