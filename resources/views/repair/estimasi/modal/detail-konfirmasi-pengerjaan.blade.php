@foreach ($dataCase as $case)
    @if ($case->jenisStatus->jenis_status == 'Proses Menunggu Konfirmasi')
        <div id="detail-konfirmasi-pengerjaan-{{ $case->id }}" tabindex="-1" class="modal fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-7xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    {{-- Header Modal --}}
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Detail Konfirmasi Estimasi
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-konfirmasi-pengerjaan-{{ $case->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    {{-- Body Modal --}}
                    <div class="px-2 py-2 lg:px-8 lg:py-6 bg-gray-50 dark:bg-gray-600">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="p-4 rounded-lg bg-white border shadow-md dark:bg-gray-700 dark:border-gray-600">
                                <h3 class="text-lg font-semibold mb-4 dark:text-white">Detail Customer</h3>
                                <div class="grid grid-cols-2 gap-4 mb-2">
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1">Nama Customer</h3>
                                        <p class="text-gray-500 text-base">{{ $case->customer->first_name }} {{ $case->customer->last_name }} - {{ $case->customer->id }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1">Jenis Drone</h3>
                                        <p class="text-gray-500 text-base">{{ $case->jenisProduk->jenis_produk }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1">Fungsional Drone</h3>
                                        <p class="text-gray-500 text-base">{{ $case->jenisFungsional->jenis_fungsional }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1">Jenis Case</h3>
                                        <p class="text-gray-500 text-base">{{ $case->jenisCase->jenis_case }}</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold mb-4 pt-2 border-t dark:text-white">Detail Kronologi</h3>
                                <div class="grid grid-cols-2 gap-4 mb-2">
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1">Keluhan</h3>
                                        <p class="text-gray-500 text-base">{{ $case->keluhan ?? "-" }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1">Kronologi Kerusakan</h3>
                                        <p class="text-gray-500 text-base">{{ $case->kronologi_kerusakan ?? "-" }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1">Penggunaan After Crash</h3>
                                        <p class="text-gray-500 text-base">{{ $case->penanganan_after_crash ?? "-" }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1">Riwayat Penggunaan</h3>
                                        <p class="text-gray-500 text-base">{{ $case->riwayat_penggunaan ?? "-" }}</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold mb-4 pt-2 border-t dark:text-white">Detail Pesan Troubleshooting</h3>
                                <div>
                                    <h3 class="text-sm font-semibold mb-1">Pesan Hasil Troubleshooting</h3>
                                    <p class="text-gray-500 text-base">{!! nl2br(e($case->estimasi->estimasiChat->isi_chat)) !!}</p>
                                </div>
                            </div>
                            <div class="p-4 rounded-lg bg-white border shadow-md dark:bg-gray-700 dark:border-gray-600">
                                <h3 class="text-lg font-semibold mb-4 dark:text-white">Daftar Estimasi</h3>
                                <div class="relative overflow-y-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 rounded-s-lg">
                                                    Jenis Transaksi
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nama Sparepart
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Harga Customer
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (array_merge($case->estimasi->estimasiPart->all(), $case->estimasi->estimasiJrr->all()) as $index => $estimasi)
                                                @if ($estimasi->active == 'Active')    
                                                    <tr class="bg-white dark:bg-gray-800">
                                                        <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                            {{ $estimasi->jenisTransaksi->code_jt }}
                                                        </th>
                                                        <td class="px-6 py-4 items-center">
                                                            @if (isset($estimasi->gudang_produk_id))
                                                                {{ $estimasi->sparepartGudang->produkSparepart->nama_internal }}
                                                            @else
                                                                {{ $estimasi->jenis_jasa }}
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            Rp. {{ number_format($estimasi->harga_customer, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach