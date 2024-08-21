<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }} | RD</title>
        <link rel="icon" href="{{ asset('/img/RD Tab Icon.png') }}" sizes="16x16 32x32" type="image/png">
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
</head>
<body class="bg-gray-1000 flex items-center justify-center min-h-screen">

    <div class="bg-white my-20 p-8 rounded-lg text-center border shadow-lg max-w-4xl lg:w-3/4">

        <form action="{{ route('review-customer.store') }}" method="POST" autocomplete="off">
            @csrf

            <input type="text" value="{{ $noTelpon }}">
            <div class="border-b-2">
                <div class="border rounded-full p-2 absolute inset-x-0 -translate-y-20 bg-white mx-auto w-20">
                    <img src="{{ asset('/img/RD Tab Icon.png') }}" alt="Logo RD">
                </div>

                @if (session()->has('success'))
                    <div id="alert-success-input" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
                        <span class="material-symbols-outlined flex-shrink-0 w-4 h-4">task_alt</span>
                        <div class="ml-3 mt-1 text-sm font-medium">
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
                        <div class="ml-3 mt-1 text-sm font-medium">
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

                <div class="my-4">
                    <h1 class="text-xl font-bold">INI JUDUL</h1>
                    <p class="text-gray-500">Ini nanti deskripsinya gatau apa yang mau ditulis disini nanti</p>
                </div>
            </div>
            
            <input type="hidden" name="rating_tingkat_ps" id="tingkat-ps-rating" value="0">
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Tingkat problem solved yang kami lakukan</h3>
                <div class="grid grid-cols-3 mx-10 items-center justify-center my-4 space-x-2">
                    <div class="text-end">
                        <span class="text-gray-600 text-sm mt-2">Tidak Puas</span>
                    </div>
                    <div class="flex items-center justify-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg
                                id="tingkat-ps-star-{{ $i }}"
                                onclick="rate('tingkat-ps', {{ $i }})"
                                class="w-6 h-6 text-gray-300 hover:text-black cursor-pointer fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-start">
                        <span class="text-gray-600 text-sm mt-2">Sangat Puas</span>
                    </div>
                </div>
            </div>
    
            <input type="hidden" name="rating_kecepatan_respon" id="kecepatan-respon-rating" value="0">
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Tingkat kecepantan respon kami</h3>
                <div class="grid grid-cols-3 mx-10 items-center justify-center my-4 space-x-2">
                    <div class="text-end">
                        <span class="text-gray-600 text-sm mt-2">Tidak Puas</span>
                    </div>
                    <div class="flex items-center justify-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg
                                id="kecepatan-respon-star-{{ $i }}"
                                onclick="rate('kecepatan-respon', {{ $i }})"
                                class="w-6 h-6 text-gray-300 hover:text-black cursor-pointer fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-start">
                        <span class="text-gray-600 text-sm mt-2">Sangat Puas</span>
                    </div>
                </div>
            </div>
    
            <input type="hidden" name="rating_kecepatan_ts" id="kecepatan-ts-rating" value="0">
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Tingkat kecepatan troubleshooting kami</h3>
                <div class="grid grid-cols-3 mx-10 items-center justify-center my-4 space-x-2">
                    <div class="text-end">
                        <span class="text-gray-600 text-sm mt-2">Tidak Puas</span>
                    </div>
                    <div class="flex items-center justify-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg
                                id="kecepatan-ts-star-{{ $i }}"
                                onclick="rate('kecepatan-ts', {{ $i }})"
                                class="w-6 h-6 text-gray-300 hover:text-black cursor-pointer fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-start">
                        <span class="text-gray-600 text-sm mt-2">Sangat Puas</span>
                    </div>
                </div>
            </div>
    
            <input type="hidden" name="rating_kecepatan_pengerjaan" id="kecepatan-pengerjaan-rating" value="0">
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Tingkat kecepatan proses pengerjaan kami</h3>
                <div class="grid grid-cols-3 mx-10 items-center justify-center my-4 space-x-2">
                    <div class="text-end">
                        <span class="text-gray-600 text-sm mt-2">Tidak Puas</span>
                    </div>
                    <div class="flex items-center justify-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg
                                id="kecepatan-pengerjaan-star-{{ $i }}"
                                onclick="rate('kecepatan-pengerjaan', {{ $i }})"
                                class="w-6 h-6 text-gray-300 hover:text-black cursor-pointer fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-start">
                        <span class="text-gray-600 text-sm mt-2">Sangat Puas</span>
                    </div>
                </div>
            </div>
            
    
            <input type="hidden" name="rating_kebersihan" id="kebershian-rating" value="0">
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Tingkat kualitas kebersihan drone yang diterima</h3>
                <div class="grid grid-cols-3 mx-10 items-center justify-center my-4 space-x-2">
                    <div class="text-end">
                        <span class="text-gray-600 text-sm mt-2">Tidak Puas</span>
                    </div>
                    <div class="flex items-center justify-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg
                                id="kebershian-star-{{ $i }}"
                                onclick="rate('kebershian', {{ $i }})"
                                class="w-6 h-6 text-gray-300 hover:text-black cursor-pointer fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-start">
                        <span class="text-gray-600 text-sm mt-2">Sangat Puas</span>
                    </div>
                </div>
            </div>
    
            <input type="hidden" name="rating_kualitas_hasil" id="kualitas-hasil-rating" value="0">
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Tingkat kualitas hasil pengerjaan kami</h3>
                <div class="grid grid-cols-3 mx-10 items-center justify-center my-4 space-x-2">
                    <div class="text-end">
                        <span class="text-gray-600 text-sm mt-2">Tidak Puas</span>
                    </div>
                    <div class="flex items-center justify-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg
                                id="kualitas-hasil-star-{{ $i }}"
                                onclick="rate('kualitas-hasil', {{ $i }})"
                                class="w-6 h-6 text-gray-300 hover:text-black cursor-pointer fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-start">
                        <span class="text-gray-600 text-sm mt-2">Sangat Puas</span>
                    </div>
                </div>
            </div>
    
            <div class="border-t-2"></div>
    
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Jenis pelayanan yang diharapkan</h3>
                <div class="grid grid-cols-4 mx-10 items-center justify-center my-4 space-x-2">
                    <div class="flex items-center justify-center me-4">
                        <input name="pelayanan[]" id="checkbox-santai" type="checkbox" value="Santai" class="pelayanan-checkbox w-4 h-4 text-black bg-gray-100 border-gray-300 rounded focus:ring-black">
                        <label for="checkbox-santai" class="ms-2 text-sm font-medium text-gray-900">Santai</label>
                    </div>
                    <div class="flex items-center justify-center me-4">
                        <input name="pelayanan[]" id="checkbox-formal" type="checkbox" value="Formal" class="pelayanan-checkbox w-4 h-4 text-black bg-gray-100 border-gray-300 rounded focus:ring-black">
                        <label for="checkbox-formal" class="ms-2 text-sm font-medium text-gray-900">Formal</label>
                    </div>
                    <div class="col-span-2 flex items-center justify-center me-4">
                        <input id="checkbox-other" type="checkbox" value="" class="pelayanan-checkbox w-4 h-4 text-black bg-gray-100 border-gray-300 rounded focus:ring-black">
                        <label for="checkbox-other" class="ms-2 text-sm font-medium text-gray-900">Other</label>
                        <input type="text" name="pelayanan[]" id="other-field" class="ml-2 py-0.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" disabled>
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="rating_tingkat_pelayanan" id="tingkat-pelayanan-rating" value="0">
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Tingkat pelayanan yang kami berikan</h3>
                <div class="grid grid-cols-3 mx-10 items-center justify-center my-4 space-x-2">
                    <div class="text-end">
                        <span class="text-gray-600 text-sm mt-2">Tidak Puas</span>
                    </div>
                    <div class="flex items-center justify-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg
                                id="tingkat-pelayanan-star-{{ $i }}"
                                onclick="rate('tingkat-pelayanan', {{ $i }})"
                                class="w-6 h-6 text-gray-300 hover:text-black cursor-pointer fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-start">
                        <span class="text-gray-600 text-sm mt-2">Sangat Puas</span>
                    </div>
                </div>
            </div>
    
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Apakah Anda akan kembali menggunakan layanan kami di masa mendatang?</h3>
                <div class="grid grid-cols-2 mx-10 items-center justify-center my-4 space-x-2">
                    <div class="flex items-center justify-center me-4">
                        <input name="kembali_lagi[]" id="checkbox-kembali" type="checkbox" value="Kembali" class="w-4 h-4 text-black bg-gray-100 border-gray-300 rounded focus:ring-black">
                        <label for="checkbox-kembali" class="ms-2 text-sm font-medium text-gray-900">Ya</label>
                    </div>
                    <div class="flex items-center justify-center me-4">
                        <input name="kembali_lagi[]" id="checkbox-tidak-kembali" type="checkbox" value="Tidak Kembali" class="w-4 h-4 text-black bg-gray-100 border-gray-300 rounded focus:ring-black">
                        <label for="checkbox-tidak-kembali" class="ms-2 text-sm font-medium text-gray-900">Tidak</label>
                    </div>
                </div>
            </div>
    
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Jika ada yang tidak berkenan berikan kritik kepada kami</h3>
                <input type="text" name="kritik" class="block w-full mt-4 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Kritik kepada kami . . ." required>
            </div>
    
            <div class="items-center justify-center my-4">
                <h3 class="text-base font-semibold">Saran agar kami bisa menjadi lebih baik</h3>
                <input type="text" name="saran" class="block w-full mt-4 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Saran kepada kami . . ." required>
            </div>

            <div class="flex items-center justify-end pt-3 border-t border-gray-200 rounded-b dark:border-gray-600">
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
    </div>

    <script>
        function rate(category, star) {
        for (let i = 1; i <= 5; i++) {
            document.getElementById(category + '-star-' + i).classList.remove('text-black');
            document.getElementById(category + '-star-' + i).classList.add('text-gray-300');
        }

        for (let i = 1; i <= star; i++) {
            document.getElementById(category + '-star-' + i).classList.remove('text-gray-300');
            document.getElementById(category + '-star-' + i).classList.add('text-black');
        }

        document.getElementById(category + '-rating').value = star;
    }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const checkboxes = document.querySelectorAll('.pelayanan-checkbox');

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', (event) => {
            if (event.target.id === 'checkbox-other') {
                document.getElementById('other-field').disabled = !event.target.checked;
                checkboxes.forEach((cb) => {
                    if (cb !== event.target) {
                        cb.checked = false;
                    }
                });
            } else {
                checkboxes.forEach((cb) => {
                    if (cb !== event.target) {
                        cb.checked = false;
                    }
                });
                document.getElementById('other-field').disabled = true;
            }
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxKembali = document.getElementById('checkbox-kembali');
        const checkboxTidakKembali = document.getElementById('checkbox-tidak-kembali');

        checkboxKembali.addEventListener('change', function() {
            if (this.checked) {
                checkboxTidakKembali.checked = false;
            }
        });

        checkboxTidakKembali.addEventListener('change', function() {
            if (this.checked) {
                checkboxKembali.checked = false;
            }
        });
    });
</script>

</body>
</html>