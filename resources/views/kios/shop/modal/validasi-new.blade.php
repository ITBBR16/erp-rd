@foreach ($data as $item)
    <div id="validasi-order{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Validasi Order K.{{ $item->id }}</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="validasi-order{{ $item->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8">
                    <form action="{{ url('kios/shop/'.$item->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="grid md:grid-cols-2 md:gap-6 pt">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="hidden" name="supplier_id" value="{{ $item->supplier->id }}">
                                <input type="text" name="supplier_kios" id="supplier_kios" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $item->supplier->nama_perusahaan }}" readonly>
                                <label for="supplier_kios" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Supplier</label>
                            </div>
                            @error('supplier_kios')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="invoice" id="invoice" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $item->invoice }}" required>
                                <label for="invoice" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Invoice</label>
                            </div>
                            @error('invoice')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <h3 class="my-3 font-semibold text-gray-900 dark:text-white">Daftar Barang</h3>
                        <div id="form-validasi-{{ $item->id }}">
                            @foreach ($item->orderLists as $key => $ol)
                            <div class="grid grid-cols-5 mb-4 gap-4">
                                <div class="relative col-span-2 z-0 w-full group">
                                    <select name="jenis_paket[]" id="jenis_paket{{ $key }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                                        <option value="" hidden>-- Seri Drone --</option>
                                        @foreach ($paketPenjualan as $pp)
                                            @if ($ol->sub_jenis_id == $pp->id)
                                                <option value="{{ $pp->id }}" selected class="dark:bg-gray-700">{{ $pp->produkjenis->jenis_produk }} {{ $pp->paket_penjualan }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <input type="text" name="quantity[]" id="val-qty-buy-baru{{ $key }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $ol->quantity }}" oninput="this.value = this.value.replace(/\D/g, '')" required>
                                    <label for="val-qty-buy-baru{{ $key }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <input type="text" name="nilai[]" id="val-nilai-buy-baru{{ $key }}" class="val-nilai-buy-baru block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ $ol->nilai }}" oninput="this.value = this.value.replace(/\D/g, '')" required>
                                    <label for="val-nilai-buy-baru{{ $key }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Harga /pcs</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between my-3 text-rose-600">
                            <div class="flex cursor-pointer mt-4 hover:text-red-400">
                                <button type="button" id="add-form-validasi-belanja" data-id="{{ $item->id }}" class="flex flex-row justify-between gap-2">
                                    <span class="material-symbols-outlined">add_circle</span>
                                    <span class="">Tambah Produk</span>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center pt-3 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
