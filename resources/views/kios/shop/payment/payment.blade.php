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
                {{-- <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-52 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search. . .">
                </div>
                <div class="relative">
                    <button type="button" data-modal-target="add-payment-kios" data-modal-toggle="add-payment-kios" class="p-2 text-blue-700 border border-blue-700 hover:text-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-400 font-medium rounded-lg text-sm py-2.5 px-5 text-center dark:border-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Add Payment</button>
                </div> --}}
            </div>
        </div>
    </div>
    <div id="unpaid-kios" class="relative mt-6" style="display: block">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Order ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Supplier
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
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                {{ ($py->order_type == 'Baru') ? 'N.' . $py->order_id : 'S.' . $py->order_id }}
                            </th>
                            <td class="px-6 py-2">
                                {{ ($py->order_type == 'Baru') ? $py->order->supplier->nama_perusahaan : $py->ordersecond->customer->first_name ." ". $py->ordersecond->customer->last_name }}
                            </td>
                            <td class="px-6 py-2">
                                {{ \Carbon\Carbon::parse(($py->order_type == 'Baru') ? $py->order->created_at : '')->isoFormat('D MMMM YYYY') }}
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
                                <button id="dropdownReqPembayaranButton{{ $py->id }}" data-dropdown-toggle="dropdownReqPembayaran{{ $py->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Dropdown menu -->
                        <div id="dropdownReqPembayaran{{ $py->id }}" class="z-10 hidden bg-white rounded-lg shadow w-auto dark:bg-gray-700">
                            <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownReqPembayaranButton{{ $py->id }}">
                                <li>
                                    <button type="button" data-modal-target="view-belum-terbayar-{{ $py->id }}" data-modal-toggle="view-belum-terbayar-{{ $py->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">visibility</i>
                                        <span class="whitespace-nowrap">Detail Pembayaran</span>
                                    </button>
                                </li>
                                @if ($py->status == 'Unpaid')
                                    <li>
                                        <button type="button" data-modal-target="edit-pembayaran{{ $py->id }}" data-modal-toggle="edit-pembayaran{{ $py->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                            <i class="material-symbols-outlined text-base mr-3">edit</i>
                                            <span class="whitespace-nowrap">Edit Pembayaran</span>
                                        </button>
                                    </li>
                                    @if (!empty($py->metodepembayaran) || !empty($py->metodepembayaransecond))
                                        <li>
                                            <button type="button" data-modal-target="konfirmasi-pembayaran{{ $py->id }}" data-modal-toggle="konfirmasi-pembayaran{{ $py->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                                <i class="material-symbols-outlined text-base mr-3">task_alt</i>
                                                <span class="whitespace-nowrap">Konfirmasi Pembayaran</span>
                                            </button>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </div>
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

    <div id="done-payment-kios" class="relative mt-6" style="display: none">
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
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <th class="px-6 py-2">
                                {{ ($dpy->order_type == 'Baru') ? 'N.' . $dpy->order_id : 'S.' . $dpy->order_id }}
                            </th>
                            <td class="px-6 py-2">
                                {{ \Carbon\Carbon::parse(($dpy->order_type == 'Baru') ? $dpy->order->created_at : $dpy->ordersecond->tanggal_pembelian)->isoFormat('D MMMM YYYY') }}
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
                                <button id="dropdownDonePembayaranButton{{ $dpy->id }}" data-dropdown-toggle="dropdownDonePembayaran{{ $dpy->id }}" data-dropdown-placement="bottom" class="text-gray-500 border border-gray-300 font-bold rounded-lg text-sm p-2 w-32 text-start inline-flex items-center dark:text-gray-300 dark:border-gray-300" type="button">Atur <svg class="w-2.5 h-2.5 ms-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Dropdown menu -->
                        <div id="dropdownDonePembayaran{{ $dpy->id }}" class="z-10 hidden bg-white rounded-lg shadow w-auto dark:bg-gray-700">
                            <ul class="h-auto py-2 text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDonePembayaranButton{{ $dpy->id }}">
                                <li>
                                    <button type="button" data-modal-target="view-pembayaran{{ $dpy->id }}" data-modal-toggle="view-pembayaran{{ $dpy->id }}" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                        <i class="material-symbols-outlined text-base mr-3">visibility</i>
                                        <span class="whitespace-nowrap">Detail Pembayaran</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
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
    @include('kios.shop.payment.modal.view-payment')
    @include('kios.shop.payment.modal.validasi-payment')
    @include('kios.shop.payment.modal.edit-payment')
    @include('kios.shop.payment.modal.view-done-payment')

    <script>
        function toggleFormPayment(formId) {
            var forms = ['unpaid-kios', 'done-payment-kios'];
            var activeButtonId = formId === 'unpaid-kios' ? 'belum-bayar' : 'sudah-bayar';
            var inactiveButtonId = formId === 'unpaid-kios' ? 'sudah-bayar' : 'belum-bayar';

            forms.forEach(function (form) {
                document.getElementById(form).style.display = 'none';
            });

            document.getElementById(formId).style.display = 'block';

            document.getElementById(activeButtonId).classList.remove('text-rose-600');
            document.getElementById(activeButtonId).classList.add('text-white', 'bg-rose-700');

            document.getElementById(inactiveButtonId).classList.remove('text-white', 'bg-rose-700');
            document.getElementById(inactiveButtonId).classList.add('text-rose-600');
        }
    </script>

@endsection
