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

    <div class="grid grid-cols-3 gap-4 mt-6">
        <div class="col-span-2 rounded-lg shadow-md border bg-white p-4 h-fit">
            <div class="flex mb-4 items-center justify-between">
                <div class="flex justify-start min-w-full pb-4 border-b border-gray-300">
                    <p class="text-lg font-semibold text-black dark:text-white">
                        Data List Resi
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="relative">
                    <div class="overflow-y-auto max-h-[650px] border rounded-lg shadow-md">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal Pickup
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
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                                    <th class="px-6 py-2">
                                        {{-- {{ \Carbon\Carbon::parse($data->tanggal_request)->isoFormat('D MMMM YYYY') }} --}}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4 w-fit h-fit">
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
                        <p class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex justify-start">
                        <p class="font-semibold text-gray-900 dark:text-white">Nilai Packing :</p>
                    </div>
                    <div class="flex justify-end ml-auto">
                        <p class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex justify-start">
                        <p class="font-semibold text-gray-900 dark:text-white">Nilai Asuransi :</p>
                    </div>
                    <div class="flex justify-end ml-auto">
                        <p class="text-gray-900 font-normal dark:text-white">Rp. 0</p>
                    </div>
                </div>
                <div class="py-2 items-center border-b-2"></div>
                <div class="flex items-center justify-between mt-2">
                    <div class="flex justify-start">
                        <p class="font-bold text-lg text-purple-600 dark:text-white">Nilai Total :</p>
                    </div>
                    <div class="flex justify-end ml-auto">
                        <p class="text-purple-600 text-lg font-bold dark:text-white">Rp. 0</p>
                    </div>
                </div>
            </div>
            <div class="rounded-lg shadow-md border bg-white p-4">
                
            </div>
            <div>
                <button type="submit" class="submit-button-form text-white mt-4 bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-bold rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800 w-80 mx-auto">Submit</button>
                <div class="loader-button-form" style="display: none">
                    <button class="cursor-not-allowed text-white border border-purple-700 bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-purple-500 dark:text-white dark:bg-purple-500 dark:focus:ring-purple-800" disabled>
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
@endsection