@extends('kios.layouts.main')

@section('container')
    <div class="w-full mx-auto mt-3">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">monetization_on</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Profit</span>
                                </div>
                                <div class="px-3 py-2">
                                    <div class="font-bold text-xl mb-2 text-slate-900 dark:text-gray-400">666</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-indigo-600 text-4xl dark:text-indigo-500">shopping_cart</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Sales</span>
                                </div>
                                <div class="px-3 py-2">
                                    <div class="font-bold text-xl mb-2 text-slate-900 dark:text-gray-400">666</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-orange-500 text-4xl dark:text-orange-400">group</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">New Customer</span>
                                </div>
                                <div class="px-3 py-2">
                                    <div class="font-bold text-xl mb-2 text-slate-900 dark:text-gray-400">666</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Analis Chart --}}
    <div class="p-6 mt-6 border bg-white rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
        <div class="grid grid-cols-1 my-3 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Profit</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">Rp. 666.000.000</span>
                        </div>
                        <div class="px-3 flex items-center">
                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-500 dark:text-green-400">add</span>
                            <span class="ml-0 text-sm text-green-500 dark:text-green-400">77%</span>
                            <span class="ml-1 text-sm">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Drone Terjual</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">666</span>
                        </div>
                        <div class="px-3 flex items-center">
                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-500 dark:text-green-400">add</span>
                            <span class="ml-0 text-sm text-green-500 dark:text-green-400">77%</span>
                            <span class="ml-1 text-sm">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Cust. Mau Beli Produk</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">666</span>
                        </div>
                        <div class="px-3 flex items-center">
                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-500 dark:text-green-400">add</span>
                            <span class="ml-0 text-sm text-green-500 dark:text-green-400">77%</span>
                            <span class="ml-1 text-sm">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Cust. Mau Jual Produk</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">666</span>
                        </div>
                        <div class="px-3 flex items-center">
                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-red-500 dark:text-red-400">remove</span>
                            <span class="ml-0 text-sm text-red-500 dark:text-red-400">77%</span>
                            <span class="ml-1 text-sm">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-gray-400">Produk Bekas Masuk</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">666</span>
                        </div>
                        <div class="px-3 flex items-center">
                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-red-500 dark:text-red-400">remove</span>
                            <span class="ml-0 text-sm text-red-500 dark:text-red-400">77%</span>
                            <span class="ml-1 text-sm">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
        </div>
        {{-- Chart --}}
        <div class="bg-white border shadow-md h-64 rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
            
        </div>
    </div>
@endsection