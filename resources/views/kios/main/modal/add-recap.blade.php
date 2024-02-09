<div id="add-daily-recap" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">Daily Recap</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-daily-recap">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="px-6 py-6 lg:px-8">
                <form action="{{ route('form-daily-recap') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="nama_customer"></label>
                            <select name="nama_customer" id="nama_customer" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama_customer') border-red-600 dark:border-red-500 @enderror" required>
                                <option value="" hidden>-- Nama Customer --</option>
                                @foreach ($customer as $cs)
                                <option value="{{ $cs->id }}" class="dark:bg-gray-700">{{ $cs->first_name }} {{ $cs->last_name }}</option>
                                @endforeach
                            </select>
                            @error('nama_customer')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="jenis_produk"></label>
                            <select name="jenis_produk" id="jenis_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('jenis_produk') border-red-600 dark:border-red-500 @enderror" required>
                                <option value="" hidden>-- Jenis Produk --</option>
                                @foreach ($statusProduk as $stp)
                                    <option value="{{ $stp->id }}" class="dark:bg-gray-700">{{ $stp->status_produk }}</option>
                                @endforeach
                            </select>
                            @error('jenis_produk')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="keperluan_recap"></label>
                            <select name="keperluan_recap" id="keperluan_recap" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('keperluan_recap') border-red-600 dark:border-red-500 @enderror" required>
                                <option value="" hidden>-- Keperluan --</option>
                                @foreach ($keperluanrecap as $keperluan)
                                    <option value="{{ $keperluan->id }}" class="dark:bg-gray-700">{{ $keperluan->nama }}</option>
                                @endforeach
                            </select>
                            @error('keperluan_recap')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="status_recap"></label>
                            <select name="status_recap" id="status_recap" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('status_recap') border-red-600 dark:border-red-500 @enderror" required>
                                <option value="" hidden>-- Status --</option>
                                @foreach ($statusrecap as $status)
                                    <option value="{{ $status->id }}" class="dark:bg-gray-700">{{ $status->nama }}</option>
                                @endforeach
                            </select>
                            @error('status_recap')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="sub_jenis_produk"></label>
                            <select name="sub_jenis_produk" id="sub_jenis_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('sub_jenis_produk') border-red-600 dark:border-red-500 @enderror" required>
                                <option value="" hidden>-- Seri Produk --</option>
                                @foreach ($subjenisProduk as $seri)
                                    <option value="{{ $seri->id }}" class="dark:bg-gray-700">{{ $seri->produkjenis->jenis_produk }} {{ $seri->paket_penjualan }}</option>
                                @endforeach
                            </select>
                            @error('sub_jenis_produk')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="barang_cari" id="barang_cari" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('barang_cari') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('barang_cari') }}" required>
                            <label for="barang_cari" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Barang yang dicari</label>
                            @error('barang_cari')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="keterangan" id="keterangan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('keterangan') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('keterangan') }}" required>
                        <label for="keterangan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
                        @error('keterangan')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
