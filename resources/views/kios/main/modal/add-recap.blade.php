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
                                <option value="" hidden>Nama Customer</option>
                                @foreach ($customer as $cs)
                                    <option value="{{ $cs->id }}" class="dark:bg-gray-700">{{ $cs->first_name }} {{ $cs->last_name }}</option>
                                @endforeach
                            </select>
                            @error('nama_customer')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="keperluan_recap"></label>
                            <select name="keperluan_recap" id="keperluan_recap" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('keperluan_recap') border-red-600 dark:border-red-500 @enderror" required>
                                <option value="" hidden>Keperluan</option>
                                @foreach ($keperluanrecap as $keperluan)
                                    <option value="{{ $keperluan->id }}" class="dark:bg-gray-700">{{ $keperluan->nama }}</option>
                                @endforeach
                            </select>
                            @error('keperluan_recap')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="jenis_produk"></label>
                            <select name="jenis_produk" id="jenis_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('jenis_produk') border-red-600 dark:border-red-500 @enderror" required>
                                <option value="" hidden>Jenis Produk</option>
                                @foreach ($produkJenis as $jenis)
                                    <option value="{{ $jenis->id }}" class="dark:bg-gray-700">{{ $jenis->jenis_produk }}</option>
                                @endforeach
                            </select>
                            @error('jenis_produk')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="kategori_permasalahan"></label>
                            <select name="kategori_permasalahan" id="kategori_permasalahan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('kategori_permasalahan') border-red-600 dark:border-red-500 @enderror" required>
                                <option value="" hidden>Kategori Permasalahan</option>
                                @foreach ($kategoriPermasalahan as $kategori)
                                    <option value="{{ $kategori->id }}" class="dark:bg-gray-700">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori_permasalahan')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="permasalahan"></label>
                            <select name="permasalahan" id="permasalahan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('permasalahan') border-red-600 dark:border-red-500 @enderror" required>
                                <option value="" hidden>Permasalahan</option>
                                @foreach ($permasalahan as $permasalahan)
                                    <option value="{{ $permasalahan->id }}" class="dark:bg-gray-700">{{ $permasalahan->nama }}</option>
                                @endforeach
                            </select>
                            @error('permasalahan')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="link_permasalahan" id="link_permasalahan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('link_permasalahan') border-red-600 dark:border-red-500 @enderror" placeholder="" readonly>
                            <label for="link_permasalahan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Link Permsaalahan</label>
                            @error('link_permasalahan')
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
                        <button type="submit" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                        <div class="loader-button-form" style="display: none">
                            <button type="submit" class="cursor-not-allowed text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                                Loading . . .
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
