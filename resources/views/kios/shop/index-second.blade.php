@extends('kios.layouts.main')
@extends($sidebarLayout)

@section('container')
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="shopSecondTabs" data-tabs-toggle="#shopSecondTabsContent" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dsbl-tab" data-tabs-target="#dsbl" type="button" role="tab" aria-controls="dsbl" aria-selected="false">Detail Belanja</button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="second-product-tab" data-tabs-target="#second-product" type="button" role="tab" aria-controls="second-product" aria-selected="false">Belanja Product Second</button>
            </li>
        </ul>
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

    @if (session()->has('error'))
        <div id="alert-failed-input" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
            <span class="material-symbols-outlined flex-shrink-0 w-5 h-5">info</span>
            <div class="ml-3 text-sm font-medium">
                {{ session('error') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-failed-input" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <div class="shopSecondTabsContent">
        @include('kios.shop.tabs.detail-second')
        @include('kios.shop.tabs.second-belanja')
    </div>

@endsection
