@extends('repair.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("case-list.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">list_alt</span>
                    List Case
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Detail {{ $case->customer->first_name }} {{ $case->customer->last_name }} - {{ $case->customer->id }} - {{ $case->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-2 gap-4 mt-4">
        <div class="p-4 rounded-lg bg-white border border-gray-100 shadow-md dark:bg-gray-700 dark:border-gray-600">
            <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Detail Customer</h3>
            <div class="grid grid-cols-2 gap-4 mb-2">
                <div>
                    <h3 class="text-sm font-semibold mb-1">Nama Customer</h3>
                    <p class="text-gray-500 text-base">{{ $case->customer->first_name }} {{ $case->customer->last_name }} - {{ $case->customer->id }} - {{ $case->id }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-1">Jenis Drone</h3>
                    <p class="text-gray-500 text-base">{{ $case->jenisProduk->jenis_produk }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-1">Fungsional Drone</h3>
                    <p class="text-gray-500 text-base">{{ $case->jenisFungsional->jenis_fungsional }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-1">Jenis Case</h3>
                    <p class="text-gray-500 text-base">{{ $case->jenisCase->jenis_case }}</p>
                </div>
                <div class="col-span-2 mb-2">
                    <h3 class="text-sm font-semibold mb-3">Link Drive</h3>
                    <a href="{{ $case->link_doc }}" target="_blank" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Folder Drive</a>
                </div>
            </div>
            <h3 class="text-lg font-semibold mb-4 pt-2 border-t text-black dark:text-white">Detail Kronologi</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-semibold mb-1">Keluhan</h3>
                    <p class="text-gray-500 text-base">{{ $case->keluhan ?? "-" }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-1">Kronologi Kerusakan</h3>
                    <p class="text-gray-500 text-base">{{ $case->kronologi_kerusakan ?? "-" }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-1">Penggunaan After Crash</h3>
                    <p class="text-gray-500 text-base">{{ $case->penanganan_after_crash ?? "-" }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold mb-1">Riwayat Penggunaan</h3>
                    <p class="text-gray-500 text-base">{{ $case->riwayat_penggunaan ?? "-" }}</p>
                </div>
            </div>
        </div>
        <div class="p-4 rounded-lg bg-white border border-gray-100 shadow-md dark:bg-gray-700 dark:border-gray-600">
            <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Daftar Kelengkapan</h3>
            <div class="relative overflow-y-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-s-lg">
                                Kelengkapan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Quantity
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Serial Number
                            </th>
                            <th scope="col" class="px-6 py-3 rounded-e-lg">
                                Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($case->detailKelengkapan as $item)
                            <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ ($item->item_kelengkapan_id == null) ? $item->nama_data_lama : $item->itemKelengkapan->kelengkapan }}
                                </th>
                                <td class="px-6 py-4 items-center">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->serial_number ?? "-" }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->keterangan ?? "-" }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 mt-4">
        <div class="grid-rows-2 space-y-4">
            <div class="bg-white rounded-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-600">
                <div class="relative">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-3 py-2" style="width: 30%">
                                    Pengecekkan Fisik
                                </th>
                                <th scope="col" class="px-3 py-2" style="width: 10%">
                                    Check
                                </th>
                                <th scope="col" class="px-3 py-2" style="width: 20%">
                                    Kondisi
                                </th>
                                <th scope="col" class="px-3 py-2" style="width: 40%">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (optional($case?->qualityControl?->cekFisik)->isNotEmpty())
                                @foreach ($case->qualityControl->cekFisik as $fisik)
                                    <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-3 py-2">
                                            {{ $fisik->qcKategori->nama }}
                                        </td>
                                        <td class="px-3 py-2">
                                            <input {{ ($fisik->check == 1) ? 'checked' : '' }} type="checkbox" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" disabled>
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $fisik->qcKondisi->nama ?? "-" }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $fisik->keterangan }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 py-4">
                                        Tidak ada data quality control.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="grid grid-cols-3">
                <div class="bg-white col-span-2 rounded-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-600">
                    <div class="relative">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-3 py-2" style="width: 30%">
                                        Calibrasi
                                    </th>
                                    <th scope="col" class="px-3 py-2" style="width: 10%">
                                        Check
                                    </th>
                                    <th scope="col" class="px-3 py-2" style="width: 60%">
                                        Keterangan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (optional($case?->qualityControl?->cekCalibrasi)->isNotEmpty())
                                    @foreach ($case?->qualityControl->cekCalibrasi as $calibrasi)
                                        <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-3 py-2">
                                                {{ $calibrasi->qcKategori->nama }}
                                            </td>
                                            <td class="px-3 py-2">
                                                <input {{ ($calibrasi->check == 1) ? 'checked' : '' }} type="checkbox" value="" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" disabled>
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $calibrasi->keterangan }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500 py-4">
                                            Tidak ada data quality control.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-span-1 ml-2 p-2 bg-white">
                    <h3 class="text-sm text-left text-gray-500 dark:text-gray-400">Frimware Version</h3>
                    <ol class="relative border-s border-gray-200 dark:border-gray-700">
                        <li class="mb-4 ms-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-2 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                            <p class="p-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">Aircraft</p>
                            <h3 class="p-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $case->qualityControl->fv_aircraft ?? "-" }}</h3>
                        </li>
                        <li class="mb-4 ms-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                            <p class="p-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">RC</p>
                            <h3 class="p-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $case->qualityControl->fv_rc ?? "-" }}</h3>
                        </li>
                        <li class="ms-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                            <p class="p-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">Battery</p>
                            <h3 class="p-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $case->qualityControl->fv_battery ?? "-" }}</h3>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-600">
                <div class="relative">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-3 py-2" style="width: 30%">
                                    Testfly
                                </th>
                                <th scope="col" class="px-3 py-2" style="width: 10%">
                                    Check
                                </th>
                                <th scope="col" class="px-3 py-2" style="width: 60%">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (optional($case?->qualityControl?->testFly)->isNotEmpty())
                                @foreach ($case?->qualityControl->testFly as $testFly)
                                    <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-3 py-2">
                                            {{ $testFly->qcKategori->nama }}
                                        </td>
                                        <td class="px-3 py-2">
                                            <input {{ ($testFly->check == 1) ? 'checked' : '' }} type="checkbox" value="" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" disabled>
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $testFly->keterangan }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 py-4">
                                        Tidak ada data quality control.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="border border-gray-200 block p-4 bg-white text-sm text-gray-900 rounded-lg dark:border-gray-600 space-y-4">
                <h3 class="text-base font-semibold text-black dark:text-white">Kesimpulan</h3>
                <p>{{ $case?->qualityControl->kesimpulan ?? "-" }}</p>
            </div>
        </div>
        <div>
            <div class="border border-gray-200 block p-4 bg-white text-sm text-gray-900 rounded-lg dark:border-gray-600 space-y-4">
                <div class="border-b grid grid-cols-2 gap-2 pb-2">
                    <div class="text-base text-start">
                        <h3 class="font-semibold">All Jurnal</h3>
                    </div>
                    <div class="text-sm text-end">
                        <h3 class="font-semibold">Teknisi : {{ $case->teknisi->first_name ?? "-" }}</h3>
                    </div>
                </div>
                <ol class="relative border-s border-gray-200 dark:border-gray-700">
                    @foreach ($case->timestampStatus as $status)
                        <li class="mb-10 ms-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($status->created_at)->isoFormat('D MMMM YYYY') }}</time>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $status->jenisStatus->jenis_status }}</h3>
                            @foreach ($status->jurnal as $jurnal)
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($jurnal->created_at)->isoFormat('D MMMM YYYY') }}</p>
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{!! nl2br(e($jurnal->isi_jurnal)) !!}</p>
                            @endforeach
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
        
    </div>

@endsection