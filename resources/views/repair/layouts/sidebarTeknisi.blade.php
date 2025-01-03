<aside id="logo-sidebar" class="fixed top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="z-50 h-full px-3 pb-4 overflow-y-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-inherit bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="#" class="{{ ($active === 'repair') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">dashboard</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Dashboard</span>
                </a>
            </li>
            <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                <li class="text-sm text-gray-700 dark:text-white">Daftar Case</li>
                <li>
                    <a href="{{ route('new-case-teknisi.index') }}" class=" {{ ($active == 'new-case') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">format_list_bulleted_add</span>
                        <span class="ml-3">Ambil Case</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('listCaseTeknisi') }}" class=" {{ ($active == 'list-case') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">list_alt</span>
                        <span class="ml-3">List Case</span>
                    </a>
                </li>
            </ul>
            <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                <li class="text-sm text-gray-700 dark:text-white">Progress Pengerjaan</li>
                <li>
                    <a href="{{ route('troubleshooting.index') }}" class=" {{ ($active == 'troubleshooting') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">troubleshoot</span>
                        <span class="ml-3">Troubleshooting</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengerjaan.index') }}" class=" {{ ($active == 'pengerjaan') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">construction</span>
                        <span class="ml-3">Pengerjaan</span>
                    </a>
                </li>
                {{-- <li x-data="{ open: {{ ($dropdown == 'req-part') ? 'true' : 'false' }} }">
                    <button @click="open = !open" type="button" class="flex items-center w-full text-left p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group" aria-controls="dropdown-chek">
                        <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">handyman</span>
                        <span class="flex-1 ml-3 whitespace-nowrap">Sparepart</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="py-2 space-y-1">
                        <li>
                            <a href="{{ route('req-sparepart-teknisi.index') }}" class="{{ ($active === 'req-part') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-8">
                                <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">contract_edit</span>
                                <span class="flex-1 text-sm ml-3 whitespace-nowrap">Request Sparepart</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="{{ ($active === 'penerimaan-part') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-8">
                                <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">fact_check</span>
                                <span class="flex-1 text-sm ml-3 whitespace-nowrap">Penerimaan Sparepart</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="{{ ($active === 'pengembalian-part') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-8">
                                <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">assignment_return</span>
                                <span class="flex-1 text-sm ml-3 whitespace-nowrap">Pengembalian Sparepart</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </ul>
    </div>
</aside>