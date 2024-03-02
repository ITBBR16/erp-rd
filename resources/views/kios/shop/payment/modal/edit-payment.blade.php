@foreach ($payment as $editPayment)
    <div id="edit-pembayaran{{ $editPayment->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Edit Payment Order K.{{ $editPayment->order->id }}</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-pembayaran{{ $editPayment->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8">
                    <form action="{{ route('pembayaran.update', $editPayment->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="grid md:grid-cols-2 md:gap-6 pt">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="hidden" name="supplier_id" value="{{ $editPayment->order->supplier->id }}">
                                <input type="text" name="supplier_kios" id="supplier_kios{{ $editPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $editPayment->order->supplier->nama_perusahaan }}" readonly>
                                <label for="supplier_kios{{ $editPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Supplier</label>
                            </div>
                            @error('supplier_kios{{ $editPayment->id }}')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="invoice" id="invoice{{ $editPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $editPayment->order->invoice }}" readonly>
                                <label for="invoice{{ $editPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Invoice</label>
                            </div>
                            @error('invoice{{ $editPayment->id }}')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex">
                            <label class="relative inline-flex items-center me-5 mb-4 cursor-pointer">
                                <input type="checkbox" name="new-metode-payment-edit" id="new-metode-payment-edit" data-id="{{ $editPayment->id }}" value="" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-600 peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Metode Pembayaran Baru</span>
                            </label>
                        </div>
                        <div id="new-payment-metode-edit-{{ $editPayment->id }}">
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="hidden" name="metode_pembayaran_id" value="{{ $editPayment->metodepembayaran->id ?? '' }}">
                                    <input type="text" name="media_pembayaran" id="media-pembayaran-{{ $editPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('media-pembayaran-{{ $editPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('media-pembayaran', $editPayment->metodepembayaran->media_pembayaran ?? '') }}" readonly>
                                    <label for="media-pembayaran-{{ $editPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Media Transaksi</label>
                                    @error('media-pembayaran-{{ $editPayment->id }}')
                                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="text" name="no_rek" id="no-rek-{{ $editPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('no-rek-{{ $editPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('no-rek', $editPayment->metodepembayaran->no_rek ?? '') }}" readonly>
                                    <label for="no-rek-{{ $editPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Rekening / VA</label>
                                    @error('no-rek-{{ $editPayment->id }}')
                                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="nama_akun" id="nama-akun-{{ $editPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama-akun-{{ $editPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('nama-akun', $editPayment->metodepembayaran->nama_akun ?? '') }}" readonly>
                                <label for="nama-akun-{{ $editPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Akun</label>
                                @error('nama-akun-{{ $editPayment->id }}')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-3 md:gap-6 mt-2">
                            <div class="relative z-0 w-full group flex items-center">
                                <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                <input type="text" name="nilai_belanja" id="nilai-belanja-{{ $editPayment->id }}" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ number_format($editPayment->nilai, 0, ',', '.') }}" readonly>
                                <label for="nilai-belanja-{{ $editPayment->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Total Belanja</label>
                            </div>
                            @error('nilai-belanja-{{ $editPayment->id }}')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div class="relative z-0 w-full group flex items-center">
                                <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                <input type="text" name="ongkir" id="ongkir-{{ $editPayment->id }}" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ number_format($editPayment->ongkir, 0, ',', '.') }}">
                                <label for="ongkir-{{ $editPayment->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Ongkir</label>
                            </div>
                            @error('ongkir-{{ $editPayment->id }}')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div class="relative z-0 w-full group flex items-center">
                                <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                <input type="text" name="pajak" id="pajak-{{ $editPayment->id }}" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ number_format($editPayment->pajak, 0, ',', '.') }}">
                                <label for="pajak-{{ $editPayment->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Pajak</label>
                            </div>
                            @error('pajak-{{ $editPayment->id }}')
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
