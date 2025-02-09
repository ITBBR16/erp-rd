@extends('logistik.layouts.main')

@section('container')

    <div class="grid grid-cols-2 gap-8 mb-8 border-b border-gray-400 py-3">
        <div class="flex text-3xl font-bold text-gray-700 dark:text-gray-300">
            List Unpicked & No Resi
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

    <div class="grid grid-cols-2 gap-x-6 gap-y-4">
        {{-- List --}}
        <div class="relative">
            <div class="overflow-y-auto max-h-[650px] border rounded-lg shadow-md">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Tanggal Pickup
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Divisi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Customer
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ekspedisi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jenis Layanan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataRequest as $data)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                <th class="px-6 py-2">
                                    {{ \Carbon\Carbon::parse($data->tanggal_request)->isoFormat('D MMMM YYYY') }}
                                </th>
                                <td class="px-6 py-2">
                                    {{ $data->divisi->nama }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $data->customer->first_name }} {{ $data->customer->last_name ?? '' }} - {{ $data->customer->id }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $data->layananEkspedisi->ekspedisi->ekspedisi }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $data->layananEkspedisi->nama_layanan }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 ">
                {{-- {{ $dataCustomer->links() }} --}}
            </div>
        </div>

        {{-- Form --}}
        <div class="relative">
            <div class="mb-4 pb-2">
                <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Form Pick Up / Input No Resi : </h3>
            </div>
            <div class="grid grid-cols-4 mb-4" style="grid-template-columns: 3fr 5fr 3fr 5fr">
                <div class="text-end pr-3">
                    <label for="option-jenis-form" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Jenis Form :</label>
                </div>
                <div class="text-start">
                    <select name="case_fungsional" id="option-jenis-form" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Form</option>
                        <option value="form-pickup">Form Pickup 📦</option>
                        <option value="form-input-resi">Form Input Resi 📄</option>
                    </select>
                </div>
                <div class="text-end pr-3">
                    <label for="option-ekspedisi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Ekspedisi :</label>
                </div>
                <div class="text-start">
                    <select name="case_fungsional" id="option-ekspedisi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Ekspedisi</option>
                    </select>
                </div>
            </div>

            {{-- Form Pickup --}}
            <div class="relative" style="display: none">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-pickup" type="checkbox" class="check-all-pickup w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-pickup" class="sr-only">checkbox all</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Customer 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Layanan Ekspedisi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="container-pickup-logistik">
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="checkbox_select_pickup[]" id="checkbox-pickup" value="" class="check-data-pickup w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" value="">
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                
                            </td>
                            <td class="px-6 py-2">
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Form Input Resi --}}
            <div class="relative">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="p-4" style="width: 1%">
                                <div class="flex items-center">
                                    <input id="checkbox-all-resi" type="checkbox" class="check-all-pickup w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-resi" class="sr-only">checkbox all</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Customer 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                No Resi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nominal Ongkir
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nominal Packing
                            </th>
                        </tr>
                    </thead>
                    <tbody id="container-pickup-logistik">
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="checkbox_select_pickup[]" id="checkbox-pickup" value="" class="check-data-pickup w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" value="">
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                adasdasdasdasdasdasdas
                            </td>
                            <td class="px-6 py-2">
                                asdasdasdasdasd
                            </td>
                            <td class="px-6 py-2">
                                asdasdasdasdasdasd
                            </td>
                            <td class="px-6 py-2">
                                asdasdasdasdasdas
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection