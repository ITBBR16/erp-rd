@foreach ($dataIncoming as $item)
    <div id="input-resi{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:bg-gray-700">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">Input Ekspedisi / Resi</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="input-resi{{ $item->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="px-6 py-6 lg:px-8">
                    <form action="{{ route('pengiriman.update', $item->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="grid md:grid-cols-2 md:gap-6 pt">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="order_id" id="order_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ ($item->status_order == 'Baru' ? 'K.' . $item->order->id : 'S.' . $item->ordersecond->id) }}" required>
                                <label for="order_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Order ID</label>
                            </div>
                            @error('order_id')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div class="relative w-full group">
                                <div class="absolute start-0 bottom-9 ps-1 font-bold text-gray-500 dark:text-gray-400 pointer-events-none">
                                   <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input datepicker datepicker-autohide name="tanggal_dikirim" id="date-input" type="text" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" placeholder="Tanggal Pengiriman" required>
                            </div>
                            @error('tanggal_dikirim')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6 pt">
                            <div class="relative z-0 w-full mb-6 group">
                                <select name="ekspedisi" id="ekspedisi" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" {{ ($item->jenis_layanan_id != '' ? 'disabled' : '') }} required>
                                    <option value="" hidden>-- Ekspedisi --</option>
                                    @foreach ($ekspedisi as $eks)
                                        @php
                                            $selected = ($item->pelayanan && $item->pelayanan->ekspedisi && $item->pelayanan->ekspedisi->id == $eks->id) ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $eks->id }}" class="dark:bg-gray-700" {{ $selected }}>{{ $eks->ekspedisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ekspedisi')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div class="relative z-0 w-full mb-6 group">
                                <select name="layanan" id="layanan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" {{ ($item->jenis_layanan_id != '' ? 'disabled' : '') }} required>
                                    <option value="" hidden>-- Jenis Pengiriman --</option>
                                    @foreach ($jenisLayanan as $layanan)
                                        @if ($item->jenis_layanan_id == $layanan->id)
                                            <option value="{{ $layanan->id }}" class="dark:bg-gray-700" selected>{{ $layanan->nama_layanan }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('layanan')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 md:gap-6 pt">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="no_resi" id="no_resi" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ old('no_resi', $item->no_resi) }}" {{ ($item->no_resi != '' ? 'disabled' : '') }} required>
                                <label for="no_resi" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Resi</label>
                            </div>
                            @error('no_resi')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="no_faktur" id="no_faktur" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ old('no_resi', $item->no_faktur) }}" {{ ($item->no_faktur != '' ? 'disabled' : '') }}>
                                <label for="no_faktur" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Faktur Pajak</label>
                            </div>
                            @error('no_faktur')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end items-center pt-3 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endforeach