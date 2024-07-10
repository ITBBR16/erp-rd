@foreach ($dataRecapTs as $recap)
    <div id="lanjut-ts-{{ $recap->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Lanjut New Thecnical Support</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="lanjut-ts-{{ $recap->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="#" method="POST" autocomplete="off">
                    @csrf
                    <div class="px-6 py-6 lg:px-8">
                        <div class="relative col-span-2 w-full mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="add-jenis-produk-ts-{{ $recap->id }}">List Produk : </label>
                            <select name="add_jenis_produk[]" id="add-jenis-produk-ts-{{ $recap->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                                <option value="" hidden>Jenis Produk</option>
                                @foreach ($jenisProduk as $produk)
                                    <option value="{{ $produk->id }}">{{ $produk->jenis_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex">
                            <label class="relative inline-flex items-center me-5 mb-4 cursor-pointer">
                                <input type="checkbox" name="check_permasalahan_lanjut" id="check-permasalahan-lanjut-{{ $recap->id }}" data-id="{{ $recap->id }}" value="" class="new-permasalahan sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-600 peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Input Permasalahan Baru</span>
                            </label>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="keperluan_ts"></label>
                                <select name="keperluan_ts" id="keperluan_ts" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                                    <option value="" hidden>Keperluan</option>
                                    @foreach ($kategoriPermasalahan as $keperluan)
                                        <option value="{{ $keperluan->id }}" class="dark:bg-gray-700">{{ $keperluan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="dd-permasalahan-{{ $recap->id }}" class="relative z-0 w-full mb-6 group">
                                <label for="permasalahan-lanjut-{{ $recap->id }}"></label>
                                <select name="permasalahan_lanjut" id="permasalahan-lanjut-{{ $recap->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                                    <option value="" hidden>Permasalahan</option>
                                    @foreach ($dataTs as $ts)
                                        <option value="{{ $ts->id }}">{{ $ts->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="new-permasalahan-{{ $recap->id }}" class="relative z-0 w-full mb-6 group" style="display: none">
                                <input type="text" name="add_permasalahan" id="add-permasalahan-{{ $recap->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                                <label for="add_link_video" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Permasalahan</label>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="deskripsi-ts" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi : </label>
                            <textarea name="deskrisi_ts" id="deskripsi-ts" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tulis deskripsi . . ." required></textarea>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="add_link_video" id="add_link_video" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                            <label for="add_link_video" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Link Video</label>
                        </div>
                    </div>
                    <div class="mt-4 text-end border-t p-3">
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
@endforeach
