<div class="hidden p-4" id="createPaket" role="tabpanel" aria-labelledby="createPaket-tab">
    <form action="{{ route('add-paket-penjualan-second.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <h3 class="text-gray-900 dark:text-white font-semibold text-xl mb-2">Data Paket Penjualan Produk</h3>
        <div class="w-10/12">
            <div class="bg-white p-4 text-white border border-solid shadow-md rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-200">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div>
                        <div x-data="dropdownPaketPenjualanSecond()" class="relative text-start">
                            <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Paket Penjualan :</label>
                            <div class="relative">
                                <input x-model="search" 
                                    @focus="open = true" 
                                    @keydown.escape="open = false" 
                                    @click.outside="open = false"
                                    type="text" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    placeholder="Search or select varian product...">
                                    <svg :class="{ 'rotate-180': open }" class="absolute inset-y-0 right-2 top-2.5 w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                <input type="hidden" id="paket_penjualan_produk_second" name="paket_penjualan_produk_second" :value="selected" required>
                            </div>
    
                            <ul x-show="open" 
                                x-transition 
                                class="absolute z-30 bg-white border border-gray-300 rounded-lg mt-1 max-h-60 w-full overflow-y-auto shadow-md dark:bg-gray-700 dark:border-gray-600">
                                <template x-for="varian in filteredVarians" :key="varian.id">
                                    <li @click="select(varian.id, varian.display)" 
                                        class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white">
                                        <span x-text="varian.display" class="text-black dark:text-white"></span>
                                    </li>
                                </template>
                                <li 
                                    x-show="filteredVarians.length === 0" 
                                    class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                    Data paket penjualan tidak ditemukan.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <label for="cc_produk_second" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">CC Produk</label>
                        <input type="text" name="cc_produk_second" id="cc_produk_second" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CC Produk" oninput="this.value = this.value.replace(/\D/g, '')">
                    </div>

                    <div>
                        <label for="modal_produk_second" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Modal :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="modal_produk_second" id="modal_produk_second" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')" readonly>
                        </div>
                    </div>

                    <div>
                        <label for="harga_jual_produk_second" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Penjualan :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="harga_jual_produk_second" id="harga_jual_produk_second" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')" required>
                        </div>
                    </div>

                    <div>
                        <label for="serial-number-second" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Serial Number :</label>
                        <input type="text" name="serial_number_second" id="serial-number-second" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="SN123456QWERT" required>
                    </div>
                </div>
                <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Isi Kelengkapan</h3>
                <div id="kelengkapan-jual-second">
                    
                </div>
                <div class="flex justify-between text-rose-600">
                    <div class="flex cursor-pointer mt-4 hover:text-red-400">
                        <button type="button" id="add-kelengkapan-second" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span class="">Tambah Kelengkapan</span>
                        </button>
                    </div>
                </div>
            </div>
            <h3 class="mt-6 text-gray-900 dark:text-white font-semibold text-xl mb-2">Data File Upload</h3>
            <div class="bg-white p-4 text-white border border-solid shadow-md rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-200">
                <div class="mt-3 grid grid-cols-2 gap-4 md:gap-6">
                    <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">File Utama Produk :</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="file_paket_produk" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div id="image_paket" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 w text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG or JPG</p>
                            </div>
                            <div id="selected_images_paket" class="flex flex-col items-center justify-center pt-5 pb-6" style="display: none"></div>
                            <input name="file_paket_produk" id="file_paket_produk" type="file" class="hidden">
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 md:gap-6 mt-4">
                    <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Files Kelengkapan :</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="file_kelengkapan_produk" class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div id="image_kelengkapan" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG or JPG</p>
                            </div>
                            <div id="selected_images_kelengkapan" class="flex flex-wrap justify-evenly" style="display: none"></div>
                            <input name="file_kelengkapan_produk[]" id="file_kelengkapan_produk" type="file" class="hidden" multiple>
                        </label>
                    </div>
                </div>
                <div class="mt-6 text-end">
                    <button type="submit" id="btn-create-paket-second" class="cursor-not-allowed submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" disabled>Submit</button>
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

    <script>
        function dropdownPaketPenjualanSecond() {
            return {
                open: false,
                search: '',
                selected: '',
                varians: Object.values(@json($kiosproduks)),
                filteredVarians: [],
                debounceSearch: null,
                init() {
                    if (!Array.isArray(this.varians)) {
                        this.varians = [];
                    }
                    this.filteredVarians = this.varians;
                    this.$watch('search', (value) => {
                        clearTimeout(this.debounceSearch);
                        this.debounceSearch = setTimeout(() => {
                            this.filteredVarians = this.varians.filter(varian =>
                                varian.display.toLowerCase().includes(value.toLowerCase())
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