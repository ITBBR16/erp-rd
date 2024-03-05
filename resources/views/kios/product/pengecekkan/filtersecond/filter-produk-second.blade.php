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

    <form action="#" method="POST" autocomplete="off">
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
                            
                        </th>
                    </tr>
                </thead>
                <tbody id="additional-kelengkapan-qc-second">
                    @foreach ($kos->qcsecond->kelengkapans as $index => $kelengkapan)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <input type="hidden" name="pivot_id[]" value="{{ $kelengkapan->pivot->pivot_qc_id }}">
                                <input type="text" name="nama_kelengkapan[]" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 appearance-none dark:text-white focus:outline-none focus:ring-0" value="{{ $kelengkapan->kelengkapan }}" readonly>
                            </th>
                            <td class="px-6 py-4">
                                <input type="text" name="kondisi[]" id="kondisi-{{ $index }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" name="serial_number[]" id="serial_number-{{ $index }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600">
                            </td>
                            <td class="px-6 py-4 text-right">
                                <input type="text" name="keterangan[]" id="keterangan-{{ $index }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600">
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
                                    <button type="button" id="add-second-additional-qc" class="flex flex-row justify-between gap-2">
                                        <span class="material-symbols-outlined">add_circle</span>
                                        <span class="">Tambah Additional Kelengkapan</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div id="barang-exclude-qc-second" class="border p-4 rounded-lg shadow-md mt-6 dark:border-gray-800 text-gray-500 dark:text-gray-400 mb-10">
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Kelengkapan Exclude
            </caption>
        </div>
        <div class="flex my-4 justify-between text-rose-600">
            <div class="flex cursor-pointer mt-4 hover:text-red-400">
                <button type="button" id="add-second-exclude-kelengkapan-qc" class="flex flex-row justify-between gap-2">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span class="">Tambah Additional Kelengkapan</span>
                </button>
            </div>
        </div>
        <div class="mt-4 text-end">
            <button type="submit" id="submit_qc_second" class="cursor-not-allowed text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" disabled>Submit</button>
        </div>
    </form>

@endsection
