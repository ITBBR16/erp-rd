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
    <div class="relative shadow-md sm:rounded-lg">
        <div class="overflow-y-auto max-h-[570px]">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                    @foreach ($listBelanja as $belanja) 
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                N.{{ $belanja->id }}
                            </th>
                            <td class="px-6 py-2">
                                {{ $belanja->gudangSupplier->nama }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $belanja->invoice }}
                            </td>
                            <td class="px-6 py-2">
                                @php
                                    $totalNominal = $belanja->total_pembelian + $belanja->total_ongkir + $belanja->total_pajak;
                                @endphp
                                Rp. {{ number_format($totalNominal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $belanja->status }}</span>
                            </td>
                            <td class="px-6 py-2">
                                <button id="dropdownListBelanja{{ $belanja->id }}" data-dropdown-toggle="dropdownLB{{ $belanja->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <div id="dropdownLB{{ $belanja->id }}" class="z-10 hidden bg-white rounded-lg shadow w-48 dark:bg-gray-700">
                            <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownListBelanja{{ $belanja->id }}">
                                <li>
                                    <button type="button" data-modal-target="detail-belanja-{{ $belanja->id }}" data-modal-toggle="detail-belanja-{{ $belanja->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <span class="material-symbols-outlined text-base mr-3">visibility</span>
                                        <span class="whitespace-nowrap">Detail</span>
                                    </button>
                                </li>
                                @if ($belanja->status == 'Menunggu Konfirmasi Belanja')
                                    <li>
                                        <a href="{{ route('belanja-sparepart.edit', encrypt($belanja->id)) }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                            <i class="material-symbols-outlined text-xl mr-3">edit</i>
                                            <span class="whitespace-nowrap">Ubah Belanja</span>
                                        </a>
                                    </li>
                                    <li>
                                        <button type="button" data-modal-target="req-payment-{{ $belanja->id }}" data-modal-toggle="req-payment-{{ $belanja->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                            <span class="material-symbols-outlined text-base mr-3">payments</span>
                                            <span class="whitespace-nowrap">Request Payment</span>
                                        </button>
                                    </li>
                                @endif
                                @if ($belanja->status == 'Menunggu Konfirmasi Belanja')
                                    <li>
                                        <button type="button" data-modal-target="delete-belanja-{{ $belanja->id }}" data-modal-toggle="delete-belanja-{{ $belanja->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                            <span class="material-symbols-outlined text-base mr-3">delete</span>
                                            <span class="whitespace-nowrap">Hapus Data</span>
                                        </button>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Modal Action --}}
    @include('gudang.purchasing.modal.detail-belanja')
    @include('gudang.purchasing.modal.delete-belanja')
    @include('gudang.purchasing.modal.req-pembayaran')
</div>