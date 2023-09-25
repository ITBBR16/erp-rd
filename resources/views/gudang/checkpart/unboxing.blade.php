@extends('gudang.layouts.main')

@section('container')
    <div class="flex text-3xl">
        <span class="text-gray-700 font-bold dark:text-gray-300">Unboxing</span>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Order ID</th>
                    <th scope="col" class="px-6 py-3">Invoice</th>
                    <th scope="col" class="px-6 py-3">Resi</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-2">N.55</th>
                    <td class="px-6 py-2">INV/20230830/MPL/3429878418</td>
                    <td class="px-6 py-2">LP249538515SG</td>
                    <td class="px-6 py-2">
                        <span class="bg-orange-400 rounded-md px-2 py-0 text-white">Shipping</span>
                    </td>
                    <td class="px-6 py-2">
                        <div class="flex flex-wrap">
                            <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">unarchive</i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-2">N.44</th>
                    <td class="px-6 py-2">INV/20230821/MPL/3413578710</td>
                    <td class="px-6 py-2">LP250795065SG</td>
                    <td class="px-6 py-2">
                        <span class="bg-orange-400 rounded-md px-2 py-0 text-white">Shipping</span>
                    </td>
                    <td class="px-6 py-2">
                        <div class="flex flex-wrap">
                            <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">unarchive</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection