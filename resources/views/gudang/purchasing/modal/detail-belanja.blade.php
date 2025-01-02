@foreach ($listBelanja as $belanja)
    <div id="detail-belanja-{{ $belanja->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-7xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail Belanja N.{{ $belanja->id }}</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-belanja-{{ $belanja->id }}">
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
                            <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Informasi Pembelian</h3>
                            <div class="grid grid-cols-2 gap-4 mb-2">
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Supplier</h3>
                                    <p class="text-gray-500 text-base">{{ $belanja->gudangSupplier->nama }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Invoice Supplier</h3>
                                    <p class="text-gray-500 text-base">{{ $belanja->invoice }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Total Item</h3>
                                    <p class="text-gray-500 text-base">{{ $belanja->total_quantity }} Unit</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Subtotal</h3>
                                    <p class="text-gray-500 text-base">Rp. {{ number_format($belanja->total_pembelian, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Nominal Ongkir</h3>
                                    <p class="text-gray-500 text-base">Rp. {{ number_format($belanja->total_ongkir, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Nominal Pajak</h3>
                                    <p class="text-gray-500 text-base">Rp. {{ number_format($belanja->total_pajak, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold mb-4 pt-2 border-t text-black dark:text-white">Akun Pembayaran Supplier</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Media Transaksi</h3>
                                    <p class="text-gray-500 text-base">{{ $belanja->gudangMetodePembayaran->media_transaksi }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Bank Pembayaran</h3>
                                    <p class="text-gray-500 text-base">{{ $belanja->gudangMetodePembayaran->namaBank->nama }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Nama Akun</h3>
                                    <p class="text-gray-500 text-base">{{ $belanja->gudangMetodePembayaran->nama_akun }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">ID Akun</h3>
                                    <p class="text-gray-500 text-base">{{ $belanja->gudangMetodePembayaran->id_akun }}</p>
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
                                                Jenis Drone
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Sparepart
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Qty
                                            </th>
                                            <th scope="col" class="px-6 py-3 rounded-e-lg">
                                                Harga
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($belanja->detailBelanja as $detail)
                                            <tr class="bg-white dark:bg-gray-800">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                    {{ $detail->sparepart->produkJenis->jenis_produk }}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                    {{ $detail->sparepart->nama_internal }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $detail->quantity }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    Rp. {{ number_format($detail->nominal_pcs, 0, ',', '.') }}
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

