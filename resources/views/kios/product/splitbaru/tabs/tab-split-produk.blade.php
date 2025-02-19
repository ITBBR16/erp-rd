<div class="hidden p-4" id="splitProduk" role="tabpanel" aria-labelledby="splitProduk-tab">
    <form action="{{ route('split-produk-baru.index') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-3">
            <div class="col-span-2">
                <div class="rounded-lg shadow-md border bg-white p-4">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Paket Penjualan :</label>
                            <div x-data="dropdownPaketPenjualan()" class="relative col-span-2 text-start">
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
                                    <input type="hidden" id="paket-penjualan-awal-split" name="paket_penjualan_awal_split" :value="selected" required>
                                </div>
                            
                                <ul x-show="open" 
                                    x-transition 
                                    class="absolute z-20 bg-white border border-gray-300 rounded-lg mt-1 max-h-60 w-full overflow-y-auto shadow-md dark:bg-gray-700 dark:border-gray-600">
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
                        <div>
                            <label for="sn-produk-awal-split" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Serial Number :</label>
                            <select name="sn_awal_split" id="sn-produk-awal-split" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Serial Number</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex mt-6 items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">
                                List Kelengkapan Produk Baru
                            </p>
                        </div>
                    </div>
                    <div class="relative mt-6">
                        <div class="overflow-y-auto max-h-[540px]">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="sticky top-0 z-10 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" style="width: 50%">
                                            Nama Kelengkapan
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="width: 25%">
                                            Serial Number
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="width: 25%">
                                            Nominal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="container-split-produk-baru">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-1 flex flex-col gap-6 w-fit h-fit mx-auto">
                <div class="rounded-lg shadow-md border bg-white p-4">
                    <div class="flex mb-4 items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">
                                Detail Produk Baru
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Nilai Modal :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <input type="hidden" name="modal_awal_produk_baru" id="modal-awal-produk-baru">
                            <p id="modal-awal-split" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex justify-start">
                            <p class="font-bold text-lg text-purple-600 dark:text-white">Sisa Nominal :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="sisa-nominal-split-kios" class="text-purple-600 text-lg font-bold dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                </div>
                <div>
                    <button id="btn-split-kios" type="submit" class="submit-button-form cursor-not-allowed text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-bold rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800 w-96 mx-auto" disabled>Submit</button>
                    <div class="loader-button-form" style="display: none">
                        <button class="cursor-not-allowed text-white border border-purple-700 bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-purple-500 dark:text-white dark:bg-purple-500 dark:focus:ring-purple-800 w-96 mx-auto" disabled>
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

    <script>
        function dropdownPaketPenjualan() {
            return {
                open: false,
                search: '',
                selected: '',
                jenis: Object.values(@json($produks)),
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
                    const event = new CustomEvent('paket-penjualan-split', {
                        detail: { id: this.selected },
                    });
                    document.dispatchEvent(event);
                }
            }
        }
    </script>
</div>