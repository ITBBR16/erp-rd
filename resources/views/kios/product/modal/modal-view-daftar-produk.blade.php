@foreach ($produks as $produk)
    <div id="view-detail-produk{{ $produk->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Detail Produk {{ $produk->subjenis->paket_penjualan }}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="view-detail-produk{{ $produk->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Detail Produk : </h3>
                            <div class="grid grid-cols-2 gap-4 mb-2">
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Harga Jual</h3>
                                    <p class="text-gray-500 text-base">Rp. {{ number_format($produk->srp, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Harga promo</h3>
                                    <p class="text-gray-500 text-base">Rp. {{ number_format($produk->harga_promo, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Tanggal Start Promo</h3>
                                    <p class="text-gray-500 text-base">{{ \Carbon\Carbon::parse($produk->start_promo)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Tanggal End Promo</h3>
                                    <p class="text-gray-500 text-base">{{ \Carbon\Carbon::parse($produk->end_promo)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Isi Kelengkapan :</h2>
                            <ul class="max-w-full space-y-1 text-gray-500 list-inside dark:text-gray-400 columns-2">
                                @foreach ($produk->subjenis->kelengkapans as $kelengkapan)
                                    <li class="flex items-center">
                                        <svg class="w-3.5 h-3.5 me-2 text-indigo-500 dark:text-indigo-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                        </svg>
                                        {{ $kelengkapan->kelengkapan }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h2 class="my-2 text-lg font-semibold text-gray-900 dark:text-white">Serial Number Ready :</h2>
                            <div class="overflow-y-auto max-h-[250px]">
                                <table id="produk-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="sticky top-0 text-xs text-gray-700 uppercase tracking-wider bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                        <tr>
                                            <th scope="col" class="px-6 py-3" style="width: 60%;">
                                                Serial Number
                                            </th>
                                            <th scope="col" class="px-6 py-3" style="width: 40%;">
                                                Modal Awal
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($produk->serialnumber as $sn)
                                            @if ($sn->status == 'Ready')
                                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600 customer-row">
                                                <td class="px-6 py-2">
                                                    {{ $sn->serial_number }}
                                                </td>
                                                <td class="px-6 py-2">
                                                    Rp. {{ number_format($sn->validasiproduk->orderLists->nilai, 0, ',', '.') }}
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
            </div>
        </div>
    </div>
@endforeach
