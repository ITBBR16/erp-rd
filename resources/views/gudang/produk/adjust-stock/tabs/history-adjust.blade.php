<div class="hidden p-4" id="history-adjust" role="tabpanel" aria-labelledby="history-adjust-tab">
    <div class="relative overflow-x-auto">
        <div class="flex items-center justify-between py-4">
            <div class="flex text-xl">
                <span class="text-gray-700 font-semibold dark:text-gray-300">History Adjust Stock</span>
            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Items">
            </div>
        </div>
    </div>
    <div class="relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        SKU
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Sparepart
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ID Item
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Supplier
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Adjust
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historyAdjust as $item)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                        <th class="px-6 py-2">
                            @php
                                $sku = $item->idItemGudang->gudangProduk->produkSparepart->produkType->code . "." . $item->idItemGudang->gudangProduk->produkSparepart->partModel->code . "." . 
                                        $item->idItemGudang->gudangProduk->produkSparepart->produk_jenis_id . "." . $item->idItemGudang->gudangProduk->produkSparepart->partBagian->code . "." . 
                                        $item->idItemGudang->gudangProduk->produkSparepart->partSubBagian->code . "." . $item->idItemGudang->gudangProduk->produkSparepart->produk_part_sifat_id;
                            @endphp
                            {{ $sku }}
                        </th>
                        <td class="px-6 py-2">
                            {{ $item->idItemGudang->gudangProduk->produkSparepart->nama_internal }}
                        </td>
                        <td class="px-6 py-2">
                            {{ ($item->idItemGudang->produk_asal == 'Belanja') ? 'N' : (($item->idItemGudang->produk_asal == 'Split') ? 'P' : 'G' ) }}.{{ $item->idItemGudang->gudang_belanja_id }}.{{ $item->idItemGudang->gudangBelanja->gudang_supplier_id }}.{{ $item->idItemGudang->id }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $item->idItemGudang->gudangBelanja->gudangSupplier->nama }}
                        </td>
                        <td class="px-6 py-2">
                            {{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-2">
                            <span class="bg-red-500 text-white font-medium me-2 px-2.5 py-0.5 rounded-full">{{ $item->status }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>