<div class="hidden p-4" id="listCase" role="tabpanel" aria-labelledby="listCase-tab">
    <div class="relative overflow-x-auto">
        <div class="flex items-center justify-between py-4">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="list-case-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search. . .">
            </div>
        </div>
    </div>

    <div class="relative">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Masuk
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Case
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Customer
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Drone
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Teknisi
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
                    <td class="px-6 py-2">
                        19 September 2024
                    </td>
                    <td class="px-6 py-2">
                        Express Online
                    </td>
                    <td class="px-6 py-2">
                        Daniel Kukuk
                    </td>
                    <td class="px-6 py-2">
                        DJI PHANTOM 4 STANDARD
                    </td>
                    <td class="px-6 py-2">
                        Magang Anjay
                    </td>
                    <td class="px-6 py-2">
                        New Case
                    </td>
                    <td class="px-6 py-2">
                        <button id="dropdownListCase" data-dropdown-toggle="dropdownLC" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                <!-- Dropdown menu -->
                <div id="dropdownLC" class="z-10 hidden bg-white rounded-lg shadow w-40 dark:bg-gray-700">
                    <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownListCase">
                        <li>
                            <button type="button" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                <span class="material-symbols-outlined text-base mr-3">visibility</span>
                                <span class="whitespace-nowrap">Detail</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                <span class="material-symbols-outlined text-base mr-3">edit</span>
                                <span class="whitespace-nowrap">Edit</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                <span class="material-symbols-outlined text-base mr-3">delete</span>
                                <span class="whitespace-nowrap">Hapus Data</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </tbody>
        </table>
        <div class="mt-4 ">
            {{-- {{ $dataCustomer->links() }} --}}
        </div>
    </div>
</div>