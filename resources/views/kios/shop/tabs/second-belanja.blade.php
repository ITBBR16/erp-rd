<div class="hidden p-4" id="second-product" role="tabpanel" aria-labelledby="second-product-tab">
    <form action="{{ route('shop-second.store') }}" method="POST" autocomplete="off">
        @csrf
        <h3 class="mt-3 text-gray-900 dark:text-white font-semibold text-xl">Data Penjual</h3>
        <h5 class="mb-3 text-gray-900 dark:text-white font-semibold text-xs">Jika belum ada Data Penjual, <a href="/kios/customer/daily-recap" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline" target="_blank">Tekan Disini</a></h5>
        <div class="w-10/12">
            <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="come_from" class="sr-only">Come From</label>
                    <select name="come_from" id="come_from" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                        <option value="" hidden>Dapat Dari Mana ?</option>
                        <option value="Customer" class="bg-white dark:bg-gray-700">Customer</option>
                        <option value="Hunting" class="bg-white dark:bg-gray-700">Hunting</option>
                    </select>
                </div>
                <div class="relative z-0 w-full mb-6 group" id="marketplaceContainer" style="display: none">
                    <div id="asal-jual" style="display: none">
                        <label for="shop-second-marketplace" class="sr-only">Nama Marketplace</label>
                        <select name="marketplace" id="shop-second-marketplace" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                            <option value="" hidden>Pilih Asal</option>
                            @foreach ($marketplace as $market)
                                <option value="{{ $market->id }}" class="bg-white dark:bg-gray-700">{{ $market->nama }}</option>
                            @endforeach
                        </select>
                        @error('shop-second-marketplace')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div id="alasan-container" style="display: none">
                        <label for="alasan-jual" class="sr-only">Alasan Jual</label>
                        <select name="alasan_jual" id="alasan-jual" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                            <option value="" hidden>Pilih Alasan Jual</option>
                            @foreach ($alasanJual as $alasan)
                                <option value="{{ $alasan->id }}">{{ $alasan->alasan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="metode_pembelian" class="sr-only">Metode Pembelian</label>
                    <select name="metode_pembelian" id="metode_pembelian" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                        <option value="" hidden>Metode Pembelian</option>
                        @foreach ($metodePembelian as $mp)
                            <option value="{{ $mp->id }}" class="bg-white dark:bg-gray-700">{{ $mp->metode_pembelian }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full group">
                    <span class="absolute top-3 font-bold text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18">
                            <path d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z"/>
                        </svg>
                    </span>
                    <input type="text" name="no_customer_second" id="no_customer_second" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " oninput="this.value = this.value.replace(/\D/g, '')" required>
                    <label for="no_customer_second" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Nomor Customer</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="hidden" name="id_customer" id="id_customer">
                    <input type="text" id="nama_customer" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" disabled>
                    <label id="nama_customer_label" for="nama_customer" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Customer</label>
                </div>
            </div>
            <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Informasi Pembelian</h3>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="paket_penjualan_second" class="sr-only">Jenis Paket Produk</label>
                    <select name="paket_penjualan_second" id="paket_penjualan_second" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                        <option value="" hidden>Pilih Paket Penjualan</option>
                        @foreach ($produkKios as $pk)
                            <option value="{{ $pk->id }}" class="bg-white dark:bg-gray-700">{{ $pk->paket_penjualan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="relative w-full group">
                    <div class="absolute start-0 bottom-9 ps-1 font-bold text-gray-500 dark:text-gray-400 pointer-events-none">
                       <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input datepicker datepicker-autohide name="tanggal_pembelian" id="date-input" type="text" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" placeholder="Pilih Tanggal Pembelian" required>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full group flex items-center">
                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                    <input type="text" name="biaya_pengambilan" id="biaya_pengambilan" class="biaya_satuan block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                    <label for="biaya_pengambilan" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Biaya Pengambilan</label>
                </div>
                <div class="relative z-0 w-full group flex items-center">
                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                    <input type="text" name="biaya_ongkir" id="biaya_ongkir" class="biaya_satuan block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="biaya_ongkir" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Biaya Ongkir</label>
                </div>
            </div>
            <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Kelengkapan</h3>
            <div id="kelengkapan-second">
                
            </div>
            <div id="tambah-kelengkapan">

            </div>
            <div class="flex justify-between text-rose-600">
                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                    <button type="button" id="add-second-belanja" class="flex flex-row justify-between gap-2">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span class="">Tambah Kelengkapan Produk</span>
                    </button>
                </div>
            </div>
            <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Additional Kelengkapan</h3>
            <div id="additional-kelengkapan-second">
                
            </div>
            <div class="flex justify-between text-rose-600">
                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                    <button type="button" id="add-second-additional-belanja" class="flex flex-row justify-between gap-2">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span class="">Tambah Additional Kelengkapan</span>
                    </button>
                </div>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                <div class="loader-button-form" style="display: none">
                    <button class="cursor-not-allowed text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                        </svg>
                        Loading . . .
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>