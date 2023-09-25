@extends('gudang.layouts.main')

@section('container')
    <div class="flex text-3xl">
        <span class="text-gray-700 font-bold dark:text-gray-300">Request Payment</span>
    </div>
    <div class="flex text-xl mt-6">
        <span class="text-gray-700 font-semibold dark:text-gray-300">Overview</span>
    </div>
    <div class="w-full mx-auto mt-3">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-xl rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-4xl dark:text-gray-400">sync</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Pending Payment</span>
                                </div>
                                <div class="px-3 py-2">
                                    <div class="font-bold text-xl mb-2 text-slate-900 dark:text-gray-400">666</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-xl rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-4xl dark:text-gray-400">hourglass_empty</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Requested Payment</span>
                                </div>
                                <div class="px-3 py-2">
                                    <div class="font-bold text-xl mb-2 text-slate-900 dark:text-gray-400">666</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-xl rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-4xl dark:text-gray-400">check_circle</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Done Payment</span>
                                </div>
                                <div class="px-3 py-2">
                                    <div class="font-bold text-xl mb-2 text-slate-900 dark:text-gray-400">666</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto mt-10">
        <div class="flex items-center justify-between py-4">
            <div class="flex text-xl">
                <span class="text-gray-700 font-semibold dark:text-gray-300">Recent Activity</span>
            </div>
            <div class="relative text-xl">
                <button type="button" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">
                    <span class="material-symbols-outlined">add_card</span>
                    <span class="ml-2"> Req Payment</span>
                </button>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2 mb-4">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Ref Gudang</th>
                    <th scope="col" class="px-6 py-3">Keterangan</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Nominal</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-2">Gudang-555</th>
                    <td class="px-6 py-2">Pembelian Part Mavic Pro</td>
                    <td class="px-6 py-2">
                        <span class="bg-teal-500 rounded-md px-2 py-0 text-white">Pending</span>
                    </td>
                    <td class="px-6 py-2">Rp. 15.400.000</td>
                    <td class="px-6 py-2">5 Mei 2023</td>
                </tr>
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-2">Gudang-333</th>
                    <td class="px-6 py-2">Pembelian Accessories Rumah Drone</td>
                    <td class="px-6 py-2">
                        <span class="bg-amber-500 rounded-md px-2 py-0 text-white">Processing</span>
                    </td>
                    <td class="px-6 py-2">Rp. 7.010.200</td>
                    <td class="px-6 py-2">6 April 2023</td>
                </tr>
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-2">Gudang-99</th>
                    <td class="px-6 py-2">Bayar pajak sparepart</td>
                    <td class="px-6 py-2">
                        <span class="bg-green-500 rounded-md px-2 py-0 text-white">Success</span>
                    </td>
                    <td class="px-6 py-2">Rp. 603.103</td>
                    <td class="px-6 py-2">1 April 2023</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection