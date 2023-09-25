<div class="hidden p-4" id="belanja" role="tabpanel" aria-labelledby="belanja-tab">
    <form>
        <div class="w-full px-3 py-3 mx-auto">
            <div class="flex flex-wrap -mx-3">
                <div class="max-w-full px-3 md:w-2/3 md:flex-none">
                    <div class="flex flex-wrap -mx-3">
                        <div class="grid w-full md:w-full md:grid-cols-2 md:gap-4 md:px-3">
                            <div class="relative z-0 w-full mb-4 group">
                                <input type="text" name="floating_ref" id="floating_ref" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="Gudang-101" readonly required>
                                <label for="floating_ref" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ref Gudang</label>
                            </div>
                            <div class="relative z-0 w-full mb-4 group">
                                <input type="text" name="floating_orderId" id="floating_orderId" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="N.333" readonly required>
                                <label for="floating_orderId" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Order ID</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3">
                        <div class="grid w-full md:w-full md:grid-cols-2 md:gap-4 md:px-3">
                            <div class="relative z-0 w-full mb-4 group">
                                <input type="text" name="floating_supplier" id="floating_supplier" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                <label for="floating_supplier" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Supplier</label>
                            </div>
                            <div class="relative z-0 w-full mb-4 group">
                                <input type="text" name="floating_invoice" id="floating_invoice" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                <label for="floating_invoice" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Invoice</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 md:px-3">
                        <div class="grid md:w-full md:grid-cols-5 md:gap-4">
                            <div>
                                <label for="select_jDrone" class="sr-only"></label>
                                <select id="select_jDrone" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                    <option selected>Jenis Drone</option>
                                    <option value="">MAVIC MINI</option>
                                    <option value="">SPARK</option>
                                    <option value="">MINI 2</option>
                                    <option value="">MAVIC PRO</option>
                                </select>
                            </div>
                            <div>
                                <label for="select_part" class="sr-only"></label>
                                <select id="select_part" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                    <option selected>Pilih Part</option>
                                    <option value="">Propeller Mavic Mini (Set)</option>
                                    <option value="">2 set camera lens film</option>
                                    <option value="">Fly More Combo Bag Mavic Mini</option>
                                    <option value="">Filter ND4 Sunnylife MaMi/Mini 2/Mini SE</option>
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-4 group">
                                <input type="text" name="floating_iQty" id="floating_iQty" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                <label for="floating_iQty" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                            </div>
                            <div class="relative z-0 w-full mb-4 group">
                                <input type="text" name="floating_iNominal" id="floating_iNominal" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                <label for="floating_iNominal" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total Nominal</label>
                            </div>
                            <div class="flex justify-center items-center">
                                <button type="button">
                                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 md:px-3">
                        <div class="grid md:w-full md:grid-cols-5 md:gap-4">
                            <div>
                                <label for="select_jDrone" class="sr-only"></label>
                                <select id="select_jDrone" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                    <option selected>Jenis Drone</option>
                                    <option value="">MAVIC MINI</option>
                                    <option value="">SPARK</option>
                                    <option value="">MINI 2</option>
                                    <option value="">MAVIC PRO</option>
                                </select>
                            </div>
                            <div>
                                <label for="select_part" class="sr-only"></label>
                                <select id="select_part" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                    <option selected>Pilih Part</option>
                                    <option value="">Propeller Mavic Mini (Set)</option>
                                    <option value="">2 set camera lens film</option>
                                    <option value="">Fly More Combo Bag Mavic Mini</option>
                                    <option value="">Filter ND4 Sunnylife MaMi/Mini 2/Mini SE</option>
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-4 group">
                                <input type="text" name="floating_iQty" id="floating_iQty" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                <label for="floating_iQty" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                            </div>
                            <div class="relative z-0 w-full mb-4 group">
                                <input type="text" name="floating_iNominal" id="floating_iNominal" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                <label for="floating_iNominal" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total Nominal</label>
                            </div>
                            <div class="flex justify-center items-center">
                                <button type="button">
                                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">add_circle</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Order Summary --}}
                <div class="w-full max-w-full px-3 lg:w-1/3 lg:flex-none">
                    <div class="relative flex flex-col h-auto min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                        <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-solid rounded-t-2xl border-b-transparent dark:bg-gray-800 dark:border-gray-600">
                            <div class="flex flex-wrap -mx-3">
                                <div class="flex items-center flex-none w-full max-w-full px-3">
                                    <span class="text-xl text-gray-600 font-medium block dark:text-white">Order Summary</span>
                                </div>
                            </div>
                        </div>
                        {{-- Isi Body --}}
                        <div class="flex-auto p-4 pb-0">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full max-w-full px-3 md:w-1/2 md:flex-none">
                                    <div class="relative z-0 w-full mb-4 group">
                                        <input type="text" name="floating_mt" id="floating_mt" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                        <label for="floating_mt" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Media Transaksi</label>
                                    </div>
                                </div>
                                <div class="w-full max-w-full px-3 md:w-1/2 md:flex-none">
                                    <div class="relative z-0 w-full mb-4 group">
                                        <input type="text" name="floating_namaAkun" id="floating_namaAkun" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                        <label for="floating_namaAkun" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Akun</label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full max-w-full px-3 md:w-1/2 md:flex-none">
                                    <div class="relative z-0 w-full mb-4 group">
                                        <input type="text" name="floating_bank" id="floating_bank" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                        <label for="floating_bank" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Bank Pembayaran</label>
                                    </div>
                                </div>
                                <div class="w-full max-w-full px-3 md:w-1/2 md:flex-none">
                                    <div class="relative z-0 w-full mb-4 group">
                                        <input type="text" name="idAkun" id="idAkun" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                        <label for="idAkun" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">ID Akun</label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full max-w-full px-3 md:w-full md:flex-none">
                                    <div class="relative z-0 w-full mb-4 group">
                                        <input type="text" name="floating_keterangan" id="floating_keterangan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                        <label for="floating_keterangan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap px-3 -mx-3 justify-between">
                                <div class="flex">
                                    <span class="text-lg font-medium text-gray-700 mr-1 dark:text-gray-300">Subtotal : </span>
                                </div>
                                <div class="flex items-end">
                                    <span class="text-lg font-bold text-gray-700 dark:text-gray-300">Rp. 15.666.000</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap px-3 py-3 -mx-3 justify-end">
                                <div class="flex">
                                    <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Checkout</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>