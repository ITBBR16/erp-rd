<div class="hidden p-4" id="ajk" role="tabpanel" aria-labelledby="ajk-tab">
    <form action="{{ route('form-kelengkapan') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-2 gap-6 w-full">
            <div class="flex flex-col w-10/12">
                <h3 class="text-gray-900 font-semibold text-lg mb-3 dark:text-white dark:border-gray-200">Add Jenis Produk : </h3>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="kategori_id"></label>
                    <select name="kategori_id" id="kategori_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('kategori_id') border-red-600 dark:border-red-500 @enderror" required>
                        <option value="" hidden>-- Kategori Produk --</option>
                        @foreach ($kategori as $ktg)
                            <option value="{{ $ktg->id }}" class="dark:bg-gray-700">{{ $ktg->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="jenis_produk" id="jenis_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                    <label for="jenis_produk" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jenis Produk</label>
                    @error('jenis_produk')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                </div>
            </div>
            {{-- <div class="flex flex-col w-10/12">
                <h3 class="text-gray-900 font-semibold text-lg mb-3 dark:text-white dark:border-gray-200">Add Kelengkapan : </h3>
                <div id="jenis-kelengkapan">
                    <div id="jenis-kelengkapan-1" class="grid grid-cols-2 gap-4 md:gap-6" style="grid-template-columns: 5fr 1fr">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="jenis_kelengkapan[]" id="jenis_kelengkapan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                            <label for="jenis_kelengkapan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Kelengkapan</label>
                        </div>
                        <div class="flex justify-center items-center">
                            <button type="button" class="remove-jenis-kelengkapan" data-id="1">
                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between text-rose-600">
                    <div class="flex cursor-pointer mt-4 hover:text-red-400">
                        <button type="button" id="add-jenis-kelengkapan" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span class="">Tambah Kelengkapan</span>
                        </button>
                    </div>
                </div>
            </div> --}}
        </div>
    </form>
</div>