<div class="hidden p-4" id="cbk" role="tabpanel" aria-labelledby="cbk-tab">
    <form id="dataForm" action="{{ route('form-kelengkapan') }}" method="POST" autocomplete="off">
        @csrf
        <div class="flex flex-col">
            <div class="flex flex-row justify-between">
                <h3 class="text-gray-900 font-semibold text-lg mb-3 dark:text-white dark:border-gray-200">Edit Kelengkapan : </h3>
                <div class="flex flex-nowrap">
                    <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
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
                    <div id="box-edit-kelengkapan-1" class="flex flex-row col-span-2 border rounded-lg items-center w-full border-gray-300 mb-6 gap-3 p-2 text-sm">
                        
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
            <div class="flex flex-col w-full mt-6">
                <h3 class="text-gray-900 font-semibold text-lg mb-3 dark:text-white dark:border-gray-200">Add Kelengkapan : </h3>
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
                            <div id="box-add-kelengkapan-1" class="col-span-4 flex flex-row border rounded-lg items-center w-full border-gray-300 mb-6 gap-3 p-2 text-sm">
                                
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