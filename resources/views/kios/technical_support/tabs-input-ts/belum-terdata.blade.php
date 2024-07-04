<div class="hidden p-4" id="its" role="tabpanel" aria-labelledby="its-tab">
    <form action="#" method="POST" autocomplete="off">
    @csrf
        <div class="relative overflow-x-auto">
            <div class="flex justify-between items-center py-4">
                <button type="button" data-modal-target="add-data-ts" data-modal-toggle="add-data-ts" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Add Data TS</button>
                <button type="button" id="button-checkbox" class="cursor-not-allowed flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800" disabled>Submit Checkbox</button>
            </div>
        </div>
        <div class="relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all" class="sr-only">checkbox all</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal Input
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jenis Produk
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jenis Permasalahan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Keterangan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="container-data-ts">
                    @foreach ($dataRecapTs as $recap)
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="checkboxSelect[]" id="checkbox-{{ $recap->id }}" class="checkbox-ts w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" value="{{ $recap->id }}">
                                    <label for="checkbox-{{ $recap->id }}" class="sr-only">checkbox all</label>
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                {{ \Carbon\Carbon::parse($recap->created_at)->isoFormat('D MMMM YYYY') }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $recap->recapTs->produkjenis->jenis_produk }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $recap->recapTs->kategoriPermasalahan->nama }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $recap->recapTs->keterangan }}
                            </td>
                            <td class="px-6 py-2">
                                <button id="dropdownInputTS{{ $recap->id }}" data-dropdown-toggle="dropdownITS{{ $recap->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdownITS{{ $recap->id }}" class="z-10 hidden bg-white rounded-lg shadow w-40 dark:bg-gray-700">
                                    <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInputTS{{ $recap->id }}">
                                        <li>
                                            <button type="button" data-modal-target="recap-view{{ $recap->id }}" data-modal-toggle="recap-view{{ $recap->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                                <span class="material-symbols-outlined text-base mr-3">keyboard_tab</span>
                                                <span class="whitespace-nowrap">Lanjut</span>
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" data-modal-target="recap-edit{{ $recap->id }}" data-modal-toggle="recap-edit{{ $recap->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                                <span class="material-symbols-outlined text-base mr-3">cancel</span>
                                                <span class="whitespace-nowrap">Cancel</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 ">
                {{-- {{ $dailyRecap->links() }} --}}
            </div>
        </div>
    </form>
    {{-- Modal --}}
    @include('kios.technical_support.modal-ts.new-data-ts')

</div>