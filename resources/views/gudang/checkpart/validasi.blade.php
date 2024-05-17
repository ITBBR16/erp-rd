@extends('gudang.layouts.main')

@section('container')
    <div class="flex text-3xl">
        <span class="text-gray-700 font-bold dark:text-gray-300">Validasi Barang</span>
    </div>
    <div class="w-full px-3 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="max-w-full px-3 md:flex-none">
                <div class="flex items-center justify-between mt-6 gap-4">
                    <div class="flex justify-start gap-6">
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
                    <div class="relative text-lg">
                        <button type="button" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Submit</button>
                    </div>
                </div>
                <div class="relative overflow-auto shadow-md md:rounded-lg mt-4 mb-4">
                    <table class="w-full text-xs table-fixed text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4 w-4 h-4">No</th>
                                <th scope="col" class="px-3 py-3">Jenis Drone</th>
                                <th scope="col" class="px-3 py-3">Nama Part</th>
                                <th scope="col" class="px-3 py-3">ID Item</th>
                                <th scope="col" class="px-3 py-3">QTY</th>
                                <th scope="col" class="px-3 py-3">Fisik</th>
                                <th scope="col" class="px-3 py-3">Fungsional</th>
                                <th scope="col" class="px-6 py-2">
                                    <div class="flex">
                                        <label for="checkbox-all-search" class="pr-2">Validation</label>
                                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="p-4">1</th>
                                <td class="px-3 py-3">MINI 3 PRO</td>
                                <td class="px-3 py-3">GPS Board Mini 3 Pro</td>
                                <td class="px-3 py-3">N.131.6.1</td>
                                <td class="px-3 py-3">Pass</td>
                                <td class="px-3 py-3">Pass</td>
                                <td class="px-3 py-3">Pass</td>
                                <td class="px-6 py-2">
                                    <div class="flex items-center justify-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="p-4">2</th>
                                <td class="px-3 py-3">MINI 3 PRO</td>
                                <td class="px-3 py-3">GPS Board Mini 3 Pro</td>
                                <td class="px-3 py-3">N.131.6.2</td>
                                <td class="px-3 py-3">Pass</td>
                                <td class="px-3 py-3">Fail</td>
                                <td class="px-3 py-3">Pass</td>
                                <td class="px-6 py-2">
                                    <div class="flex items-center justify-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th class="p-4">3</th>
                                <td class="px-3 py-3">MINI 3 PRO</td>
                                <td class="px-3 py-3">GPS Board Mini 3 Pro</td>
                                <td class="px-3 py-3">N.131.6.3</td>
                                <td class="px-3 py-3">Pass</td>
                                <td class="px-3 py-3">Pass</td>
                                <td class="px-3 py-3">Fail</td>
                                <td class="px-6 py-2">
                                    <div class="flex items-center justify-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection