@foreach ($dataTransaksi as $transaksi)
    @if ($transaksi->status_dp != '' || $transaksi->status_po != '')
        <div id="dppo-views-{{ $transaksi->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Detail {{ $transaksi->customer->first_name }} {{ $transaksi->customer->last_name }}
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">status</span>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="dppo-views-{{ $transaksi->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="px-6 py-6 lg:px-8">
                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <div class="grid-rows-2">
                                <h3 class="text-base font-medium text-gray-900 dark:text-white">Nama Kasir</h3>
                                <h3 class="text-base text-gray-900 dark:text-white">{{ $transaksi->employee->first_name }} {{ $transaksi->employee->last_name }}</h3>
                            </div>
                            <div class="grid-rows-2">
                                <h3 class="text-base font-medium text-gray-900 dark:text-white">Tanggal Dibuat</h3>
                                <h3 class="text-base text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($transaksi->created_at)->locale('id_ID')->isoFormat('D MMMM YYYY, HH:mm [WIB]') }}</h3>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <div class="grid-rows-2">
                                <h3 class="text-base font-medium text-gray-900 dark:text-white">Rekening Pembayaran</h3>
                                <h3 class="text-base text-gray-900 dark:text-white">{{ $transaksi->metodepembayaran->nama_akun }}</h3>
                            </div>
                            <div class="grid-rows-2">
                                <h3 class="text-base font-medium text-gray-900 dark:text-white">Total Nominal Belanja</h3>
                                <h3 class="text-base text-gray-900 dark:text-white">Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 mb-4 pb-4 border-b-2">
                            <div class="grid-rows-2">
                                <h3 class="text-base font-medium text-gray-900 dark:text-white">Total DP Customer</h3>
                                <h3 class="text-base text-gray-900 dark:text-white">Rp. {{ number_format($transaksi->transaksidp->jumlah_pembayaran, 0, ',', '.') }}</h3>
                            </div>
                            <div class="grid-rows-2">
                                <h3 class="text-base font-medium text-gray-900 dark:text-white">Sisa Pembayaran</h3>
                                @php
                                    $totalSisa = $transaksi->total_harga - $transaksi->transaksidp->jumlah_pembayaran;
                                @endphp
                                <h3 class="text-base text-gray-900 dark:text-white">Rp. {{ number_format($totalSisa, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                        <ul class="max-w-lg divide-y divide-gray-200 dark:divide-gray-500">
                            <li class="">
                                <div class="grid grid-cols-7 gap-4 mb-4">
                                    <div class="col-span-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Transaksi</div>
                                    <div class="col-span-4 text-sm font-medium text-gray-900 dark:text-white">Nama Produk</div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Qty</div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                @foreach ($transaksi->detailtransaksi->unique('kios_produk_id') as $detail)
                                    <div class="grid grid-cols-7 gap-4 mb-4">
                                        <div class="col-span-2 text-sm text-gray-900 dark:text-white">{{ $detail->jenis_transaksi }}</div>
                                        <div class="col-span-4 text-sm text-gray-900 dark:text-white">{{ $detail->produkKios->subjenis->produkjenis->jenis_produk }} {{ $detail->produkKios->subjenis->paket_penjualan }}</div>
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $transaksi->detailtransaksi->where('kios_produk_id', $detail->kios_produk_id)->count() }}</div>
                                    </div>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
