<div class="hidden p-4" id="new-product" role="tabpanel" aria-labelledby="new-product-tab">
    <form action="{{ route('shop.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="w-full px-3 py-3 mx-auto">
            <div class="flex flex-nowrap -mx-3">
                <div class="max-w-full px-3 md:w-10/12 md:flex-none">
                    <div class="grid grid-cols-3 gap-6">
                        {{-- Bagian Kiri --}}
                        <div class="col-span-2">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="supplier-kios" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Supplier :</label>
                                    <select name="supplier_kios" id="supplier-kios" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" hidden>Pilih Supplier</option>
                                        @foreach ($supplier as $supp)
                                            <option value="{{ $supp->id }}" class="bg-white dark:bg-gray-700">{{ $supp->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="my-4 border-t-2 border-gray-400 pt-2">
                                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">List Belanja</h3>
                                </div>
                                <div id="form-new-belanja">
                                    <div id="data-form-belanja-baru-1" class="form-kb grid grid-cols-3 gap-6" style="grid-template-columns: 5fr 3fr 1fr">
                                        <div>
                                            <label for="paket-penjualan-1" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                                            <select name="paket_penjualan[]" id="paket-penjualan-1" class="select-new-belanja bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option value="" hidden>Pilih Paket Penjualan</option>
                                                @foreach ($paketPenjualan as $pp)
                                                    <option value="{{ $pp->id }}" class="bg-white dark:bg-gray-700">{{ $pp->paket_penjualan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="quantity-1" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Quantity : </label>
                                            <input type="text" name="quantity[]" id="quantity-1" class="format-angka kios-baru-qty bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                                        </div>
                                        <div class="flex justify-center mt-10">
                                            <button type="button" class="remove-form-pembelian" style="display: none">
                                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span>
                                            </button>
                                        </div>
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
                        </div>
                        {{-- Bagian Kanan --}}
                        <div class="col-span-1 h-[200px] bg-white p-4 rounded-lg border shadow-lg dark:bg-gray-800 dark:border-gray-600 sticky top-4">
                            <h2 class="text-lg font-semibold mb-4 text-black dark:text-white pb-2 border-b">Order Summary :</h2>
                            <div class="flex justify-between gap-6 mb-4">
                                <div class="flex text-start">
                                    <p class="font-semibold italic text-black dark:text-white">Total Item :</p>
                                </div>
                                <div class="flex text-end">
                                    <p id="total-item-belanja-baru" class="font-normal text-black dark:text-white">0 Unit</p>
                                </div>
                                <div class="flex text-start">
                                    <p class="font-semibold italic text-black dark:text-white">Total Qty :</p>
                                </div>
                                <div class="flex text-end">
                                    <p id="total-qty-belanja-baru" class="font-normal text-black dark:text-white">0 Unit</p>
                                </div>
                            </div>
                            <div class="text-end mt-6">
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
            </div>
        </div>
    </form>
</div>

<script>
    let paketPenjualan = @json($paketPenjualan);
</script>