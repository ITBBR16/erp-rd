@foreach ($reqPayments as $reqPayment)
    <div id="detail-req-payment-{{ $reqPayment->id }}" tabindex="-1" class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[cal(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail Request Payment</h3>
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-req-payment-{{ $reqPayment->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8 lg:py-6 bg-white dark:bg-gray-700">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <h3 class="text-sm font-semibold mb-1">Ref Gudang</h3>
                            <p class="text-gray-500 text-base">Gudang-{{ $reqPayment->id }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold mb-1">Order ID</h3>
                            <p class="text-gray-500 text-base">N.{{ $reqPayment->gudang_belanja_id }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold mb-1">Media Transaksi</h3>
                            <p class="text-gray-500 text-base">{{ $reqPayment->metodePembayaran->media_transaksi }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold mb-1">Nama Akun</h3>
                            <p class="text-gray-500 text-base">{{ $reqPayment->metodePembayaran->nama_akun }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold mb-1">Bank Pembayaran</h3>
                            <p class="text-gray-500 text-base">{{ $reqPayment->metodePembayaran->namaBank->nama }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold mb-1">ID Akun</h3>
                            <p class="text-gray-500 text-base">{{ $reqPayment->metodePembayaran->id_akun }}</p>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="flex flex-wrap justify-between">
                            <div class="flex">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Harga Barang</span>
                            </div>
                            <div class="justify-end">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Rp. {{ number_format($reqPayment->gudangBelanja->total_pembelian, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-between">
                            <div class="flex">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Ongkir</span>
                            </div>
                            <div class="justify-end">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Rp. {{ number_format($reqPayment->gudangBelanja->total_ongkir, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-between">
                            <div class="flex">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Pajak</span>
                            </div>
                            <div class="justify-end">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Rp. {{ number_format($reqPayment->gudangBelanja->total_pajak, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-between">
                            <div class="flex">
                                <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Total Biaya : </span>
                            </div>
                            <div class="justify-end">
                                @php
                                    $totalBiaya = $reqPayment->gudangBelanja->total_pembelian + $reqPayment->gudangBelanja->total_ongkir + $reqPayment->gudangBelanja->total_pajak;
                                @endphp
                                <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Rp. {{ number_format($totalBiaya, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-sm font-semibold mb-1">Keterangan</h3>
                        <div class="p-2 border rounded-lg">
                            <p class="text-gray-500 text-base">{{ $reqPayment->keterangan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach