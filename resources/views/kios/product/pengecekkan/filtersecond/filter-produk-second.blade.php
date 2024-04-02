@extends('kios.layouts.main')

@section('container')
    <div class="flex flex-row justify-between items-center border-b border-gray-400 py-3">
        <div class="flex flex-col my-2 w-2/3">
            <div class="flex flex-row">
                <a href="/kios/product/filter-product-second" class="w-5 mr-3">
                    <span class="material-symbols-outlined text-red-500">arrow_back</span>
                </a>
                <div class="font-semibold mr-4 text-xl text-gray-700 dark:text-gray-300">
                    Filter Product / {{ $kos->subjenis->produkjenis->jenis_produk }} {{ $kos->subjenis->paket_penjualan }}
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('filter-product-second.update', $kos->qcsecond->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <input type="hidden" id="jenis-qc-id" value="{{ $kos->subjenis->produkjenis->id }}">
        <div class="w-10/12 my-6">
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="qc_supplier" id="qc_supplier" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('qc_supplier') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ $kos->come_from == 'Customer' ? $kos->customer->first_name . ' ' . $kos->customer->last_name : $kos->marketplace->nama }}" readonly>
                    <label for="qc_supplier" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Customer</label>
                    @error('qc_supplier')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="status_qc_second" class="sr-only">Status QC Produk</label>
                    <select name="status_qc_second" id="status_qc_second" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('status_qc_second') border-red-600 dark:border-red-500 @enderror">
                        <option value="" hidden>-- Status QC Produk --</option>
                        <option value="Negoisasi Ulang" class="dark:bg-gray-700">Negoisasi Ulang</option>
                    </select>
                    @error('status_qc_second')
                        <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full group flex items-center">
                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                    <input type="text" name="biaya_ambil" id="biaya_ambil" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ number_format($kos->biaya_pembelian, 0, ',', '.') }}" readonly>
                    <label for="biaya_ambil" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Biaya Ambil</label>
                </div>
                @error('biaya_ambil')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                <div class="relative z-0 w-full group flex items-center">
                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                    <input type="text" name="biaya_cek_filter" id="biaya_cek_filter" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly>
                    <label for="biaya_cek_filter" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Biaya Cek Filter</label>
                </div>
                @error('biaya_cek_filter')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                    Cek Kelengkapan
                    <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Pastikan memasukkan hasil quality control sesuai.</p>
                </caption>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama Kelengkapan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kondisi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Serial Number
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Keterangan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Harga Satuan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                        </th>
                    </tr>
                </thead>
                <tbody id="additional-kelengkapan-filter-second">
                    @foreach ($kos->qcsecond->kelengkapans as $index => $kelengkapan)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <input type="hidden" name="pivot_id[]" value="{{ $kelengkapan->pivot->pivot_qc_id }}">
                                <input type="text" name="nama_kelengkapan[]" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 appearance-none dark:text-white focus:outline-none focus:ring-0" value="{{ $kelengkapan->kelengkapan }}" readonly>
                            </th>
                            <td class="px-6 py-4">
                                <input type="text" name="kondisi[]" id="kondisi-{{ $index }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" value="{{ $kelengkapan->pivot->kondisi }}" required>
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" name="serial_number[]" id="serial-number-{{ $index }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" value="{{ $kelengkapan->pivot->serial_number }}" required>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <input type="text" name="keterangan[]" id="keterangan-{{ $index }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" value="{{ $kelengkapan->pivot->keterangan }}" required>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="relative z-0 w-full group flex items-center">
                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                    <input type="text" name="harga_satuan_filter_second[]" id="harga_satuan_filter_second" class="harga_satuan_filter_second block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="0" required>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-gray-900 dark:text-white">
                        <td scope="row" class="px-6 py-3 text-base">
                            <div class="flex justify-between text-rose-600">
                                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                                    <button type="button" id="add-second-additional-filter" class="flex flex-row justify-between gap-2">
                                        <span class="material-symbols-outlined">add_circle</span>
                                        <span class="text-sm">Tambah Kelengkapan Produk</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div id="barang-exclude-filter-second" class="border p-4 rounded-lg shadow-md mt-6 dark:border-gray-800 text-gray-500 dark:text-gray-400 mb-10">
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Kelengkapan Exclude
            </caption>
            
        </div>
        <div class="flex my-4 justify-between text-rose-600">
            <div class="flex cursor-pointer mt-4 hover:text-red-400">
                <button type="button" id="add-second-exclude-kelengkapan-filter" class="flex flex-row justify-between gap-2">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span class="">Tambah Kelengkapan Exclude</span>
                </button>
            </div>
        </div>
        <div class="mt-4 text-end">
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
    </form>

@endsection
