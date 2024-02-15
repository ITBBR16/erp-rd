<div class="hidden p-4" id="createPaket" role="tabpanel" aria-labelledby="createPaket-tab">
    <form action="{{ route('add-paket-penjualan-second.store') }}" method="POST" autocomplete="off">
        @csrf
        <h3 class="text-gray-900 dark:text-white font-semibold text-xl">Data Paket Penjualan Produk</h3>
        <div class="w-10/12">
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="paket_penjualan_produk_second" class="sr-only">Jenis Paket Produk</label>
                    <select name="paket_penjualan_produk_second" id="paket_penjualan_produk_second" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('paket_penjualan_produk_second') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Jenis Produk --</option>
                        @foreach ($kiosproduks as $produk)
                            @foreach ($produk->subjenis as $sj)
                                <option value="{{ $sj->id }}" class="dark:bg-gray-700">{{ $produk->jenis_produk }} {{ $sj->paket_penjualan }}</option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('paket_penjualan_produk_second')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="cc_produk_second" id="cc_produk_second" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" oninput="this.value = this.value.replace(/\D/g, '')" required>
                    <label for="cc_produk_second" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">CC Produk</label>
                    @error('cc_produk_second')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full group flex items-center">
                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                    <input type="text" name="modal_produk_second" id="modal_produk_second" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly>
                    <label for="modal_produk_second" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Modal Awal</label>
                    @error('modal_produk_second')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full group flex items-center">
                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                    <input type="text" name="harga_jual_produk_second" id="harga_jual_produk_second" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " oninput="this.value = this.value.replace(/\D/g, '')" required>
                    <label for="harga_jual_produk_second" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Harga Jual</label>
                    @error('harga_jual_produk_second')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Isi Kelengkapan</h3>
            <div id="kelengkapan-jual-second">
                
            </div>
            <div class="flex justify-between text-rose-600">
                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                    <button type="button" id="add-kelengkapan-second" class="flex flex-row justify-between gap-2">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span class="">Tambah Kelengkapan</span>
                    </button>
                </div>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
            </div>
        </div>
    </form>
</div>