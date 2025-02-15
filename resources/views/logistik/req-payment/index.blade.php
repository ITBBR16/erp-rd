@extends('logistik.layouts.main')

@section('container')
    <div class="border-b border-gray-400 py-3">
        <div class="flex text-3xl font-bold text-gray-700 dark:text-white">
            List Request Payment
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

    <form action="{{ route('req-payment.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-3 gap-4 mt-6">
            <div class="col-span-2 flex flex-col gap-6 h-fit">
                {{-- List Table --}}
                <div class="rounded-lg shadow-md border bg-white p-4">
                    <div class="flex mb-4 items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">
                                Data List Resi
                            </p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="overflow-y-auto max-h-[200px] border rounded-lg shadow-md">
                            <table class="w-full text-xs text-left text-gray-500 dark:text-gray-400">
                                <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            No Resi
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Ekspedisi
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Jenis Layanan
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Tanggal Pickup
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataRequest as $data)
                                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                            <th class="px-6 py-2">
                                                {{ $data->no_resi }}
                                            </th>
                                            <td class="px-6 py-2">
                                                {{ $data->layananEkspedisi->ekspedisi->ekspedisi }}
                                            </td>
                                            <td class="px-6 py-2">
                                                {{ $data->layananEkspedisi->nama_layanan }}
                                            </td>
                                            <td class="px-6 py-2">
                                                {{ \Carbon\Carbon::parse($data->tanggal_pickup)->isoFormat('D MMMM YYYY') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    
                {{-- Input Request Payment --}}
                <div class="rounded-lg shadow-md border bg-white p-4 h-fit">
                    <div class="flex mb-4 items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">
                                Data Request Payment
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-4 text-center mb-4 justify-center" style="grid-template-columns: 3fr 5fr 2fr 2fr">
                        <div class="text-start pr-6">
                            <label for="payment-ekspedisi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Ekspedisi :</label>
                        </div>
                        <div class="text-start">
                            <select name="ekspedisi_id" id="payment-ekspedisi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Ekspedisi</option>
                                @foreach ($ekspedisis as $ekspedisi)
                                    <option value="{{ $ekspedisi->id }}">{{ $ekspedisi->ekspedisi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-center">
                            <label class="inline-flex items-center me-5 cursor-pointer">
                                <input type="checkbox" name="check_box_ongkir" id="checkbox-input-ongkir" value="Ongkir" class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600 dark:peer-checked:bg-teal-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Ongkir</span>
                            </label>
                        </div>
                        <div class="flex">
                            <label class="inline-flex items-center me-5 cursor-pointer">
                                <input type="checkbox" name="check_box_packing" id="checkbox-input-packing" value="Packing" class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-500 dark:peer-checked:bg-orange-500"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Packing</span>
                            </label>
                        </div>
                    </div>
    
                    {{-- Form Data Request Payment --}}
                    <div id="table-form-request-payment" class="relative">
                        <div class="overflow-y-auto max-h-[420px] border rounded-lg shadow-md">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th scope="col" class="p-4" style="width: 1%">
                                            <div class="flex items-center">
                                                <input id="checkbox-all-req-payment" type="checkbox" class="checkbox-all-req-payment w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all-req-payment" class="sr-only">checkbox all</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="width: 19%">
                                            No Resi
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="width: 14%">
                                            Nominal Ongkir
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="width: 14%">
                                            Nominal Packing
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="width: 12%">
                                            Nominal Asuransi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="container-request-payment">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
    
                </div>
            </div>
            <div class="flex flex-col gap-6 w-fit h-fit mx-auto">
                <div class="rounded-lg shadow-md border bg-white p-4">
                    <div class="flex mb-4 items-center justify-between">
                        <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">
                                Resume Tagihan
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Nilai Ongkir :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="resume-ongkir" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Nilai Packing :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="resume-packing" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Nilai Asuransi :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="resume-asuransi" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex justify-start">
                            <p class="font-semibold text-gray-900 dark:text-white">Biaya Lain Lain :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="resume-biaya-lain-lain" class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                    <div class="py-2 items-center border-b-2"></div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex justify-start">
                            <p class="font-bold text-lg text-purple-600 dark:text-white">Nilai Total :</p>
                        </div>
                        <div class="flex justify-end ml-auto">
                            <p id="resume-nilai-total" class="text-purple-600 text-lg font-bold dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg shadow-md border bg-white p-4">
                    <div class="flex mb-4 items-center min-w-full border-b justify-between">
                        <div class="flex justify-start pb-4 border-gray-300">
                            <p class="text-lg font-semibold text-black dark:text-white">
                                Input Tagihan
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1 text-start pr-6">
                            <label for="payment-nama-akun" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Akun Bank :</label>
                        </div>
                        <div class="col-span-2 text-start">
                            <select name="payment_ekspedisi" id="payment-nama-akun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Akun Bank</option>
                                @foreach ($daftarAkun as $akun)
                                    <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-1 text-start pr-6">
                            <label for="biaya-lain-lain" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Biaya Lain Lain :</label>
                        </div>
                        <div class="col-span-2 text-start">
                            <input type="text" name="biaya_lain_lain" id="biaya-lain-lain" class="format-angka-logistik rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                        </div>
                        <div class="col-span-1 text-start pr-6">
                            <label for="invoice-logistik" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Invoice :</label>
                        </div>
                        <div class="col-span-2 text-start">
                            <input type="text" name="invoice_logistik" id="invoice-logistik" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="SO/R/2025/02/47685">
                        </div>
                        <div class="col-span-1 text-start pr-6">
                            <label for="file-bukti-transaksi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Bukti Files :</label>
                        </div>
                        <div class="col-span-2 text-start">
                            <label 
                                for="file-bukti-transaksi" 
                                id="file-label" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                No file chosen
                            </label>
                            <input 
                                type="file" 
                                name="file_bukti_transaksi[]" 
                                id="file-bukti-transaksi" 
                                class="hidden"
                                onchange="updateFileName(this)"
                                multiple
                                required>
                        </div>
                        <div class="col-span-1 text-start pr-6">
                            <label for="keterangan-payment" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan :</label>
                        </div>
                        <div class="col-span-2 text-start">
                            <textarea name="keterangan_payment" id="keterangan-payment" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Keterangan untuk finance . . ." required></textarea>
                        </div>
                    </div>
                </div>
                <div>
                    <button id="btn-req-payment-logistik" type="submit" class="submit-button-form cursor-not-allowed text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-bold rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800 w-full mx-auto" disabled>Submit</button>
                    <div class="loader-button-form" style="display: none">
                        <button class="cursor-not-allowed text-white border border-purple-700 bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-purple-500 dark:text-white dark:bg-purple-500 dark:focus:ring-purple-800 w-full mx-auto" disabled>
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            Loading . . .
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function updateFileName(input) {
            const files = input.files;
            const label = input.previousElementSibling;
            
            if (files.length > 0) {
                const fileNames = Array.from(files).map(file => file.name).join(", ");
                label.textContent = fileNames;
            } else {
                label.textContent = "No file chosen";
            }
        }
    </script>
@endsection