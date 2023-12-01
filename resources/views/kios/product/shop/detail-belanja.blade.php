<div class="hidden p-4" id="dbl" role="tabpanel" aria-labelledby="dbl-tab">
    <div class="relative overflow-x-auto">
        <div class="flex items-center justify-between py-4">
            <div class="flex text-xl">
                <span class="text-gray-700 font-semibold dark:text-gray-300">List Belanja</span>
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
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Order ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Supplier
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Invoice
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Nominal
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
                        K.666
                    </th>
                    <td class="px-6 py-2">
                        DORAN
                    </td>
                    <td class="px-6 py-2">
                        INV/20230908/MPL/3446962446
                    </td>
                    <td class="px-6 py-2">
                        Rp. 5.407.200
                    </td>
                    <td class="px-6 py-2">
                        <span class="bg-orange-400 rounded-md px-2 py-0 text-white">Waiting</span>
                    </td>
                    <td class="px-6 py-2">
                        <div class="flex flex-wrap">
                            <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">visibility</i>
                            </button>
                            <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">edit</i>
                            </button>
                            <button type="button" data-modal-target="delete-belanja" data-modal-toggle="delete-belanja" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-4">
                        K.444
                    </th>
                    <td class="px-6 py-4">
                        DJI
                    </td>
                    <td class="px-6 py-4">
                        INV/20230906/MPL/3442830262
                    </td>
                    <td class="px-6 py-4">
                        Rp. 15.507.123
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-green-400 rounded-lg px-2 py-0 text-white">Validate</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap">
                            <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">visibility</i>
                            </button>
                            <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">edit</i>
                            </button>
                            <button type="button" data-modal-target="delete-belanja" data-modal-toggle="delete-belanja" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                <i class="material-symbols-outlined text-base">delete</i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    {{-- Modal Action --}}
    @include('kios.product.shop.modal.modal-delete')
</div>