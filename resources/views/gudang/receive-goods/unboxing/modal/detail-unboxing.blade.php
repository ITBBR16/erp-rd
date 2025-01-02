@foreach ($dataUnboxing as $unboxing)
    <div id="detail-unboxing-{{ $unboxing->id }}" tabindex="-1" class="modal fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                {{-- Header Modal --}}
                <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Detail Unboxing N.{{ $unboxing->gudang_belanja_id }} / <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $unboxing->status }}</span>
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-unboxing-{{ $unboxing->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                {{-- Body Modal --}}
                <div class="px-2 py-2 lg:px-8 lg:py-6 bg-gray-50 dark:bg-gray-600">
                    <div class="p-4 rounded-lg bg-white border border-gray-200 shadow-md dark:bg-gray-700 dark:border-gray-600">
                        <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Informasi Pembelian</h3>
                        <div class="grid grid-cols-2 gap-4 mb-2">
                            <div>
                                <h3 class="text-sm font-semibold mb-1">Supplier</h3>
                                <p class="text-gray-500 text-base">{{ $unboxing->gudangBelanja->gudangSupplier->nama }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold mb-1">Invoice Supplier</h3>
                                <p class="text-gray-500 text-base">{{ $unboxing->gudangBelanja->invoice }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold mb-1">No Resi</h3>
                                <p class="text-gray-500 text-base">{{ $unboxing->gudangPengiriman->no_resi }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold mb-1">Total Item</h3>
                                <p class="text-gray-500 text-base">{{ $unboxing->gudangBelanja->total_quantity }} Unit</p>
                            </div>
                            <div>
                                <h3 class="text-sm text-left text-gray-500 dark:text-gray-400">Timeline Pengiriman</h3>
                                <ol class="relative border-s border-gray-200 dark:border-gray-700">
                                    <li class="mb-4 ms-4">
                                        <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-2 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                                        <p class="p-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">Tanggal Dikirim</p>
                                        <h3 class="p-1 text-sm font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($unboxing->gudangPengiriman->tanggal_pengiriman)->format('d M Y') }}</h3>
                                    </li>
                                    <li class="mb-4 ms-4">
                                        <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                                        <p class="p-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">Tanggal Diterima</p>
                                        <h3 class="p-1 text-sm font-semibold text-gray-900 dark:text-white">{{ ($unboxing->tanggal_diterima != null) ? \Carbon\Carbon::parse($unboxing->tanggal_diterima)->format('d M Y') : "-" }}</h3>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach