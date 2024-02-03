@foreach ($dataKomplain as $item)
    <div id="validasi-komplain{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:bg-gray-700">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Validasi Proses Komplain</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="validasi-komplain{{ $item->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('komplain.update', $item->id) }}" method="POST" autocomplete="off">
                    <div class="px-6 py-6 lg:px-8">
                        @csrf
                        @method('PUT')
                        @php
                            $totalNilai = $item->validasi->orderLists->nilai * $item->quantity
                        @endphp
                        <input type="hidden" name="order-id" id="order-id" value="{{ $item->validasi->orderLists->order_id }}">
                        <input type="hidden" name="order-list-id" id="order-list-id" value="{{ $item->validasi->orderLists->id }}">
                        <input type="hidden" name="nilai-kurang" id="nilai-kurang" value="{{ $totalNilai }}">
                        <input type="hidden" name="id-supplier" id="id-supplier" value="{{ $item->validasi->orderLists->order->supplier_kios_id }}">
                        <div class="flex flex-row gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <select name="status-komplain" id="status-komplain" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                                    <option value="" hidden>-- Pilih Proses --</option>
                                    @foreach ($statusKomplain as $sk)
                                        <option value="{{ $sk->nama }}" class="dark:bg-gray-700">{{ $sk->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('status-komplain')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div id="bank-transfer-id" class="relative z-0 w-full mb-6 group" style="display: none">
                                <select name="bank-transfer" id="bank-transfer" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600">
                                    <option value="" hidden>-- Bank Transfer --</option>
                                    @foreach ($bankAkun as $bank)
                                        <option value="{{ $bank->id }}" class="dark:bg-gray-700">{{ $bank->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('bank-transfer')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-4 group">
                            <input type="text" name="keterangan" id="keterangan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                            <label for="keterangan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
                        </div>
                        @error('keterangan')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="p-4 border-t">
                        <div class="flex justify-end items-center pt-3 rounded-b dark:border-gray-600">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3.5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endforeach