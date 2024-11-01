@extends('gudang.layouts.main')

@section('container')
    <div class="relative mt-2">
        <div class="flex items-center justify-between py-4">
            <div class="flex text-xl">
                <span class="text-gray-700 font-semibold dark:text-gray-300">List Pengiriman</span>
            </div>
            <div class="relative text-xl">
                <button type="button" data-modal-target="add-resi" data-modal-toggle="add-resi" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">
                    <span class="material-symbols-outlined">person_pin</span>
                    <span class="ml-2"> Add Supplier</span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="relative shadow-md sm:rounded-lg mt-2">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Supplier</th>
                    <th scope="col" class="px-6 py-3">Negara</th>
                    <th scope="col" class="px-6 py-3">Kontak Person</th>
                    <th scope="col" class="px-6 py-3">No Telpon</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-2">FLAYS</th>
                    <td class="px-6 py-2">Afrika</td>
                    <td class="px-6 py-2">Jainudin</td>
                    <td class="px-6 py-2">+62 851 55651 9066</td>
                    <td class="px-6 py-2">
                        <span class="bg-green-500 rounded-md px-2 py-0 text-white">Active</span>
                    </td>
                    <td class="px-6 py-2">
                        <button id="dropdownSupplier" data-dropdown-toggle="dropdownSup" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                <div id="dropdownSup" class="z-10 hidden bg-white rounded-lg shadow w-48 dark:bg-gray-700">
                    <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownSupplier">
                        <li>
                            <button type="button" data-modal-target="detail-supplier" data-modal-toggle="detail-supplier" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                <span class="material-symbols-outlined text-base mr-3">visibility</span>
                                <span class="whitespace-nowrap">Detail</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </tbody>
        </table>
    </div>
    {{-- Modal Input Resi --}}
    
@endsection