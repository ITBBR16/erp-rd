<div class="hidden p-4" id="second-product" role="tabpanel" aria-labelledby="second-product-tab">
    <form action="#" method="POST" autocomplete="off">
        @csrf
        <h3 class="mt-3 text-gray-900 dark:text-white font-semibold text-xl">Data Supplier</h3>
        <h5 class="mb-3 text-gray-900 dark:text-white font-semibold text-xs">Jika Belum Ada Data Customer <a href="/customer/add-customer" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline" target="_blank">Click Here</a></h5>
        <div class="w-10/12">
            <div class="grid md:grid-cols-2 md:gap-6">
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
                <div class="relative z-0 w-full mb-6 group">
                    <label for="customer" class="sr-only">Nama Customer</label>
                    <select name="customer" id="customer" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('customer') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Pilih Customer --</option>
                        @foreach ($customer as $cs)
                            <option value="{{ $cs->id }}" class="dark:bg-gray-700">{{ $cs->first_name }} {{ $cs->last_name }}</option>
                        @endforeach
                    </select>
                    @error('customer')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Informasi Pembelian</h3>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('tanggal_pembelian') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('tanggal_pembelian') }}" required>
                    <label for="tanggal_pembelian" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal Pembelian</label>
                    @error('tanggal_pembelian')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="jenis_drone_second" class="sr-only">-- Jenis Paket Produk --</label>
                    <select name="jenis_drone_second" id="jenis_drone_second" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('jenis_drone_second') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Jenis Produk --</option>
                        @foreach ($produkKios as $pk)
                            <optgroup label="{{ $pk->jenis_produk }}" class="dark:bg-gray-700">
                                @foreach ($pk->subjenis as $sj)
                                    <option value="{{ $sj->id }}" class="dark:bg-gray-700">{{ $sj->paket_penjualan }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('jenis_drone_second')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
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
                <div class="relative z-0 w-full mb-6 group">
                    <input type="number" name="biaya_pembelian" id="biaya_pembelian" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('biaya_pembelian') border-red-600 dark:border-red-500 @enderror" placeholder="" required>
                    <label for="biaya_pembelian" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Biaya Pengambilan</label>
                    @error('biaya_pembelian')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
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