@extends('gudang.layouts.main')

@section('container')
    <div class="flex text-3xl">
        <span class="text-gray-700 font-bold dark:text-gray-300">Inventory Gudang</span>
    </div>
    <div class="relative overflow-x-auto mt-6">
        <div class="flex items-center justify-between py-4">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Items">
            </div>
            <div class="flex text-xl">
                <a href="/gudang/inventory/tambah-sku" type="button" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Add SKU</a>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Produk</th>
                    <th scope="col" class="px-6 py-3">Nama Part</th>
                    <th scope="col" class="px-6 py-3">Stock</th>
                    <th scope="col" class="px-6 py-3">Modal Pcs</th>
                    <th scope="col" class="px-6 py-3">SRP Repair</th>
                    <th scope="col" class="px-6 py-3">SRP Global</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-6 py-3">SPARK</td>
                    <td class="px-6 py-3">Propeller Guard Spark</td>
                    <td class="px-6 py-3">66</td>
                    <td class="px-6 py-3">Rp 93.296</td>
                    <td class="px-6 py-3">Rp 108.296</td>
                    <td class="px-6 py-3">Rp 375.000</td>
                    <td class="px-6 py-3">
                        <div class="flex flex-wrap">
                            <button type="button" data-modal-target="view-inventory" data-modal-toggle="view-inventory" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">visibility</i>
                            </button>
                            <button type="button" data-modal-target="edit-inventory" data-modal-toggle="edit-inventory" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">edit</i>
                            </button>
                            <button type="button" data-modal-target="disable-sku" data-modal-toggle="disable-sku" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">block</i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-3">SPARK</td>
                    <td class="px-6 py-3">Propeller Guard Spark</td>
                    <td class="px-6 py-3">66</td>
                    <td class="px-6 py-3">Rp 93.296</td>
                    <td class="px-6 py-3">Rp 108.296</td>
                    <td class="px-6 py-3">Rp 375.000</td>
                    <td class="px-6 py-3">
                        <div class="flex flex-wrap">
                            <button type="button" data-modal-target="view-inventory" data-modal-toggle="view-inventory" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">visibility</i>
                            </button>
                            <button type="button" data-modal-target="edit-inventory" data-modal-toggle="edit-inventory" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">edit</i>
                            </button>
                            <button type="button" data-modal-target="disable-sku" data-modal-toggle="disable-sku" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">block</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Modal Action --}}

    {{-- Modal View --}}
    <div id="view-inventory" tabindex="-1" class="fixed top-0 left-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="view-inventory">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-6 text-xl font-medium text-gray-900 dark:text-white">Judul View</h3>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Edit --}}
    <div id="edit-inventory" tabindex="-1" class="fixed top-0 left-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-inventory">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-6 text-xl font-medium text-gray-900 dark:text-white">Judul Edit</h3>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Disable --}}
    <div id="disable-sku" tabindex="-1" class="fixed top-0 left-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="disable-sku">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <span class="mb-4 inline-flex justify-center items-center w-[62px] h-[62px] rounded-full border-4 border-yellow-50 bg-yellow-100 text-yellow-500">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                        </svg>
                    </span>
                    <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-gray-300">Disable SKU</h3>
                    <p class="mb-4 text-gray-500 dark:text-gray-400">Yakin Menonaktifkan SKU ?</p>
                    <button data-modal-hide="disable-sku" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 mr-4 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Disable</button>
                    <button data-modal-hide="disable-sku" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection