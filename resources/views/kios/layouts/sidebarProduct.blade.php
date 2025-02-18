<aside id="logo-sidebar" class="fixed top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-inherit bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/kios/product/dashboard-produk" class="{{ ($active === 'dashboard-produk' ? 'bg-gray-100 dark:bg-gray-700' : '') }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">dashboard</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Dashboard</span>
                </a>
            </li>
        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li class="text-sm text-gray-700 dark:text-white">List Produk</li>
            <li x-data="{ openProduk: {{ ($dropdown == 'list-produk') ? 'true' : 'false' }} }">
                <button @click="openProduk = !openProduk" type="button" class="flex items-center w-full text-left p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">inventory_2</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Produk</span>
                    <svg :class="{ 'rotate-180': openProduk }" class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul x-show="openProduk" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="py-2 space-y-1">
                    <li>
                        <a href="/kios/product/list-product" class="{{ ($active === 'product') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">list_alt</span>
                            <span class="flex-1 ml-3 whitespace-nowrap">Produk Baru</span>
                        </a>
                    </li>
                    <li>
                        <a href="/kios/product/list-product-second" class="{{ ($active === 'product-second') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">list_alt</span>
                            <span class="flex-1 ml-3 whitespace-nowrap">Produk Second</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li class="text-sm text-gray-700 dark:text-white">Pembelanjaan</li>
            <li x-data="{ openPembelanjaan: {{ ($dropdownShop == 'shop') ? 'true' : 'false' }} }">
                <button @click="openPembelanjaan = !openPembelanjaan" type="button" class="flex items-center w-full text-left p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">storefront</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Pembelanjaan</span>
                    <svg :class="{ 'rotate-180': openPembelanjaan }" class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul x-show="openPembelanjaan" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="py-2 space-y-1">
                    <li>
                        <a href="/kios/product/shop" class="{{ ($active === 'shop') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="flex-1 ml-3 whitespace-nowrap">Produk Baru</span>
                        </a>
                    </li>
                    <li>
                        <a href="/kios/product/shop-second" class="{{ ($active === 'shop-second') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="flex-1 ml-3 whitespace-nowrap">Produk Second</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/kios/product/pembayaran" class="{{ ($active === 'payment') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">shopping_cart_checkout</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Req. Payment</span>
                </a>
            </li>
            <li>
                <a href="/kios/product/pengiriman" class="{{ ($active === 'shipment') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">local_shipping</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Pengiriman</span>
                </a>
            </li>
        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li class="text-sm text-gray-700 dark:text-white">Pengecekan</li>
            <li>
                <a href="/kios/product/penerimaan-produk" class="{{ ($active === 'unboxing-qc') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">package_2</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Penerimaan</span>
                </a>
            </li>
            <li>
                <a href="/kios/product/qc-produk-baru" class="{{ ($active === 'validasi') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">search_check</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Pengecekan Baru</span>
                </a>
            </li>
            <li x-data="{ open: {{ ($dropdown == 'pengecekkan-second') ? 'true' : 'false' }} }">
                <button @click="open = !open" type="button" class="flex items-center w-full text-left p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">fact_check</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Pengecekan Second</span>
                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="py-2 space-y-1">
                    <li>
                        <a href="/kios/product/pengecekkan-produk-second" class="{{ $active === 'pengecekkan-second' ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="flex-1 ml-3 whitespace-nowrap">Unboxing & QC</span>
                        </a>
                    </li>
                    <li>
                        <a href="/kios/product/filter-product-second" class="{{ $active === 'filter-produk-second' ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="flex-1 ml-3 whitespace-nowrap">Filter Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="/kios/product/add-paket-penjualan-second" class="{{ ($active === 'create-paket-second') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="flex-1 ml-3 whitespace-nowrap">Produk Second</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li class="text-sm text-gray-700 dark:text-white">Manajemen Produk</li>
            <li>
                <a href="{{ route('supplier-kios.index') }}" class="{{ ($active === 'supplier') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">account_box</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Add Supplier</span>
                </a>
            </li>
            <li>
                <a href="/kios/product/add-product" class="{{ ($active === 'add-product') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">list_alt_add</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Add Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('split-produk-baru.index') }}" class="{{ ($active === 'splitdb') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">compare_arrows</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Split Produk</span>
                </a>
            </li>
        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li class="text-sm text-gray-700 dark:text-white">Komplain</li>
            <li>
                <a href="/kios/product/komplain" class="{{ ($active === 'komplain') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">person_alert</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Komplain Supplier</span>
                </a>
            </li>
        </ul>
    </div>
</aside>