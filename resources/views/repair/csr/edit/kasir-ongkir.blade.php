@extends('repair.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("kasir-repair.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">point_of_sale</span>
                    Kasir
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Data Ongkir Customer {{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }} - {{ $dataCase->customer->id }}</span>
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

    <form action="{{ route('createOngkirKasir', $dataCase->id) }}" method="POST" autocomplete="off">
        @csrf
        <div class="px-2 py-2 lg:px-8 lg:py-6">
            <div class="grid grid-cols-2 gap-x-4 relative">
                <div class="relative space-y-4 px-4 py-4 rounded-md shadow-lg border border-gray-200 bg-white dark:bg-gray-700 dark:border-gray-600">
                    <div class="pb-2 border-b flex justify-between items-center">
                        <h2 class="text-base font-semibold mb-4 text-black dark:text-white">Data Customer</h2>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="checkbox_customer_kasir" id="checkbox-ongkir-kasir-repair" class="checkbox-ongkir-kasir-repair sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-500"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Beda Penerima</span>
                        </label>
                    </div>
                    <div id="ongkir-repair-customer" class="space-y-4">
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Nama Customer :
                            </div>
                            <div class="col-span-2">
                                <input type="hidden" name="customer_id" value="{{ $dataCase->customer_id }}">
                                <input type="text" id="nama-customer" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Customer" value="{{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }}" readonly>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Provinsi :
                            </div>
                            <div class="col-span-2">
                                <select name="provinsi_customer" id="ongkir-provinsi" data-selected="{{ $selectedProvinsi }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" hidden>Pilih Provinsi</option>
                                    @foreach ($dataProvinsi as $provinsi)
                                    <option value="{{ $provinsi->id }}" {{ $provinsi->id == $dataCase->customer->provinsi_id ? 'selected' : '' }}>
                                        {{ $provinsi->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Kota / Kabupaten :
                            </div>
                            <div class="col-span-2">
                                <select name="kota_customer" id="ongkir-kota" data-selected="{{ $selectedKota }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" hidden>Pilih Kota / Kabupaten</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Kecamatan :
                            </div>
                            <div class="col-span-2">
                                <select name="kecamatan_customer" id="ongkir-kecamatan" data-selected="{{ $selectedKecamatan }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" hidden>Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Kelurahan :
                            </div>
                            <div class="col-span-2">
                                <select name="kelurahan_customer" id="ongkir-kelurahan" data-selected="{{ $selectedKelurahan }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" hidden>Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Kode Pos :
                            </div>
                            <div class="col-span-2">
                                <input type="text" name="kode_pos_customer" id="ongkir-kodepos" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Kode Pos" oninput="this.value = this.value.replace(/[^0-9+\-]/g, '')" value="{{ $dataCase->customer->kode_pos }}" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Nama Jalan :
                            </div>
                            <div class="col-span-2">
                                <input type="text" name="alamat_customer" id="ongkir-alamat" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jalan" value="{{ $dataCase->customer->nama_jalan }}" required>
                            </div>
                        </div>
                    </div>
                    {{-- Form Beda Penerima --}}
                    <div id="ongkir-repair-beda-penerima" class="space-y-4" style="display: none">
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Nama Customer :
                            </div>
                            <div class="col-span-2">
                                <input type="text" name="nama_penerima" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Customer" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                No Telpon :
                            </div>
                            <div class="col-span-2">
                                <input type="text" name="no_telpon" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="628123456789" oninput="this.value = this.value.replace(/\D/g, '')" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Provinsi :
                            </div>
                            <div class="col-span-2">
                                <select name="provinsi_penerima" id="other-ongkir-provinsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" hidden>Pilih Provinsi</option>
                                    @foreach ($dataProvinsi as $provinsi)
                                        <option value="{{ $provinsi->id }}">
                                            {{ $provinsi->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Kota / Kabupaten :
                            </div>
                            <div class="col-span-2">
                                <select name="kota_penerima" id="other-ongkir-kota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" hidden>Pilih Kota / Kabupaten</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Kecamatan :
                            </div>
                            <div class="col-span-2">
                                <select name="kecamatan_penerima" id="other-ongkir-kecamatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" hidden>Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Kelurahan :
                            </div>
                            <div class="col-span-2">
                                <select name="kelurahan_penerima" id="other-ongkir-kelurahan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" hidden>Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Kode Pos :
                            </div>
                            <div class="col-span-2">
                                <input type="text" name="kode_pos_penerima" id="other-kode-pos" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Kode Pos" oninput="this.value = this.value.replace(/[^0-9+\-]/g, '')">
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Nama Jalan :
                            </div>
                            <div class="col-span-2">
                                <input type="text" name="nama_jalan_penerima" id="other-nama-jalan" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jalan" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-center">
                            <div class="col-span-1">
                                Keterangan :
                            </div>
                            <div class="col-span-2">
                                <textarea name="keterangan" id="keterangan" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Keterangan . . ." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative space-y-4 px-4 py-4 rounded-md shadow-lg border bg-white dark:bg-gray-700">
                    <h2 class="text-base font-semibold mb-4 text-black dark:text-white pb-2 border-b">Data Ekspedisi</h2>
                    <div class="grid grid-cols-3 items-center">
                        <div class="col-span-1">
                            Ekspedisi :
                        </div>
                        <div class="col-span-2">
                            <input type="hidden" name="relasi_logistik" value="{{ optional($dataCase->logRequest)->id !== null ? $dataCase->logRequest->id : '' }}">
                            <select id="ongkir-ekspedisi-repair" data-selected="{{ $selectedEkspedisi }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Ekspedisi</option>
                                @foreach ($dataEkspedisi as $ekspedisi)
                                    <option value="{{ $ekspedisi->id }}" {{ $ekspedisi->id == $dataCase?->logRequest?->layananEkspedisi?->ekspedisi?->id ? 'selected' : '' }}>{{ $ekspedisi->ekspedisi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center">
                        <div class="col-span-1">
                            Layanan :
                        </div>
                        <div class="col-span-2">
                            <select name="layanan_ongkir_repair" id="ongkir-layanan-repair" data-selected="{{ $selectedLayanan }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Layanan</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center">
                        <div class="col-span-1">
                            Nominal Ongkir :
                        </div>
                        <div class="col-span-2">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="nominal_ongkir_repair" id="nominal-ongkir-repair" class="format-angka-ongkir-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ optional($dataCase->logRequest)->biaya_customer_ongkir !== null ? number_format($dataCase->logRequest->biaya_customer_ongkir, 0, '.', ',') : '' }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center">
                        <div class="col-span-1">
                            Nominal Paking :
                        </div>
                        <div class="col-span-2">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="nominal_packing_repair" id="nominal-packing-repair" class="format-angka-ongkir-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ optional($dataCase->logRequest)->biaya_customer_packing !== null ? number_format($dataCase->logRequest->biaya_customer_packing, 0, '.', ',') : '' }}">
                            </div>
                        </div>
                    </div>
                    <h2 class="text-base font-semibold my-4 dark:text-white pb-2 border-b">Data Asuransi</h2>
                    <div class="grid grid-cols-3 items-center">
                        <div class="col-span-1">
                            Nominal Produk :
                        </div>
                        <div class="col-span-2">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="nominal_produk" id="nominal-produk-repair" class="format-angka-ongkir-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ optional($dataCase->logRequest)->nominal_produk !== null ? number_format($dataCase->logRequest->nominal_produk, 0, '.', ',') : '' }}" oninput="this.value = this.value.replace(/\D/g, '')">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center">
                        <div class="col-span-1">
                            Nominal Asuransi :
                        </div>
                        <div class="col-span-2">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="nominal_asuransi" id="nominal-asuransi-repair" class="format-angka-ongkir-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ optional($dataCase->logRequest)->nominal_asuransi !== null ? number_format($dataCase->logRequest->nominal_asuransi, 0, '.', ',') : '' }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="action" value="cancel" class="submit-button-form text-rose-700 hover:text-white border border-rose-700 hover:bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-rose-500 dark:text-rose-500 dark:hover:text-white dark:hover:bg-rose-500 dark:focus:ring-rose-800">Cancel Pengiriman</button>
                        <div class="loader-button-form" style="display: none">
                            <button class="cursor-not-allowed text-white border border-rose-700 bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-rose-500 dark:text-white dark:bg-rose-500 dark:focus:ring-rose-800" disabled>
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
        </div>
        <div class="text-end p-3 border-t">
            <button type="submit" name="action" value="submit" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
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
    </form>

@endsection