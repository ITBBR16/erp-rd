@extends('repair.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("case-list.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">list_alt</span>
                    Input New Case
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Ubah Data {{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }}-{{ $dataCase->customer->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

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

    <form action="#" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-2 gap-8">
            {{-- Form Data Customer --}}
            <div>
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Customer : </h3>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-customer" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Customer :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="case_customer" id="case-customer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required readonly>
                            <option value="" hidden>Select Customer</option>
                            <option value="{{ $dataCase->customer->id }}" selected>{{ $dataCase->customer->first_name }} {{ $dataCase->customer->last_name }} - {{ $dataCase->customer->id }}</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-jenis-drone" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="case_jenis_drone" id="case-jenis-drone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Jenis Drone</option>
                            @foreach ($jenisDrone as $drone)
                                @if ($dataCase->produk_jenis_id == $drone->id)
                                    <option value="{{ $drone->id }}" selected>{{ $drone->jenis_produk }}</option>
                                @else
                                    <option value="{{ $drone->id }}">{{ $drone->jenis_produk }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-fungsional" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Fungsional Drone :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="case_fungsional" id="case-fungsional" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Fungsional Drone</option>
                            @foreach ($fungsionalDrone as $fungsional)
                                @if ($fungsional->id == $dataCase->jenis_fungsional_id)
                                    <option value="{{ $fungsional->id }}" selected>{{ $fungsional->jenis_fungsional }}</option>
                                @else
                                    <option value="{{ $fungsional->id }}">{{ $fungsional->jenis_fungsional }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-jenis" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Case :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="case_jenis" id="case-jenis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Jenis Case</option>
                            @foreach ($jenisCase as $jc)
                            @if ($jc->id == $dataCase->jenis_case_id)
                                <option value="{{ $jc->id }}" selected>{{ $jc->jenis_case }}</option>
                            @else
                                <option value="{{ $jc->id }}">{{ $jc->jenis_case }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- Form Kronologi --}}
            <div>
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Kronologi : </h3>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-keluhan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keluhan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="case_keluhan" id="case-keluhan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCase->keluhan }}">
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-kronologi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kronologi Kerusakan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="case_kronologi" id="case-kronologi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ $dataCase->kronologi_kerusakan }}">
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-penggunaan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Penggunaan After Crash :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="case_penggunaan" id="case-penggunaan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" {{ $dataCase->penanganan_after_crash }}>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="case-riwayat" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Riwayat Penggunaan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="case_riwayat" id="case-riwayat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" {{ $dataCase->riwayat_penggunaan }}>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4 border-t-2 border-gray-400 pt-2">
            <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Kelengkapan</h3>
        </div>
        {{-- Form Data Kelengkapan --}}
        <div id="container-data-kelengkapan-case">
            @foreach ($dataCase->detailKelengkapan as $index => $item)
            <div id="form-data-kelengkapan-case-{{ $index }}" class="grid grid-cols-4 gap-4 mt-5">
                    <div>
                        <label for="case-kelengkapan-{{ $index }}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelengkapan :</label>
                        <select name="case_kelengkapan[]" id="case-kelengkapan-{{ $index }}" class="dd-kelengkapan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Kelengkapan</option>
                            @foreach ($dataCase->jenisProduk->kelengkapans as $kelengkapan)
                                @if ($item->item_kelengkapan_id == $kelengkapan->id)
                                    <option value="{{ $kelengkapan->id }}" selected>{{ $kelengkapan->kelengkapan }}</option>
                                @else
                                    <option value="{{ $kelengkapan->id }}">{{ $kelengkapan->kelengkapan }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="case-quantity-{{ $index }}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                        <input type="text" name="case_quantity[]" id="case-quantity-{{ $index }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" oninput="this.value = this.value.replace(/\D/g, '')" value="{{ $item->quantity }}" required>
                    </div>
                    <div>
                        <label for="case-sn-{{ $index }}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number : </label>
                        <input type="text" name="case_sn[]" id="case-sn-{{ $index }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $item->serial_number }}">
                    </div>
                    <div class="grid grid-cols-2" style="grid-template-columns: 5fr 1fr">
                        <div>
                            <label for="case-keterangan-{{ $index }}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan : </label>
                            <input type="text" name="case_keterangan[]" id="case-keterangan-{{ $index }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $item->keterangan }}">
                        </div>
                        <div class="flex justify-center items-end pb-2">
                            <button type="button" class="remove-form-dkcs" data-id="{{ $index }}">
                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex justify-start text-red-500 mt-6">
            <div class="flex cursor-pointer my-2 hover:text-rose-700">
                <button type="button" id="add-kelengkapan-case" class="flex flex-row justify-between gap-2">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span>Tambah Kelengkapan</span>
                </button>
            </div>
        </div>
        <div class="mt-6 text-end">
            <button type="submit" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
            <div class="loader-button-form" style="display: none">
                <button class="cursor-not-allowed text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    Loading . . .
                </button>
            </div>
        </div>
    </form>

@endsection