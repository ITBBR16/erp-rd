@foreach ($payment as $validasiPayment)
    <div id="konfirmasi-pembayaran{{ $validasiPayment->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Req Payment Order {{ ($validasiPayment->order_type == 'Baru') ? 'N.' . $validasiPayment->order_id : 'S.' . $validasiPayment->order_id }}</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="konfirmasi-pembayaran{{ $validasiPayment->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Daftar Penjual</h3>
                    <form action="{{ route('form-validasi-payment', ['id' => $validasiPayment->id]) }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="status_order" value="{{ $validasiPayment->order_type }}">
                        <input type="hidden" name="order_id" id="order_id{{ $validasiPayment->id }}" value="{{ ($validasiPayment->order_type == 'Baru') ? $validasiPayment->order->id : $validasiPayment->ordersecond->id }}">
                        <div class="grid md:grid-cols-2 md:gap-6 pt">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="supplier_kios" id="supplier_kios{{ $validasiPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ ($validasiPayment->order_type == 'Baru') ? $validasiPayment->order->supplier->nama_perusahaan : $validasiPayment->ordersecond->customer->first_name ." ". $validasiPayment->ordersecond->customer->last_name }}" readonly required>
                                <label for="supplier_kios{{ $validasiPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Supplier</label>
                            </div>
                            @error('supplier_kios')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" id="tanggal_req{{ $validasiPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ \Carbon\Carbon::parse(($validasiPayment->order_type == 'Baru') ? $validasiPayment->order->created_at : $validasiPayment->ordersecond->tanggal_pembelian)->isoFormat('D MMMM YYYY') }}" readonly required>
                                <label for="tanggal_req{{ $validasiPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal Request</label>
                            </div>
                            @error('tanggal_req{{ $validasiPayment->id }}')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <h3 class="my-3 font-semibold text-gray-900 dark:text-white">Data Transaksi</h3>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="media_transaksi" id="media_transaksi{{ $validasiPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('media_transaksi{{ $validasiPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ $validasiPayment->metodepembayaran->media_pembayaran ?? '' }}" readonly required>
                                <label for="media_transaksi{{ $validasiPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Media Transaksi</label>
                                @error('media_transaksi{{ $validasiPayment->id }}')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="no_rek" id="no_rek{{ $validasiPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('no_rek{{ $validasiPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ $validasiPayment->metodepembayaran->no_rek ?? '' }}" readonly required>
                                <label for="no_rek{{ $validasiPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Rekening / VA</label>
                                @error('no_rek{{ $validasiPayment->id }}')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="nama_akun" id="nama_akun{{ $validasiPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama_akun{{ $validasiPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ $validasiPayment->metodepembayaran->nama_akun ?? '' }}" readonly required>
                            <label for="nama_akun{{ $validasiPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Akun</label>
                            @error('nama_akun{{ $validasiPayment->id }}')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-3 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="nilai_belanja" id="nilai_belanja{{ $validasiPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nilai_belanja{{ $validasiPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="Rp. {{ number_format($validasiPayment->nilai, 0, ',', '.') }}" readonly required>
                                <label for="nilai_belanja{{ $validasiPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total Belanja</label>
                                @error('nilai_belanja{{ $validasiPayment->id }}')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="ongkir" id="ongkir{{ $validasiPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('ongkir{{ $validasiPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="Rp. {{ number_format($validasiPayment->ongkir, 0, ',', '.') }}" readonly>
                                <label for="ongkir{{ $validasiPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ongkir</label>
                                @error('ongkir{{ $validasiPayment->id }}')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="pajak" id="pajak{{ $validasiPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('pajak{{ $validasiPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="Rp. {{ number_format($validasiPayment->pajak, 0, ',', '.') }}" readonly>
                                <label for="pajak{{ $validasiPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pajak</label>
                                @error('pajak{{ $validasiPayment->id }}')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="keterangan" id="keterangan{{ $validasiPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('keterangan{{ $validasiPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" required>
                            <label for="keterangan{{ $validasiPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
                            @error('keterangan{{ $validasiPayment->id }}')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center pt-3 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
