<div class="hidden p-4" id="cbk" role="tabpanel" aria-labelledby="cbk-tab">
    <form id="dataForm" action="{{ route('form-kelengkapan') }}" method="POST" autocomplete="off">
        @csrf
        <div class="flex flex-col">
            <div class="flex flex-row justify-between">
                <h3 class="text-gray-900 font-semibold text-lg mb-3 dark:text-white dark:border-gray-200">Edit Kelengkapan : </h3>
                <div class="flex flex-nowrap">
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
            <div id="form-edit-kelengkapan">
                <div id="edit-kelengkapan-form-1" class="grid grid-cols-4 gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="edit_kelengkapan_produk"></label>
                        <select name="edit_kelengkapan_produk[]" id="edit_kelengkapan_produk" data-id="1" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                            <option value="" hidden>-- Kelengkapan Produk --</option>
                            @foreach ($kelengkapan as $klp)
                                <option value="{{ $klp->id }}" class="dark:bg-gray-700">{{ $klp->kelengkapan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="edit_produk_jenis1"></label>
                        <select name="edit_produk_jenis[]" id="edit_produk_jenis1" data-id="1" class="edit_produk_jenis block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                            <option value="" hidden>-- Jenis Produk --</option>
                            @foreach ($jenis_produk as $jp)
                                <option value="{{ $jp->id }}" class="dark:bg-gray-700">{{ $jp->jenis_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="box-edit-kelengkapan-1" class="flex flex-wrap col-span-2 border rounded-lg items-center w-full h-10 border-gray-300 mb-6 gap-3 p-2 text-sm overflow-y-auto">
                        
                    </div>
                </div>
            </div>
            <div class="flex justify-between text-rose-600">
                <div class="flex cursor-pointer my-2 hover:text-red-400">
                    <button type="button" id="add-edit-kelengkapan" class="flex flex-row justify-between gap-2">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span class="">Tambah Kelengkapan</span>
                    </button>
                </div>
            </div>
            <div class="flex flex-col w-full mt-6 border-t-2 border-gray-600 dark:border-gray-400">
                <h3 class="text-gray-900 font-semibold text-lg mb-3 dark:text-white dark:border-gray-200 mt-6">Add Kelengkapan : </h3>
                <div id="jenis-kelengkapan">
                    <div id="jenis-kelengkapan-1" class="grid grid-cols-4 gap-4 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="jenis_kelengkapan[]" id="jenis_kelengkapan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                            <label for="jenis_kelengkapan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Kelengkapan</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="produk_jenis1"></label>
                            <select name="produk_jenis[]" id="produk_jenis1" data-id="1" class="produk_jenis block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                                <option value="" hidden>-- Jenis Produk --</option>
                                @foreach ($jenis_produk as $jp)
                                    <option value="{{ $jp->id }}" class="dark:bg-gray-700">{{ $jp->jenis_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 grid grid-cols-5" style="grid-template-columns: 5fr 5fr 5fr 5fr 1fr">
                            <div id="box-add-kelengkapan-1" class="flex flex-wrap col-span-4 border rounded-lg items-center w-full h-10 border-gray-300 mb-6 gap-3 p-2 text-sm overflow-y-auto">
                                
                            </div>
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
            </div>
        </div>
    </form>
</div>

<script>
    let kelengkapanProduk = @json($kelengkapan);
    let jenisProduk = @json($jenis_produk);
</script>