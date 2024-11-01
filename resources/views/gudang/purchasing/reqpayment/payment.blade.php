@extends('gudang.layouts.main')

@section('container')
    <div class="relative overflow-x-auto">
        <div class="flex items-center justify-between py-4">
            <div class="flex text-xl">
                <span class="text-gray-700 font-semibold dark:text-gray-300">Recent Activity</span>
            </div>
            <div class="relative text-xl">
                <button type="button" data-modal-target="add-payment" data-modal-toggle="add-payment" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">
                    <span class="material-symbols-outlined">add_card</span>
                    <span class="ml-2"> Req Payment</span>
                </button>
            </div>
        </div>
    </div>
    <div class="relative shadow-md sm:rounded-lg mt-2 mb-4">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Ref Gudang</th>
                    <th scope="col" class="px-6 py-3">Keterangan</th>
                    <th scope="col" class="px-6 py-3">Nominal</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-2">Gudang-555</th>
                    <td scope="row" class="px-6 py-2">Pembelian Part Mavic Pro</td>
                    <td class="px-6 py-2">Rp. 15.400.000</td>
                    <td class="px-6 py-2">5 Mei 2023</td>
                    <td class="px-6 py-2">
                        <span class="bg-teal-500 rounded-md px-2 py-0 text-white">Pending</span>
                    </td>
                    <td class="px-6 py-2">
                        <button id="dropdownReqPayment" data-dropdown-toggle="dropdownRP" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                <div id="dropdownRP" class="z-10 hidden bg-white rounded-lg shadow w-48 dark:bg-gray-700">
                    <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownReqPayment">
                        <li>
                            <button type="button" data-modal-target="detail-req-payment" data-modal-toggle="detail-req-payment" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                <span class="material-symbols-outlined text-base mr-3">visibility</span>
                                <span class="whitespace-nowrap">Detail</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </tbody>
        </table>
    </div>
    {{-- Modal Req Payment --}}
    @include('gudang.purchasing.modal.add-payment')
    @include('gudang.purchasing.modal.detail-req-payment')
@endsection