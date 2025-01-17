@foreach ($dataFormRepair as $data)
    <div id="detail-penerimaan-{{ $data->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-6xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail {{ $data->nama_lengkap }}</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-penerimaan-{{ $data->id }}">
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
                            <h3 class="text-lg font-semibold text-black mb-4 dark:text-white">Detail Customer</h3>
                            <div class="grid grid-cols-2 gap-4 mb-2">
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Nama Customer</h3>
                                    <p class="text-gray-500 text-base">{{ $data->nama_lengkap }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">No Telpon</h3>
                                    <p class="text-gray-500 text-base">{{ $data->no_wa }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Jenis Drone</h3>
                                    <p class="text-gray-500 text-base">{{ $data->tipe_produk }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Fungsional Drone</h3>
                                    <p class="text-gray-500 text-base">{{ $data->fungsional_produk }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 rounded-lg bg-white border border-gray-200 shadow-md dark:bg-gray-700 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-black mb-4 dark:text-white">Detail Kronologi</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Keluhan</h3>
                                    <p class="text-gray-500 text-base">{{ $data->keluhan ?? "-" }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Kronologi Kerusakan</h3>
                                    <p class="text-gray-500 text-base">{{ $data->kronologi_kerusakan ?? "-" }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Penggunaan After Crash</h3>
                                    <p class="text-gray-500 text-base">{{ $data->penanganan_after_crash ?? "-" }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Riwayat Penggunaan</h3>
                                    <p class="text-gray-500 text-base">{{ $data->riwayat_penggunaan ?? "-" }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach