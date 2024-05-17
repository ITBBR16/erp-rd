<div class="hidden p-4" id="additional" role="tabpanel" aria-labelledby="additional-tab">
    <form>
        <div class="w-full px-3 py-3 mx-auto">
            <div class="max-w-full w-2/3 px-3">
                <div class="md:w-1/5">
                    <div class="relative z-0 w-full mb-4 group">
                        <input type="text" name="floating_ref" id="floating_ref" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="Gudang-101" readonly required>
                        <label for="floating_ref" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ref Gudang</label>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="grid w-full md:grid-cols-3 md:gap-6">
                        <div>
                            <label for="select_orderId" class="sr-only"></label>
                            <select id="select_orderId" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                                <option selected>Order ID</option>
                                <option value="">N.666</option>
                                <option value="">N.555</option>
                                <option value="">N.444</option>
                            </select>
                        </div>
                        <div>
                            <label for="select_mediaTransaksi" class="sr-only"></label>
                            <select id="select_mediaTransaksi" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option selected>Media Transaksi</option>
                                <option value="">Aliexpress</option>
                                <option value="">Dealer System</option>
                                <option value="">Pos Indonesia</option>
                                <option value="">Tokopedia</option>
                            </select>
                        </div>
                        <div>
                            <label for="select_bank" class="sr-only"></label>
                            <select id="select_bank" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option selected>Bank Pembayaran</option>
                                <option value="">BCA</option>
                                <option value="">Cash</option>
                                <option value="">Citi Bank</option>
                                <option value="">Mandiri</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="grid w-full md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-4 group">
                            <input type="text" name="floating_namaAkun" id="floating_namaAkun" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                            <label for="floating_namaAkun" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Akun</label>
                        </div>
                        <div class="relative z-0 w-full mb-4 group">
                            <input type="text" name="floating_idAkun" id="floating_idAkun" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                            <label for="floating_idAkun" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">ID Akun</label>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="grid w-full md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-4 group">
                            <input type="number" name="floating_ongkir" id="floating_ongkir" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                            <label for="floating_ongkir" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Biaya Ongkir</label>
                        </div>
                        <div class="relative z-0 w-full mb-4 group">
                            <input type="number" name="floating_pajak" id="floating_pajak" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                            <label for="floating_pajak" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Biaya Pajak</label>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="relative z-0 w-full mb-4 group">
                        <input type="text" name="floating_keterangan" id="floating_keterangan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                        <label for="floating_keterangan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
                    </div>
                </div>
                <div>
                    <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>