@extends('gudang.layouts.main')

@section('container')
    <div class="relative mt-2">
        <div class="flex items-center justify-between py-4">
            <div class="flex text-xl">
                <span class="text-gray-700 font-semibold dark:text-gray-300">List Pengiriman</span>
            </div>
            {{-- <div class="relative text-xl">
                <button type="button" data-modal-target="add-resi" data-modal-toggle="add-resi" class="flex text-indigo-600 hover:text-white border border-indigo-600 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-indigo-500 dark:text-indigo-500 dark:hover:text-white dark:hover:bg-indigo-500 dark:focus:ring-indigo-800">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="ml-2"> Add Resi</span>
                </button>
            </div> --}}
        </div>
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
    
    <div class="relative shadow-md sm:rounded-lg mt-2">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Order ID</th>
                    <th scope="col" class="px-6 py-3">Invoice</th>
                    <th scope="col" class="px-6 py-3">No Resi</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listPengiriman as $pengiriman)
                    <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                        <th class="px-6 py-2">
                            N.{{ $pengiriman->gudangBelanja->id }}
                        </th>
                        <td scope="row" class="px-6 py-2">
                            {{ $pengiriman->gudangBelanja->invoice }}
                        </td>
                        <td scope="row" class="px-6 py-2">
                            {{ $pengiriman->no_resi }}
                        </td>
                        <td class="px-6 py-2">
                            <span class="bg-teal-500 rounded-md px-2 py-0 text-white">{{ $pengiriman->status }}</span>
                        </td>
                        <td class="px-6 py-2">
                            <button id="dropdownPengiriman{{ $pengiriman->id }}" data-dropdown-toggle="dropdownP{{ $pengiriman->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">
                                Atur 
                                <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <div id="dropdownP{{ $pengiriman->id }}" class="z-10 hidden bg-white rounded-lg shadow w-48 dark:bg-gray-700">
                        <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownPengiriman{{ $pengiriman->id }}">
                            <li>
                                <button type="button" data-modal-target="detail-pengiriman-{{ $pengiriman->id }}" data-modal-toggle="detail-pengiriman-{{ $pengiriman->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                    <span class="material-symbols-outlined text-base mr-3">visibility</span>
                                    <span class="whitespace-nowrap">Detail</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" data-modal-target="create-resi-{{ $pengiriman->id }}" data-modal-toggle="create-resi-{{ $pengiriman->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                    <span class="material-symbols-outlined text-base mr-3">receipt_long</span>
                                    <span class="whitespace-nowrap">Add Resi</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Modal Input Resi --}}
    {{-- @include('gudang.purchasing.modal.add-resi') --}}
    @include('gudang.purchasing.modal.create-resi')
@endsection