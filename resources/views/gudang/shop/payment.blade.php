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
                <button type="button" data-modal-target="req-payment" data-modal-toggle="req-payment" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">
                    <span class="material-symbols-outlined">add_card</span>
                    <span class="ml-2"> Req Payment</span>
                </button>
            </div>
        </div>
    </div>
    {{-- Modal Req Payment --}}
    <div id="req-payment" tabindex="-1" class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[cal(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="req-payment">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-6 text-xl font-medium text-gray-900 dark:text-white">Request Payment</h3>
                    <form class="space-y-6" action="#">
                        <div>
                            <label for="ref-gudang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ref Gudang</label>
                            <select id="ref-gudang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                <option hidden>Reff Gudang</option>
                                <option value="">Gudang-666</option>
                                <option value="">Gudang-555</option>
                                <option value="">Gudang-444</option>
                                <option value="">Gudang-333</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="order_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Order ID</label>
                                <input type="text" name="order_id" id="order_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="N.666" readonly>
                            </div>
                            <div>
                                <label for="media_transaksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Transaksi</label>
                                <input type="text" name="media_transaksi" id="media_transaksi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="Tokopedia" readonly>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="nama_akun" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Akun</label>
                                <input type="text" name="nama_akun" id="nama_akun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="BCA VA TOPED" readonly>
                            </div>
                            <div>
                                <label for="bank_pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank Pembayaran</label>
                                <input type="text" name="bank_pembayaran" id="bank_pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="BCA" readonly>
                            </div>
                            <div>
                                <label for="id_akun" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Akun</label>
                                <input type="text" name="id_akun" id="id_akun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="80777082234415140" readonly>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-between">
                            <div class="flex">
                                <span class="text-sm text-gray-700 dark:text-gray-300">HPP</span>
                            </div>
                            <div class="justify-end">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Rp. 13.000.000</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-between">
                            <div class="flex">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Ongkir</span>
                            </div>
                            <div class="justify-end">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Rp. 2.666.000</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-between">
                            <div class="flex">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Pajak</span>
                            </div>
                            <div class="justify-end">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Rp. -</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-between">
                            <div class="flex">
                                <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Total Biaya : </span>
                            </div>
                            <div class="justify-end">
                                <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Rp. 15.666.00</span>
                            </div>
                        </div>
                        <div>
                            <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Type here . . ." required>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Proceed Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
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