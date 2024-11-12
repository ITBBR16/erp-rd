@foreach ($groupedItems as $items)
    @php
        $qc = $items->first();
        $quantityCount = $items->count();
    @endphp
    @if ($qc->qualityControll->checked_quantity == '' || $qc->qualityControll->checked_fungsional == '')
        <div id="detail-qc-{{ $qc->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail QC N.{{ $qc->gudang_belanja_id }} / <i>{{ $sku }}</i></h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-qc-{{ $qc->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-2 py-2 lg:px-8 lg:py-6 bg-gray-50 dark:bg-gray-600">
                        <div class="p-4 rounded-lg bg-white border shadow-md dark:bg-gray-700 dark:border-gray-600">
                            <h3 class="text-lg font-semibold mb-4 dark:text-white">Informasi Pembelian</h3>
                            <div class="grid grid-cols-2 gap-4 mb-2">
                                <div>
                                    <h3 class="text-xs font-semibold mb-1">Supplier</h3>
                                    <p class="text-gray-500 text-sm">{{ $qc->gudangBelanja->gudangSupplier->nama }}</p>
                                </div>
                                <div>
                                    <h3 class="text-xs font-semibold mb-1">Invoice Supplier</h3>
                                    <p class="text-gray-500 text-sm">{{ $qc->gudangBelanja->invoice }}</p>
                                </div>
                                <div>
                                    <h3 class="text-xs font-semibold mb-1">Nama Sparepart</h3>
                                    <p class="text-gray-500 text-sm">{{ $qc->gudangProduk->produkSparepart->nama_internal }}</p>
                                </div>
                                <div>
                                    <h3 class="text-xs font-semibold mb-1">Jumlah Sparepart</h3>
                                    <p class="text-gray-500 text-sm">{{ $quantityCount }}</p>
                                </div>
                                <div>
                                    <h3 class="text-xs font-semibold mb-1">SKU Sparepart Supplier</h3>
                                    <p class="text-gray-500 text-sm">{{ $qc->gudangProduk->produkSparepart->sku_origin ?? '-' }}</p>
                                </div>
                                <div>
                                    <h3 class="text-xs font-semibold mb-1">Nama Sparepart Supplier</h3>
                                    <p class="text-gray-500 text-sm">{{ $qc->gudangProduk->produkSparepart->nama_origin ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
