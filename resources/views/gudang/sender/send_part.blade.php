<div class="hidden p-2" id="part" role="tabpanel" aria-labelledby="part-tab">
    <form action="#">
        <div class="mb-6">
            <div class="relative z-0 w-full md:w-1/2 mb-6 group">
                <label for="select_customer_repair" class="sr-only"></label>
                <select id="select_customer_repair" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option hidden>Nama Customer</option>
                    <option value="">LIBERTY-778-1188</option>
                    <option value="">BOBBI ADIEL-1151-1516</option>
                    <option value="">Husein-1252</option>
                    <option value="">ELSAN-1187-13</option>
                </select>
            </div>
            <div class="grid md:w-1/2 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="floating_jdrone" id="floating_jdrone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="DJI MAVIC 2 ZOOM" readonly required>
                    <label for="floating_jdrone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jenis Drone</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="floating_tgl" id="floating_tgl" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="21/08/2023" readonly required>
                    <label for="floating_tgl" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal Request</label>
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Jenis Transaksi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            SKU
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Produk
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Part
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Stock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Input
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-2">
                            P.BARU
                        </th>
                        <td class="px-6 py-2">
                            DR.5.GBL.437
                        </td>
                        <td class="px-6 py-2">
                            MAVIC 2
                        </td>
                        <td class="px-6 py-2">
                            Yaw Roll Module Mavic 2 Zoom
                        </td>
                        <td class="px-6 py-2">
                            0
                        </td>
                        <td class="px-6 py-2">
                            <input type="text" class="bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0">
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4">
                            P.BARU
                        </th>
                        <td class="px-6 py-4">
                            DR.5.GBL.437
                        </td>
                        <td class="px-6 py-4">
                            MAVIC 2
                        </td>
                        <td class="px-6 py-4">
                            Yaw Roll Module Mavic 2 Zoom
                        </td>
                        <td class="px-6 py-4">
                            66
                        </td>
                        <td class="px-6 py-4">
                            <input type="text" class="bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
        </div>
    </form>
</div>