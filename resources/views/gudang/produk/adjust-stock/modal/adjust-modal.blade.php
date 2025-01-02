<div id="new-adjust-stock" tabindex="-1" class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[cal(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">Adjust Stock Sparepart</h3>
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="new-adjust-stock">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ route('adjust-stock.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="px-6 py-6 lg:px-8 lg:py-6 space-y-4 bg-white dark:bg-gray-700">
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label for="jenis-produk-split" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Produk :</label>
                            <select id="jenis-produk-split" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Jenis Produk</option>
                                @foreach ($jenisProduk as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->jenis_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="nama-sparepart" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sparepart :</label>
                            <select id="nama-sparepart" class="sparepart-split bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Sparepart</option>
                            </select>
                        </div>
                        <div>
                            <label for="id-item" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">ID Item :</label>
                            <select name="id_item" id="id-item" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih ID Item</option>
                            </select>
                        </div>
                        <div>
                            <label for="status-adjust" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Status Adjust :</label>
                            <select name="status_adjust" id="status-adjust" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Status</option>
                                <option value="Kurang">Kurang</option>
                                {{-- <option value="Lebih">Lebih</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="add-keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                        <textarea rows="3" name="keterangan" id="add-keterangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Keterangan . . ." required></textarea>
                    </div>
                    <button type="submit" class="submit-button-form w-full text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                    <div class="loader-button-form" style="display: none">
                        <button class="cursor-not-allowed w-full text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
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