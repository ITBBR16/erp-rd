<div class="hidden p-4" id="akp" role="tabpanel" aria-labelledby="akp-tab">
    <form action="{{ route('form-kelengkapan') }}" method="POST" autocomplete="off">
        @csrf
        <div class="w-10/12">
            <div class="grid grid-cols-3 gap-4 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="jenis_id"></label>
                    <select name="jenis_id" id="jenis_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('jenis_id') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Jenis Produk --</option>
                        @foreach ($jenis_produk as $jp)
                            @if (old('jenis_id') == $jp->id)
                                <option value="{{ $jp->id }}" class="dark:bg-gray-700" selected>{{ $jp->jenis_produk }}</option>
                            @else
                                <option value="{{ $jp->id }}" class="dark:bg-gray-700">{{ $jp->jenis_produk }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('jenis_id')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="kategori_paket"></label>
                    <select name="kategori_paket" id="kategori_paket" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('kategori_paket') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Kategori Paket --</option>
                        @foreach ($types as $type)
                            @if (old('kategori_paket') == $type->id)
                                <option value="{{ $type->id }}" class="dark:bg-gray-700" selected>{{ $type->type }}</option>
                            @else
                                <option value="{{ $type->id }}" class="dark:bg-gray-700">{{ $type->type }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('kategori_paket')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="paket_penjualan" id="paket_penjualan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('paket_penjualan') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('paket_penjualan') }}" required>
                    <label for="paket_penjualan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Paket Penjualan</label>
                    @error('paket_penjualan')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="my-4 border-b-2 border-gray-400 pb-2">
                <h3 class="text-gray-900 dark:text-white font-semibold text-xl">Kelengkapan</h3>
            </div>
            <div id="form-kelengkapan">
                <div id="form-kelengkapan-dd" class="grid grid-cols-3 gap-4 md:gap-6 mt-5">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="kelengkapan"></label>
                        <select name="kelengkapan[]" id="kelengkapan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>-- Kelengkapan Produk --</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="quantity[]" id="quantity" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                        <label for="quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Barang</label>
                    </div>
                    <div class="flex justify-center items-center">
                        <button type="button" class="remove-kelengkapan" style="display: none">
                            <span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex justify-between text-rose-600">
                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                    <button type="button" id="add-kelengkapan" class="flex flex-row justify-between gap-2">
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
