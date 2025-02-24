@extends('gudang.layouts.main')

@section('container')
    <div class="grid grid-cols-2 gap-8 mb-8 border-b border-gray-400 py-3">
        <div class="flex text-3xl font-bold text-gray-700 dark:text-gray-300">
            List Label Sparepart
        </div>
    </div>

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

    <div class="relative">
        <div class="flex items-center gap-4 mb-4">
            <div x-data="dropdownSparepart()">
                <label class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Sparepart</label>
                <div class="relative">
                    <input x-model="search" 
                        @focus="open = true" 
                        @keydown.escape="open = false" 
                        @click.outside="open = false"
                        type="text" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Search or select sparepart...">
                        <svg :class="{ 'rotate-180': open }" class="absolute inset-y-0 right-2 top-2.5 w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    <input type="hidden" :value="selected" required>
                </div>
            
                <ul x-show="open" 
                    x-transition 
                    class="absolute z-10 bg-white rounded-lg mt-1 max-h-60 w-96 overflow-y-auto shadow-md dark:bg-gray-700">
                    <template x-for="sparepart in filteredspareparts" :key="sparepart.id">
                        <li @click="select(sparepart.id, sparepart.display)" 
                            class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white">
                            <span x-text="sparepart.display" class="text-black dark:text-white"></span>
                        </li>
                    </template>
                    <li 
                        x-show="filteredspareparts.length === 0" 
                        class="px-4 py-2 text-gray-500 dark:text-gray-400">
                        Data sparepart tidak ditemukan.
                    </li>
                </ul>
            </div>
            <div>
                <label for="label-id-belanja" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">ID Pembelanjaan</label>
                <select id="label-id-belanja" class="bg-gray-50 border w-72 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" hidden>Pilih ID Pembelanjaan</option>
                </select>
            </div>
        </div>
    </div>

    <div class="relative">
        <div class="overflow-y-auto max-h-[580px]">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Order ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            SKU
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Produk
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody id="container-table-label">
                    
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function dropdownSparepart() {
            return {
                open: false,
                search: '',
                selected: '',
                spareparts: Object.values(@json($dataSparepart)),
                filteredspareparts: [],
                debounceSearch: null,
                init() {
                    if (!Array.isArray(this.spareparts)) {
                        this.spareparts = [];
                    }
                    this.filteredspareparts = this.spareparts;
                    this.$watch('search', (value) => {
                        clearTimeout(this.debounceSearch);
                        this.debounceSearch = setTimeout(() => {
                            this.filteredspareparts = this.spareparts.filter(sparepart =>
                                sparepart.display.toLowerCase().includes(value.toLowerCase())
                            );
                        }, 300);
                    });
                },
                select(id, display) {
                    this.selected = id;
                    this.search = display;
                    this.open = false;

                    // Emit event
                    const event = new CustomEvent('nama-sparepart-label', {
                        detail: { id: this.selected },
                    });
                    document.dispatchEvent(event);
                }
            }
        }
    </script>

@endsection