@extends('gudang.layouts.main')

@section('container')
    <div class="grid grid-cols-2 gap-8 mb-8">
        <div class="flex text-3xl font-bold text-gray-700">
            Dashboard
        </div>
    </div>
    <div class="border border-gray-300 rounded-lg p-4 overflow-hidden my-2">
        <div class="text-gray-500 font-semibold text-lg mb-4">Status</div>
        <div class="grid grid-cols-4 gap-4 w-full">
            <div class="px-4 border-r">
                <div class="py-4">
                    <div class="flex flex-nowrap items-center">
                        <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">Total
                            <button data-popover-target="popover-description" data-popover-placement="bottom-start" type="button">
                                <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Show Information</span>
                            </button>
                        </p>
                        <div datapopover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-64 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                            <div class="p-2 space-y-2">
                                <p>Total Deskripsi</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="my-1 text-2xl whitespace-nowrap font-semibold">
                            <p>66</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 border-r">
                <div class="py-4">
                    <div class="flex flex-nowrap items-center">
                        <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">Battery
                            <button data-popover-target="popover-description-battery" data-popover-placement="bottom-start" type="button">
                                <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Show Information</span>
                            </button>
                        </p>
                        <div datapopover id="popover-description-battery" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-64 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                            <div class="p-2 space-y-2">
                                <p>Battery Deskripsi</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="my-1 text-lg whitespace-nowrap font-semibold">
                            <p>66</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-pink-300 h-2.5 rounded-full" style="width: 66%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 border-r">
                <div class="py-4">
                    <div class="flex flex-nowrap items-center">
                        <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">Kios
                            <button data-popover-target="popover-description-kios" data-popover-placement="bottom-start" type="button">
                                <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Show Information</span>
                            </button>
                        </p>
                        <div datapopover id="popover-description-kios" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-64 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                            <div class="p-2 space-y-2">
                                <p>Kios Deskripsi</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="my-1 text-lg whitespace-nowrap font-semibold">
                            <p>66</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-300 h-2.5 rounded-full" style="width: 66%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <div class="py-4">
                    <div class="flex flex-nowrap items-center">
                        <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">Repair
                            <button data-popover-target="popover-description-repair" data-popover-placement="bottom-start" type="button">
                                <svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Show Information</span>
                            </button>
                        </p>
                        <div datapopover id="popover-description-repair" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-64 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                            <div class="p-2 space-y-2">
                                <p>Repair Deskripsi</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="my-1 text-lg whitespace-nowrap font-semibold">
                            <p>66</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-yellow-300 h-2.5 rounded-full" style="width: 66%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection