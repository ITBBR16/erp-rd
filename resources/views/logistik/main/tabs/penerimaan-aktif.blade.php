<div class="hidden p-4" id="penerimaanAktif" role="tabpanel" aria-labelledby="penerimaanAktif-tab">
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
                        Divisi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No Resi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ekspedisi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Layanan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Dikirim
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
                {{-- @foreach ($dataIncoming as $data)
                    @if ($data->status == 'Incoming')
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                {{ $data->divisi->nama }}
                            </th>
                            <td class="px-6 py-2">
                                {{ $data->no_resi }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $data->pelayanan->ekspedisi->ekspedisi }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $data->pelayanan->nama_layanan }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $data->tanggal_kirim }}
                            </td>
                            <td class="px-6 py-2">
                                <span class="bg-orange-400 rounded-md px-2 py-0 text-white">{{ $data->status }}</span>
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex flex-wrap">
                                    <button type="button" data-modal-target="view-order-new" data-modal-toggle="view-order-new{{ $data->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base">visibility</i>
                                    </button>
                                    <button type="button" data-modal-target="modal-penerimaan" data-modal-toggle="modal-penerimaan{{ $data->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base">receipt_long</i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach --}}
            </tbody>
        </table>
        <div class="mt-4 ">
            {{-- {{ $suppliers->links() }} --}}
        </div>
    </div>
    {{-- @if (!$dataIncoming->contains('status', 'Incoming'))
        <div class="p-4 mt-4">
            <div class="flex datas-center justify-center">
                <figure class="max-w-lg">
                    <img class="h-auto max-w-full rounded-lg" src="/img/box-empty-3d.png" alt="Not Found" width="200" height="10">
                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Belum ada paket yang dikirim</figcaption>
                </figure>
            </div>
        </div>
    @endif --}}

    {{-- Modal --}}
    {{-- @include('logistik.main.modal.penerimaan-modal') --}}
</div>