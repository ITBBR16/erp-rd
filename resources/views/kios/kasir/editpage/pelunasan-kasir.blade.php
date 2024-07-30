@extends('kios.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("kasir.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">point_of_sale</span>
                    Pelunasan Kasir
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Pelunasan {{ $dataTransaksi->customer->first_name }} {{ $dataTransaksi->customer->last_name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <form action="{{ route('kasir.update', $dataTransaksi->id) }}" id="kasir-form" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-3 w-full">
            <div class="col-span-2 my-4">
                <div class="flex items-center justify-between">
                    <div class="flex justify-start">
                        <p class="text-base font-semibold text-gray-900 dark:text-white">Current Date : <span class="text-gray-900 font-normal dark:text-white">{{ $today->format('d/m/Y') }}</span></p>
                    </div>
                    <div class="flex justify-end">
                        <p class="text-base font-semibold text-gray-900 dark:text-white">Invoice Number : <span class="text-gray-900 font-normal dark:text-white">{{ $dataTransaksi->created_at->format('Ymd') }}{{ $dataTransaksi->id }}</span></p>
                    </div>
                </div>
                <div class="my-4 pt-2 border-t-2 text-center justify-center">
                    <p class="text-lg font-bold text-black dark:text-white">INVOICE PELUNASAN</p>
                </div>
                <div class="grid grid-cols-2 w-full gap-6">
                    <div>
                        <label for="kasir-nama-customer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Customer :</label>
                        <div class="flex">
                            <input type="hidden" name="id_customer" id="id_customer" value="{{ $dataTransaksi->customer_id }}">
                            <input type="text" name="nama_customer" id="kasir-nama-customer" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ $dataTransaksi->customer->first_name }} {{ $dataTransaksi->customer->last_name }}" readonly>
                        </div>
                    </div>
                    <div>
                        <label for="kasir_metode_pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Metode Pembayaran :</label>
                        <select name="kasir_metode_pembayaran" id="kasir_metode_pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Metode Pembayaran</option>
                            @foreach ($akunrd as $akun)
                                @if ($akun->id == $dataTransaksi->metode_pembayaran)
                                    <option value="{{ $akun->id }}" selected>{{ $akun->nama_akun }}</option>
                                @else
                                    <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="kasir-discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="kasir_discount" id="kasir-discount" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($dataTransaksi->discount, 0, ',', '.') }}" oninput="this.value = this.value.replace(/\D/g, '')">
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="kasir_tax" id="kasir-tax">
                        <label for="kasir-ongkir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ongkir :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="kasir_ongkir" id="kasir-ongkir" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($dataTransaksi->ongkir, 0, ',', '.') }}" oninput="this.value = this.value.replace(/\D/g, '')">
                        </div>
                    </div>
                    <div>
                        <label for="kasir-nominal-bayar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Pembayaran :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="kasir_nominal_pembayaran" id="kasir-nominal-pembayaran" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ $dataTransaksi->nominal_pembayaran }}" oninput="this.value = this.value.replace(/\D/g, '')" required>
                        </div>
                    </div>
                    <div>
                        <label for="keterangan-pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan :</label>
                        <input type="text" name="keterangan_pembayaran" id="keterangan-pembayaran" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Keterangan . . ." value="{{ $dataTransaksi->keterangan ?? "" }}">
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan Kasir --}}
            <div class="col-span-1 my-4 mx-auto flex justify-center">
                <div class="w-80 text-base bg-white p-4 text-white border-2 border-solid shadow-xl rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="mb-4 text-center justify-center">
                        <p class="text-lg font-semibold text-gray-800 dark:text-white">Resume Tagihan</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Subtotal :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-subtotal" class="text-gray-900 font-normal dark:text-white">Rp. {{ number_format($dataTransaksi->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Discount :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-discount" class="text-gray-900 font-normal dark:text-white">Rp. {{ number_format($dataTransaksi->discount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Ongkir :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-ongkir" class="text-gray-900 font-normal dark:text-white">Rp. {{ number_format($dataTransaksi->ongkir, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-b-2">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Tax :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-tax" class="text-gray-900 font-normal dark:text-white">Rp. {{ number_format($dataTransaksi->tax, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Total :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            @php
                                $totalTransaksi = $dataTransaksi->total_harga + $dataTransaksi->ongkir + $dataTransaksi->tax - $dataTransaksi->discount;
                            @endphp
                            <p id="kasir-box-total" class="text-gray-900 font-normal dark:text-white">Rp. {{ number_format($totalTransaksi, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <button type="button" data-modal-target="kasir-invoice" data-modal-toggle="kasir-invoice" class="review-invoice text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Review Invoice</button>
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto pt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-900 border-b-2 uppercase dark:text-white">
                    <tr>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Jenis Transaksi
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 30%;">
                            Product Name
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Serial Number
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Total Price
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 5%;">
                            Tax
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 5%;">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="kasir-container">
                    @if ($dataTransaksi->detailtransaksi->isNotEmpty())
                        @foreach ($dataTransaksi->detailtransaksi as $index => $detail)
                            <tr id="pelunasan-item-{{ $index }}" class="bg-white dark:bg-gray-800">
                                <td class="px-4 py-4">
                                    <input type="hidden" name="id_detail_transaksi[]" value="{{ $detail->id }}">
                                    <label for="jenis-transaksi-{{ $index }}"></label>
                                    <select name="jenis_transaksi[]" id="jenis-transaksi-{{ $index }}" data-id="{{ $index }}" class="jenis_produk bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih Jenis Transaksi</option>
                                        <option value="drone_baru" {{ ($detail->jenis_transaksi == 'drone_baru') ? 'selected' : '' }}>Drone Baru</option>
                                        <option value="drone_bekas" {{ ($detail->jenis_transaksi == 'drone_bekas') ? 'selected' : '' }}>Drone Bekas</option>
                                        <option value="part_baru" {{ ($detail->jenis_transaksi == 'part_baru') ? 'selected' : '' }}>Part Baru</option>
                                        <option value="part_bekas" {{ ($detail->jenis_transaksi == 'part_bekas') ? 'selected' : '' }}>Part Bekas</option>
                                    </select>
                                </td>
                                <td class="px-4 py-4">
                                    <input type="hidden" name="item_id[]" id="item-id-pelunasan-{{ $index }}" value="{{ $detail->produkKios->subjenis->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
                                    <input type="text" name="item_name[]" id="item-name-pelunasan-{{ $index }}" value="{{ $detail->produkKios->subjenis->paket_penjualan }}" data-id="{{ $index }}" class="item-pelunasan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
                                </td>
                                <td class="px-4 py-4">
                                    <label for="pelunasan-sn-{{ $index }}"></label>
                                    <select name="kasir_sn[]" id="pelunasan-sn-{{ $index }}" data-id="{{ $index }}" class="pelunasan-sn bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih SN</option>
                                    </select>
                                </td>
                                <td class="px-4 py-4">
                                    <input type="hidden" name="kasir_modal_part[]" id="pelunasan-modal-part-{{ $index }}">
                                    <input type="text" name="kasir_harga[]" id="pelunasan-harga-{{ $index }}" value="Rp. {{ number_format($detail->harga_jual, 0, ',', '.') }}" data-id="{{ $index }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp. 0" readonly required>
                                </td>
                                <td class="px-4 py-4">
                                    <input type="checkbox" name="checkbox_tax_pelunasan[]" id="checkbox-tax-{{ $index }}" data-id="{{ $index }}" class="pelunasan-checkbox-tax w-10 h-6 bg-gray-100 border border-gray-300 text-green-600 text-lg rounded-lg focus:ring-green-600 focus:ring-2 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:ring-offset-gray-800">
                                </td>
                                <td class="px-4 py-4">
                                    <button type="button" class="remove-pelunasan-item" data-id="{{ $index }}">
                                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    @if ($dataTransaksi->transaksiPart->isNotEmpty())
                        @foreach ($dataTransaksi->transaksiPart as $index => $part)
                            <tr id="pelunasan-item-{{ $index }}" class="bg-white dark:bg-gray-800">
                                <td class="px-4 py-4">
                                    <input type="hidden" name="id_detail_transaksi[]" value="{{ $part->id }}">
                                    <label for="jenis-transaksi-{{ $index }}"></label>
                                    <select name="jenis_transaksi[]" id="jenis-transaksi-{{ $index }}" data-id="{{ $index }}" class="jenis_produk bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih Jenis Transaksi</option>
                                        <option value="drone_baru" {{ ($part->jenis_transaksi_part == 'drone_baru') ? 'selected' : '' }}>Drone Baru</option>
                                        <option value="drone_bekas" {{ ($part->jenis_transaksi_part == 'drone_bekas') ? 'selected' : '' }}>Drone Bekas</option>
                                        <option value="part_baru" {{ ($part->jenis_transaksi_part == 'part_baru') ? 'selected' : '' }}>Part Baru</option>
                                        <option value="part_bekas" {{ ($part->jenis_transaksi_part == 'part_bekas') ? 'selected' : '' }}>Part Bekas</option>
                                    </select>
                                </td>
                                <td class="px-4 py-4">
                                    <input type="hidden" name="item_id[]" id="item-id-pelunasan-{{ $index }}" value="{{ $part->sku_part }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
                                    <input type="text" name="item_name[]" id="item-name-pelunasan-{{ $index }}" value="{{ $part->nama_part }}" data-id="{{ $index }}" class="item-pelunasan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
                                </td>
                                <td class="px-4 py-4">
                                    <label for="pelunasan-sn-{{ $index }}"></label>
                                    <select name="kasir_sn[]" id="pelunasan-sn-{{ $index }}" data-id="{{ $index }}" class="pelunasan-sn bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih SN</option>
                                    </select>
                                </td>
                                <td class="px-4 py-4">
                                    <input type="hidden" name="kasir_modal_part[]" id="pelunasan-modal-part-{{ $index }}">
                                    <input type="text" name="kasir_harga[]" id="pelunasan-harga-{{ $index }}" value="Rp. {{ number_format($part->harga_jual_part, 0, ',', '.') }}" data-id="{{ $index }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp. 0" readonly required>
                                </td>
                                <td class="px-4 py-4">
                                    <input type="checkbox" name="checkbox_tax_pelunasan[]" id="checkbox-tax-{{ $index }}" data-id="{{ $index }}" class="pelunasan-checkbox-tax w-10 h-6 bg-gray-100 border border-gray-300 text-green-600 text-lg rounded-lg focus:ring-green-600 focus:ring-2 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:ring-offset-gray-800">
                                </td>
                                <td class="px-4 py-4">
                                    <button type="button" class="remove-pelunasan-item" data-id="{{ $index }}">
                                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-gray-900 dark:text-white">
                        <td class="px-4 py-3">
                            <div class="flex justify-between text-rose-600">
                                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                                    <button type="button" id="add-item-kasir" class="flex flex-row justify-between gap-2">
                                        <span class="material-symbols-outlined">add_circle</span>
                                        <span class="">Tambah Item</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </form>
    {{-- Modal --}}
    
@endsection