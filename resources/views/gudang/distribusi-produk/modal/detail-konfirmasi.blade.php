@foreach ($repairCase as $case)
    @if ($case->estimasi && $case->estimasi->estimasiPart->contains('tanggal_dikirim', ''))
        <div id="detail-konfirmasi-{{ $case->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-9xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Detail Request Sparepart / {{ $case->customer->first_name }} {{ $case->customer->last_name }} - {{ $case->customer->id }}
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detail-konfirmasi-{{ $case->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="px-6 py-6 lg:px-8 bg-gray-50">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg bg-white border border-gray-200 shadow-md dark:bg-gray-700 dark:border-gray-600">
                                <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Informasi Customer</h3>
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
                                        <h3 class="text-sm font-semibold mb-1">Tanggal Konfirmasi</h3>
                                        <p class="text-gray-500 text-base">{{ \Carbon\Carbon::parse($case->estimasi->estimasiPart->first()->tanggal_konfirmasi)->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1">Total Sparepart Request</h3>
                                        <p class="text-gray-500 text-base">{{ $case->estimasi->estimasiPart->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 rounded-lg bg-white border border-gray-200 shadow-md dark:bg-gray-700 dark:border-gray-600">
                                <h3 class="text-lg font-semibold mb-4 text-black dark:text-white">Daftar Sparepart</h3>
                                <div class="relative overflow-y-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 rounded-s-lg">
                                                    SKU
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Jenis Drone
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nama Sparepart
                                                </th>
                                                <th scope="col" class="px-6 py-3 rounded-e-lg">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($case->estimasi->estimasiPart as $detail)
                                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                        {{ $detail->sku }}
                                                    </th>
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                        {{ $detail->jenis_produk }}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        {{ $detail->nama_produk }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ ($detail->tanggal_dikirim == '') ? 'Belum Dikirim' : 'Sudah Dikirim' }}
                                                    </td>
                                                </tr>
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
