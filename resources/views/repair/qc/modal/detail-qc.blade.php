@foreach ($dataCase as $case)
    @if ($case->jenisStatus->jenis_status == 'Proses Quality Control')
        <div id="detail-qc-{{ $case->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-full max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail Hasil QC Nama Customer</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-qc-{{ $case->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-6 py-6 lg:px-8 bg-gray-50">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="grid-rows-2 space-y-4">
                                <div class="bg-white rounded-lg border dark:bg-gray-800 dark:border-gray-600">
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
                                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
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
                                    <div class="bg-white col-span-2 rounded-lg border dark:bg-gray-800 dark:border-gray-600">
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
                                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                                <td class="px-3 py-2">
                                                                    {{ $calibrasi->qcKategori->nama }}
                                                                </td>
                                                                <td class="px-3 py-2">
                                                                    <input {{ ($calibrasi->check == 1) ? 'checked' : '' }} type="checkbox" value="" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                            </div>
                            <div>
                                <div class="bg-white rounded-lg border dark:bg-gray-800 dark:border-gray-600">
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
                                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                            <td class="px-3 py-2">
                                                                {{ $testFly->qcKategori->nama }}
                                                            </td>
                                                            <td class="px-3 py-2">
                                                                <input {{ ($testFly->check == 1) ? 'checked' : '' }} type="checkbox" value="" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                            </div>
                            <div class="border block p-4 bg-white text-sm text-gray-900 rounded-lg dark:border-gray-600 space-y-4">
                                <h3 class="text-base font-semibold dark:text-white">Kesimpulan</h3>
                                <p>{{ $case?->qualityControl->kesimpulan ?? "-" }}</p>
                            </div>
                            <div class="border block p-4 bg-white text-sm text-gray-900 rounded-lg dark:border-gray-600 space-y-4">
                                <h3 class="text-base font-semibold dark:text-white">Jurnal</h3>
                                @php
                                    $timeStamp = $case?->timestampStatus?->firstWhere('jenis_status_id', 7);
                                @endphp

                                @if ($timeStamp && $timeStamp->jurnal->isNotEmpty())
                                    @foreach ($timeStamp->jurnal->sortByDesc('created_at')->take(1) as $jurnal)
                                        <p>{!! nl2br(e($jurnal->isi_jurnal)) !!}</p>
                                    @endforeach
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
