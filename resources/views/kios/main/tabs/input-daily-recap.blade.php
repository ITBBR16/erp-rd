<div class="hidden p-4" id="idr" role="tabpanel" aria-labelledby="idr-tab">
    <div class="w-10/12">
        <form action="{{ route('form-daily-recap') }}" method="POST" autocomplete="off">
            @csrf
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="nama_customer"></label>
                    <select name="nama_customer" id="nama_customer" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama_customer') border-red-600 dark:border-red-500 @enderror" required>
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
                    <select name="jenis_produk" id="jenis_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('jenis_produk') border-red-600 dark:border-red-500 @enderror" required>
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
                    <label for="seri_produk"></label>
                    <select name="seri_produk" id="seri_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('seri_produk') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Seri Produk --</option>
                        @foreach ($seriProduk as $seri)
                            <option value="{{ $seri->id }}" class="dark:bg-gray-700">{{ $seri->jenis_produk }}</option>
                        @endforeach
                    </select>
                    @error('seri_produk')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="jenis_paket"></label>
                    <select name="jenis_paket" id="jenis_paket" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('jenis_paket') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Jenis Paket --</option>
                    </select>
                    @error('jenis_paket')
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