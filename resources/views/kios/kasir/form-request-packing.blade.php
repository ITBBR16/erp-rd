@extends('kios.layouts.main')

@section('container')

    <div class="grid grid-cols-2 gap-8 mb-8 border-b border-gray-400 py-3">
        <div class="flex text-3xl font-bold text-gray-700 dark:text-gray-300">
            Form Request Packing
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

    <form action="{{ route('req-packing-kios.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-3 gap-4">
            {{-- Box Customer --}}
            <div class="border rounded-md bg-white shadow-md p-4 h-fit">
                <div class="pb-2 border-b flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-black dark:text-white">Data Customer</h2>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="checkbox_customer" id="checkbox-data-customer" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-500"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Customer RD</span>
                    </label>
                </div>
                <div class="grid grid-cols-3 mb-4 gap-y-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="nama-lengkap" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <div id="customer-rd">
                            <div x-data="dropdownCustomerCase()" class="relative col-span-2 text-start">
                                <div class="relative">
                                    <input x-model="search" 
                                        @focus="open = true" 
                                        @keydown.escape="open = false" 
                                        @click.outside="open = false"
                                        type="text" 
                                        id="select-customer-rd"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Search or select customer...">
                                        <svg :class="{ 'rotate-180': open }" class="absolute inset-y-0 right-2 top-2.5 w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    <input type="hidden" id="i-customer-rd" name="customer_rd" :value="selected" required>
                                </div>
                            
                                <ul x-show="open" 
                                    x-transition 
                                    class="absolute z-10 bg-white border border-gray-300 rounded-lg mt-1 max-h-60 w-full overflow-y-auto shadow-md dark:bg-gray-700 dark:border-gray-600">
                                    <template x-for="customer in filteredCustomers" :key="customer.id">
                                        <li @click="select(customer.id, customer.display)" 
                                            class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white">
                                            <span x-text="customer.display" class="text-black dark:text-white"></span>
                                        </li>
                                    </template>
                                    <li 
                                        x-show="filteredCustomers.length === 0" 
                                        class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                        Data customer tidak ditemukan.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="customer-non-rd" style="display: none;">
                            <input type="text" id="i-customer-non-rd" name="nama_penerima" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Customer">
                        </div>
                    </div>


                    <div class="col-span-1 text-end pr-6">
                        <label for="no-whatsapp" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">No Whatsapp</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="no-whatsapp" name="no_whatsapp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="628123456789" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="provinsi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Provinsi</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="provinsi_customer" id="provinsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Provinsi</option>
                            @foreach ($dataProvinsi as $provinsi)
                                <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="kota-kabupaten" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kota / Kabupaten</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="kota_kabupaten" id="kota-kabupaten" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Kota / Kabupaten</option>
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="kecamatan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kecamatan</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="kecamatan" id="kecamatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Kecamatan</option>
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="kelurahan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelurahan</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="kelurahan" id="kelurahan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Kelurahan</option>
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="kode-pos" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pos</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="kode_pos" id="kode-pos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="65139" oninput="this.value = this.value.replace(/\D/g, '')">
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="alamat-lengkap" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="alamat" id="alamat-lengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Alamat lengkap . . .">
                    </div>
                </div>
            </div>
            {{-- Box Ekspedisi --}}
            <div class="border rounded-md bg-white shadow-md p-4 h-fit">
                <div class="mb-4">
                    <h3 class="text-gray-900 font-semibold text-lg border-b-2 pb-2 dark:text-white">Data Logistik</h3>
                </div>
                <div class="grid grid-cols-3 mb-4 gap-y-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="jenis-pengiriman" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Pengiriman</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="jenis_pengiriman" id="jenis-pengiriman" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Jenis Pengiriman</option>
                            <option value="Kirim Ulang">Kirim Ulang</option>
                            <option value="Unit Cancel">Unit Cancel</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="ekspedisi0" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Ekspedisi</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select id="ekspedisi0" data-id="0" class="ekspedisi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Ekspedisi</option>
                            @foreach ($dataEkspedisi as $ekspedisi)
                                <option value="{{ $ekspedisi->id }}">{{ $ekspedisi->ekspedisi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="layanan0" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Layanan</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="layanan_ekspedisi" id="layanan0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Jenis Layanan</option>
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="option-transaksi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Transaksi Ongkir</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="opsi_transaksi" id="option-transaksi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Transaksi Ongkir</option>
                            <option value="Ada Transaksi">Ada Transaksi</option>
                            <option value="Tidak Ada Transaksi">Tidak Ada Transaksi</option>
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="divisi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Divisi</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="asal_divisi" id="divisi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Department</option>
                            @foreach ($dataDivisi as $divisi)
                                <option value="{{ $divisi->id }}">Department {{ $divisi->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="rekening" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Rekening</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="rekening_pembayaran" id="rekening" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" hidden>Pilih Rekening</option>
                            @foreach ($daftarAkun as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="nominal-ongkir" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Ongkir</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="nominal_ongkir" id="nominal-ongkir" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                        </div>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="nominal-packing" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Packing</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="nominal_packing" id="nominal-packing" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                        </div>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="nominal-asuransi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Asuransi</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="nominal_asuransi" id="nominal-asuransi" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                        </div>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="keterangan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <textarea name="keterangan" id="keterangan" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Keterangan . . ."></textarea>
                    </div>
                </div>
            </div>
            {{-- Box Kelengkapan --}}
            <div class="border rounded-md bg-white shadow-md p-4 h-fit">
                <div class="mb-4">
                    <h3 class="text-gray-900 font-semibold text-lg border-b-2 pb-2 dark:text-white">Isi Paket</h3>
                </div>
                <div class="relative">
                    <div class="overflow-y-auto max-h-[500px] rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="sticky top-0 text-xs text-gray-200 uppercase bg-violet-500 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3" style="width: 45%;">
                                        Nama Item
                                    </th>
                                    <th scope="col" class="px-6 py-3" style="width: 5%;">
                                        Quantity
                                    </th>
                                    <th scope="col" class="px-6 py-3" style="width: 45%;">
                                        Keterangan
                                    </th>
                                    <th scope="col" class="px-6 py-3" style="width: 5%;">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="iReqPacking">
                                
                            </tbody>
                            <tfoot class="sticky -bottom-0 text-xs text-gray-200 uppercase bg-white dark:bg-gray-700 dark:text-gray-300">
                                <tr class="font-semibold text-sm text-gray-900 dark:text-white">
                                    <td colspan="4" class="px-2 py-3">
                                        <div class="flex items-center justify-between text-violet-600">
                                            <!-- Tombol Tambah Item -->
                                            <div class="flex cursor-pointer hover:text-violet-400">
                                                <button type="button" id="add-item-kasir-req-packing" class="flex flex-row items-center gap-2">
                                                    <span class="material-symbols-outlined">add_circle</span>
                                                    <span>Tambah Item</span>
                                                </button>
                                            </div>
                            
                                            <!-- Tombol Submit -->
                                            <div class="flex items-center gap-2">
                                                <button type="submit" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                                                    Submit
                                                </button>
                                                <div class="loader-button-form" style="display: none">
                                                    <button class="cursor-not-allowed text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
                                                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                        </svg>
                                                        Loading . . .
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Search Select Function --}}
    <script>
        function dropdownCustomerCase() {
            return {
                open: false,
                search: '',
                selected: '',
                customers: Object.values(@json($dataCustomers)),
                filteredCustomers: [],
                debounceSearch: null,
                init() {
                    if (!Array.isArray(this.customers)) {
                        this.customers = [];
                    }
                    this.filteredCustomers = this.customers;
                    this.$watch('search', (value) => {
                        clearTimeout(this.debounceSearch);
                        this.debounceSearch = setTimeout(() => {
                            this.filteredCustomers = this.customers.filter(customer =>
                                customer.display.toLowerCase().includes(value.toLowerCase())
                            );
                        }, 300);
                    });
                },
                select(id, display) {
                    this.selected = id;
                    this.search = display;
                    this.open = false;

                    const event = new CustomEvent('customer-req-packing-changed', {
                        detail: { id: this.selected, display: this.search }
                    });
                    document.dispatchEvent(event);
                }
            }
        }
    </script>

@endsection
