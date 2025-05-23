<div class="hidden p-4" id="dsbl" role="tabpanel" aria-labelledby="dsbl-tab">
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
        <div class="overflow-y-auto h-[580px]">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" style="width: 15%">
                            Metode Pembelian
                        </th>
                        <th scope="col" class="px-6 py-3" style="width: 15%">
                            Supplier
                        </th>
                        <th scope="col" class="px-6 py-3" style="width: 15%">
                            Tanggal Pembelian
                        </th>
                        <th scope="col" class="px-6 py-3" style="width: 15%">
                            Total Nominal
                        </th>
                        <th scope="col" class="px-6 py-3" style="width: 10%">
                            Status Pembayaran
                        </th>
                        <th scope="col" class="px-6 py-3" style="width: 15%">
                            Status Order
                        </th>
                        <th scope="col" class="px-6 py-3" style="width: 15%">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderSecond as $os)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                        <th class="px-6 py-2">
                            {{ $os->buymetodesecond->metode_pembelian }}
                        </th>
                        <td class="px-6 py-2">
                            {{ $os->customer->first_name }} {{ $os->customer->last_name }}
                        </td>
                        <td class="px-6 py-2">
                            {{ \Carbon\Carbon::parse($os->tanggal_pembelian)->isoFormat('D MMMM YYYY') }}
                        </td>
                        <td class="px-6 py-2">
                            @php
                                $totalNilai = $os->biaya_pembelian + $os->biaya_ongkir;
                            @endphp
                            Rp. {{ number_format($totalNilai, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-2">
                            @if ($os->status_pembayaran == 'Paid')
                                <span class="bg-green-100 text-green-800 font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{ $os->status_pembayaran }}</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">{{ $os->status_pembayaran }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-2">
                            <span class="bg-{{ ($os->status != 'InRD' ? 'orange' : 'green') }}-400 rounded-md px-2 py-0 text-white">{{ $os->status }}</span>
                        </td>
                        <td class="px-6 py-2">
                            <button id="dropdownListBelanjaDroneSecondButton{{ $os->id }}" data-dropdown-toggle="dropdownListBelanjaDroneSecond{{ $os->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <!-- Dropdown menu -->
                    <div id="dropdownListBelanjaDroneSecond{{ $os->id }}" class="z-10 hidden bg-white rounded-lg shadow w-40 dark:bg-gray-700">
                        <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownListBelanjaDroneSecondButton{{ $os->id }}">
                            <li>
                                <button type="button" data-modal-target="view-second{{ $os->id }}" data-modal-toggle="view-second{{ $os->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                    <i class="material-symbols-outlined text-base mr-3">visibility</i>
                                    <span class="whitespace-nowrap">Detail</span>
                                </button>
                            </li>
                            @if ($os->status_pembayaran != 'Paid')
                                <li>
                                    <button type="button" data-modal-target="delete-second{{ $os->id }}" data-modal-toggle="delete-second{{ $os->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">delete</i>
                                        <span class="whitespace-nowrap">Hapus</span>
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
    {{-- Modal --}}
    @include('kios.shop.modal.view-second')
    @include('kios.shop.modal.delete-second')
</div>