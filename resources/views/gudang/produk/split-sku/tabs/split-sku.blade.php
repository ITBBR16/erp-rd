<div class="hidden p-4" id="split" role="tabpanel" aria-labelledby="split-tab">
    <form action="{{ route('split-sku.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-3 gap-6">
            {{-- Bagian Kiri --}}
            <div class="col-span-2">
                <div class="grid grid-cols-3 gap-4">
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
                </div>
                <div>
                    <div class="my-4 border-t-2 border-gray-400 pt-2">
                        <h3 class="text-gray-900 font-semibold text-xl dark:text-white">List Sparepart</h3>
                    </div>
                    <div id="container-split-part">
                        <div id="form-list-split-0" class="form-list-split grid grid-cols-4 gap-6" style="grid-template-columns: 5fr 3fr 3fr 1fr">
                            <div>
                                <label for="sparepart-split-0" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sparepart :</label>
                                <select name="sparepart_split[]" id="sparepart-split-0" data-id="0" class="sparepart-split bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" hidden>Pilih Sparepart</option>
                                </select>
                            </div>
                            <div>
                                <label for="nominal-split-0" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal / Pcs :</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                    <input type="text" name="nominal_split[]" id="nominal-split-0" data-id="0" class="format-angka-rupiah nominal-split rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                                </div>
                            </div>
                            <div>
                                <label for="qty-split-0" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                                <input type="text" name="qty_split[]" id="qty-split-0" data-id="0" class="number-format qty-split bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-start text-red-500 mt-6">
                    <div class="flex cursor-pointer my-2 hover:text-rose-700">
                        <button type="button" id="tambah-split-part" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span>Tambah Sparepart</span>
                        </button>
                    </div>
                </div>
                {{-- Form Optional --}}
                <div>
                    <div class="my-4 border-t-2 border-gray-400 pt-2">
                        <h3 class="text-gray-900 font-semibold text-xl dark:text-white">List Optional Sparepart</h3>
                    </div>
                    <div id="container-optional-split-part">
                        <div id="form-list-optional-split-1" class="form-list-optional-split grid grid-cols-5 gap-6" style="grid-template-columns: 5fr 5fr 3fr 3fr 1fr">
                            <div>
                                <label for="produk-optional-split-1" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                                <select name="optional_produk[]" id="produk-optional-split-1" data-id="1" class="optional-produk-split bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" hidden>Pilih Produk</option>
                                    @foreach ($jenisProduk as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->jenis_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="sparepart-optional-split-1" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sparepart :</label>
                                <select name="sparepart_split[]" id="sparepart-optional-split-1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" hidden>Pilih Sparepart</option>
                                </select>
                            </div>
                            <div>
                                <label for="nominal-optional-split-1" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal / Pcs :</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                    <input type="text" name="nominal_split[]" id="nominal-optional-split-1" data-id="0" class="format-angka-rupiah nominal-split-optional rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                                </div>
                            </div>
                            <div>
                                <label for="qty-optional-split-1" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                                <input type="text" name="qty_split[]" id="qty-optional-split-1" data-id="0" class="number-format qty-optional-split bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-start text-red-500 mt-6">
                    <div class="flex cursor-pointer my-2 hover:text-rose-700">
                        <button type="button" id="tambah-split-optional-part" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span>Tambah Sparepart Optional</span>
                        </button>
                    </div>
                </div>
            </div>
            {{-- Bagian Kanan --}}
            <div class="col-span-1">
                <div class="col-span-1 h-280px] bg-white p-6 rounded-lg border border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-600 sticky top-4">
                    <h2 class="text-lg font-semibold mb-4 text-black dark:text-white pb-2 border-b border-gray-200 dark:border-gray-600">Detail Split :</h2>
                    <div class="grid grid-cols-2 gap-6 mb-4">
                        <div class="flex justify-between">
                            <div class="flex text-start">
                                <p class="font-semibold italic text-black dark:text-white">SKU :</p>
                            </div>
                            <div class="flex text-end">
                                <p id="text-sku-split" class="font-normal text-black dark:text-white">-</p>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="flex text-start">
                                <p class="font-semibold italic text-black dark:text-white">Tanggal Masuk :</p>
                            </div>
                            <div class="flex text-end">
                                <p id="tanggal-masuk-split" class="font-normal text-black dark:text-white">-</p>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="flex text-start">
                                <p class="font-semibold italic text-black dark:text-white">Nilai Awal :</p>
                            </div>
                            <div class="flex text-end">
                                {{-- Hidden Input --}}
                                <input type="hidden" name="nominal_sparepart" id="nominal-awal-part-split" value="0">
                                <input type="hidden" name="belanja_id" id="belanja-id">
                                <p id="text-sisa-nilai" class="font-normal text-black dark:text-white">Rp. 0</p>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="flex text-start">
                                <p class="font-semibold italic text-black dark:text-white">Sisa Nilai :</p>
                            </div>
                            <div class="flex text-end">
                                <p id="sisa-nominal-split" class="font-normal text-black dark:text-white">Rp. 0</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-6">
                        <button type="submit" id="submit-split" class="submit-button-form cursor-not-allowed w-full text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" disabled>Submit</button>
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
                </div>
            </div>
        </div>
    </form>
</div>