@extends('gudang.layouts.main')

@section('container')
    <div class="grid grid-cols-2 gap-6">
        <div class="relative border border-gray-200 rounded-lg">
            <h2 class="p-3 text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                List Estimasi Sudah Dikirim
            </h2>
            <div class="overflow-y-auto max-h-[250px]">
                <table id="list-case-csr" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">Jenis Drone</th>
                            <th scope="col" class="px-6 py-3">Nama Sparepart</th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Modal Gudang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listSudahDikirim as $lsd)
                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <td class="px-6 py-2">{{ $lsd['jenis_drone'] }}</td>
                                <td class="px-6 py-2">{{ $lsd['nama_sparepart'] }}</td>
                                <td class="px-6 py-2">{{ $lsd['total_quantity'] }}</td>
                                <td class="px-6 py-2">Rp. {{ number_format($lsd['modal_gudang'], 0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="relative border border-gray-200 rounded-lg">
            <h2 class="p-3 text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                List Estimasi Lanjut Belum Dikirim
            </h2>
            <div class="overflow-y-auto max-h-[250px]">
                <table id="list-case-csr" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">Jenis Drone</th>
                            <th scope="col" class="px-6 py-3">Nama Sparepart</th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Modal Gudang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listBelumDikirim as $lsd)
                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <td class="px-6 py-2">{{ $lsd['jenis_drone'] }}</td>
                                <td class="px-6 py-2">{{ $lsd['nama_sparepart'] }}</td>
                                <td class="px-6 py-2">{{ $lsd['total_quantity'] }}</td>
                                <td class="px-6 py-2">Rp. {{ number_format($lsd['modal_gudang'], 0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="relative border border-gray-200 rounded-lg">
            <h2 class="p-3 text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                List Estimasi Belum Lanjut
            </h2>
            <div class="overflow-y-auto max-h-[250px]">
                <table id="list-case-csr" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">Jenis Drone</th>
                            <th scope="col" class="px-6 py-3">Nama Sparepart</th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Modal Gudang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listbelumlanjut as $lsd)
                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <td class="px-6 py-2">{{ $lsd['jenis_drone'] }}</td>
                                <td class="px-6 py-2">{{ $lsd['nama_sparepart'] }}</td>
                                <td class="px-6 py-2">{{ $lsd['total_quantity'] }}</td>
                                <td class="px-6 py-2">Rp. {{ number_format($lsd['modal_gudang'], 0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="relative border border-gray-200 rounded-lg">
            <h2 class="p-3 text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                List Transaksi Kios
            </h2>
            <div class="overflow-y-auto max-h-[250px]">
                <table id="list-case-csr" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">Jenis Drone</th>
                            <th scope="col" class="px-6 py-3">Nama Sparepart</th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Modal Gudang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listLakuKios as $lkk)
                            <tr class="bg-white border-b border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <td class="px-6 py-2">{{ $lkk['jenis_drone'] }}</td>
                                <td class="px-6 py-2">{{ $lkk['nama_sparepart'] }}</td>
                                <td class="px-6 py-2">{{ $lkk['total_quantity'] }}</td>
                                <td class="px-6 py-2">Rp. {{ number_format($lkk['modal_gudang'], 0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection