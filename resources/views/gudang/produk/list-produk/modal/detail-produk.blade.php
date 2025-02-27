@foreach ($dataProduk as $produk)
    <div id="detail-produk-{{ $produk->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Detail Sparepart / <span class="bg-{{ ($produk->status == 'Ready') ? 'green' : (($produk->status == 'Promo') ? 'red' : 'orange') }}-500 text-white text-sm font-medium me-2 px-2.5 py-0.5 rounded-full">{{ $produk->status }}</span>
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-produk-{{ $produk->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8">
                    <h2 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">Data Sparepart :</h2>
                    <div class="grid grid-cols-2 gap-4 mb-2">
                        <div>
                            <h3 class="text-xs font-semibold mb-1">SKU Internal</h3>
                            @php
                                $sku = $produk->produkSparepart->produkType->code . "." . $produk->produkSparepart->partModel->code . "." . 
                                        $produk->produkSparepart->produkJenis->code . "." . $produk->produkSparepart->partBagian->code . "." . 
                                        $produk->produkSparepart->partSubBagian->code . "." . $produk->produkSparepart->produk_part_sifat_id . "." . $produk->produkSparepart->id;
                            @endphp
                            <p class="text-gray-500 text-sm">{{ $sku }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-semibold mb-1">Nama Internal</h3>
                            <p class="text-gray-500 text-sm">{{ $produk->produkSparepart->nama_internal }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-semibold mb-1">Modal Awal</h3>
                            <p class="text-gray-500 text-sm">Rp. {{ number_format($produk->modal_awal, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-semibold mb-1">Harga Internal</h3>
                            <p class="text-gray-500 text-sm">Rp. {{ number_format($produk->harga_internal, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-semibold mb-1">Harga Global</h3>
                            <p class="text-gray-500 text-sm">Rp. {{ number_format($produk->harga_global, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-semibold mb-1">Harga Promo</h3>
                            <p class="text-gray-500 text-sm">Rp. {{ number_format($produk->harga_promo, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-semibold mb-1">Start Promo</h3>
                            <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($produk->tanggal_start_promo)->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-semibold mb-1">End Promo</h3>
                            <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($produk->tanggal_end_promo)->format('d M Y') ?? '-' }}</p>
                        </div>
                    </div>
                    <h2 class="my-2 text-base font-semibold text-gray-900 dark:text-white">ID Item Ready :</h2>
                    <ul class="max-w-full space-y-1 text-gray-500 list-inside dark:text-gray-400 columns-2">
                        @foreach ($produk->produkSparepart->gudangIdItem as $idItem)
                            @if ($idItem->status_inventory == 'Ready')
                                <li class="flex items-center">
                                    <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                    </svg>
                                    N.{{ $idItem->gudang_belanja_id }}.{{ $idItem->gudangBelanja->gudang_supplier_id }}.{{ $idItem->id }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach
