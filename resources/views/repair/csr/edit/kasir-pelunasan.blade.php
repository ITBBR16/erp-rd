@extends('repair.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("kasir-repair.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">point_of_sale</span>
                    Kasir
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Lunas {{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }}-{{ $dataCase->customer->id }}-{{ $dataCase->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    @if (session()->has('error'))
        <div id="alert-failed-input" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
            <span class="material-symbols-outlined flex-shrink-0 w-5 h-5">info</span>
            <div class="ml-3 text-sm font-medium">
                {{ session('error') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-failed-input" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <form action="{{ route('createPelunasan', $dataCase->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-3 gap-6 mt-4">
            {{-- Detail Box --}}
            <div id="invoice-dp-repair" class="bg-white p-6 rounded-lg shadow-lg border col-span-2 border-gray-200 dark:bg-gray-800 dark:border-gray-600">
                <div class="mb-4 justify-center text-center">
                    <div class="flex justify-center text-center">
                        <img src="/img/Logo Rumah Drone Black.png" class="w-40" alt="Logo RD">
                    </div>
                    <p class="text-[10px]">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karang Besuki Kec. Sukun Kota Malang Kode Pos 65146</p>
                    <p class="text-[10px]">Telp. 0813-3430-0706</p>
                </div>
                <div class="flex justify-between my-4">
                    <div class="text-start">
                        <h2 class="text-lg font-semibold text-black dark:text-white">Detail Transaksi / <span class="text-lg text-gray-600 dark:text-gray-400">R-{{ $dataCase->id }} <span class="text-sm ml-2 text-green-500 bg-green-100 px-2 py-1 rounded-full">Lunas</span></span></h2>
                    </div>
                    <div class="text-end">
                        <h2 class="text-lg font-semibold text-black dark:text-white">{{ $dataCase->jenisProduk->jenis_produk }}</h2>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Nama Customer</p>
                        <h3 class="text-sm font-semibold text-black dark:text-white">{{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }}</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">No Telpon</p>
                        <h3 class="text-sm font-semibold text-black dark:text-white">{{ $dataCase->customer->no_telpon }}</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Alamat</p>
                        <h3 class="text-sm font-semibold text-black dark:text-white">{{ $dataCase->customer->kota->name }}</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Status Case</p>
                        <h3 class="text-sm font-semibold text-black dark:text-white">{{ $dataCase->jenisCase->jenis_case }}</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Tanggal Masuk</p>
                        <h3 class="text-sm font-semibold text-black dark:text-white">{{ \Carbon\Carbon::parse($dataCase->created_at)->isoFormat('D MMMM YYYY') }}</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Tanggal Keluar</p>
                        <h3 class="text-sm font-semibold text-black dark:text-white">{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</h3>
                    </div>
                </div>

                <table class="text-sm mt-6 w-full bg-gray-50 rounded-lg dark:text-gray-400 dark:bg-gray-700">
                    <thead class="text-left text-gray-900 dark:text-white">
                        <tr>
                            <th class="p-2" style="width: 80%">
                                Analisa Kerusakan
                            </th>
                            <th class="p-2" style="width: 20%">
                                Harga
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-300">
                        @php
                            $totalTagihan = 0;
                            $totalOngkir = 0;
                            $biayaOngkir = 0;
                            $biayaPacking = 0;
                        @endphp
                        
                        @foreach (array_merge($dataCase->estimasi->estimasiPart->all(), $dataCase->estimasi->estimasiJrr->all()) as $index => $estimasi)
                            @if ($estimasi->active == 'Active')
                                @php
                                    $totalTagihan += $estimasi->harga_customer 
                                @endphp
                                <tr class="border-t">
                                    <td class="p-2">
                                        {{ 
                                            (isset($estimasi->gudang_produk_id)) ? 
                                                ($estimasi->nama_alias != '' ? $estimasi->nama_alias :
                                                    $estimasi->sparepartGudang->produkSparepart->nama_internal) :
                                                            $estimasi->nama_jasa 
                                        }}
                                    </td>
                                    <td class="p-2">
                                        Rp. {{ number_format($estimasi->harga_customer, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif
                            @endforeach

                            @if (!empty($dataCase->logRequest->biaya_customer_ongkir) && !empty($dataCase->logRequest->biaya_customer_packing))
                                <tr class="border-t">
                                    <td class="p-2">
                                        Total Ongkir
                                    </td>
                                    <td class="p-2">
                                        @php
                                            $biayaOngkir = $dataCase?->logRequest->biaya_customer_ongkir ?? 0;
                                            $biayaPacking = $dataCase?->logRequest->biaya_customer_packing ?? 0;
                                            $totalOngkir += $biayaOngkir + $biayaPacking;
                                        @endphp
                                        Rp. {{ number_format($totalOngkir, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($dataCase->logRequest->nominal_asuransi))
                                @php
                                    $nominalAsuransi = $dataCase->logRequest->nominal_asuransi;
                                    $totalOngkir += $nominalAsuransi;
                                @endphp
                                <tr class="border-t">
                                    <td class="p-2">
                                        Asuransi
                                    </td>
                                    <td class="p-2">
                                        Rp. {{ number_format($nominalAsuransi, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif
                            <tr class="border-t-2 border-gray-800">
                                <td class="p-2 font-bold">
                                    Total Tagihan
                                </td>
                                <td class="p-2">
                                    @php
                                        $totalAkhir = $totalTagihan + $totalOngkir;
                                    @endphp
                                    Rp. {{ number_format($totalAkhir, 0, ',', '.') }}
                                </td>
                            </tr>
                    </tbody>
                </table>

                <table class="text-sm mt-6 w-full bg-gray-50 rounded-lg dark:text-gray-400 dark:bg-gray-700">
                    <thead class="text-left text-gray-900 dark:text-white">
                        <tr>
                            <th class="p-2" style="width: 35%">
                                Kelengkapan
                            </th>
                            <th class="p-2" style="width: 10%">
                                Quantity
                            </th>
                            <th class="p-2" style="width: 20%">
                                Serial Number
                            </th>
                            <th class="p-2" style="width: 35%">
                                Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-300">
                        @foreach ($dataCase->detailKelengkapan as $kelengkapan)
                            <tr class="border-t">
                                <td class="p-2">
                                    {{ $kelengkapan->itemKelengkapan->kelengkapan }}
                                </td>
                                <td class="p-2">
                                    {{ $kelengkapan->quantity }}
                                </td>
                                <td class="p-2">
                                    {{ $kelengkapan->serial_number }}
                                </td>
                                <td class="p-2">
                                    {{ ($kelengkapan->keterangan) ? $kelengkapan->keterangan : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="grid grid-cols-3 mt-4">
                    <div class="col-span-2 text-sm border p-3">
                        <div class="border-b font-semibold">Keluhan Kerusakan</div>
                        <div class="pt-2">{{ $dataCase->keluhan }}</div>
                    </div>
                    <div class="col-span-1">
                        <div class="text-sm w-full max-w-2xl pl-3">
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">Down Payment</dt>
                                @php
                                    $totalDp = $dataCase->transaksi->total_pembayaran ?? 0
                                @endphp
                                <dd class="col-span-2 text-gray-500">Rp. {{ number_format($totalDp, 0, ',', '.') }}</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">Discount</dt>
                                <dd class="col-span-2 text-gray-500">Rp. 0</dd>
                            </dl>
                            <dl class="my-1 border-b"></dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">Total Pembayaran</dt>
                                <dd id="total-pembayaran-dp" class="col-span-2 text-gray-500">Rp 0</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 mt-4">
                    <div class="col-span-2 text-sm border p-3">
                        <div class="border-b font-semibold">Ketentuan Garansi</div>
                        <div>
                            <p class="text-xs text-gray-500">- Garansi hanya termasuk bagian yang direpair / direplace</p>
                            <p class="text-xs text-gray-500">- Garansi tidak berlaku jika human error, overheat, overvoltage, overclocking</p>
                            <p class="text-xs text-gray-500">- Garansi tidak berlaku jika segel rusak</p>
                            <p class="text-xs text-gray-500">- Garansi berlaku 1 bulan setelah barang diterima</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 mt-4 text-center">
                    <div>
                        <h3 class="text-sm font-semibold mb-12">Penerima</h3>
                        <p class="text-xs">( {{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }} )</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold mb-12">Hormat Kami</h3>
                        <p class="text-xs">( {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} )</p>
                    </div>
                </div>
            </div>

            {{-- Input Box --}}
            <div class="col-span-1 h-[620px] bg-white p-6 rounded-lg border border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-600 sticky top-4">
                <h2 class="text-lg font-semibold mb-4 text-black dark:text-white pb-2 border-b">Pembayaran Kasir</h2>
                <div class="mb-4 text-sm">
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold text-black dark:text-white">Total Tagihan :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal text-black dark:text-white">Rp. {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between ">
                        <div class="flex text-start">
                            <p class="font-semibold text-black dark:text-white">Ongkir :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal text-black dark:text-white">Rp. {{ number_format($biayaOngkir, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between ">
                        <div class="flex text-start">
                            <p class="font-semibold text-black dark:text-white">Paking :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal text-black dark:text-white">Rp. {{ number_format($biayaPacking, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold text-black dark:text-white">Asuransi :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal text-black dark:text-white">Rp. {{ number_format($nominalAsuransi ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between mb-2">
                        <div class="flex text-start">
                            <p class="font-semibold text-black dark:text-white">Total DP :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal text-black dark:text-white">Rp. {{ number_format($totalDp, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold text-black dark:text-white">Sisa Total Tagihan :</p>
                        </div>
                        <div class="flex text-end">
                            @php
                                $sisaTagihan = $totalTagihan + $biayaOngkir + $biayaPacking + ($nominalAsuransi ?? 0) - $totalDp
                            @endphp
                            <p class="font-normal text-black dark:text-white">Rp. {{ number_format($sisaTagihan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <h2 class="text-base font-semibold mb-4 text-black dark:text-white border-y py-2">Input Pembayaran</h2>
                <div class="mb-4">
                    <input type="hidden" name="link_doc" value="{{ $dataCase->link_doc }}">
                    <input type="hidden" name="sisa_tagihan" value="{{ $sisaTagihan }}">
                    <label for="metode-pembayaran-pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Metode Pembayaran :</label>
                    <select name="metode_pembayaran_pembayaran" id="metode-pembayaran-pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Metode Pembayaran</option>
                        @foreach ($daftarAkun as $akun)
                            <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Files Bukti Transaksi :</label>
                <div class="flex items-center justify-center w-full">
                    <label for="file-upload-kasir" class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div id="image-transaksi" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG or JPG</p>
                        </div>
                        <div id="selected-files-bukti-transaksi" class="flex flex-wrap justify-evenly" style="display: none"></div>
                        <input name="file_bukti_transaksi" id="file-upload-kasir" type="file" class="hidden file-upload-kasir">
                    </label>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
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
            </div>
        </div>
    </form>

@endsection