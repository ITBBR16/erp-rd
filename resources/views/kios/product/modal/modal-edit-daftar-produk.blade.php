@foreach ($produks as $produk)
    <div id="update-produk{{ $produk->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Detail Produk {{ $produk->subjenis->produkjenis->jenis_produk }} {{ $produk->subjenis->paket_penjualan }}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="update-produk{{ $produk->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('product.update', $produk->id) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-6 lg:px-8 space-y-6">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full group flex items-center">
                                <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                <input type="text" name="harga_jual" id="harga_jual{{ $produk->id }}" class="harga_jual block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ number_format($produk->srp, 0, ',', '.') }}">
                                <label for="harga_jual{{ $produk->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Harga Jual</label>
                            </div>
                            <div class="relative z-0 w-full group flex items-center">
                                <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                <input type="text" name="harga_promo" id="harga_promo{{ $produk->id }}" class="harga_promo block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ number_format($produk->harga_promo, 0, ',', '.') }}">
                                <label for="harga_promo{{ $produk->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Harga Promo</label>
                            </div>
                        </div>
                        <div date-rangepicker class="grid grid-cols-5 items-center">
                            <div class="relative col-span-2 flex items-center">
                                <input name="start_date" type="text" class="bg-transparent border-0 border-b-2 border-gray-300 text-gray-900 text-sm focus:ring-blue-500 w-full p-2.5 dark:placeholder-gray-400 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" placeholder="Mulai Promo" value="{{ $produk->start_promo }}">
                                <div class="absolute end-0 pe-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 align-middle" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="col-span-1 flex justify-center">
                                <span class="text-gray-500">to</span>
                            </div>
                            <div class="relative col-span-2 flex items-center">
                                <input name="end_date" type="text" class="bg-transparent border-0 border-b-2 border-gray-300 text-gray-900 text-sm focus:ring-blue-500 w-full p-2.5 dark:placeholder-gray-400 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" placeholder="Akhir Promo" value="{{ $produk->end_promo }}">
                                <div class="absolute end-0 pe-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 align-middle" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end p-3 border-t rounded-t dark:border-gray-600">
                        <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
