<div class="hidden p-4" id="fisik" role="tabpanel" aria-labelledby="fisik-tab">
    <div class="w-full px-3 py-3 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="flex text-xl px-3">
                <span class="text-gray-700 font-semibold dark:text-gray-300">Ini Judul Cek Fisik</span>
            </div>
            <div class="max-w-full px-3 md:flex-none">
                <div class="flex items-center justify-between mt-6 gap-4">
                    <div class="flex items-center justify-start gap-6">
                        <div>
                            <label for="select_orderID" class="sr-only">Order ID</label>
                            <select id="select_orderID" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                                <option selected>Order ID</option>
                                <option value="">N.666</option>
                                <option value="">N.555</option>
                                <option value="">N.444</option>
                                <option value="">N.333</option>
                            </select>
                        </div>
                        <div>
                            <label for="select_sku" class="sr-only">SKU</label>
                            <select id="select_sku" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                                <option selected>SKU</option>
                                <option value="">DR.1.GBL.206</option>
                                <option value="">DR.5.BDY.826</option>
                            </select>
                        </div>
                        <div>
                            <label for="select_pj" class="sr-only">Penanggung Jawab</label>
                            <select id="select_pj" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                                <option selected>Penanggung Jawab</option>
                                <option value="">Novan</option>
                                <option value="">Faral</option>
                            </select>
                        </div>
                    </div>
                    <div class="relative text-xl">
                        <button type="button" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Submit</button>
                    </div>
                </div>
                <div class="relative overflow-auto shadow-md md:rounded-lg mt-4 mb-4">
                    <table class="w-full text-xs table-fixed text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="w-4 p-4">No</th>
                                <th scope="col" class="px-3 py-3">SKU</th>
                                <th scope="col" class="px-3 py-3">Jenis Drone</th>
                                <th scope="col" class="px-3 py-3">Nama Part</th>
                                <th scope="col" class="px-3 py-3">ID Item</th>
                                <th scope="col" class="px-3 py-3">Status</th>
                                <th scope="col" class="px-3 py-3">SN</th>
                                <th scope="col" class="px-3 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="w-4 p-4">1</th>
                                <td class="px-3 py-3">DR.1.GBL.206</td>
                                <td class="px-3 py-3">MINI 3 PRO</td>
                                <td class="px-3 py-3">GPS Board Mini 3 Pro</td>
                                <td class="px-3 py-3">N.666.6.1</td>
                                <td class="px-3 py-3">
                                    <label for="select_status" class="sr-only">Status</label>
                                    <select id="select_status" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                                        <option selected>Status</option>
                                        <option value="">Pass</option>
                                        <option value="">Fail</option>
                                    </select>
                                </td>
                                <td class="px-3 py-3">
                                    <input type="text" class="w-full bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0">
                                </td>
                                <td class="px-3 py-3">
                                    <input type="text" class="w-full bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0">
                                </td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="w-4 p-4">2</th>
                                <td class="px-3 py-3">DR.1.GBL.206</td>
                                <td class="px-3 py-3">MINI 3 PRO</td>
                                <td class="px-3 py-3">GPS Board Mini 3 Pro</td>
                                <td class="px-3 py-3">N.666.6.2</td>
                                <td class="px-3 py-3">
                                    <label for="select_status" class="sr-only">Status</label>
                                    <select id="select_status" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200">
                                        <option selected>Status</option>
                                        <option value="">Pass</option>
                                        <option value="">Fail</option>
                                    </select>
                                </td>
                                <td class="px-3 py-3">
                                    <input type="text" class="w-full bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0">
                                </td>
                                <td class="px-3 py-3">
                                    <input type="text" class="w-full bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>