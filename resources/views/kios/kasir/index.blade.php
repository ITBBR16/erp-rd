@extends('kios.layouts.main')

@section('container')

    @if (session()->has('success'))
        <div id="alert-success-input" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
            <span class="material-symbols-outlined flex-shrink-0 w-4 h-4">task_alt</span>
            <div class="ml-3 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-success-input" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            </button>
        </div>
    @endif

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

    <form action="{{ route('kasir.store') }}" id="kasir-form" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-3 w-full">
            <div class="col-span-2 my-4">
                <div class="flex items-center justify-between">
                    <div class="flex justify-start">
                        <p class="text-base font-semibold text-gray-900 dark:text-white">Current Date : <span class="text-gray-900 font-normal dark:text-white">{{ $today->format('d/m/Y') }}</span></p>
                    </div>
                    <div class="flex justify-end">
                        <p class="text-base font-semibold text-gray-900 dark:text-white">Invoice Number : <span class="text-gray-900 font-normal dark:text-white">{{ $today->format('Ymd') }}{{ $invoiceid + 1 }}</span></p>
                    </div>
                </div>
                <div class="my-4 pt-2 border-t-2 text-center justify-center">
                    <p class="text-lg font-bold text-black dark:text-white">INVOICE</p>
                </div>
                <div class="grid grid-cols-2 w-full gap-6">
                    <div>
                        <label for="kasir-nama-customer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Customer :</label>
                        <select name="nama_customer" id="kasir-nama-customer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Customer</option>
                            @foreach ($customerdata as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="kasir_metode_pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Metode Pembayaran :</label>
                        <select name="kasir_metode_pembayaran" id="kasir_metode_pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Metode Pembayaran</option>
                            @foreach ($akunrd as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="kasir-discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="kasir_discount" id="kasir-discount" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="kasir_tax" id="kasir-tax">
                        <label for="kasir-ongkir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ongkir :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="kasir_ongkir" id="kasir-ongkir" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                        </div>
                    </div>
                    <div>
                        <label for="kasir-nominal-bayar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Pembayaran :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="kasir_nominal_pembayaran" id="kasir-nominal-pembayaran" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')" required>
                        </div>
                    </div>
                    <div>
                        <label for="keterangan-pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan :</label>
                        <input type="text" name="keterangan_pembayaran" id="keterangan-pembayaran" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Keterangan . . .">
                    </div>
                </div>
            </div>
    
            {{-- Bagian Kanan Kasir --}}
            <div class="col-span-1 my-4 mx-auto flex justify-center">
                <div class="w-80 text-base bg-white p-4 text-white border-2 border-solid shadow-xl rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="mb-4 text-center justify-center">
                        <p class="text-lg font-semibold text-gray-600 dark:text-white">Resume Tagihan</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Subtotal :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-subtotal" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Discount :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-discount" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Ongkir :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-ongkir" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-b-2">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Tax :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-tax" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Total :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-total" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <button type="button" data-modal-target="kasir-invoice" data-modal-toggle="kasir-invoice" class="review-invoice text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Review Invoice</button>
                    <button type="submit" name="status_kasir" value="Hold" class="review-invoice text-white mt-4 bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800 w-full">Hold Payment</button>
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto pt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-900 border-b-2 uppercase dark:text-white">
                    <tr>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Jenis Transaksi
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 30%;">
                            Product Name
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Serial Number
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Total Price
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 5%;">
                            Tax
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 5%;">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="kasir-container">
                    
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-gray-900 dark:text-white">
                        <td class="px-4 py-3">
                            <div class="flex justify-between text-rose-600">
                                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                                    <button type="button" id="add-item-kasir" class="flex flex-row justify-between gap-2">
                                        <span class="material-symbols-outlined">add_circle</span>
                                        <span class="">Tambah Item</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </form>
    {{-- Modal --}}
    @include('kios.kasir.modal.invoice-modal')

@endsection
