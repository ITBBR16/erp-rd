@foreach ($dataSplit as $split)
    <div id="view-detail-history-split-{{ $split->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-3xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Detail Split Produk {{ $split->kiosproduk->subjenis->paket_penjualan }}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="view-detail-history-split-{{ $split->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8">
                    <div class="relative">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3" style="width: 30%;">
                                        Kelengkapan
                                    </th>
                                    <th scope="col" class="px-6 py-3" style="width: 25%;">
                                        Serial Number
                                    </th>
                                    <th scope="col" class="px-6 py-3" style="width: 25%;">
                                        Modal
                                    </th>
                                    <th scope="col" class="px-6 py-3" style="width: 20%;">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($split->listKelengkapanSplit as $kelengkapan)
                                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                        <td class="px-6 py-2">
                                            {{ $kelengkapan->kelengkapanProduk->kelengkapan }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $kelengkapan->serial_number_split }}
                                        </td>
                                        <td class="px-6 py-2">
                                            Rp. {{ number_format($kelengkapan->nominal, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-2">
                                            <span class="bg-indigo-500 rounded-md px-2 py-0 text-white">{{ $kelengkapan->status }}</span>
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
@endforeach
