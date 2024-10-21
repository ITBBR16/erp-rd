<div class="hidden p-4" id="recap-transaksi" role="tabpanel" aria-labelledby="recap-transaksi-tab">
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
            <div class="flex text-end">
                <button data-modal-target="add-mutasi" data-modal-toggle="add-mutasi" type="button" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">Tambah Mutasi</button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-2">
        <div class="relative col-span-2">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-blue-700 uppercase bg-blue-50 dark:bg-blue-700 dark:text-blue-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No Mutasi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Akun
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nominal
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jenis Mutasi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Saldo Akhir
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Keterangan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $groupMutasi = $dataMutasiSementara->groupBy('namaAkun.id');
                    @endphp

                    @foreach ($groupMutasi as $mutasiAkun)
                    @php
                        $saldoAkhir = $mutasiAkun->first()->namaAkun->saldo_awal;
                    @endphp

                        @foreach ($mutasiAkun as $item)
                            <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <td class="px-6 py-2">
                                    M-{{ $item->id }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $item->namaAkun->nama_akun }}
                                </td>
                                <td class="px-6 py-2">
                                    Rp. {{ number_format($item->nominal, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ ($item->jenis_mutasi == 'db') ? 'Pendapatan' : '' }}
                                </td>
                                <td class="px-6 py-2">
                                    @php
                                        if($item->jenis_mutasi == 'db') {
                                            $saldoAkhir += $item->nominal;
                                        } else {
                                            $saldoAkhir -= $item->nominal;
                                        }
                                    @endphp
                                    Rp. {{ number_format($saldoAkhir, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $item->keterangan }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $item->status }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-green-700 uppercase bg-green-50 dark:bg-green-700 dark:text-green-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No Nota
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nominal
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataTransaksi as $transaksi)
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td class="px-6 py-2">
                                {{ $transaksi->transaksi_id }}
                            </td>
                            <td class="px-6 py-2">
                                Rp. {{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $transaksi->keterangan }}
                            </td>
                            <td class="px-6 py-2">
                               {{ $transaksi->status_recap }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- List Modal --}}
    @include('repair.csr.modal.rt-new-mutasi')
</div>