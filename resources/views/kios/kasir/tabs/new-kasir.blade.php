<div class="hidden p-4" id="new-kasir" role="tabpanel" aria-labelledby="new-kasir-tab">
    <form action="{{ route('kasir.store') }}" id="kasir-form" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-3 w-full">
            <div class="col-span-2 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex justify-start">
                        <p class="text-base font-semibold text-gray-900 dark:text-white">Current Date : <span class="text-gray-900 font-normal dark:text-white">{{ $today->format('d/m/Y') }}</span></p>
                    </div>
                    <div class="flex justify-end">
                        <p class="text-base font-semibold text-gray-900 dark:text-white">Invoice Number : <span class="text-gray-900 font-normal dark:text-white">{{ $today->format('Ymd') }}{{ $invoiceid + 1 }}</span></p>
                    </div>
                </div>
                <h2 class="text-base font-semibold mb-4 text-black dark:text-white my-4 pt-2 border-t-2">Data Customer</h2>
                <div class="grid grid-cols-3 w-full gap-x-4 gap-y-2 mb-4">
                    <div x-data="dropdownCustomerCase()" class="relative text-start">
                        <label for="kasir-nama-customer" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Customer :</label>
                        <div class="relative">
                            <input x-model="search" 
                                @focus="open = true" 
                                @keydown.escape="open = false" 
                                @click.outside="open = false"
                                type="text" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="Search or select customer...">
                                <svg :class="{ 'rotate-180': open }" class="absolute inset-y-0 right-2 top-2.5 w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            <input type="hidden" id="kasir-nama-customer" name="nama_customer" :value="selected" required>
                        </div>

                        <ul x-show="open" 
                            x-transition 
                            class="absolute z-10 bg-white border border-gray-300 rounded-lg mt-1 max-h-60 w-full overflow-y-auto shadow-md dark:bg-gray-700 dark:border-gray-600">
                            <template x-for="customer in filteredCustomers" :key="customer.id">
                                <li @click="select(customer.id, customer.display)" 
                                    class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white">
                                    <span x-text="customer.display" class="text-black dark:text-white"></span>
                                </li>
                            </template>
                            <li 
                                x-show="filteredCustomers.length === 0" 
                                class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                Data customer tidak ditemukan.
                            </li>
                        </ul>
                    </div>
                    <div>
                        <div x-data>
                            <label for="kasir-discount" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Discount :</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="kasir_discount" id="kasir-discount" x-model="$store.kasirForm.discount" @change="$store.kasirForm.updateInvoice()" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div x-data>
                            <label for="kasir-kerugian" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Kerugian :</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="kasir_kerugian" id="kasir-kerugian" x-model="$store.kasirForm.kerugian" @change="$store.kasirForm.updateInvoice()" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div x-data>
                            <input type="hidden" name="kasir_tax" id="kasir-tax" value="0">
                            <div class="flex justify-between items-center">
                                <label for="kasir-ongkir" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Ongkir :</label>
                                <div x-effect="$store.kasirForm.toggleAsuransi()">
                                    <label class="inline-flex items-center mb-2 cursor-pointer">
                                        <input id="checkbox-asuransi" type="checkbox" x-model="$store.kasirForm.asuransiChecked" class="sr-only peer">
                                        <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-orange-600 dark:peer-checked:bg-orange-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Asuransi</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="kasir_ongkir" id="kasir-ongkir" x-model="$store.kasirForm.ongkir" @change="$store.kasirForm.updateInvoice()" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                                <input type="hidden" name="kasir_asuransi" id="kasir-asuransi" x-model="$store.kasirForm.asuransi" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div x-data>
                            <label for="kasir-packing" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Packing :</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="kasir_packing" id="kasir-packing" x-model="$store.kasirForm.packing" @change="$store.kasirForm.updateInvoice()" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="keterangan-pembayaran" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Keterangan :</label>
                        <input type="text" name="keterangan_pembayaran" id="keterangan-pembayaran" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pendapatan Kios Sejumlah Rp.xxx.xxx . . ." required>
                    </div>
                </div>

                <h2 class="text-base font-semibold mb-4 text-black dark:text-white border-t pt-2">Ekspedisi</h2>
                    <div class="grid grid-cols-3 gap-4 w-full mb-4">
                        <div>
                            <label for="ekspedisi0" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Ekspedisi :</label>
                            <select name="ekspedisi" id="ekspedisi0" data-id="0" class="ekspedisi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" hidden>Pilih Ekspedisi</option>
                                @foreach ($ekspedisi as $ekspedisi)
                                    <option value="{{ $ekspedisi->id }}" class="bg-white dark:bg-gray-700">{{ $ekspedisi->ekspedisi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="layanan0" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Ekspedisi :</label>
                            <select name="layanan" id="layanan0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" hidden>Jenis Pengiriman</option>
                            </select>
                        </div>
                        <div>
                            
                        </div>
                    </div>

                <div id="form-kelebihan" style="display: none">
                    <h2 class="text-base font-semibold mb-4 text-black dark:text-white border-t pt-2">Pembayaran Lebih</h2>
                    <div class="grid grid-cols-3 gap-4 w-full mb-4">
                        <div>
                            <label for="kasir-dikembalikan" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Dikembalikan :</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="kasir_dikembalikan" id="kasir-dikembalikan" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                            </div>
                        </div>
                        <div>
                            <label for="kasir-pll" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal P. Lain Lain :</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="kasir_pll" id="kasir-pll" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                            </div>
                        </div>
                        <div>
                            <label for="kasir-sc" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Save Saldo Customer :</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="kasir_sc" id="kasir-sc" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="text-base font-semibold mb-4 text-black dark:text-white border-t pt-2">Metode Pemabayaran</h2>
                <div id="container-metode-pembayaran-kasir-kios">
                    <div id="form-mp-kasir" class="form-mp-kasir grid grid-cols-4 gap-4 mb-4" style="grid-template-columns: 5fr 5fr 3fr 1fr">
                        <div>
                            <label for="kasir-metode-pembayaran" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Metode Pembayaran :</label>
                            <select name="kasir_metode_pembayaran[]" id="kasir-metode-pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Select Metode Pembayaran</option>
                                @foreach ($daftarAkun as $akun)
                                    <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="kasir-nominal-pembayaran" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Pembayaran :</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="kasir_nominal_pembayaran[]" id="kasir-nominal-pembayaran" class="kasir-formated-rupiah kasir-nominal-pembayaran rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')" required>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Files Bukti Transaksi :</label>
                            <div class="relative z-0 w-full">
                                <label for="file-bukti-transaksi" id="file-label" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    No file chosen
                                </label>
                                <input type="file" name="file_bukti_transaksi[]" id="file-bukti-transaksi" class="hidden" onchange="updateFileName(this)" required>
                            </div>
                        </div>
                        <div class="flex justify-center items-end pb-2">
                            {{-- <button type="button" class="remove-mp-kasir">
                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                            </button> --}}
                        </div>
                    </div>
                </div>
                <div class="flex justify-start text-red-500 mt-6">
                    <div class="flex cursor-pointer my-2 hover:text-rose-700">
                        <button type="button" id="add-metode-pembayaran-lunas" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span>Tambah Metode Pembayaran</span>
                        </button>
                    </div>
                </div>
            </div>
    
            {{-- Bagian Kanan Kasir --}}
            <div class="col-span-1 my-4 mx-auto flex justify-center flex-col">
                <div class="w-80 text-base bg-white p-4 text-white border-gray-600 border-2 border-solid shadow-xl rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-200">
                    <div class="flex mb-4 items-center justify-between">
                        <div class="flex justify-start">
                            <p class="text-lg font-bold text-black dark:text-white">Resume Tagihan</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <span id="status-box-lunas" class="bg-rose-100 text-rose-700 text-xs font-bold me-2 px-2.5 py-0.5 rounded dark:bg-rose-800 dark:text-rose-300">Not Pass</span>
                        </div>
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
                            <p class="font-semibold text-gray-900 dark:text-white">Kerugian :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-kerugian" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
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
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Packing :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-packing" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Asuransi :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-asuransi" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Total :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="kasir-box-total" class="text-gray-900 font-semibold dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                </div>
                <button type="button" data-modal-target="kasir-invoice" data-modal-toggle="kasir-invoice" class="review-invoice text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-80 mx-auto">Review Invoice</button>
                {{-- <button type="submit" name="status_kasir" value="Hold" class="text-white mt-4 bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800 w-full">Hold Payment</button> --}}
            </div>
        </div>

        <div x-data>
    
            <table class="w-full mt-4 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                <tbody>
                    <template x-for="item in $store.kasirForm.items" :key="item.id">
                        <tr>
                            <td class="px-4 py-2">
                                <select name="jenis_transaksi[]" x-model="item.jenisTransaksi" @change="$store.kasirForm.fetchItemOptions(item)" class="jenis_produk bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" hidden>Pilih Jenis Transaksi</option>
                                    <option value="drone_baru">Drone Baru</option>
                                    <option value="drone_bnob">Drone Baru BNOB</option>
                                    <option value="drone_bekas">Drone Bekas</option>
                                    <option value="part_baru">Part Baru</option>
                                    <option value="part_bekas">Part Bekas</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 relative text-start">
                                <div class="relative">
                                    <input x-model="item.searchQuery" 
                                        @focus="item.showDropdown = true" 
                                        @keydown.escape="item.showDropdown = false" 
                                        @click.outside="item.showDropdown = false"
                                        @input="$store.kasirForm.searchItems(item)"
                                        type="text" 
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Search or select product...">
                                        <svg :class="{ 'rotate-180': item.showDropdown }" class="absolute inset-y-0 right-2 top-2.5 w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    <input type="hidden" name="item_id[]" :value="item.itemId" required>
                                </div>
        
                                <ul x-show="item.showDropdown" 
                                    x-transition 
                                    class="absolute z-10 bg-white border border-gray-300 rounded-lg mt-1 max-h-60 w-full overflow-y-auto shadow-md dark:bg-gray-700 dark:border-gray-600">
                                    <template x-for="option in item.filteredItems" :key="option.value">
                                        <li @click="$store.kasirForm.selectItem(item, option)" 
                                            class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white">
                                            <span x-text="option.label" class="text-black dark:text-white"></span>
                                        </li>
                                    </template>
                                    <li 
                                        x-show="item.itemOptions.length === 0" 
                                        class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                        Data produk tidak ditemukan.
                                    </li>
                                </ul>
                            </td>
                            <td class="px-4 py-2">
                                <select x-model="item.kasirSn" 
                                        name="kasir_sn[]" 
                                        @change="
                                            $store.kasirForm.updateNilaiDroneBekas(item, $event.target.value)
                                                .then(() => {
                                                    $store.kasirForm.addToInvoice(item);
                                                });
                                            $nextTick(() => $store.kasirForm.updateInvoice());
                                        "
                                        class="kasir_sn bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        required>
                                    <option value="" hidden>Pilih SN</option>
                                    <template x-for="sn in item.kasirSnOptions" :key="sn.value">
                                        <option :value="sn.value" x-text="sn.label"></option>
                                    </template>
                                </select>
                            </td>
                            <td class="px-4 py-2">
                                <input type="hidden" name="kasir_modal_part[]" x-model="item.modalGudang">
                                <input type="text" name="kasir_harga[]" x-model="item.kasirHarga" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp. 0" readonly required>
                            </td>
                            <td class="px-4 py-2">
                                <input type="checkbox" name="checkbox_tax[]" x-model="item.checkboxTax" class="checkbox-tax w-10 h-6 bg-gray-100 border border-gray-300 text-green-600 text-lg rounded-lg focus:ring-green-600 focus:ring-2 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:ring-offset-gray-800">
                            </td>
                            <td class="px-4 py-2">
                                <button type="button" @click="$store.kasirForm.removeItem(item.id)">
                                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <div class="flex justify-between text-rose-600">
                <div class="flex cursor-pointer mt-4 hover:text-red-400">
                    <button type="button" @click="$store.kasirForm.addItem()" id="add-item-kasir" class="flex flex-row justify-between gap-2">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span class="">Tambah Item</span>
                    </button>
                </div>
            </div>

            <template x-for="invoice in $store.kasirForm.invoices" :key="invoice.productName">
                <tr>
                    <td class="px-2 py-1">
                        <input type="hidden" name="invoiceProductName[]" x-bind:value="invoice.productName">
                    </td>
                    <td class="px-2 py-1">
                        <input type="hidden" name="invoiceDescription[]" x-bind:value="invoice.description">
                    </td>
                    <td class="px-2 py-1">
                        <input type="hidden" name="invoiceQty[]" x-bind:value="invoice.qty">
                    </td>
                    <td class="px-2 py-1">
                        <input type="hidden" name="invoiceItemPrice[]" x-bind:value="invoice.itemPrice">
                    </td>
                    <td class="px-2 py-1">
                        <input type="hidden" name="invoiceTotalPrice[]" x-bind:value="invoice.totalPrice">
                    </td>
                </tr>
            </template>
            
        </div>
        <input type="hidden" name="input_invoice_subtotal" id="input-invoice-subtotal">
        <input type="hidden" name="input_invoice_discount" id="input-invoice-discount">
        <input type="hidden" name="input_invoice_ongkir" id="input-invoice-ongkir">
        <input type="hidden" name="input_invoice_total" id="input-invoice-total">
    </form>
    {{-- Modal --}}
    @include('kios.kasir.modal.invoice-modal')

    {{-- Function Script --}}
    <script>
        let daftarAkun = @json($daftarAkun);
        function dropdownCustomerCase() {
            return {
                open: false,
                search: '',
                selected: '',
                customers: Object.values(@json($customerdata)),
                filteredCustomers: [],
                debounceSearch: null,
                init() {
                    if (!Array.isArray(this.customers)) {
                        this.customers = [];
                    }
                    this.filteredCustomers = this.customers;
                    this.$watch('search', (value) => {
                        clearTimeout(this.debounceSearch);
                        this.debounceSearch = setTimeout(() => {
                            this.filteredCustomers = this.customers.filter(customer =>
                                customer.display.toLowerCase().includes(value.toLowerCase())
                            );
                        }, 300);
                    });
                },
                select(id, display) {
                    this.selected = id;
                    this.search = display;
                    this.open = false;
                }
            }
        }

        function updateFileName(input) {
            const fileName = input.files.length > 0 ? input.files[0].name : "No file chosen";
            const label = input.previousElementSibling;
            if (label) {
                label.textContent = fileName;
            }
        }
    </script>
</div>