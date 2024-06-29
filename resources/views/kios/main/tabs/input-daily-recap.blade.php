<div class="hidden p-4" id="idr" role="tabpanel" aria-labelledby="idr-tab">
    <div class="relative overflow-x-auto">
        <div class="relative overflow-x-auto">
            <div class="flex items-center justify-between py-4">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search. . .">
                </div>
                <div class="flex text-end">
                    <button type="button" data-modal-target="add-daily-recap" data-modal-toggle="add-daily-recap" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Add Recap</button>
                </div>
            </div>
        </div>
    </div>
    <div class="relative">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Keperluan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Produk
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kategori Permasalahan
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
                {{-- @foreach ($dailyRecap as $recap)
                    <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                        <td class="px-6 py-2">
                            {{ $recap->customer->first_name }} {{ $recap->customer->last_name }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $recap->keperluan->nama }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $recap->produkjenis->jenis_produk }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $recap->kategoripermasalahan->nama }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $recap->status }}
                        </td>
                        <td class="px-6 py-2">
                            <button id="dropdownDailyRecapButton{{ $recap->id }}" data-dropdown-toggle="dropdownDailyRecap{{ $recap->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownDailyRecap{{ $recap->id }}" class="z-10 hidden bg-white rounded-lg shadow w-40 dark:bg-gray-700">
                                <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDailyRecapButton{{ $recap->id }}">
                                    <li>
                                        <button type="button" data-modal-target="recap-view{{ $recap->id }}" data-modal-toggle="recap-view{{ $recap->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                            <span class="material-symbols-outlined text-base mr-3">visibility</span>
                                            <span class="whitespace-nowrap">Detail</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" data-modal-target="recap-edit{{ $recap->id }}" data-modal-toggle="recap-edit{{ $recap->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                            <span class="material-symbols-outlined text-base mr-3">edit</span>
                                            <span class="whitespace-nowrap">Edit</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" data-modal-target="recap-delete{{ $recap->id }}" data-modal-toggle="recap-delete{{ $recap->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                            <span class="material-symbols-outlined text-base mr-3">delete</span>
                                            <span class="whitespace-nowrap">Hapus Data</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <div class="mt-4 ">
            {{-- {{ $dailyRecap->links() }} --}}
        </div>
    </div>

    {{-- Modal --}}
    @include('kios.main.modal.add-recap')
    {{-- @include('kios.main.modal.recap-view')
    @include('kios.main.modal.recap-edit')
    @include('kios.main.modal.recap-delete') --}}
    
</div>