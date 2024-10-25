<div class="hidden p-4" id="belanja" role="tabpanel" aria-labelledby="belanja-tab">
    <form action="#" method="POST" autocomplete="off">
        <div class="grid grid-cols-3 gap-6">
            {{-- Bagian Kiri --}}
            <div class="col-span-2">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="supplier-gudang" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Supplier :</label>
                        <select name="supplier" id="supplier-gudang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">Pilih Supplier</option>
                        </select>
                    </div>
                    <div>
                        <label for="invoice-supplier" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Supplier :</label>
                        <input type="text" name="invoice_supplier" id="invoice-supplier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Invoice Supplier">
                    </div>
                    <div>
                        <label for="nominal-ongkir" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Ongkir :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="nominal_ongkir" id="nominal-ongkir" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                        </div>
                    </div>
                    <div>
                        <label for="nominal-pajak" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal Pajak :</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                            <input type="text" name="nominal_pajak" id="nominal-pajak" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="my-4 border-t-2 border-gray-400 pt-2">
                        <h3 class="text-gray-900 font-semibold text-xl dark:text-white">List Belanja</h3>
                    </div>
                    <div class="grid grid-cols-5 gap-6" style="grid-template-columns: 5fr 5fr 5fr 5fr 1fr">
                        <div>
                            <label for="jenis-drone" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                            <select name="jenis_drone[]" id="jenis-drone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Jenis Drone</option>
                            </select>
                        </div>
                        <div>
                            <label for="spareparts" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sparepart :</label>
                            <select name="spareparts[]" id="spareparts" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" hidden>Pilih Sparepart</option>
                            </select>
                        </div>
                        <div>
                            <label for="sparepart-qty" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                            <input type="text" name="sparepart_qty[]" id="sparepart-qty" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
                        </div>
                        <div>
                            <label for="nominal-pcs" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Harga / Pcs :</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                <input type="text" name="nominal_pcs[]" id="nominal-pcs" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                            </div>
                        </div>
                        <div class="flex justify-center pt-10">
                            <button type="button" class="remove-list-belanja" data-id="">
                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex justify-start text-red-500 mt-6">
                    <div class="flex cursor-pointer my-2 hover:text-rose-700">
                        <button type="button" id="add-kelengkapan-case" class="flex flex-row justify-between gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            <span>Tambah Belanja</span>
                        </button>
                    </div>
                </div>
            </div>
            {{-- Bagian Kanan --}}
            <div class="col-span-1 h-[400px] bg-white p-6 rounded-lg border shadow-lg dark:bg-gray-800 dark:border-gray-600 sticky top-4">
                <h2 class="text-lg font-semibold mb-4 dark:text-white pb-2 border-b">Order Summary :</h2>
                <div class="grid grid-cols-2 gap-6 mb-4">
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold italic dark:text-white">Total Item :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal dark:text-white">0 Unit</p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex text-start">
                            <p class="font-semibold italic dark:text-white">Total Biaya :</p>
                        </div>
                        <div class="flex text-end">
                            <p class="font-normal dark:text-white">Rp. 0</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 border-t py-2">
                    <div>
                        <label for="media-transaksi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Media Transaksi :</label>
                        <input type="text" name="media_transaksi" id="media-transaksi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Media Transaksi">
                    </div>
                    <div>
                        <label for="nama_akun" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Akun :</label>
                        <input type="text" name="nama_akun" id="nama_akun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Akun">
                    </div>
                    <div>
                        <label for="bank-pembayaran" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Bank Pembayaran :</label>
                        <input type="text" name="bank_pembayaran" id="bank-pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Bank Pembayaran">
                    </div>
                    <div>
                        <label for="id-akun" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">ID Akun :</label>
                        <input type="text" name="id_akun" id="id-akun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ID Akun">
                    </div>
                </div>
                <div class="text-end mt-4">
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
    </form>
</div>