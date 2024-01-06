<aside id="logo-sidebar" class="fixed top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/kios" class="{{ ($active === 'dashboard-kios') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">dashboard</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/kios/daily-recap" class="{{ ($active === 'daily-recap') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">note_add</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Daily Recap</span>
                </a>
            </li>
        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li class="text-sm text-gray-700 dark:text-white">Add Supplier & Product</li>
            <li>
                <a href="/kios/supplier" class="{{ ($active === 'supplier') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">account_box</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Supplier</span>
                </a>
            </li>
            <li>
                <button type="button" class="flex items-center w-full text-left p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group" aria-controls="dropdown-chek" data-collapse-toggle="dropdown-produk">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">inventory_2</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Produk</span>
                    <svg sidebar-toggle-item class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-produk" class="{{ $dropdown ? '' : 'hidden' }} py-2 space-y-1">
                    <li>
                        <a href="/kios/product" class="{{ ($active === 'product') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">
                            <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">list_alt</span>
                            <span class="flex-1 ml-3 whitespace-nowrap">Detail Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="/kios/add-product" class="{{ ($active === 'add-product') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">
                            <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">list_alt_add</span>
                            <span class="flex-1 ml-3 whitespace-nowrap">Kelengkapan</span>
                        </a>
                    </li>
                    <li>
                        <a href="/kios/upload" class="{{ ($active === 'file-upload') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">
                            <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">cloud_upload</span>
                            <span class="flex-1 ml-3 whitespace-nowrap">File Upload</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li class="text-sm text-gray-700 dark:text-white">Shop</li>
            <li>
                <button type="button" class="flex items-center w-full text-left p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group" aria-controls="dropdown-chek" data-collapse-toggle="dropdown-shop">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">storefront</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Pembelanjaan</span>
                    <svg sidebar-toggle-item class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-shop" class="{{ $dropdownShop ? '' : 'hidden' }} py-2 space-y-1">
                    <li>
                        <a href="/kios/shop" class="{{ ($active === 'shop') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="flex-1 ml-3 whitespace-nowrap">Produk Baru</span>
                        </a>
                    </li>
                    <li>
                        <a href="/kios/shop-second" class="{{ ($active === 'shop-second') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="flex-1 ml-3 whitespace-nowrap">Produk Second</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/kios/pembayaran" class="{{ ($active === 'payment') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">shopping_cart_checkout</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Pembayaran</span>
                </a>
            </li>
            <li>
                <a href="/kios/pengiriman" class="{{ ($active === 'shipment') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">local_shipping</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Pengiriman</span>
                </a>
            </li>
        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <li class="text-sm text-gray-700 dark:text-white">Komplain</li>
            <li>
                <a href="/kios/komplain" class="{{ ($active === 'komplain') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">person_alert</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Komplain Supplier</span>
                </a>
            </li>
        </ul>
    </div>
</aside>