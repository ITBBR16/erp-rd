<div class="relative mt-2">
    <div class="overflow-y-auto max-h-[550px]">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="sticky top-0 text-xs text-gray-700 uppercase tracking-wider bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3" style="width: 14%;">
                        SKU
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 30%;">
                        Nama Sparepart
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 10%;">
                        Stok
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 13%;">
                        Harga Internal
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 13%;">
                        Harga Global
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 10%;">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 10%;">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataProduk as $produk)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600 customer-row">
                        <td class="px-6 py-2">
                            @php
                                $sku = $produk->produkSparepart->produkType->code . "." . $produk->produkSparepart->partModel->code . "." . 
                                        $produk->produkSparepart->produkJenis->code . "." . $produk->produkSparepart->partBagian->code . "." . 
                                        $produk->produkSparepart->partSubBagian->code . "." . $produk->produkSparepart->produk_part_sifat_id . "." . $produk->produkSparepart->id;
                            @endphp
                            {{ $sku }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $produk->produkSparepart->nama_internal }}
                        </td>
                        <td class="px-6 py-2">
                            @php
                                $stock = $produk->produkSparepart->gudangIdItem->where('status_inventory', 'Ready')->count()
                            @endphp
                            {{ $stock }}
                        </td>
                        <td class="px-6 py-2">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-bold text-gray-700 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-300 dark:border-gray-600">RP</span>
                                <input type="text" id="harga-internal-{{ $produk->id }}" data-id="{{ $produk->id }}" class="format-angka-rupiah harga-internal rounded-none rounded-e-lg bg-gray-50 border text-base text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-12 border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($produk->harga_internal, 0, ',', '.') }}">
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-bold text-gray-700 bg-gray-200 border rounded-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-300 dark:border-gray-600">RP</span>
                                <input type="text" id="harga-global-{{ $produk->id }}" data-id="{{ $produk->id }}" class="format-angka-rupiah harga-global rounded-none rounded-e-lg bg-gray-50 border text-base text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-12 border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="{{ number_format($produk->harga_global, 0, ',', '.') }}">
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            @php
                                $statusColors = [
                                    'Ready' => 'bg-green-500',
                                    'Promo' => 'bg-red-500',
                                    'Pending' => 'bg-orange-500'
                                ];
                            @endphp
                            <span class="{{ $statusColors[$produk->status] ?? 'bg-gray-500' }} text-white font-medium px-2.5 py-0.5 rounded-full">
                                {{ $produk->status }}
                            </span>
                        </td>
                        <td class="px-6 py-2">
                            <button id="dropdownListProduk{{ $produk->id }}" data-dropdown-toggle="dropdownLP{{ $produk->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <!-- Dropdown menu -->
                    <div id="dropdownLP{{ $produk->id }}" class="z-10 hidden bg-white rounded-lg shadow w-40 dark:bg-gray-700">
                        <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownListProduk{{ $produk->id }}">
                            <li>
                                <button type="button" data-modal-target="detail-produk-{{ $produk->id }}" data-modal-toggle="detail-produk-{{ $produk->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                    <i class="material-symbols-outlined text-base mr-3">visibility</i>
                                    <span class="whitespace-nowrap">Detail Produk</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" data-modal-target="promo-sparepart-{{ $produk->id }}" data-modal-toggle="promo-sparepart-{{ $produk->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                    <i class="material-symbols-outlined text-base mr-3">confirmation_number</i>
                                    <span class="whitespace-nowrap">Add Promo</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4">
                            <div class="p-4">
                                <div class="flex items-center justify-center">
                                    <figure class="max-w-lg">
                                        <img class="h-auto max-w-full rounded-lg" src="/img/security-system.png" alt="Not Found" width="250" height="150">
                                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Data Tidak Ada.</figcaption>
                                    </figure>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 ">
    {{ $dataProduk->appends(['search' => request('search')])->links() }}
</div>


{{-- Modal --}}
@include('gudang.produk.list-produk.modal.detail-produk')
@include('gudang.produk.list-produk.modal.promo-produk')