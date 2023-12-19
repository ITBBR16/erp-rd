@foreach ($data as $item)
    <div id="validasi-order{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Vlidasi Order K.{{ $item->id }}</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="validasi-order{{ $item->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8">
                    <div class="grid md:grid-cols-2 md:gap-6 pt">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="supplier_kios" id="supplier_kios" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $item->supplier->nama_perusahaan }}" readonly>
                            <label for="supplier_kios" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Supplier</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="invoice" id="invoice" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                            <label for="invoice" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Invoice</label>
                        </div>
                    </div>
                    <h3 class="my-3 font-semibold text-gray-900 dark:text-white">Daftar Barang</h3>
                    @foreach ($item->orderLists as $key => $ol)
                    <div class="grid grid-cols-4 gap-4">
                        <div class="relative z-0 w-full mb-6 group">
                            <select name="jenis_produk[]" id="jenis_produk{{ $key }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                                <option value="" hidden>-- Seri Drone --</option>
                                @foreach ($jenisProduk as $jp)
                                    @if ($ol->produk_jenis_id == $jp->id)
                                        <option value="{{ $jp['id'] }}" selected class="dark:bg-gray-700">{{ $jp['jenis_produk'] }}</option>
                                    @else
                                        <option value="{{ $jp['id'] }}" class="dark:bg-gray-700">{{ $jp['jenis_produk'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('jenis_produk{{ $key }}')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <select name="jenis_paket[]" id="jenis_paket{{ $key }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                                <option value="" hidden>-- Seri Drone --</option>
                                @foreach ($paketPenjualan as $pp)
                                    @if ($ol->sub_jenis_id == $pp->id)
                                        <option value="{{ $pp['id'] }}" selected class="dark:bg-gray-700">{{ $pp['paket_penjualan'] }}</option>
                                    @else
                                        <option value="{{ $pp['id'] }}" class="dark:bg-gray-700">{{ $pp['paket_penjualan'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('jenis_paket{{ $key }}')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-4 group">
                            <input type="number" name="quantity[]" id="quantity{{ $key }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $ol->quantity }}" required>
                            <label for="quantity{{ $key }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                        </div>
                        <div class="relative z-0 w-full mb-4 group">
                            <input type="number" name="nilai[]" id="nilai{{ $key }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                            <label for="nilai{{ $key }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Harga /pcs</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach
