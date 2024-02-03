<div class="hidden p-4" id="second-product" role="tabpanel" aria-labelledby="second-product-tab">
    <form action="{{ route('shop-second.store') }}" method="POST" autocomplete="off">
        @csrf
        <h3 class="mt-3 text-gray-900 dark:text-white font-semibold text-xl">Data Supplier</h3>
        <h5 class="mb-3 text-gray-900 dark:text-white font-semibold text-xs">Jika Belum Ada Data Customer <a href="/customer/add-customer" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline" target="_blank">Tekan Disini</a></h5>
        <div class="w-10/12">
            <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="come_from" class="sr-only">Come From</label>
                    <select name="come_from" id="come_from" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('come_from') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Come From --</option>
                        <option value="Customer" class="dark:bg-gray-700">Customer</option>
                        <option value="Hunting" class="dark:bg-gray-700">Hunting</option>
                    </select>
                    @error('come_from')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="metode_pembelian" class="sr-only">Metode Pembelian</label>
                    <select name="metode_pembelian" id="metode_pembelian" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('metode_pembelian') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Metode Pembelian --</option>
                        @foreach ($metodePembelian as $mp)
                            <option value="{{ $mp->id }}" class="dark:bg-gray-700">{{ $mp->metode_pembelian }}</option>
                        @endforeach
                    </select>
                    @error('metode_pembelian')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group" id="customerContainer" style="display: none">
                    <label for="customer" class="sr-only">Nama Customer</label>
                    <select name="customer" id="customer" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('customer') border-red-600 dark:border-red-500 @enderror">
                        <option value="" hidden>-- Pilih Customer --</option>
                        @foreach ($customer as $cs)
                            <option value="{{ $cs->id }}" class="dark:bg-gray-700">{{ $cs->first_name }} {{ $cs->last_name }}</option>
                        @endforeach
                    </select>
                    @error('customer')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group" id="marketplaceContainer" style="display: none">
                    <label for="marketplace" class="sr-only">Nama Marketplace</label>
                    <select name="marketplace" id="marketplace" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('marketplace') border-red-600 dark:border-red-500 @enderror">
                        <option value="" hidden>-- Pilih Marketplace --</option>
                        @foreach ($marketplace as $market)
                            <option value="{{ $market->id }}" class="dark:bg-gray-700">{{ $market->nama }}</option>
                        @endforeach
                    </select>
                    @error('marketplace')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Informasi Pembelian</h3>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="jenis_drone_second" class="sr-only">Jenis Paket Produk</label>
                    <select name="jenis_drone_second" id="jenis_drone_second" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('jenis_drone_second') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Jenis Produk --</option>
                        @foreach ($produkKios as $pk)
                            @foreach ($pk->subjenis as $sj)
                                <option value="{{ $sj->id }}" class="dark:bg-gray-700">{{ $pk->jenis_produk }} {{ $sj->paket_penjualan }}</option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('jenis_drone_second')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
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
                <div class="relative z-0 w-full mb-6 group">
                    <label for="status_pembayaran" class="sr-only">Status Pembayaran</label>
                    <select name="status_pembayaran" id="status_pembayaran" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('status_pembayaran') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Pilih Status Pembayaran --</option>
                        @foreach ($statusPembayaran as $status)
                            <option value="{{ $status->id }}" class="dark:bg-gray-700">{{ $status->status_pembayaran }}</option>
                        @endforeach
                    </select>
                    @error('status_pembayaran')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full group">
                    <span class="absolute start-0 bottom-8 font-bold text-gray-500 dark:text-gray-400">RP</span>
                    <input type="text" name="biaya_pengambilan" id="biaya_pengambilan" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="biaya_pengambilan" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Biaya Pengambilan</label>
                </div>
                @error('biaya_pengambilan')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Kelengkapan</h3>
            <div id="kelengkapan-second">
                
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
            </div>
        </div>
    </form>
</div>