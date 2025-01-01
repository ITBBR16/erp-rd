@extends('kios.layouts.main')

@section('container')
    <div class="fixed top-16 w-full bg-white border-t border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-2/3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <span class="text-3xl font-bold text-gray-700 dark:text-white">Dashboard</span>
                </div>
                {{-- <div class="flex items-center">
                    <div>
                        <div class="flex items-center">
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input datepicker type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="w-full mx-auto mt-16">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">monetization_on</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Profit</span>
                                </div>
                                <div class="px-3 py-0">
                                    <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">Rp. {{ number_format($totalProfit, 0, ',', '.') }} / Rp. 135.000.000</div>
                                    <div class="flex-none w-full max-w-full flex items-center">
                                        @if ($profitType == 'Keuntungan')
                                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-700 dark:text-green-500">add</span>
                                            <span class="ml-0 text-sm text-green-700 dark:text-green-500">{{ $percentage }}%</span>
                                        @else
                                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-red-700 dark:text-red-500">remove</span>
                                            <span class="ml-0 text-sm text-red-700 dark:text-red-500">{{ $percentage }}%</span>
                                        @endif
                                        <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">person_add</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Customer Growth</span>
                                </div>
                                <div class="px-3 py-0">
                                    <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">{{ $newCustomer }} New Customer</div>
                                    <div class="flex-none w-full max-w-full flex items-center">
                                        @if ($profitType == 'Keuntungan')
                                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-700 dark:text-green-500">add</span>
                                            <span class="ml-0 text-sm text-green-700 dark:text-green-500">{{ $customerPercentage }}%</span>
                                        @else
                                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-red-700 dark:text-red-500">remove</span>
                                            <span class="ml-0 text-sm text-red-700 dark:text-red-500">{{ $customerPercentage }}%</span>
                                        @endif
                                        <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">sentiment_satisfied</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Customer Satisfaction</span>
                                </div>
                                <div class="px-3 py-0">
                                    <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">90% 😁</div>
                                    <div class="flex-none w-full max-w-full flex items-center">
                                        <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-700 dark:text-green-500">add</span>
                                        <span class="ml-0 text-sm text-green-700 dark:text-green-500">10%</span>
                                        <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">store</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Sales New Drone</span>
                                </div>
                                <div class="px-3 py-0">
                                    <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">20 Unit / 30 Unit</div>
                                    <div class="flex-none w-full max-w-full flex items-center">
                                        <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-red-700 dark:text-red-500">remove</span>
                                        <span class="ml-0 text-sm text-red-700 dark:text-red-500">34%</span>
                                        <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">recycling</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Sales Second Drone</span>
                                </div>
                                <div class="px-3 py-0">
                                    <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">60 Unit / 40 Unit</div>
                                    <div class="flex-none w-full max-w-full flex items-center">
                                        <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-700 dark:text-green-500">add</span>
                                        <span class="ml-0 text-sm text-green-700 dark:text-green-500">50%</span>
                                        <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-6 xl:w-1/3">
                <div class="flex flex-col h-24 min-w-0 break-words bg-white shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="px-3 py-3">
                                <span class="material-symbols-outlined text-green-500 text-4xl dark:text-green-400">apartment</span>
                            </div>
                            <div>
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Sales Enterpise - Agri</span>
                                </div>
                                <div class="px-3 py-0">
                                    <div class="font-bold text-base mb-1 text-slate-900 dark:text-gray-400">4 Unit / 2 Unit</div>
                                    <div class="flex-none w-full max-w-full flex items-center">
                                        <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-700 dark:text-green-500">add</span>
                                        <span class="ml-0 text-sm text-green-700 dark:text-green-500">50%</span>
                                        <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Analis Chart --}}
    <div class="p-6 mt-6 border border-gray-200 bg-white rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
        <div class="grid grid-cols-1 mb-3 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white shadow-md border-b-4 border-green-500 rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Profit</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">Rp. {{ number_format($totalProfit, 0, ',', '.') }}</span>
                        </div>
                        <div class="px-3 flex items-center">
                            @if ($profitType == 'Keuntungan')
                                <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-700 dark:text-green-500">add</span>
                                <span class="ml-0 text-sm text-green-700 dark:text-green-500">{{ $percentage }}%</span>
                            @else
                                <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-red-700 dark:text-red-500">remove</span>
                                <span class="ml-0 text-sm text-red-700 dark:text-red-500">{{ $percentage }}%</span>
                            @endif
                            <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white hover:shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Drone Terjual</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">{{ $droneLaku }} Unit</span>
                        </div>
                        <div class="px-3 flex items-center">
                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-500 dark:text-green-400">add</span>
                            <span class="ml-0 text-sm text-green-500 dark:text-green-400">77%</span>
                            <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white hover:shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Konv. Penjualan</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">666</span>
                        </div>
                        <div class="px-3 flex items-center">
                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-green-500 dark:text-green-400">add</span>
                            <span class="ml-0 text-sm text-green-500 dark:text-green-400">77%</span>
                            <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white hover:shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Konv. Supply Second</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">666</span>
                        </div>
                        <div class="px-3 flex items-center">
                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-red-500 dark:text-red-400">remove</span>
                            <span class="ml-0 text-sm text-red-500 dark:text-red-400">77%</span>
                            <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
            <button type="button" class="flex flex-col h-auto min-w-0 break-words bg-white hover:shadow-md rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                <div class="flex-auto p-4">
                    <div class="flex flex-col -mx-3">
                        <div class="flex-none max-w-full px-3">
                            <span class="flex whitespace-nowrap text-gray-700 dark:text-white">Kerugian</span>
                        </div>
                        <div class="px-3 font-bold text-xl">
                            <span class="flex whitespace-nowrap text-slate-900 dark:text-gray-400">Rp. 2.500.000</span>
                        </div>
                        <div class="px-3 flex items-center">
                            <span class="material-symbols-outlined flex whitespace-nowrap text-sm text-red-500 dark:text-red-400">remove</span>
                            <span class="ml-0 text-sm text-red-500 dark:text-red-400">77%</span>
                            <span class="ml-1 text-sm dark:text-white">dari 30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </button>
        </div>
        {{-- Chart --}}
        <div class="bg-white p-2 border border-gray-200 shadow-md h-64 rounded-xl bg-clip-border dark:bg-gray-800 dark:border-gray-600" style="min-height: 385px;">
            <div id="analisa-profit-chart" style="height: 420;" class="w-full"></div>
        </div>
    </div>
@endsection