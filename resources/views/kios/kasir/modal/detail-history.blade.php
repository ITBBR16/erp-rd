@foreach ($dataHistory as $item)
    <div id="detail-history-{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-8xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail {{ $item->customer->first_name }} {{ $item->customer->last_name ?? '' }} - {{ $item->customer->id }}</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-history-{{ $item->id }}">
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
                            <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Informasi Customer</h3>
                            <div class="grid grid-cols-2 gap-4 mb-2">
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Customer</h3>
                                    <p class="text-gray-500 text-base">{{ $item->customer->first_name }} {{ $item->customer->last_name ?? '' }} - {{ $item->customer->id }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">No Invoice</h3>
                                    <p class="text-gray-500 text-base">{{ $item->created_at->format('Ymd') }}{{ $item->id }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Status DP</h3>
                                    <p class="text-gray-500 text-base">-</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Status PO</h3>
                                    <p class="text-gray-500 text-base">-</p>
                                </div>
                                {{-- <a href="" target="_blank" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Invoice</a> --}}
                            </div>
                            <h3 class="text-lg font-semibold mb-4 pt-2 border-t text-black dark:text-white">Akun Pembayaran Customer</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Total Nilai Produk</h3>
                                    <p class="text-gray-500 text-base">Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Total Nilai Discount</h3>
                                    <p class="text-gray-500 text-base">Rp. {{ number_format($item->discount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Total Nilai Ongkir</h3>
                                    <p class="text-gray-500 text-base">Rp. {{ number_format($item->ognkir, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Total Nilai Pajak</h3>
                                    <p class="text-gray-500 text-base">Rp. {{ number_format($item->tax, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-span-2">
                                    <h3 class="text-sm font-semibold mb-1">Keterangan</h3>
                                    <p class="text-gray-500 text-base">{{ $item->keterangan }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 rounded-lg bg-white border border-gray-200 shadow-md dark:bg-gray-700 dark:border-gray-600">
                            <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Daftar Produk</h3>
                            <div class="relative overflow-y-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 rounded-s-lg">
                                                Jenis Transaksi
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Produk
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                SN / Id Item
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Harga Promo
                                            </th>
                                            <th scope="col" class="px-6 py-3 rounded-e-lg">
                                                Harga SRP
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->detailtransaksi as $detail)
                                            <tr class="bg-white dark:bg-gray-800">
                                                @php
                                                    $jenisTransaksi = ucwords(str_replace('_', ' ', $detail->jenis_transaksi));
                                                    $serialNumber = match ($detail->jenis_transaksi) {
                                                        'drone_baru' => optional($detail->kiosSerialnumbers)->serial_number,
                                                        'drone_bekas' => optional($detail->produkKiosBekas)->serial_number,
                                                        'drone_bnob' => optional($detail->produkKiosBnob)->serial_number,
                                                        default => '',
                                                    };
                                                @endphp
                                    
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                    {{ $jenisTransaksi }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ optional($detail->produkKios->subjenis)->paket_penjualan }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $serialNumber }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    Rp. {{ number_format($detail->harga_promo, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    Rp. {{ number_format($detail->harga_jual, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    
                                        @foreach ($item->transaksiPart as $detail)
                                            <tr class="bg-white dark:bg-gray-800">
                                                @php
                                                    $jenisTransaksi = ucwords(str_replace('_', ' ', $detail->jenis_transaksi_part));
                                                    $produkAsal = optional($detail->gudangIdItem)->produk_asal;
                                                    $supplierId = optional($detail->gudangBelanja)->gudang_supplier_id;
                                                    $code = match ($produkAsal) {
                                                        'Belanja' => 'N.',
                                                        'Split' => 'P.',
                                                        default => 'E.',
                                                    };
                                                    $idItem = $code . optional($detail->gudangIdItem)->gudang_belanja_id . '.' . $supplierId . '.' . optional($detail->gudangIdItem)->id;
                                                @endphp
                                    
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                    {{ $jenisTransaksi }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ optional($detail->sparepart)->nama_internal }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $idItem }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    Rp. {{ number_format(0, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    Rp. {{ number_format($detail->harga_jual_part, 0, ',', '.') }}
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
@endforeach

