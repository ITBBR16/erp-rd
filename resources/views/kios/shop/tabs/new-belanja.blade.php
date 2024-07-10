<div class="hidden p-4" id="new-product" role="tabpanel" aria-labelledby="new-product-tab">
    <form action="{{ route('shop.store') }}" method="POST" autocomplete="off">
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
                        <div id="data-form-belanja-baru" class="grid md:w-full md:grid-cols-5 md:gap-4">
                            <div class="col-span-2">
                                <label for="paket-penjualan-z" class="sr-only"></label>
                                <select name="paket_penjualan[]" id="paket-penjualan-z" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer" required>
                                    <option value="" hidden>Select Paket Penjualan</option>
                                    @foreach ($paketPenjualan as $pp)
                                        <option value="{{ $pp->id }}" class="dark:bg-gray-700">{{ $pp->paket_penjualan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-4 group col-span-2">
                                <input type="number" name="quantity[]" id="quantity" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                                <label for="quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                            </div>
                            <div class="flex justify-center items-center col-span-1">
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
                                <span class="">Tambah Produk</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-end pr-5">
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
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let paketPenjualan = @json($paketPenjualan);
</script>
