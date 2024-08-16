@extends('repair.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("estimasi-biaya.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">playlist_add_check_circle</span>
                    Estimasi Biaya
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Estimasi {{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }} - {{ $dataCase->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <form action="#" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="grid grid-row-2 gap-6 mt-4">
            <div class="bg-white p-4 rounded-lg shadow-lg border dark:bg-gray-800 dark:border-gray-600">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="border-b pb-2">
                            <h3 class="font-semibold text-sm">Detail Customer</h3>
                        </div>
                        <div class="grid grid-cols-2 mt-2 gap-3">
                            <div class="text-start">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Tanggal Masuk</p>
                                <h3 class="text-sm font-semibold dark:text-white">{{ \Carbon\Carbon::parse($dataCase->created_at)->isoFormat('D MMMM YYYY') }}</h3>
                            </div>
                            <div class="text-end">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Tanggal Estimasi</p>
                                <h3 class="text-sm font-semibold dark:text-white">{{ \Carbon\Carbon::parse($dataCase->updated_at)->isoFormat('D MMMM YYYY') }}</h3>
                            </div>
                            <div class="mr-auto text-start">
                                <p class="text-xs text-gray-700 dark:text-gray-300">No Telpon</p>
                                <a href="https://wa.me/{{ $dataCase->customer->no_telpon }}" target="__blank" class="text-sm flex items-center text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                    <span class="font-semibold mr-3">{{ $dataCase->customer->no_telpon }}</span>
                                    <i class="material-symbols-outlined">call</i>
                                </a>
                            </div>
                            <div class="ml-auto text-end">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Link Drive</p>
                                <a href="{{ $dataCase->link_doc }}" target="__blank" class="text-sm flex items-center text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
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
                            {{-- <div class="">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Kendala</p>
                                <h3 class="text-sm font-semibold dark:text-white">{{ $dataCase->keluhan }}</h3>
                            </div>
                            <div class="">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Kronologi Kerusakan</p>
                                <h3 class="text-sm font-semibold dark:text-white">{{ ($dataCase->kronologi_kerusakan) ? $dataCase->kronologi_kerusakan : '-' }}</h3>
                            </div>
                            <div class="">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Penanganan After Crash</p>
                                <h3 class="text-sm font-semibold dark:text-white">{{ ($dataCase->penanganan_after_crash) ? $dataCase->penanganan_after_crash : '-' }}</h3>
                            </div>
                            <div class="">
                                <p class="text-xs text-gray-700 dark:text-gray-300">Riwayat Penggunaan</p>
                                <h3 class="text-sm font-semibold dark:text-white">{{ ($dataCase->riwayat_penggunaan) ? $dataCase->riwayat_penggunaan : '-' }}</h3>
                            </div> --}}
                        </div>
                    </div>
                    <div>
                        <div class="border-b grid grid-cols-2 gap-2 pb-2">
                            <div class="text-sm text-start">
                                <h3 class="font-semibold">Hasil Troubleshooting</h3>
                            </div>
                            <div class="text-sm text-end">
                                <h3 class="font-semibold">Teknisi : {{ $dataCase->teknisi->first_name }}</h3>
                            </div>
                        </div>
                        <div class="border mt-2 p-2 text-sm0">
                            @foreach ($dataCase->timestampStatus as $timeStamp)
                                @foreach ($timeStamp->jurnal->where('timestamps_status_id', 1)->sortByDesc('created_at')->take(1) as $jurnal)
                                    {!! nl2br(e($jurnal->isi_jurnal)) !!}
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg border shadow-lg dark:bg-gray-800 dark:border-gray-600">
                <div class="grid grid-cols-3 gap-5">
                    <div class="relative col-span-2 overflow-x-auto">
                        <div class="border-b">
                            <h3 class="font-semibold text-sm pb-2">Input Estimasi</h3>
                        </div>
                        <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-900 border-b-2 uppercase dark:text-white">
                                <tr>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Jenis Transaksi
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Jenis Produk
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 30%">
                                        Product Name
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 20%">
                                        Harga Customer
                                    </th>
                                    <th scope="col" class="px-2 py-3" style="width: 10%">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="container-input-estimasi">
                                
                            </tbody>
                            <tfoot>
                                <tr class="font-semibold text-sm text-gray-900 dark:text-white">
                                    <td colspan="4" class="px-2 py-3">
                                        <div class="flex items-center justify-between text-rose-600">
                                            <div class="flex cursor-pointer mt-2 hover:text-red-400">
                                                <button type="button" id="add-item-estimasi" class="flex flex-row justify-between gap-2">
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
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-900 border-b-2 uppercase dark:text-white">
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
                            <tbody id="container-data-gudang">
                                
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </form>

@endsection