@extends('kios.layouts.main')

@section('container')
    <div class="grid grid-cols-2 gap-8 mb-8 border-b border-gray-400 py-3">
        <div class="flex text-3xl font-bold text-gray-700 dark:text-gray-300">
            Detail Customer
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

    <div class="relative overflow-x-auto mt-6">
        <div class="flex items-center justify-between py-4">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="customer-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search. . .">
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Customer
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No Telpon
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Alamat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Created At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataCustomer as $key => $dc)
                    <tr id="customerRow_{{ $dc->id }}" class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600 customer-row">
                        <td class="px-6 py-2">
                            {{ $dataCustomer->firstItem() + $key }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $dc->first_name }} {{ $dc->last_name }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $dc->no_telpon }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $dc->nama_jalan }}
                        </td>
                        <td class="px-6 py-2">
                            {{ $dc->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-2">
                            <div class="flex flex-wrap">
                                <button type="button" data-modal-target="view-customer{{ $dc->id }}" data-modal-toggle="view-customer{{ $dc->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                    <i class="material-symbols-outlined text-base">visibility</i>
                                </button>
                                @if (auth()->user()->is_admin === 1 || auth()->user()->is_admin === 2)
                                    <button type="button" data-modal-target="update-customer{{ $dc->id }}" data-modal-toggle="update-customer{{ $dc->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base">edit</i>
                                    </button>
                                    <button type="button" data-modal-target="delete-customer{{ $dc->id }}" data-modal-toggle="delete-customer{{ $dc->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base">delete</i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 ">
            {{ $dataCustomer->links() }}
        </div>
    </div>

    <div id="dataNotFound" class="hidden p-4">
        <div class="flex items-center justify-center">
            <figure class="max-w-lg">
                <img class="h-auto max-w-full rounded-lg" src="/img/not-found.png" alt="Not Found">
                <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Data Not Found</figcaption>
            </figure>
        </div>
    </div>

    {{-- Modal --}}
    @include('customer.main.modal.delete-modal')
    @include('customer.main.modal.edit-modal')
    @include('customer.main.modal.view-modal')

@endsection