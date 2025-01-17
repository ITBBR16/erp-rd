<div class="hidden p-4" id="history-penerimaan" role="tabpanel" aria-labelledby="history-penerimaan-tab">
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
    <div class="relative">
        <div class="overflow-y-auto max-h-[550px]">
            <table class="sticky top-0 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama Customer
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No Register
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jenis Produk
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Ekspedisi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No Resi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal Diterima
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
                    @foreach ($dataFormRepair as $data)
                        @if ($data->status == 'Diterima' || $data->status == 'Done InRD')
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <th class="px-6 py-2">
                                    {{ $data->nama_lengkap }}
                                </th>
                                <td class="px-6 py-2">
                                    {{ $data->no_register }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $data->tipe_produk }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $data->ekspedisi ?? '' }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $data->nomor_resi ?? '' }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ \Carbon\Carbon::parse($data->tanggal_diterima)->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td class="px-6 py-2">
                                    <span class="bg-green-400 rounded-md px-2 py-0 text-white">{{ $data->status }}</span>
                                </td>
                                <td class="px-6 py-2">
                                    <button id="dropdownPengirimanAktif{{ $data->id }}" data-dropdown-toggle="dropdownPA{{ $data->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <div id="dropdownPA{{ $data->id }}" class="z-10 hidden bg-white rounded-lg shadow w-50 dark:bg-gray-700">
                                <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownPengirimanAktif{{ $data->id }}">
                                    <li>
                                        <a href="#" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                            <i class="material-symbols-outlined text-xl mr-3">visibility</i>
                                            <span class="whitespace-nowrap">Detail</span>
                                        </a>
                                    </li>
                                    @if ($data->status == 'On Shipping')
                                        <li>
                                            <button type="button" data-modal-target="konf-penerimaan-{{ $data->id }}" data-modal-toggle="konf-penerimaan-{{ $data->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                                <span class="material-symbols-outlined text-base mr-3">archive</span>
                                                <span class="whitespace-nowrap">Produk Diterima</span>
                                            </button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 ">
            {{-- {{ $suppliers->links() }} --}}
        </div>
    </div>
    @if (!$dataFormRepair->contains('status', 'Diterima') && !$dataFormRepair->contains('status', 'Done InRD'))
        <div class="p-4 mt-4">
            <div class="flex datas-center justify-center">
                <figure class="max-w-lg">
                    <img class="h-auto max-w-full rounded-lg" src="/img/box-empty-3d.png" alt="Not Found" width="200" height="10">
                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Tidak ada history penerimaan</figcaption>
                </figure>
            </div>
        </div>
    @endif

    {{-- Modal --}}
    
</div>