@extends('repair.layouts.main')

@section('container')
    <div class="flex flex-wrap -mx-3">
        {{-- Box 1 --}}
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
            <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600 relative">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="px-3 py-3">
                            <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">monetization_on</span>
                        </div>
                        <div>
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <span class="flex whitespace-nowrap font-semibold text-gray-700 dark:text-white">Pendapatan Bulan Ini</span>
                            </div>
                            <div class="px-3 py-0">
                                <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Box 2 --}}
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
            <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600 relative">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="px-3 py-3">
                            <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">store</span>
                        </div>
                        <div>
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <span class="flex whitespace-nowrap font-semibold text-gray-700 dark:text-white">Total New Case Bulan Ini</span>
                            </div>
                            <div class="px-3 py-0">
                                <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">{{ $totalNewCase }} Case</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Box 3 --}}
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
            <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600 relative">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="px-3 py-3">
                            <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">recycling</span>
                        </div>
                        <div>
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <span class="flex whitespace-nowrap font-semibold text-gray-700 dark:text-white">Total Close Case</span>
                            </div>
                            <div class="px-3 py-0">
                                <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">{{ $totalCloseCase }} Case</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-1"></div>
        <div class="flex flex-col gap-6 col-span-2">
            <div class="relative border border-gray-200 rounded-lg">
                <h2 class="p-3 text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    List Sudah Dikirim
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
                    List Lanjut Belum Dikirim
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
        </div>
    </div>
@endsection