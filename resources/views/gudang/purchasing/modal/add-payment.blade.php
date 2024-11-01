<div id="add-payment" tabindex="-1" class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[cal(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">Detail Request Payment</h3>
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-payment">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="px-6 py-6 lg:px-8 lg:py-6 bg-white dark:bg-gray-700">
                <form class="space-y-6" action="#">
                    <div>
                        <label for="ref-gudang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ref Gudang</label>
                        <select id="ref-gudang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                            <option hidden>Reff Gudang</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="ref-gudang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Order ID</label>
                            <input type="text" name="order_id" id="ref-gudang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="N.666" readonly>
                        </div>
                        <div>
                            <label for="media_transaksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Transaksi</label>
                            <input type="text" name="media_transaksi" id="media_transaksi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="Tokopedia" readonly>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="nama_akun" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Akun</label>
                            <input type="text" name="nama_akun" id="nama_akun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="BCA VA TOPED" readonly>
                        </div>
                        <div>
                            <label for="bank_pembayaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank Pembayaran</label>
                            <input type="text" name="bank_pembayaran" id="bank_pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="BCA" readonly>
                        </div>
                        <div>
                            <label for="id_akun" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Akun</label>
                            <input type="text" name="id_akun" id="id_akun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="80777082234415140" readonly>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-between">
                        <div class="flex">
                            <span class="text-sm text-gray-700 dark:text-gray-300">HPP</span>
                        </div>
                        <div class="justify-end">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Rp. 13.000.000</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-between">
                        <div class="flex">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Ongkir</span>
                        </div>
                        <div class="justify-end">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Rp. 2.666.000</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-between">
                        <div class="flex">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Pajak</span>
                        </div>
                        <div class="justify-end">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Rp. -</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-between">
                        <div class="flex">
                            <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Total Biaya : </span>
                        </div>
                        <div class="justify-end">
                            <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Rp. 15.666.00</span>
                        </div>
                    </div>
                    <div>
                        <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Type here . . ." required>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Proceed Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>