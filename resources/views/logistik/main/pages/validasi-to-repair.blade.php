@extends('logistik.layouts.main')

@section('container')
    <nav class="flex">
        <ol class="inline-flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse">
            <li class="flex items-center">
                <a href="{{ route("sent-to-rapair.index") }}" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <span class="material-symbols-outlined text-base mr-2.5">forward</span>
                    Sent To Repair
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Validasi Data {{ $dataCustomer->nama_lengkap }}</span>
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

    <form action="{{ route('sent-to-rapair.update', $dataCustomer->no_register) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-8 mt-6">
            <input type="hidden" name="str_keluhan" value="{{ $dataCustomer->keluhan }}">
            <input type="hidden" name="str_kronologi" value="{{ $dataCustomer->kronologi_kerusakan }}">
            <input type="hidden" name="str_penggunaan" value="{{ $dataCustomer->penanganan_after_crash }}">
            <input type="hidden" name="str_riwayat" value="{{ $dataCustomer->riwayat_penggunaan }}">
            <input type="hidden" name="link_files" value="{{ $dataCustomer->dokumen_customer }}">
            {{-- Form Data Customer Awal --}}
            <div>
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Customer Awal : </h3>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-nama-customer" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Customer :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-nama-customer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->nama_lengkap ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-no-telpon" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">No Telpon :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-no-telpon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->no_wa ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-email" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Email :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="email" id="awal-email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->email ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-provinsi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Provinsi :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-provinsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->provinsi ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-kota-kabupaten" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kota / Kabupaten :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-kota-kabupaten" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->kabupaten_kota ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-kecamatan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kecamatan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-kecamatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->kecamatan ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-kelurahan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelurahan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-kelurahan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->kelurahan ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-kode-pos" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pos :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-kode-pos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->kode_pos ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-alamat" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Alamat :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-alamat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->alamat ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-jenis-drone" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-jenis-drone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->tipe_produk ?? "-" }}" disabled>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="awal-fungsional" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Fungsional :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="awal-fungsional" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" value="{{ $dataCustomer->fungsional_produk ?? "-" }}" disabled>
                    </div>
                </div>
            </div>
            {{-- Form Data Customer Koreksi --}}
            <div>
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Customer Koreksi : </h3>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="first-name" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Customer :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <input type="text" name="first_name" id="first-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="First Name" required>
                            </div>
                            <div>
                                <input type="text" name="last_name" id="last-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="no-telpon" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">No Telpon :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="no_telpon" id="no-telpon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="6285123456789" oninput="this.value = this.value.replace(/\D/g, '')" required>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="email" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Email :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ujang@gmail.com">
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="provinsi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Provinsi :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="provinsi" id="provinsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Provinsi</option>
                            @foreach ($dataProvinsi as $provinsi)
                                <option value="{{ $provinsi->id }}" class="bg-white dark:bg-gray-700">{{ $provinsi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="kota-kabupaten" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kota / Kabupaten :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="kota_kabupaten" id="kota-kabupaten" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden></option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="kecamatan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kecamatan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="kecamatan" id="kecamatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" hidden></option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="kelurahan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelurahan :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="kelurahan" id="kelurahan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" hidden></option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="kode-pos" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pos :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="kode_pos" id="kode-pos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="65139" oninput="this.value = this.value.replace(/\D/g, '')">
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="nama-jalan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Alamat :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="nama_jalan" id="nama-jalan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Alamat Customer">
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="nama-jalan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone</label>
                    </div>
                    <div x-data="dropdownJenisDrone()" class="relative col-span-2 text-start">
                        <div class="relative">
                            <input x-model="search"
                                @focus="open = true" 
                                @keydown.escape="open = false" 
                                @click.outside="open = false"
                                type="text" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="Search or select jenis drone...">
                                <svg :class="{ 'rotate-180': open }" class="absolute inset-y-0 right-2 top-2.5 w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            <input type="hidden" id="str-jenis-drone" name="str_jenis_drone" :value="selected" required>
                        </div>
                    
                        <ul x-show="open" 
                            x-transition 
                            class="absolute z-10 bg-white border border-gray-300 rounded-lg mt-1 max-h-60 w-full overflow-y-auto shadow-md dark:bg-gray-700 dark:border-gray-600">
                            <template x-for="jenis in filteredJenis" :key="jenis.id">
                                <li @click="select(jenis.id, jenis.display)"
                                    class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white">
                                    <span x-text="jenis.display" class="text-black dark:text-white"></span>
                                </li>
                            </template>
                            <li x-show="filteredJenis.length === 0" 
                                class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                Data Jenis Drone tidak ditemukan.
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-3 mb-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="str-fungsional" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Fungsional :</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <select name="str_fungsional" id="str-fungsional" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Fungsional Drone</option>
                            @foreach ($fungsionalDrone as $fungsional)
                                <option value="{{ $fungsional->id }}">{{ $fungsional->jenis_fungsional }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4 border-t-2 border-gray-400 pt-2">
            <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Kelengkapan</h3>
        </div>
        {{-- Form Data Kelengkapan --}}
        <div id="container-data-kelengkapan-str">
            <div id="form-data-kelengkapan-str" class="grid grid-cols-4 gap-4 mt-5">
                <div>
                    <label for="str-kelengkapan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelengkapan :</label>
                    <select name="str_kelengkapan[]" id="str-kelengkapan" class="dd-kelengkapan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Select Kelengkapan</option>
                    </select>
                </div>
                <div>
                    <label for="str-quantity" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                    <input type="text" name="str_quantity[]" id="str-quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" oninput="this.value = this.value.replace(/\D/g, '')" required>
                </div>
                <div>
                    <label for="str-sn" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number : </label>
                    <input type="text" name="str_sn[]" id="str-sn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                </div>
                <div class="grid grid-cols-2" style="grid-template-columns: 5fr 1fr">
                    <div>
                        <label for="str-keterangan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan : </label>
                        <input type="text" name="str_keterangan[]" id="str-keterangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                    </div>
                    {{-- <div class="flex justify-center items-end pb-2">
                        <button type="button" class="remove-form-dkcs" data-id="">
                            <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="flex justify-start text-red-500 mt-6">
            <div class="flex cursor-pointer my-2 hover:text-rose-700">
                <button type="button" id="add-kelengkapan-str" class="flex flex-row justify-between gap-2">
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

    {{-- Search Select Function --}}
    <script>
        function dropdownJenisDrone() {
            return {
                open: false,
                search: '',
                selected: '',
                jenis: Object.values(@json($jenisDrone)),
                filteredJenis: [],
                debounceSearch: null,
                init() {
                    if (!Array.isArray(this.jenis)) {
                        this.customers = [];
                    }
                    this.filteredJenis = this.jenis;
                    this.$watch('search', (value) => {
                        clearTimeout(this.debounceSearch);
                        this.debounceSearch = setTimeout(() => {
                            this.filteredJenis = this.jenis.filter(jenis =>
                                jenis.display.toLowerCase().includes(value.toLowerCase())
                            );
                        }, 300);
                    });
                },
                select(id, display) {
                    this.selected = id;
                    this.search = display;
                    this.open = false;
                    
                    // Emit event
                    const event = new CustomEvent('jenis-drone-changed', {
                        detail: { id: this.selected },
                    });
                    document.dispatchEvent(event);
                }
            }
        }
    </script>

@endsection