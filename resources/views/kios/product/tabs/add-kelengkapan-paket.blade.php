<div class="hidden p-4" id="akp" role="tabpanel" aria-labelledby="akp-tab">
    <form action="{{ route('form-kelengkapan') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="w-10/12">
            <div class="mt-2">
                <h3 class="text-gray-900 dark:text-white font-bold text-xl">Data Paket Penjualan</h3>
            </div>
            <div class="bg-white p-4 text-white border-0 border-transparent border-solid shadow-md rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="grid grid-cols-2 gap-4 md:gap-6">
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
                </div>
                <div class="grid grid-cols-2 gap-4 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <input type="text" name="berat_paket" id="berat_paket" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('berat_paket') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('berat_paket') }}" oninput="this.value = this.value.replace(/\D/g, '')" required>
                        <label for="berat_paket" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Berat Produk</label>
                        <span class="absolute bottom-8 end-0 font-bold text-gray-500 dark:text-gray-400">Kg</span>
                        @error('berat_paket')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-row border rounded-lg items-center w-full border-gray-300 mb-6 dark:border-gray-400">
                        <input type="text" name="length" placeholder="0" class="input-field py-2.5 mr-3 px-3 w-full text-sm text-gray-900 bg-transparent border-none focus:outline-none focus:border-transparent focus:ring-0 dark:text-white" oninput="this.value = this.value.replace(/\D/g, '')">
                        <div class="text-black items-center mr-3 mt-1">
                            <span class="material-symbols-outlined text-base dark:text-gray-400">close</span>
                        </div>
                        <input type="text" name="width" placeholder="0" class="input-field py-2.5 mx-3 px-3 w-full text-sm text-gray-900 bg-transparent border-none focus:outline-none focus:border-transparent focus:ring-0 dark:text-white" oninput="this.value = this.value.replace(/\D/g, '')">
                        <div class="text-black items-center mr-3 mt-1">
                            <span class="material-symbols-outlined text-base dark:text-gray-400">close</span>
                        </div>
                        <input type="text" name="height" placeholder="0" class="input-field py-2.5 mx-3 px-3 w-full text-sm text-gray-900 bg-transparent border-none focus:outline-none focus:border-transparent focus:ring-0 dark:text-white" oninput="this.value = this.value.replace(/\D/g, '')">
                        <span class="inline-flex items-center px-3 text-base font-semibold rounded-r-lg text-gray-900 bg-gray-100 border-l border-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-600 grow h-full">Cm</span>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="paket_penjualan" id="paket_penjualan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('paket_penjualan') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('paket_penjualan') }}" required>
                    <label for="paket_penjualan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Paket Penjualan</label>
                    @error('paket_penjualan')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
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
                    </div>
                </div>
                <div class="flex justify-between text-rose-600">
                    <div class="flex cursor-pointer my-2 hover:text-red-400">
                        <button type="button" id="add-kelengkapan" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span class="">Tambah Kelengkapan</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <h3 class="text-gray-900 dark:text-white font-bold text-xl">Data File Upload</h3>
            </div>
            <div class="bg-white p-4 text-white border-0 border-transparent border-solid shadow-md rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class=" mt-3 grid grid-cols-2 gap-4 md:gap-6">
                    <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">File Utama Produk :</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="file_paket_produk" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div id="image_paket" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 w text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG or JPG</p>
                            </div>
                            <div id="selected_images_paket" class="flex flex-col items-center justify-center pt-5 pb-6" style="display: none"></div>
                            <input name="file_paket_produk" id="file_paket_produk" type="file" class="hidden">
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 md:gap-6 mt-4">
                    <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Files Kelengkapan :</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="file_kelengkapan_produk" class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div id="image_kelengkapan" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG or JPG</p>
                            </div>
                            <div id="selected_images_kelengkapan" class="flex flex-wrap justify-evenly" style="display: none"></div>
                            <input name="file_kelengkapan_produk[]" id="file_kelengkapan_produk" type="file" class="hidden" multiple>
                        </label>
                    </div>
                </div>
                <div class="mt-6 text-end">
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
        </div>
    </form>
</div>
