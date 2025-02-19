@foreach ($dataCase as $case)
    <div id="tanda-terima-{{ $case->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <form action="{{ route('kirimTandaTerima', $case->id) }}" method="POST">
            @csrf
            <div class="relative w-full max-w-fit max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="bg-gray-50 dark:bg-slate-900">
                        <div class="px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
                            <div class="mx-auto">
                                {{-- Start Invoice --}}
                                <div class="flex items-center justify-center">
                                    <div id="invoice-penerimaan-repair-{{ $case->id }}" class="invoice-penerimaan-repair bg-white rounded-lg p-4 w-full max-w-[148mm]">
                                        <!-- Header -->
                                        <div class="grid grid-cols-2 border-b border-black pb-2 mb-2">
                                            <div class="text-start">
                                                <h1 class="text-lg font-semibold">Rumah Drone</h1>
                                                <p class="text-[8px]">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karang Besuki Kec. Sukun Kota Malang Kode Pos 65146</p>
                                                <p class="text-[8px]">Telp. 0813-3430-0706</p>
                                            </div>
                                            <div class="text-end">
                                                <p class="text-[8px] text-gray-600">Tanggal : {{ $case->created_at }}</p>
                                                <p class="text-[8px] text-gray-600">Status : {{ $case->jenisCase->jenis_case }}</p>
                                            </div>
                                        </div>
                                        <div class="text-center mb-2">
                                            <h2 class="text-sm font-bold mb-1">Invoice Penerimaan</h2>
                                            <p class="text-gray-500 text-[10px]"># R-{{ $case->id }}</p>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2 text-[10px] mb-3">
                                            <div>
                                                <p class="text-gray-700 dark:text-gray-300">Nama Customer</p>
                                                <h3 class="font-semibold text-black dark:text-white">{{ $case->customer->first_name }} {{ $case->customer->last_name }}</h3>
                                            </div>
                                            <div>
                                                <p class="text-gray-700 dark:text-gray-300">No Telpon</p>
                                                <h3 class="font-semibold text-black dark:text-white">{{ $case->customer->no_telpon }}</h3>
                                            </div>
                                            <div>
                                                <p class="text-gray-700 dark:text-gray-300">Jenis Drone</p>
                                                <h3 class="font-semibold text-black dark:text-white">{{ $case->jenisProduk->jenis_produk }}</h3>
                                            </div>
                                            <div>
                                                <p class="text-gray-700 dark:text-gray-300">Kota</p>
                                                <h3 class="font-semibold text-black dark:text-white">{{ $case->customer->kota->name ?? '' }}</h3>
                                            </div>
                                        </div>
                                        <!-- Body -->
                                        <div class="relative">
                                            <div class="border-t-4 border-black">
                                                <div class="absolute inset-x-0 transform -translate-y-1/2 flex justify-center">
                                                    <div class="bg-white px-4">
                                                        <img src="/img/RD Tab Icon.png" alt="Logo RD" class="w-6">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 border-b-4 border-black mb-2">
                                                <table class="text-sm w-full text-left mb-2">
                                                    <thead class="text-[8px] text-gray-700">
                                                        <tr class="border-b border-black">
                                                            <th scope="col" class="pr-2 py-1" style="width: 35%;">
                                                                Nama Kelengkapan
                                                            </th>
                                                            <th scope="col" class="pr-2 py-1" style="width: 5%;">
                                                                Qty
                                                            </th>
                                                            <th scope="col" class="pr-2 py-1" style="width: 15%;">
                                                                Serial Number
                                                            </th>
                                                            <th scope="col" class="pr-2 py-1" style="width: 45%;">
                                                                Keterangan
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-[8px]">
                                                        @foreach ($case->detailKelengkapan as $detail)
                                                            <tr class="border-b">
                                                                <td class="pr-2 py-1">
                                                                    {{ ($detail->item_kelengkapan_id == null) ? $detail->nama_data_lama : $detail->itemKelengkapan->kelengkapan }}
                                                                </td>
                                                                <td class="pr-2 py-1">
                                                                    {{ $detail->quantity }}
                                                                </td>
                                                                <td class="pr-2 py-1">
                                                                    {{ ($detail->serial_number) ? $detail->serial_number : '-' }}
                                                                </td>
                                                                <td class="pr-2 py-1">
                                                                    {{ $detail->keterangan }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    
                                        <div class="border-b border-black pb-2 text-xs">
                                            <div class="bg-white inset-0 w-14">
                                                <p class="text-gray-900 font-semibold text-[10px]">Keluhan :</p>
                                            </div>
                                            <p class="text-[9px]">{{ $case->keluhan }}</p>
                                        </div>
                                    
                                        <div class="grid grid-cols-6 text-gray-400 mt-2">
                                            <div class="col-span-4">
                                                <p class="text-[8px]">1. Untuk tingkat kerusakan yang cukup parah dan drone dengan assembly susah akan dikenakan biaya Troubleshoting kerusakan sebesar Rp 300,000 (Bila Repair di batalkan).</p>
                                                <p class="text-[8px]">2. Bila proses Repair di batalkan, pengembalian Drone dilakukan paling cepat 1 minggu setelah konfrimasi pembatalan.</p>
                                            </div>
                                            <div class="col-span-2 flex flex-col items-center justify-center relative">
                                                <img src="/img/Logo Rumah Drone Black.png" alt="Stempel RD" class="w-20">
                                                <p class="text-[8px] mt-1">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Invoice --}}
                                <div class="p-4 flex justify-end gap-x-3">
                                    <button id="ddTamdaTerimaRepair{{ $case->id }}" data-dropdown-toggle="ddTTR{{ $case->id }}" data-dropdown-placement="bottom" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                        Action
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <button type="submit" name="status_kasir" value="Done" form="kasir-form" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Send Invoice</button>
                                    <div class="loader-button-form" style="display: none">
                                        <button class="cursor-not-allowed text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
                                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                            </svg>
                                            Loading . . .
                                        </button>
                                    </div>
                                </div>
                                <div id="ddTTR{{ $case->id }}" class="z-10 hidden bg-white rounded-lg shadow w-60 dark:bg-gray-700">
                                    <ul class="h-auto py-2 overflow-y-auto text-gray-700 dark:text-gray-200" aria-labelledby="ddTamdaTerimaRepair{{ $case->id }}">
                                        <li>
                                            <a href="{{ route('downloadPdf', $case->id) }}" target="_blank" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 hover:text-black dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                                <span class="pl-2">Download Invoice</span>
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <button type="button" id="print-invoice-penerimaan-{{ $case->id }}" data-id="{{ $case->id }}" class="print-invoice-penerimaan flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                                                <span class="pl-2">Print Invoice</span>
                                            </button>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endforeach
