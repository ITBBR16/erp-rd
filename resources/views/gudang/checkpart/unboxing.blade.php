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
                            <button type="button" data-modal-target="unbox-modal" data-modal-toggle="unbox-modal" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
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
                            <button type="button" data-modal-target="unbox-modal" data-modal-toggle="unbox-modal" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">unarchive</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    {{-- Modal Unboxing --}}
    <div id="unbox-modal" tabindex="-1" class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="unbox-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-6 text-xl font-medium text-gray-900 dark:text-white">Unboxing N.55</h3>
                    <form action="#" class="space-y-6">
                        <div>
                            <label for="no_invoice">No Invoice</label>
                            <input type="text" name="no_invoice" id="no_invoice" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="INV/20230830/MPL/3429878418" readonly required>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="supplier">Supplier</label>
                                <input type="text" name="supplier" id="supplier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="ZDF" readonly required>
                            </div>
                            <div>
                                <label for="resi">No Resi</label>
                                <input type="text" name="resi" id="resi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="2001349311" readonly required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="tgl_terima">Tanggal Terima</label>
                                <input type="text" name="tgl_terima" id="tgl_terima" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="26 /09 /2023" readonly required>
                            </div>
                            <div>
                                <label for="status_upload">Status Upload</label>
                                <input type="text" name="status_upload" id="status_upload" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="BELUM" readonly required>
                            </div>
                        </div>
                        <div>
                            <label for="drive_link">Link Drive</label>
                            <input type="url" name="drive_link" id="drive_link" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="https://drive.google.com/drive/folders/1cvhAhUj92Tf7sMNLLiMH-VJeSs3cw9NS?usp=sharing" readonly required>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit Unboxing</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection