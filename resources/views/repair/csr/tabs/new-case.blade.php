<div class="hidden p-4" id="newCase" role="tabpanel" aria-labelledby="newCase-tab">
    <form action="{{ route('case-list.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-2 gap-8">
            {{-- Form Data Customer --}}
            <div>
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Customer : </h3>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-customer" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Customer :</label>
                    </div>
                    <div x-data="dropdownCustomerCase()" class="relative col-span-2 text-start">
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
                            <input type="hidden" name="case_customer" :value="selected" required>
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
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-jenis-drone" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                    </div>
                    <div x-data="dropdownJenisDrone()" class="relative col-span-2 text-start">
                        <div class="relative">
                            <input x-model="search"
                                @focus="open = true" 
                                @keydown.escape="open = false" 
                                @click.outside="open = false"
                                type="text" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="Search or select jenis drone...">
                                <svg :class="{ 'rotate-180': open }" class="absolute inset-y-0 right-2 top-2.5 w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            <input type="hidden" id="case-jenis-drone" name="case_jenis_drone" :value="selected" required>
                        </div>
                    
                        <ul x-show="open" 
                            x-transition 
                            class="absolute z-10 bg-white border border-gray-300 rounded-lg mt-1 max-h-60 w-full overflow-y-auto shadow-md dark:bg-gray-700 dark:border-gray-600">
                            <template x-for="jenis in filteredJenis" :key="jenis.id">
                                <li @click="select(jenis.id, jenis.display)"
                                    class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white">
                                    <span x-text="jenis.display" class="text-black dark:text-white"></span>
                                </li>
                            </template>
                            <li x-show="filteredJenis.length === 0" 
                                class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                Data Jenis Drone tidak ditemukan.
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-fungsional" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Fungsional Drone :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="case_fungsional" id="case-fungsional" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Fungsional Drone</option>
                            @foreach ($fungsionalDrone as $fungsional)
                                <option value="{{ $fungsional->id }}">{{ $fungsional->jenis_fungsional }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-jenis" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Case :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="case_jenis" id="case-jenis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Jenis Case</option>
                            @foreach ($jenisCase as $jc)
                                <option value="{{ $jc->id }}">{{ $jc->jenis_case }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- Form Kronologi --}}
            <div>
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Kronologi : </h3>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-keluhan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keluhan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="case_keluhan" id="case-keluhan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-kronologi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kronologi Kerusakan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="case_kronologi" id="case-kronologi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-penggunaan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Penanganan Setelah Terjadi Kendala :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="case_penggunaan" id="case-penggunaan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-riwayat" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Riwayat Penggunaan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="case_riwayat" id="case-riwayat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4 border-t-2 border-gray-400 pt-2">
            <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Kelengkapan</h3>
        </div>
        {{-- Form Data Kelengkapan --}}
        <div id="container-data-kelengkapan-case">
            <div id="form-data-kelengkapan-case" class="grid grid-cols-4 gap-4 mt-5">
                <div>
                    <label for="case-kelengkapan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelengkapan :</label>
                    <select name="case_kelengkapan[]" id="case-kelengkapan" class="dd-kelengkapan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Select Kelengkapan</option>
                    </select>
                </div>
                <div>
                    <label for="case-quantity" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                    <input type="text" name="case_quantity[]" id="case-quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" oninput="this.value = this.value.replace(/\D/g, '')" required>
                </div>
                <div>
                    <label for="case-sn" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number : </label>
                    <input type="text" name="case_sn[]" id="case-sn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                </div>
                <div class="grid grid-cols-2" style="grid-template-columns: 5fr 1fr">
                    <div>
                        <label for="case-keterangan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan : </label>
                        <input type="text" name="case_keterangan[]" id="case-keterangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                    </div>
                    {{-- <div class="flex justify-center items-end pb-2">
                        <button type="button" class="remove-form-dkcs" data-id="">
                            <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="flex justify-start text-red-500 mt-6">
            <div class="flex cursor-pointer my-2 hover:text-rose-700">
                <button type="button" id="add-kelengkapan-case" class="flex flex-row justify-between gap-2">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span>Tambah Kelengkapan</span>
                </button>
            </div>
        </div>
        <div class="mt-6 text-end">
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

    {{-- Search Select Function --}}
    <script>
        function dropdownCustomerCase() {
            return {
                open: false,
                search: '',
                selected: '',
                customers: Object.values(@json($dataCustomers)),
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

        function dropdownJenisDrone() {
            return {
                open: false,
                search: '',
                selected: '',
                jenis: Object.values(@json($jenisDrone)),
                filteredJenis: [],
                debounceSearch: null,
                init() {
                    if (!Array.isArray(this.jenis)) {
                        this.customers = [];
                    }
                    this.filteredJenis = this.jenis;
                    this.$watch('search', (value) => {
                        clearTimeout(this.debounceSearch);
                        this.debounceSearch = setTimeout(() => {
                            this.filteredJenis = this.jenis.filter(jenis =>
                                jenis.display.toLowerCase().includes(value.toLowerCase())
                            );
                        }, 300);
                    });
                },
                select(id, display) {
                    this.selected = id;
                    this.search = display;
                    this.open = false;
                    
                    // Emit event
                    const event = new CustomEvent('jenis-drone-changed', {
                        detail: { id: this.selected },
                    });
                    document.dispatchEvent(event);
                }
            }
        }
    </script>
</div>