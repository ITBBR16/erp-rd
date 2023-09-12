<div class="hidden p-4" id="belanja" role="tabpanel" aria-labelledby="belanja-tab">
    <form>
        <div class="grid md:w-1/2 md:grid-cols-2 md:gap-4">
            <div class="relative z-0 w-full mb-4 group">
                <input type="text" name="floating_ref" id="floating_ref" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="Gudang-101" readonly required>
                <label for="floating_ref" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ref Gudang</label>
            </div>
            <div class="relative z-0 w-full mb-4 group">
                <input type="text" name="floating_orderId" id="floating_orderId" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="N.333" readonly required>
                <label for="floating_orderId" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Order ID</label>
            </div>
        </div>
        <div class="grid md:w-1/2 md:grid-cols-2 md:gap-4">
            <div class="relative z-0 w-full mb-4 group">
                <input type="text" name="floating_supplier" id="floating_supplier" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                <label for="floating_supplier" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Supplier</label>
            </div>
            <div class="relative z-0 w-full mb-4 group">
                <input type="text" name="floating_invoice" id="floating_invoice" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                <label for="floating_invoice" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Invoice</label>
            </div>
        </div>
        <div class="grid md:w-1/2 md:grid-cols-5 md:gap-4">
            <div>
                <label for="select_jDrone" class="sr-only"></label>
                <select id="select_jDrone" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected>Jenis Drone</option>
                    <option value="">MAVIC MINI</option>
                    <option value="">SPARK</option>
                    <option value="">MINI 2</option>
                    <option value="">MAVIC PRO</option>
                </select>
            </div>
            <div>
                <label for="select_part" class="sr-only"></label>
                <select id="select_part" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected>Pilih Part</option>
                    <option value="">Propeller Mavic Mini (Set)</option>
                    <option value="">2 set camera lens film</option>
                    <option value="">Fly More Combo Bag Mavic Mini</option>
                    <option value="">Filter ND4 Sunnylife MaMi/Mini 2/Mini SE</option>
                </select>
            </div>
            <div class="relative z-0 w-full mb-4 group">
                <input type="text" name="floating_iQty" id="floating_iQty" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                <label for="floating_iQty" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
            </div>
            <div class="relative z-0 w-full mb-4 group">
                <input type="text" name="floating_iNominal" id="floating_iNominal" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                <label for="floating_iNominal" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total Nominal</label>
            </div>
            <div class="flex justify-center items-center">
                <button type="button">
                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">add_circle</span>
                </button>
            </div>
        </div>
    </form>
</div>