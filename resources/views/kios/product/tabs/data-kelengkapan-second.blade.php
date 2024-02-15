<div class="hidden p-4" id="dataSecond" role="tabpanel" aria-labelledby="dataSecond-tab">
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
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama Kelengkapan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Serial Number
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Harga
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
                @foreach ($kelengkapansecond as $kelengkapan)
                    @foreach ($kelengkapan->kelengkapans as $item)
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td class="px-6 py-2">
                                {{ $item->kelengkapan }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $item->pivot->serial_number }}
                            </td>
                            <td class="px-6 py-2">
                                Rp. {{ number_format($item->pivot->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-2">
                                <span class="bg-{{ ($item->pivot->status == 'On Sell') ? 'red' : (($item->pivot->status == 'Ready') ? 'green' : 'yellow') }}-500 rounded-md px-2 py-0 text-white">{{ $item->pivot->status }}</span>
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex flex-wrap">
                                    {{-- <button type="button" data-modal-target="view-supplier{{ $item->id }}" data-modal-toggle="view-supplier{{ $item->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </button>
                                    <button type="button" data-modal-target="edit-supplier{{ $item->id }}" data-modal-toggle="edit-supplier{{ $item->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    <button type="button" data-modal-target="delete-supplier{{ $item->id }}" data-modal-toggle="delete-supplier{{ $item->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 ">
            {{-- {{ $dailyRecap->links() }} --}}
        </div>
    </div>
    
</div>