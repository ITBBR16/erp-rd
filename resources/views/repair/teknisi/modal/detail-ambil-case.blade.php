@foreach ($dataCase as $case)
    @if ($case->teknisi_id == null)
        <div id="detail-ambil-case-{{ $case->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-7xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail {{ $case->customer->first_name }} {{ $case->customer->last_name }}</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-ambil-case-{{ $case->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-2 py-2 lg:px-8 lg:py-6 bg-gray-50 dark:bg-gray-600">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg bg-white border border-gray-200 shadow-md dark:bg-gray-700 dark:border-gray-600">
                                <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Detail Customer</h3>
                                <div class="grid grid-cols-2 gap-4 mb-2">
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1 text-black dark:text-white">Nama Customer</h3>
                                        <p class="text-gray-500 text-base dark:text-white">{{ $case->customer->first_name }} {{ $case->customer->last_name }} - {{ $case->customer->id }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1 text-black dark:text-white">Jenis Drone</h3>
                                        <p class="text-gray-500 text-base dark:text-white">{{ $case->jenisProduk->jenis_produk }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1 text-black dark:text-white">Fungsional Drone</h3>
                                        <p class="text-gray-500 text-base dark:text-white">{{ $case->jenisFungsional->jenis_fungsional }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1 text-black dark:text-white">Jenis Case</h3>
                                        <p class="text-gray-500 text-base dark:text-white">{{ $case->jenisCase->jenis_case }}</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold mb-4 pt-2 border-t dark:text-white">Detail Kronologi</h3>
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
                            <div class="p-4 rounded-lg bg-white border border-gray-200 shadow-md dark:bg-gray-700 dark:border-gray-600">
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
                                                <tr class="bg-white dark:bg-gray-800">
                                                    <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                        {{ $item->itemKelengkapan->kelengkapan }}
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
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
