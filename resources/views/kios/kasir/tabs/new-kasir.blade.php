<div class="hidden p-4" id="new-kasir" role="tabpanel" aria-labelledby="new-kasir-tab">
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
                    <div x-data="dropdownCustomerCase()" class="relative text-start">
                        <label for="kasir_metode_pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Customer :</label>
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
                        <label for="kasir_metode_pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Metode Pembayaran :</label>
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
                <div class="w-80 text-base bg-white p-4 text-white border-gray-600 border-2 border-solid shadow-xl rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-200">
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

    {{-- Function Script --}}
    <script>
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
    </script>
</div>