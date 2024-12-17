<div class="hidden p-4" id="new-dppo" role="tabpanel" aria-labelledby="new-dppo-tab">
    <form action="{{ route('dp-po.store') }}" id="dppo-form" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-3 w-full">
            <div class="col-span-2 my-4">
                <div class="flex items-center justify-between mb-4 pb-2 border-b-2">
                    <div class="flex justify-start">
                        <p class="text-base font-semibold text-gray-900 dark:text-white">Current Date : <span class="text-gray-900 font-normal dark:text-white">{{ $today->format('d/m/Y') }}</span></p>
                    </div>
                    <div class="flex justify-end">
                        @php
                            $invoice = $dataTransaksi->first()->id ?? 0;
                        @endphp
                        <p class="text-base font-semibold text-gray-900 dark:text-white">Invoice Number : <span class="text-gray-900 font-normal dark:text-white">{{ $today->format('Ymd') }}{{ $invoice + 1 }}</span></p>
                    </div>
                </div>
                <div class="grid grid-cols-2 w-full gap-6 mb-4">
                    <div>
                        <label for="status-dppo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select DP / PO :</label>
                        <select name="status_dppo" id="status-dppo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select DP / PO</option>
                            <option value="DP">Down Payment</option>
                            <option value="PO">Pre Order</option>
                        </select>
                    </div>
                    <div>
                        <label for="dppo_nama_customer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Customer :</label>
                        <select name="dppo_nama_customer" id="dppo_nama_customer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Customer</option>
                            @foreach ($customerdata as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 w-full gap-6">
                    <div>
                        <label for="dppo_metode_pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Metode Pembayaran :</label>
                        <select name="dppo_metode_pembayaran" id="dppo_metode_pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Metode Pembayaran</option>
                            @foreach ($akunrd as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="dppo-nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Pembayaran :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="dppo_nominal" id="dppo-nominal" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                        </div>
                    </div>
                </div>
            </div>
    
            {{-- Bagian Kanan dppo --}}
            <div class="col-span-1 my-4 mx-auto flex justify-center">
                <div class="w-80 text-base bg-white p-4 text-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Subtotal :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="dppo-box-subtotal" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-b-2">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">DP :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="dppo-box-dp" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Total :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="dppo-box-total" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <button type="button" id="dppo-review-invoice" data-modal-target="dppo-invoice" data-modal-toggle="dppo-invoice" class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Review Invoice</button>
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
                        <th scope="col" class="px-4 py-3" style="width: 35%;">
                            Nama Produk
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Jumlah Produk
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 20%;">
                            Harga Produk
                        </th>
                        <th scope="col" class="px-4 py-3" style="width: 5%;">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="dppo-container">
                    
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-gray-900 dark:text-white">
                        <td class="px-4 py-3">
                            <div class="flex justify-between text-rose-600">
                                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                                    <button type="button" id="add-item-dppo" class="flex flex-row justify-between gap-2">
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

    {{-- Modal Invoice --}}
    @include('kios.kasir.modal.invoice-dppo')
</div>