<div id="update-alamat-kasir" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                <h3 id="title-update-data-customer-kasir" class="text-xl font-medium text-gray-900 dark:text-white">Update Data Customer</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="update-alamat-kasir">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="form-update-data-customer-kasir" method="POST" autocomplete="off">
                @csrf
                <div class="px-2 py-2 lg:px-8 lg:py-6 bg-gray-50 dark:bg-gray-600">
                    <div class="gap-x-4 relative">
                        <div class="relative px-4 py-4 rounded-md shadow-lg border border-gray-200 bg-white dark:bg-gray-700 dark:border-gray-600">
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 items-center">
                                    <div class="font-semibold">
                                        Nama Customer :
                                    </div>
                                    <div class="mr-2">
                                        <input type="text" name="first_name" id="update-first-name" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="First Name" required>
                                    </div>
                                    <div class="ml-2">
                                        <input type="text" name="last_name" id="update-last-name" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 items-center">
                                    <div class="col-span-1 font-semibold">
                                        Provinsi :
                                    </div>
                                    <div class="col-span-2">
                                        <select name="provinsi_customer" id="update-kasir-provinsi" class="update-kasir-provinsi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="" hidden>Pilih Provinsi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 items-center">
                                    <div class="col-span-1 font-semibold">
                                        Kota / Kabupaten :
                                    </div>
                                    <div class="col-span-2">
                                        <select name="kota_customer" id="update-kasir-kota" class="update-kasir-kota bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="" hidden>Pilih Kota / Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 items-center">
                                    <div class="col-span-1 font-semibold">
                                        Kecamatan :
                                    </div>
                                    <div class="col-span-2">
                                        <select name="kecamatan_customer" id="update-kasir-kecamatan" class="update-kasir-kecamatan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="" hidden>Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 items-center">
                                    <div class="col-span-1 font-semibold">
                                        Kelurahan :
                                    </div>
                                    <div class="col-span-2">
                                        <select name="kelurahan_customer" id="update-kasir-kelurahan" class="update-kasir-kelurahan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            <option value="" hidden>Pilih Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 items-center">
                                    <div class="col-span-1 font-semibold">
                                        Kode Pos :
                                    </div>
                                    <div class="col-span-2">
                                        <input type="text" name="kode_pos_customer" id="update-kasir-kodepos" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Kode Pos" required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 items-center">
                                    <div class="col-span-1 font-semibold">
                                        Nama Jalan :
                                    </div>
                                    <div class="col-span-2">
                                        <input type="text" name="alamat_customer" id="update-kasir-alamat" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jalan" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end p-3 border-t">
                    <button type="button" id="done-update-data-customer" data-modal-hide="update-alamat-kasir" class="done-update-data-customer text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>