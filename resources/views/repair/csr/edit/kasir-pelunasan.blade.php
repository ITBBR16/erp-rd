@extends('repair.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("kasir-repair.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">point_of_sale</span>
                    Pelunasan
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Pelunasan Nama Customer</span>
                </div>
            </li>
        </ol>
    </nav>

    <form action="#" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-3 gap-6 mt-4">
            {{-- Detail Box --}}
            <div id="invoice-pelunasan-repair" class="bg-white p-6 rounded-lg shadow-lg border col-span-2 dark:bg-gray-800 dark:border-gray-600">
                <div class="mb-4 justify-center text-center">
                    <div class="flex justify-center text-center">
                        <img src="/img/Logo Rumah Drone Black.png" class="w-40" alt="Logo RD">
                    </div>
                    <p class="text-[10px]">Jl. Kwoka Q2-6 Perum Tidar Permai, Kel. Karang Besuki Kec. Sukun Kota Malang Kode Pos 65146</p>
                    <p class="text-[10px]">Telp. 0813-3430-0706</p>
                </div>
                <div class="flex justify-between my-4">
                    <div class="text-start">
                        <h2 class="text-lg font-semibold dark:text-white">Detail Transaksi / <span class="text-lg text-gray-600 dark:text-gray-400">R-6666 <span class="text-red-500 bg-red-100 px-2 py-1 rounded-full text-xs">Belum Bayar</span></span></h2>
                    </div>
                    <div class="text-end">
                        <h2 class="text-lg font-semibold dark:text-white">DJI Mavic Pro</h2>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Nama Customer</p>
                        <h3 class="text-sm font-semibold dark:text-white">Young Lex</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">No Telpon</p>
                        <h3 class="text-sm font-semibold dark:text-white">6285156519066</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Alamat</p>
                        <h3 class="text-sm font-semibold dark:text-white">Kota Malang</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Status Case</p>
                        <h3 class="text-sm font-semibold dark:text-white">Express Offline</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Tanggal Masuk</p>
                        <h3 class="text-sm font-semibold dark:text-white">8 Agustus 2024</h3>
                    </div>
                    <div>
                        <p class="text-xs text-gray-700 dark:text-gray-300">Tanggal Keluar</p>
                        <h3 class="text-sm font-semibold dark:text-white">17 Agustus 2024</h3>
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
                        <tr class="border-t">
                            <td class="p-2">
                                Repair Controller Gimbal
                            </td>
                            <td class="p-2">
                                Rp. 1.255.000
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
                        <tr class="border-t">
                            <td class="p-2">
                                Kelengkapan 1
                            </td>
                            <td class="p-2">
                                1
                            </td>
                            <td class="p-2">
                                3N3BH66L020050
                            </td>
                            <td class="p-2">
                                Mantap
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="p-2">
                                Kelengkapan 2
                            </td>
                            <td class="p-2">
                                1
                            </td>
                            <td class="p-2">
                                3N3BH6U0020050
                            </td>
                            <td class="p-2">
                                Mantap
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="p-2">
                                Kelengkapan 3
                            </td>
                            <td class="p-2">
                                1
                            </td>
                            <td class="p-2">
                                3N3BH6U0020666
                            </td>
                            <td class="p-2">
                                Mantap
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="grid grid-cols-3 mt-4">
                    <div class="col-span-2 text-sm border p-3">
                        <div class="border-b font-semibold">Keluhan Kerusakan</div>
                        <div>
                            After crash gedung, jatuh dari ketinggian sekitar 4m. Engsel depan kiri patah, Body bawah renggang.
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="text-sm w-full max-w-2xl pl-3">
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">Down Payment</dt>
                                <dd class="col-span-2 text-gray-500">Rp. 0</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">Discount</dt>
                                <dd class="col-span-2 text-gray-500">Rp. 0</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">Ongkir</dt>
                                <dd class="col-span-2 text-gray-500">Rp. 0</dd>
                            </dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">Total Tagihan</dt>
                                <dd class="col-span-2 text-gray-500">Rp 1.255.000</dd>
                            </dl>
                            <dl class="my-1 border-b"></dl>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                                <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200">Total Pembayaran</dt>
                                <dd class="col-span-2 text-gray-500">Rp 1.255.000</dd>
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
                        <p class="text-xs">( Young Lex )</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold mb-12">Hormat Kami</h3>
                        <p class="text-xs">( {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} )</p>
                    </div>
                </div>
            </div>

            {{-- Input Box --}}
            <div class="col-span-1 h-[510px] bg-white p-6 rounded-lg border shadow-lg dark:bg-gray-800 dark:border-gray-600 sticky top-4">
                <h2 class="text-lg font-semibold mb-4 dark:text-white pb-2 border-b">Pembayaran Kasir</h2>
                <div class="mb-4 text-sm">
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold dark:text-white">Total Tagihan :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal dark:text-white">Rp. 1.255.000</p>
                        </div>
                    </div>
                    <div class="flex justify-between ">
                        <div class="flex text-start">
                            <p class="font-semibold dark:text-white">Total DP :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex justify-between ">
                        <div class="flex text-start">
                            <p class="font-semibold dark:text-white">Ongkir :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex justify-between ">
                        <div class="flex text-start">
                            <p class="font-semibold dark:text-white">Paking :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex justify-between mb-2">
                        <div class="flex text-start">
                            <p class="font-semibold dark:text-white">Asuransi :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex justify-between ">
                        <div class="flex text-start">
                            <p class="font-semibold dark:text-white">Sisa Total Tagihan :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal dark:text-white">Rp. 1.255.000</p>
                        </div>
                    </div>
                </div>
                <h2 class="text-base font-semibold mb-4 dark:text-white border-y py-2">Input Pembayaran</h2>
                <div class="mb-4">
                    <label for="metode-pembayaran-pelunasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Metode Pembayaran :</label>
                    <select name="metode_pembayaran_pelunasan" id="metode-pembayaran-pelunasan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Metode Pembayaran</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="nominal-pelunasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Pembayaran :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="pelunasan_nominal" id="nominal-pelunasan" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                    </div>
                </div>
                <div class="text-end">
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