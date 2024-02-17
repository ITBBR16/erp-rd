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
                        <div id="data-form-belanja-baru" class="grid md:w-full md:grid-cols-5 md:gap-4">
                            <div class="col-span-2">
                                <label for="paket_penjualan" class="sr-only"></label>
                                <select name="paket_penjualan[]" id="paket_penjualan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer" required>
                                    <option value="" hidden>-- Paket Penjualan --</option>
                                    @foreach ($paketPenjualan as $pp)
                                        <option value="{{ $pp->id }}" class="dark:bg-gray-700">{{ $pp->produkjenis->jenis_produk }} {{ $pp->paket_penjualan }}</option>
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
                                <span class="">Tambah Kelengkapan</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-end pr-5">
                        <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let paketPenjualan = @json($paketPenjualan);
</script>
