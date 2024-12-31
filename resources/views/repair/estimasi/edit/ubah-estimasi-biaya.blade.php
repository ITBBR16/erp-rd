@extends('repair.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("konfirmasi-estimasi.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">playlist_add_check_circle</span>
                    Konfirmasi Estimasi
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Ubah Estimasi {{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }} - {{ $dataCase->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    @if (session()->has('error'))
        <div id="alert-failed-input" class="flex items-center p-4 my-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
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

    <form action="{{ route('konfirmasi-estimasi.update', $dataCase->estimasi->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="grid grid-row-2 gap-6 mt-4">
            <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-600">
                <div class="grid grid-cols-2 h-[550px] gap-4">
                    <div>
                        <div class="border-b grid grid-cols-2 gap-2 pb-2">
                            <div class="text-sm text-start">
                                <h3 class="font-semibold">Detail Customer</h3>
                            </div>
                            <div class="text-sm text-end">
                                <h3 class="font-semibold">Jenis Drone : {{ $dataCase->jenisProduk->jenis_produk }}</h3>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 mt-2 gap-3">
                            <div class="text-start">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Tanggal Masuk</p>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($dataCase->created_at)->isoFormat('D MMMM YYYY') }}</h3>
                            </div>
                            <div class="text-end">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Tanggal Estimasi</p>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($dataCase->updated_at)->isoFormat('D MMMM YYYY') }}</h3>
                            </div>
                            <div class="mr-auto text-start">
                                <p class="text-xs text-gray-700 dark:text-gray-300">No Telpon</p>
                                <a href="https://wa.me/{{ $dataCase->customer->no_telpon }}" target="_blank" class="text-sm flex items-center text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                    <span class="font-semibold mr-3">{{ $dataCase->customer->no_telpon }}</span>
                                    <i class="material-symbols-outlined">call</i>
                                </a>
                            </div>
                            <div class="ml-auto text-end">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Link Drive</p>
                                <a href="{{ $dataCase->link_doc }}" target="_blank" class="text-sm flex items-center text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                    <span class="font-semibold mr-3">Link Drive</span>
                                    <i class="material-symbols-outlined">link</i>
                                </a>
                            </div>
                        </div>
                        <div class="mt-4 border-b">
                            <div data-accordion="collapse" data-active-classes="bg-white text-sm dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 text-sm dark:text-gray-400">
                                <h2 id="keluhan-heading">
                                    <button type="button" class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#keluhan-body" aria-expanded="false">
                                        <span>Keluhan</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                        </svg>
                                    </button>
                                </h2>
                                <div id="keluhan-body" class="hidden" aria-labelledby="keluhan-heading">
                                    <div class="py-3 text-xs border-b border-gray-200 dark:border-gray-700">
                                        <p class="mb-2 text-gray-500 dark:text-gray-400">{{ $dataCase->keluhan }}</p>
                                    </div>
                                </div>
                                <h2 id="kronologi-heading">
                                    <button type="button" class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#kronologi-body" aria-expanded="false">
                                        <span>Kronologi Kerusakan</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                        </svg>
                                    </button>
                                </h2>
                                <div id="kronologi-body" class="hidden" aria-labelledby="kronologi-heading">
                                    <div class="py-3 text-xs border-b border-gray-200 dark:border-gray-700">
                                        <p class="mb-2 text-gray-500 dark:text-gray-400">{{ ($dataCase->kronologi_kerusakan) ? $dataCase->kronologi_kerusakan : '-' }}</p>
                                    </div>
                                </div>
                                <h2 id="pac-heading">
                                    <button type="button" class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#pac-body" aria-expanded="false">
                                        <span>Penanganan After Crash</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                        </svg>
                                    </button>
                                </h2>
                                <div id="pac-body" class="hidden" aria-labelledby="pac-heading">
                                    <div class="py-3 text-xs border-b border-gray-200 dark:border-gray-700">
                                        <p class="mb-2 text-gray-500 dark:text-gray-400">{{ ($dataCase->penanganan_after_crash) ? $dataCase->penanganan_after_crash : '-' }}</p>
                                    </div>
                                </div>
                                <h2 id="riwayat-heading">
                                    <button type="button" class="flex items-center justify-between w-full py-3 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#riwayat-body" aria-expanded="false">
                                        <span>Riwayat Penggunaan</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                        </svg>
                                    </button>
                                </h2>
                                <div id="riwayat-body" class="hidden" aria-labelledby="riwayat-heading">
                                    <div class="py-3 text-xs border-b border-gray-200 dark:border-gray-700">
                                        <p class="mb-2 text-gray-500 dark:text-gray-400">{{ ($dataCase->riwayat_penggunaan) ? $dataCase->riwayat_penggunaan : '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 bottom-0">
                            <label for="pesan-hasil-ts" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pesan Hasil Troubleshooting</label>
                            <textarea name="pesan_hasil_ts" id="pesan-hasil-ts" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pesan pesan hasil troubleshooting untuk customer . . ." required>{{ $dataCase->estimasi->estimasiChat->isi_chat }}</textarea>
                        </div>
                    </div>
                    <div class="overflow-y-auto">
                        <div class="border-b grid grid-cols-2 gap-2 pb-2">
                            <div class="text-sm text-start">
                                <h3 class="font-semibold">Hasil Troubleshooting</h3>
                            </div>
                            <div class="text-sm text-end">
                                <h3 class="font-semibold">Teknisi : {{ $dataCase->teknisi->first_name }}</h3>
                            </div>
                        </div>
                        <div class="mt-2 p-2 text-sm0">
                            @foreach ($dataCase->timestampStatus->where('jenis_status_id', 2) as $timeStamp)
                                @foreach ($timeStamp->jurnal->sortByDesc('created_at')->take(1) as $jurnal)
                                    {!! nl2br(e($jurnal->isi_jurnal)) !!}
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-600">
                <div class="grid grid-cols-3 gap-5">
                    <div class="relative col-span-2 overflow-x-auto">
                        <div class="border-b">
                            <h3 class="font-semibold text-sm pb-2">Input Estimasi</h3>
                        </div>
                        <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-[10px] text-gray-900 border-b-2 uppercase dark:text-white">
                                <tr>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Jenis Transaksi
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Jenis Produk
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 25%">
                                        Product Name
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Nama Alias
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Harga Customer
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 5%">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="container-estimasi-active">
                                @foreach (array_merge($dataCase->estimasi->estimasiPart->all(), $dataCase->estimasi->estimasiJrr->all()) as $index => $estimasi)
                                    @if ($estimasi->active == 'Active')
                                        <tr id="konfirmasi-estimasi-{{ $index }}" class="bg-white dark:bg-gray-800">
                                            <td class="px-2 py-4">
                                                <input type="hidden" name="status[]" id="status-active-{{ $index }}" value="{{ $estimasi->active }}">
                                                <input type="hidden" name="id_hasil_estimasi[]" value="{{ $estimasi->id }}">
                                                <select name="jenis_transaksi_lama[]" id="konfirmasi-jt-{{ $index }}" data-id="{{ $index }}" class="konfirmasi-jt bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                    <option value="" hidden>Pilih Jenis Transaksi</option>
                                                    @foreach ($jenisTransaksi as $jt)
                                                        <option value="{{ $jt->id }}" {{ $jt->id == $estimasi->jenis_transaksi_id ? 'selected' : '' }}>{{ $jt->code_jt }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-2 py-4" id="konfirmasi-jpj-container-{{ $index }}">
                                                @if (isset($estimasi->gudang_produk_id))
                                                    <select name="jenis_part_jasa_lama[]" id="konfirmasi-jp-{{ $index }}" data-id="{{ $index }}" class="konfirmasi-jp bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                        <option value="" hidden>Pilih Jenis Produk</option>
                                                        @foreach ($jenisProduk as $produk)
                                                            @if ($estimasi->sparepartGudang->produkSparepart->produkJenis->id == $produk->id)
                                                                <option value="{{ $produk->id }}" selected>{{ $produk->jenis_produk }}</option>
                                                            @else
                                                                <option value="{{ $produk->id }}">{{ $produk->jenis_produk }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input type="text" name="jenis_part_jasa_lama[]" id="konfirmasi-jp-{{ $index }}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jenis Jasa" value="{{ $estimasi->jenis_jasa }}">
                                                @endif
                                            </td>
                                            <td class="px-2 py-4" id="konfirmasi-part-jasa-container-{{ $index }}">
                                                @if (isset($estimasi->gudang_produk_id))
                                                    <select name="nama_part_jasa_lama[]" id="konfirmasi-part-{{ $index }}" data-id="{{ $index }}" class="konfirmasi-part bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                        <option value="" hidden>Pilih Part</option>
                                                        <option value="{{ $estimasi->gudang_produk_id }}" selected>{{ $estimasi->sparepartGudang->produkSparepart->nama_internal }}</option>
                                                    </select>
                                                @else
                                                    <input type="text" name="nama_part_jasa_lama[]" id="konfirmasi-part-{{ $index }}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jasa" value="{{ $estimasi->nama_jasa }}">
                                                @endif
                                            </td>
                                            <td class="px-2 py-4">
                                                <input type="text" name="nama_alias_lama[]" id="nama-alias-{{ $index }}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Alias" value="{{ $estimasi->nama_alias }}">
                                            </td>
                                            <td class="px-2 py-4">
                                                <div class="flex">
                                                    <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                                    <input type="text" name="harga_customer_lama[]" id="harga-customer-{{ $index }}" class="format-angka-estimasi rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($estimasi->harga_customer, 0, ',', '.') }}" required>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4 text-center">
                                                <button type="button" data-id="{{ $index }}" class="deactive-form-estimasi">
                                                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="font-semibold text-sm text-gray-900 dark:text-white">
                                    <td colspan="4" class="px-2 py-3">
                                        <div class="flex items-center justify-between text-rose-600">
                                            <div class="flex cursor-pointer mt-2 hover:text-red-400">
                                                <button type="button" id="add-ubah-estimasi" class="flex flex-row justify-between gap-2">
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
                    <div class="relative overflow-x-auto">
                        <div class="border-b">
                            <h3 class="font-semibold text-sm pb-2">Data Gudang</h3>
                        </div>
                        <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-[10px] text-gray-900 border-b-2 uppercase dark:text-white">
                                <tr>
                                    <th scope="col" class="px-2 py-3">
                                        Stok
                                    </th>
                                    <th scope="col" class="px-2 py-3">
                                        Promo
                                    </th>
                                    <th scope="col" class="px-2 py-3">
                                        Repair
                                    </th>
                                    <th scope="col" class="px-2 py-3">
                                        SRP Gudang
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="container-data-gudang-active">
                                @foreach (array_merge($dataCase->estimasi->estimasiPart->all(), $dataCase->estimasi->estimasiJrr->all()) as $indexGudang => $gudang)
                                    @if ($gudang->active == 'Active')
                                        <tr id="konfirmasi-data-gudang-{{ $indexGudang }}" class="bg-white dark:bg-gray-800">
                                            <td class="px-2 py-4">
                                                <div class="relative z-0 w-full">
                                                    <input name="stok_part[]" id="stok-part-{{ $indexGudang }}" type="text" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="-" readonly>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <div class="relative z-0 w-full group flex items-center">
                                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                                    <input name="harga_promo_part[]" id="harga-promo-part-{{ $indexGudang }}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="0" readonly>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <div class="relative z-0 w-full group flex items-center">
                                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                                    <input name="harga_repair[]" id="harga-repair-{{ $indexGudang }}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ number_format($gudang->harga_repair, 0, ',', '.') }}" readonly>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <input type="hidden" name="modal_gudang[]" id="estimasi-modal-gudang-{{ $indexGudang }}" value="{{ $gudang->modal_gudang }}">
                                                <div class="relative z-0 w-full group flex items-center">
                                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                                    <input name="harga_gudang[]" id="harga-gudang-{{ $indexGudang }}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ number_format($gudang->harga_gudang, 0, ',', '.') }}" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif    
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end px-2 py-3">
                                        <button type="submit" id="ubah-estimasi" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                                        <div class="loader-button-form" style="display: none">
                                            <button class="cursor-not-allowed text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
                                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                                </svg>
                                                Loading . . .
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-600">
                <div class="border-b">
                    <h3 class="font-semibold text-sm pb-2">Data Deactive</h3>
                </div>
                <div class="grid grid-cols-3 gap-5">
                    <div class="relative col-span-2 overflow-x-auto">
                        <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-[10px] text-gray-900 border-b-2 uppercase dark:text-white">
                                <tr>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Jenis Transaksi
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Jenis Produk
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 25%">
                                        Product Name
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Name Alias
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Harga Customer
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 5%">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="container-estimasi-deactive">
                                @foreach (array_merge($dataCase->estimasi->estimasiPart->all(), $dataCase->estimasi->estimasiJrr->all()) as $index => $estimasi)
                                    @if ($estimasi->active == 'Deactive')
                                        <tr id="konfirmasi-estimasi-{{ $index }}" class="bg-white dark:bg-gray-800">
                                            <td class="px-2 py-4">
                                                <input type="hidden" name="status[]" id="status-active-{{ $index }}" value="{{ $estimasi->active }}">
                                                <input type="hidden" name="id_hasil_estimasi[]" value="{{ $estimasi->id }}">
                                                <select name="jenis_transaksi_lama[]" id="konfirmasi-jt-{{ $index }}" data-id="{{ $index }}" class="konfirmasi-jt bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                    <option value="" hidden>Pilih Jenis Transaksi</option>
                                                    @foreach ($jenisTransaksi as $jt)
                                                        <option value="{{ $jt->id }}" {{ $jt->id == $estimasi->jenis_transaksi_id ? 'selected' : '' }}>{{ $jt->code_jt }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-2 py-4" id="konfirmasi-jpj-container-{{ $index }}">
                                                @if (isset($estimasi->sku))
                                                    <select name="jenis_part_jasa_lama[]" id="konfirmasi-jp-{{ $index }}" data-id="{{ $index }}" class="konfirmasi-jp bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                        <option value="" hidden>Pilih Jenis Produk</option>
                                                        <option value="{{ $estimasi->jenis_produk }}" selected>{{ $estimasi->jenis_produk }}</option>
                                                    </select>
                                                @else
                                                    <input type="text" name="jenis_part_jasa_lama[]" id="konfirmasi-jp-{{ $index }}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jenis Jasa" value="{{ $estimasi->jenis_jasa }}">
                                                @endif
                                            </td>
                                            <td class="px-2 py-4" id="konfirmasi-part-jasa-container-{{ $index }}">
                                                @if (isset($estimasi->sku))
                                                    <select name="nama_part_jasa_lama[]" id="konfirmasi-part-{{ $index }}" data-id="{{ $index }}" class="konfirmasi-part bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                        <option value="" hidden>Pilih Part</option>
                                                        <option value="{{ $estimasi->sku }}" selected>{{ $estimasi->nama_produk }}</option>
                                                    </select>
                                                @else
                                                    <input type="text" name="nama_part_jasa_lama[]" id="konfirmasi-part-{{ $index }}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jasa" value="{{ $estimasi->nama_jasa }}">
                                                @endif
                                            </td>
                                            <td class="px-2 py-4">
                                                <input type="text" name="nama_alias_lama[]" id="nama-alias-{{ $index }}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Alias" value="{{ $estimasi->nama_alias }}">
                                            </td>
                                            <td class="px-2 py-4">
                                                <div class="flex">
                                                    <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                                    <input type="text" name="harga_customer_lama[]" id="harga-customer-{{ $index }}" class="format-angka-estimasi rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($estimasi->harga_customer, 0, ',', '.') }}" required>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4 text-center">
                                                <button type="button" data-id="{{ $index }}" class="activate-button">
                                                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">add_circle</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-[10px] text-gray-900 border-b-2 uppercase dark:text-white">
                                <tr>
                                    <th scope="col" class="px-2 py-3">
                                        Stok
                                    </th>
                                    <th scope="col" class="px-2 py-3">
                                        Promo
                                    </th>
                                    <th scope="col" class="px-2 py-3">
                                        Repair
                                    </th>
                                    <th scope="col" class="px-2 py-3">
                                        SRP Gudang
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="container-data-gudang-deactive">
                                @foreach (array_merge($dataCase->estimasi->estimasiPart->all(), $dataCase->estimasi->estimasiJrr->all()) as $indexGudang => $gudang)
                                    @if ($gudang->active == 'Deactive')
                                        <tr id="konfirmasi-data-gudang-{{ $indexGudang }}" class="bg-white dark:bg-gray-800">
                                            <td class="px-2 py-4">
                                                <div class="relative z-0 w-full">
                                                    <input name="stok_part[]" id="stok-part-{{ $indexGudang }}" type="text" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="-" readonly>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <div class="relative z-0 w-full group flex items-center">
                                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                                    <input name="harga_promo_part[]" id="harga-promo-part-{{ $indexGudang }}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="0" readonly>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <div class="relative z-0 w-full group flex items-center">
                                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                                    <input name="harga_repair[]" id="harga-repair-{{ $indexGudang }}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ number_format($gudang->harga_repair, 0, ',', '.') }}" readonly>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <input type="hidden" name="modal_gudang[]" id="estimasi-modal-gudang-{{ $indexGudang }}" value="{{ $gudang->modal_gudang }}">
                                                <div class="relative z-0 w-full group flex items-center">
                                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                                    <input name="harga_gudang[]" id="harga-gudang-{{ $indexGudang }}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ number_format($gudang->harga_gudang, 0, ',', '.') }}" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        let jenisTransaksi = @json($jenisTransaksi);
    </script>

@endsection