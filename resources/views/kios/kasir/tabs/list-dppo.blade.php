<div class="hidden p-4" id="list-dppo" role="tabpanel" aria-labelledby="list-dppo-tab">
    <div class="relative overflow-x-auto">
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
        </div>
    </div>
    <div class="relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal DP / PO
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total DP
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Sisa Pembayaran
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
                @foreach ($dataTransaksi as $item)
                    @if ($item->status_dp == 'DP' || $item->status_po == 'PO')
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                {{ $item->customer->first_name }} {{ $item->customer->last_name }}
                            </th>
                            <td class="px-6 py-2">
                                {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY') }}
                            </td>
                            <td class="px-6 py-2">
                                Rp. {{ number_format($item->transaksidp->jumlah_pembayaran, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-2">
                                @php
                                    $totalSisa = $item->total_harga - $item->transaksidp->jumlah_pembayaran;
                                @endphp
                                Rp. {{ number_format($totalSisa, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-2">
                                @if ($item->status_dp == 'Lunas' || $item->status_po == 'Lunas')
                                    <span class="bg-green-100 text-green-800 text-xs font-bold me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Lunas</span>
                                @elseif($item->status_dp == 'DP' && $item->status_po == '')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Down Payment</span>
                                @elseif($item->status_dp == '' && $item->status_po == 'PO')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pre Order</span>
                                @elseif($item->status_dp == 'DP' && $item->status_po == 'PO')
                                    <span class="bg-red-100 text-red-800 text-xs font-bold me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">DP & PO</span>
                                @endif
                            </td>
                            <td class="px-6 py-2">
                                <button id="dropdownListBelanjaBaruButton{{ $item->id }}" data-dropdown-toggle="dropdownListBelanjaBaru{{ $item->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Dropdown menu -->
                        <div id="dropdownListBelanjaBaru{{ $item->id }}" class="z-10 hidden bg-white rounded-lg shadow w-40 dark:bg-gray-700">
                            <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownListBelanjaBaruButton{{ $item->id }}">
                                <li>
                                    <button type="button" data-modal-target="dppo-views-{{ $item->id }}" data-modal-toggle="dppo-views-{{ $item->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">visibility</i>
                                        <span class="whitespace-nowrap">Detail DP / PO</span>
                                    </button>
                                </li>
                                <li>
                                    <a href="{{ route('dp-po.edit', encrypt($item->id)) }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">task_alt</i>
                                        <span class="whitespace-nowrap">Pelunasan</span>
                                    </a>
                                </li>
                                <li>
                                    <button type="button" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">delete</i>
                                        <span class="whitespace-nowrap">Delete DP / PO</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Modal List DP PO --}}
    @include('kios.kasir.modal.dppo-views-modal')
</div>