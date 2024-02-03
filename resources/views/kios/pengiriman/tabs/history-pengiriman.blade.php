<div class="hidden p-4" id="history-pengiriman" role="tabpanel" aria-labelledby="history-pengiriman-tab">
    <div class="relative overflow-x-auto">
        <div class="flex items-center py-4">
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
                        No Resi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Pengirim
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ekspedisi
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
                @foreach ($dataIncoming as $data)
                    @if ($data->status == 'Diterima' || $data->status == 'InRD')
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                {{ ($data->status_order == 'Baru' ? 'K.' . $data->order->id : 'S.' . $data->ordersecond->id) }}
                            </th>
                            <td class="px-6 py-2">
                                {{ $data->no_resi }}
                            </td>
                            <td class="px-6 py-2">
                                {{ ($data->status_order == 'Baru' ? $data->order->supplier->nama_perusahaan : ($data->ordersecond->come_from == 'Customer' ? $data->ordersecond->customer->first_name . ' ' . $data->ordersecond->customer->first_name : $data->ordersecond->marketplace->nama)) }}
                            </td>
                            <td class="px-6 py-2">
                                @if ($data->jenis_layanan_id != '')
                                    {{ $data->pelayanan->ekspedisi->ekspedisi }}
                                @endif
                            </td>
                            <td class="px-6 py-2">
                                <span class="bg-green-400 rounded-md px-2 py-0 text-white">{{ $data->status }}</span>
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex flex-wrap">
                                    <button type="button" data-modal-target="view-order-new" data-modal-toggle="view-order-new{{ $data->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base">visibility</i>
                                    </button>
                                    @foreach ($data->penerimaan as $penerimaan)
                                        @if ($penerimaan->link_img != '')
                                            <button type="button" data-modal-target="view-img-penerimaan" data-modal-toggle="view-img-penerimaan{{ $data->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                                <i class="material-symbols-outlined text-base">photo</i>
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @if (!$dataIncoming->contains('status', 'Diterima') && !$dataIncoming->contains('status', 'InRD'))
        <div class="p-4 mt-4">
            <div class="flex items-center justify-center">
                <figure class="max-w-lg">
                    <img class="h-auto max-w-full rounded-lg" src="/img/box-empty-3d.png" alt="Not Found" width="200" height="100">
                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Tidak ada history pengiriman</figcaption>
                </figure>
            </div>
        </div>
    @endif
    {{-- Modal Action --}}
    @include('kios.pengiriman.modal.view-img')
</div>