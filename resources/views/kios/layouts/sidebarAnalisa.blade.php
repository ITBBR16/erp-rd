<aside id="logo-sidebar" class="fixed top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="z-50 h-full px-3 pb-4 overflow-y-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-inherit bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/kios/analisa/dashboard" class="{{ ($active === 'dashboard-kios') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">dashboard</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('analisa-dr') }}" class="{{ ($active === 'analisa-daily-recap') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">guardian</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Customer Report</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">shopping_cart</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Purchasement</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">monitoring</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Sales Report</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">groups_2</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Team Report</span>
                </a>
            </li>
        </ul>
    </div>
</aside>