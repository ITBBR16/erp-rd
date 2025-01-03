<aside id="logo-sidebar" class="fixed top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="z-50 h-full px-3 pb-4 overflow-y-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-inherit bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="#" class="{{ ($active === '') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">dashboard</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('estimasi-biaya.index') }}" class="{{ ($active === 'estimasi-biaya') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">playlist_add_check_circle</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Estimasi Biaya</span>
                </a>
            </li>
            <li>
                <a href="{{ route('konfirmasi-estimasi.index') }}" class="{{ ($active === 'konfirmasi-estimasi') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">contact_mail</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Konfirmasi</span>
                </a>
            </li>
            {{-- <li>
                <button type="button" class="flex items-center w-full text-left p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group" aria-controls="dropdown-chek" data-collapse-toggle="dropdown-req-sprepart-estimasi">
                    <span class="material-symbols-outlined w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">handyman</span>
                    <span class="flex-1 ml-3 whitespace-nowrap">Sparepart</span>
                    <svg sidebar-toggle-item class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-req-sprepart-estimasi" class="{{ ($dropdown == 'req-part') ? '' : 'hidden' }} py-2 space-y-1">
                    <li>
                        <a href="{{ route('req-sparepart-estimasi.index') }}" class="{{ ($active === 'req-part-estimasi') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">contract_edit</span>
                            <span class="flex-1 ml-3 whitespace-nowrap">Request Sparepart</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('penerimaan-sparepart-estimasi.index') }}" class="{{ ($active === 'penerimaan-part-estimasi') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">fact_check</span>
                            <span class="flex-1 ml-3 whitespace-nowrap">Penerimaan Sparepart</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('konfirmasi-req-sparepart.index') }}" class="{{ ($active === 'konfirmasi-part') ? 'bg-gray-100 dark:bg-gray-700' : '' }} flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group pl-11">
                            <span class="material-symbols-outlined w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">rule</span>
                            <span class="flex-1 ml-3 whitespace-nowrap">Konf. Req Sparepart</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </div>
</aside>