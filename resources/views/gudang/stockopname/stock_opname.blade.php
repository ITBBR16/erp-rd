@extends('gudang.layouts.main')

@section('container')
<div class="flex text-3xl">
    <span class="text-gray-700 font-bold dark:text-gray-300">Data Stock Opname</span>
</div>
<div class="relative overflow-x-auto mt-6">
    <div class="flex items-center justify-between py-4">
        <div class="flex text-xl">
            <button type="button" data-modal-target="add-so" data-modal-toggle="add-so" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">
                <span class="material-symbols-outlined">assignment_add</span>
                <span class="ml-2">New Data SO</span>
            </button>
        </div>
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Items">
        </div>
    </div>
</div>
{{-- Modal Add SO --}}
<div id="add-so" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        {{-- Modal Content --}}
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-6 text-xl font-medium text-gray-900 dark:text-white">Add New Data Stock Opname</h3>
                <form class="space-y-6" action="#">
                    <div>
                        <label for="scan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scan Barcode</label>
                        <input type="text" name="scan" id="scan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="BTR.5.BTR.1740 * N.110.4.3" required>
                        <p class="mt-1 text-sm text-gray-400">* Scan Barcode Part Here</p>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="select_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select id="select_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                <option selected>Status</option>
                                <option value="">Lebih</option>
                                <option value="">Kurang</option>
                            </select>
                        </div>
                        <div>
                            <label for="select_pj" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penanggung Jawab</label>
                            <select id="select_pj" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                <option selected>Penanggung Jawab</option>
                                <option value="">Novan</option>
                                <option value="">Aisyah</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Type here . . ." required>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit Stock Opname</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Tanggal
                </th>
                <th scope="col" class="px-6 py-3">
                    SKU
                </th>
                <th scope="col" class="px-6 py-3">
                    Order ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Drone
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Part
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                <th class="px-6 py-2">
                    21/09/2023
                </th>
                <td class="px-6 py-2">
                    DR.5.GBL.921
                </td>
                <td class="px-6 py-2">
                    N.29.2.7
                </td>
                <td class="px-6 py-2">
                    PHANTOM 4
                </td>
                <td class="px-6 py-2">
                    Motor Yaw Phantom 4
                </td>
                <td class="px-6 py-2">
                    Kurang
                </td>
                <td class="px-6 py-2">
                    <div class="flex flex-wrap">
                        <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                            <i class="material-symbols-outlined text-base">visibility</i>
                        </button>
                        <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                            <i class="material-symbols-outlined text-base">edit</i>
                        </button>
                        <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                            <i class="material-symbols-outlined text-base">delete</i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                <th class="px-6 py-4">
                    20/09/2023
                </th>
                <td class="px-6 py-4">
                    DR.5.GBL.213
                </td>
                <td class="px-6 py-4">
                    N.121.2.2
                </td>
                <td class="px-6 py-4">
                    MINI 3 PRO
                </td>
                <td class="px-6 py-4">
                    Camera Signal Cable Mini 3 Pro
                </td>
                <td class="px-6 py-4">
                    Kurang
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap">
                        <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                            <i class="material-symbols-outlined text-base">visibility</i>
                        </button>
                        <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                            <i class="material-symbols-outlined text-base">edit</i>
                        </button>
                        <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                            <i class="material-symbols-outlined text-base">delete</i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection