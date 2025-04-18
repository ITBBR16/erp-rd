<aside id="logo-sidebar" class="fixed top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-inherit bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/kios/kasir/kasir" class="{{ ($active === 'kasir-kios') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">point_of_sale</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Kasir</span>
                </a>
            </li>
            <li>
                <a href="/kios/kasir/dp-po" class="{{ ($active === 'dp-po-kios') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">pending_actions</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">DP / PO</span>
                </a>
            </li>
            <li>
                <a href="{{ route('indexHistory') }}" class="{{ ($active === 'history-transaksi') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">history</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">History Transaksi</span>
                </a>
            </li>
            <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                <li class="text-sm text-gray-700 dark:text-white">Logistik</li>
                <li>
                    <a href="{{ route('req-packing-kios.index') }}" class="{{ ($active === 'frp') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">local_shipping</span>
                        <span class="flex-1 ml-3 whitespace-nowrap">Form Request Packing</span>
                    </a>
                </li>
            </ul>
        </ul>
    </div>
</aside>