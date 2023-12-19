<div class="hidden p-4" id="new-product" role="tabpanel" aria-labelledby="new-product-tab">
    <form action="{{ route('form-belanja') }}" method="POST" autocomplete="off">
        @csrf
        <div class="w-full px-3 py-3 mx-auto">
            <div class="flex flex-nowrap -mx-3">
                <div class="max-w-full px-3 md:w-10/12 md:flex-none">
                    <div class="flex flex-wrap -mx-3">
                        <div class="relative z-0 w-full md:w-1/2 md:px-3 mb-4 group">
                            <label for="supplier_kios" class="sr-only"></label>
                            <select name="supplier_kios" id="supplier_kios" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer" required>
                                <option value="" hidden>Supplier</option>
                                @foreach ($supplier as $supp)
                                    <option value="{{ $supp->id }}" class="dark:bg-gray-700">{{ $supp->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="form-new-belanja" class="flex flex-wrap -mx-3 md:px-3">
                        <div id="dd-new-belanja" class="grid md:w-full md:grid-cols-4 md:gap-4">
                            <div>
                                <label for="jenis_produk" class="sr-only"></label>
                                <select name="jenis_produk[]" id="jenis_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer" required>
                                    <option value="" hidden>Series Drone</option>
                                    @foreach ($jenisProduk as $jp)
                                        <option value="{{ $jp->id }}" class="dark:bg-gray-700">{{ $jp->jenis_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="paket_penjualan" class="sr-only"></label>
                                <select name="paket_penjualan[]" id="paket_penjualan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer" required>
                                    <option value="" hidden>-- Paket Penjualan --</option>
                                    @foreach ($paketPenjualan as $pp)
                                    <option value="{{ $pp->id }}" class="dark:bg-gray-700">{{ $pp->paket_penjualan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-4 group">
                                <input type="number" name="quantity[]" id="quantity" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                <label for="quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                            </div>
                            <div class="flex justify-center items-center">
                                <button type="button" class="remove-form-pembelian" style="display: none">
                                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between text-rose-600">
                        <div class="flex cursor-pointer mt-4 hover:text-red-400">
                            <button type="button" id="add-new-belanja" class="flex flex-row justify-between gap-2">
                                <span class="material-symbols-outlined">add_circle</span>
                                <span class="">Tambah Kelengkapan</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-end pr-5">
                        <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </div>
                {{-- Order Summary --}}
                {{-- <div class="w-full max-w-full px-3 lg:w-1/3 lg:flex-none">
                    <div class="relative flex flex-col h-auto min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl rounded-2xl bg-clip-border dark:bg-gray-800 dark:border-gray-600">
                        <div class="p-4 pb-4 mb-0 bg-white border-b-0 border-solid rounded-t-2xl border-b-transparent dark:bg-gray-800 dark:border-gray-600">
                            <div class="flex flex-wrap -mx-3">
                                <div class="flex items-center flex-none w-full max-w-full px-3">
                                    <span class="text-xl text-gray-600 font-medium block dark:text-white">Order Summary</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto p-4 pb-4">
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full max-w-full px-4 md:w-full md:flex-none space-y-2">
                                    <div class="flex flex-row">
                                        <div class="flex items-center flex-none w-1/2 max-w-full">
                                            <span class="text-lg text-gray-600 font-medium block dark:text-white">Total Item</span>
                                        </div>
                                        <div class="flex items-center flex-none w-1/2 max-w-full justify-end">
                                            <span class="text-lg text-gray-600 font-medium block dark:text-white">66</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-row">
                                        <div class="flex items-center flex-none w-1/2 max-w-full">
                                            <span class="text-lg text-gray-600 font-medium block dark:text-white">Total Quantity</span>
                                        </div>
                                        <div class="flex items-center flex-none w-1/2 max-w-full justify-end">
                                            <span class="text-lg text-gray-600 font-medium dark:text-white">666</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </form>
</div>
{{-- <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-16 py-3">
                    Image
                </th>
                <th scope="col" class="px-6 py-3">
                    Product
                </th>
                <th scope="col" class="px-6 py-3">
                    Qty
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b text-center dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="p-4">
                    <img src="/img/mavic 2 pro.jpg" class="w-16 md:w-32 max-w-full max-h-full" alt="Mavic 2 Pro">
                </td>
                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                    Mavic 2 Pro
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center">
                        <button class="inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                            <span class="sr-only">Quantity button</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                            </svg>
                        </button>
                        <div>
                            <input type="number" id="first_product" class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                        </div>
                        <button class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                            <span class="sr-only">Quantity button</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                    $666
                </td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                </td>
            </tr>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="p-4">
                    <img src="/img/mavic air 2.jpg" class="w-16 md:w-32 max-w-full max-h-full" alt="Mavic Air 2">
                </td>
                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                    Mavic Air 2
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center">
                        <button class="inline-flex items-center justify-center p-1 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                            <span class="sr-only">Quantity button</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                            </svg>
                        </button>
                        <div class="ms-3">
                            <input type="number" id="first_product" class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                        </div>
                        <button class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                            <span class="sr-only">Quantity button</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                    $666
                </td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                </td>
            </tr>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="p-4">
                    <img src="/img/mavic air 2 basic.jpg" class="w-16 md:w-32 max-w-full max-h-full" alt="Mavic Air 2 Basic">
                </td>
                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                    Mavic Air 2 Basic 
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center">
                        <button class="inline-flex items-center justify-center p-1 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                            <span class="sr-only">Quantity button</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                            </svg>
                        </button>
                        <div class="ms-3">
                            <input type="number" id="first_product" class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                        </div>
                        <button class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                            <span class="sr-only">Quantity button</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                    $666
                </td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                </td>
            </tr>
        </tbody>
    </table>
</div> --}}
