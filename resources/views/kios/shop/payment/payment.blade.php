@extends('kios.layouts.main')

@section('container')
    <div class="flex text-3xl font-bold mb-8 text-gray-700 border-b border-gray-400 py-3 dark:text-gray-300">
        <span>Pembayaran</span>
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
    <div class="flex flex-nowrap relative overflow-x-auto">
        <div class="flex flex-row justify-between w-full">
            <div class="flex flex-row gap-6">
                <div class="relative">
                    <button id="belum-bayar" onclick="toggleFormPayment('unpaid-kios')" type="button" class="text-white bg-rose-700 border border-rose-600 hover:text-white hover:bg-rose-700 font-medium rounded-xl text-base py-1.5 px-5 text-center">Belum Terbayar</button>
                </div>
                <div class="relative">
                    <button id="sudah-bayar" onclick="toggleFormPayment('done-payment-kios')" type="button" class="text-rose-600 border border-rose-600 hover:text-white hover:bg-rose-700 font-medium rounded-xl text-base py-1.5 px-5 text-center">Sudah Terbayar</button>
                </div>
            </div>
            <div class="flex flex-row gap-6">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search. . .">
                </div>
                {{-- <div class="relative">
                    <button type="button" data-modal-target="add-payment-kios" data-modal-toggle="add-payment-kios" class="p-2 text-blue-700 border border-blue-700 hover:text-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-400 font-medium rounded-lg text-sm py-2.5 px-5 text-center dark:border-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Add Payment</button>
                </div> --}}
            </div>
        </div>
    </div>
    <div id="unpaid-kios" class="relative overflow-x-auto mt-6" style="display: block">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Order ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Belanja
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Pembayaran
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nominal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payment as $py)
                    @if ($py->status == 'Unpaid' || $py->status == 'Waiting For Payment')
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                N.{{ $py->order_id }}
                            </th>
                            <td class="px-6 py-2">
                                {{ \Carbon\Carbon::parse($py->order->tanggal_pembelian)->isoFormat('D MMMM YYYY') }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $py->jenis_pembayaran }}
                            </td>
                            <td class="px-6 py-2">
                                @php
                                    $totalNilai = $py->nilai + $py->ongkir + $py->pajak;
                                @endphp
                                Rp. {{ number_format($totalNilai, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-2">
                                <span class="bg-orange-400 rounded-md px-2 py-0 text-white">{{ $py->status }}</span>
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex flex-wrap">
                                    @if ($py->status != 'Waiting For Payment')
                                        <button type="button" data-modal-target="konfirmasi-pembayaran{{ $py->id }}" data-modal-toggle="konfirmasi-pembayaran{{ $py->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                            <i class="material-symbols-outlined text-base">task_alt</i>
                                        </button>
                                        <button type="button" data-modal-target="edit-pembayaran{{ $py->id }}" data-modal-toggle="edit-pembayaran{{ $py->id }}" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                            <i class="material-symbols-outlined text-base">edit</i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        @if (!$payment->contains('status', 'Unpaid') && !$payment->contains('status', 'Waiting For Payment'))
            <div class="p-4">
                <div class="flex items-center justify-center">
                    <figure class="max-w-lg">
                        <img class="h-auto max-w-full rounded-lg" src="/img/empty-cart.png" alt="Not Found" width="250" height="150">
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Empty Order Payment</figcaption>
                    </figure>
                </div>
            </div>
        @endif
        <div class="mt-4 ">
            {{-- {{ $dataCustomer->links() }} --}}
        </div>
    </div>

    <div id="done-payment-kios" class="relative overflow-x-auto mt-6" style="display: none">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Order ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Belanja
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Pembayaran
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nominal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payment as $dpy)
                    @if ($dpy->status == 'Paid')
                        <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                K.{{ $dpy->order_id }}
                            </th>
                            <td class="px-6 py-2">
                                {{ \Carbon\Carbon::parse($dpy->order->tanggal_pembelian)->isoFormat('D MMMM YYYY') }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $dpy->jenis_pembayaran }}
                            </td>
                            <td class="px-6 py-2">
                                @php
                                    $totalNilai = $dpy->nilai + $dpy->ongkir + $dpy->pajak;
                                @endphp
                                Rp. {{ number_format($totalNilai, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-2">
                                <span class="bg-green-400 rounded-md px-2 py-0 text-white">{{ $dpy->status }}</span>
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex flex-wrap">
                                    <button type="button" class="text-gray-400 hover:text-gray-800 mx-2 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base">visibility</i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        @if (!$payment->contains('status', 'Paid'))
            <div class="p-4">
                <div class="flex items-center justify-center">
                    <figure class="max-w-lg">
                        <img class="h-auto max-w-full rounded-lg" src="/img/empty-cart.png" alt="Not Found" width="250" height="150">
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Empty Order Payment</figcaption>
                    </figure>
                </div>
            </div>
        @endif
        <div class="mt-4 ">
            {{-- {{ $dataCustomer->links() }} --}}
        </div>
    </div>

    {{-- Modal --}}
    {{-- @include('kios.shop.payment.modal.add-payment') --}}
    @include('kios.shop.payment.modal.validasi-payment')
    @include('kios.shop.payment.modal.edit-payment')

@endsection
