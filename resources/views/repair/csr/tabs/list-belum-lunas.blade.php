<div class="hidden p-4" id="listKasir" role="tabpanel" aria-labelledby="listKasir-tab">
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
                        No Nota
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
                @foreach ($dataCase as $case)
                    @if ($case->jenisStatus->jenis_status == 'Proses Menunggu Pembayaran (Lanjut)')
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td class="px-6 py-2">
                                R-{{ $case->id }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $case->jenisCase->jenis_case }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $case->customer->first_name }} {{ $case->customer->last_name }}-{{ $case->customer->id }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $case->jenisProduk->jenis_produk }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $case->teknisi->first_name }} {{ $case->teknisi->last_name }}
                            </td>
                            <td class="px-6 py-2">
                                <span class="bg-orange-100 text-orange-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">{{ $case->jenisStatus->jenis_status }}</span>
                            </td>
                            <td class="px-6 py-2">
                                <button id="ddBelumLunas{{ $case->id }}" data-dropdown-toggle="dropdownBL{{ $case->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Dropdown menu -->
                        <div id="dropdownBL{{ $case->id }}" class="z-10 hidden bg-white rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="ddBelumLunas{{ $case->id }}">
                                <li>
                                    <button type="button" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <span class="material-symbols-outlined text-base mr-3">visibility</span>
                                        <span class="whitespace-nowrap">Detail</span>
                                    </button>
                                </li>
                                <li>
                                    <a href="{{ route('kasir-repair.edit', encrypt($case->id)) }}" target="_blank" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">shopping_cart_checkout</i>
                                        <span class="whitespace-nowrap">Pelunasan</span>
                                    </a>
                                </li>
                                <li>
                                    <button type="button" data-modal-target="ongkir-kasir-{{ $case->id }}" data-modal-toggle="ongkir-kasir-{{ $case->id }}" data-id="{{ $case->id }}" data-customer-id="{{ $case->customer->id }}" class="ongkir-kasir-repair flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <span class="material-symbols-outlined text-base mr-3">local_shipping</span>
                                        <span class="whitespace-nowrap">Ongkir</span>
                                    </button>
                                </li>
                                <li>
                                    <a href="{{ route('downpaymentKasir', encrypt($case->id)) }}" target="_blank" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">credit_card</i>
                                        <span class="whitespace-nowrap">Down Payment</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 ">
            {{-- {{ $dataCustomer->links() }} --}}
        </div>
    </div>
    {{-- Modal Kasir --}}
    @include('repair.csr.modal.ongkir-kasir')
</div>