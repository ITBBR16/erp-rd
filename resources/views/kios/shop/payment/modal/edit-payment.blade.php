@foreach ($payment as $editPayment)
    @if ($editPayment->status == 'Unpaid')
        <div id="edit-pembayaran{{ $editPayment->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Edit Payment Order {{ ($editPayment->order_type == 'Baru') ? 'N.' . $editPayment->order_id : 'S.' . $editPayment->order_id }}</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-pembayaran{{ $editPayment->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form action="{{ route('pembayaran.update', $editPayment->id) }}" method="POST" autocomplete="off">
                        <div class="px-6 py-6 lg:px-8">
                            @csrf
                            @method('PUT')
                            <div class="grid md:grid-cols-2 md:gap-6 pt">
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="hidden" name="status_order" value="{{ $editPayment->order_type }}">
                                    <input type="hidden" name="supplier_id" value="{{ ($editPayment->order_type == 'Baru') ? $editPayment->order->supplier->id : '' }}">
                                    <input type="hidden" name="customer_id" value="{{ ($editPayment->order_type == 'Bekas') ? $editPayment->ordersecond->customer->id : '' }}">
                                    <input type="text" name="supplier_kios" id="supplier_kios{{ $editPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ ($editPayment->order_type == 'Baru') ? $editPayment->order->supplier->nama_perusahaan : $editPayment->ordersecond->customer->first_name ." ". $editPayment->ordersecond->customer->last_name }}" readonly>
                                    <label for="supplier_kios{{ $editPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Supplier</label>
                                </div>
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="text" id="tanggal_req{{ $editPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="{{ \Carbon\Carbon::parse(($editPayment->order_type == 'Baru') ? $editPayment->order->created_at : $editPayment->ordersecond->tanggal_pembelian)->isoFormat('D MMMM YYYY') }}" readonly required>
                                    <label for="tanggal_req{{ $editPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal Request</label>
                                </div>
                            </div>
                            <div class="flex">
                                <label class="relative inline-flex items-center me-5 mb-4 cursor-pointer">
                                    <input type="checkbox" name="new-metode-payment-edit" id="new-metode-payment-edit" data-id="{{ $editPayment->id }}" value="" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-600 peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Metode Pembayaran Baru</span>
                                </label>
                            </div>
                            <div id="new-payment-metode-edit-{{ $editPayment->id }}">
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="hidden" name="metode_pembayaran_id" 
                                            value="
                                            {{ $editPayment->metode_pembayaran_id ?
                                                ($editPayment->order_type == 'Baru' ? $editPayment->metodepembayaran->id : 
                                                    ($editPayment->order_type == 'Bekas' ? $editPayment->metodepembayaransecond->id : 
                                                        '')
                                                ) 
                                                : '';
                                            }}
                                        ">
                                        @php
                                            $bankAkun = ($editPayment->order_type == 'Baru' && $editPayment->metodepembayaran) ? $editPayment->metodepembayaran->akun_bank_id : (($editPayment->order_type == 'Bekas' && $editPayment->metodepembayaransecond) ? $editPayment->metodepembayaransecond->media_pembayaran : '');
                                            $noAkun = ($editPayment->order_type == 'Baru' && $editPayment->metodepembayaran) ? $editPayment->metodepembayaran->no_rek : (($editPayment->order_type == 'Bekas' && $editPayment->metodepembayaransecond) ? $editPayment->metodepembayaransecond->no_rek : '');
                                            $namaAkun = ($editPayment->order_type == 'Baru' && $editPayment->metodepembayaran) ? $editPayment->metodepembayaran->nama_akun : (($editPayment->order_type == 'Bekas' && $editPayment->metodepembayaransecond) ? $editPayment->metodepembayaransecond->nama_akun : '');
                                        @endphp
                                        <div class="relative z-0 w-full group">
                                            <select name="akun_bank_id" id="media-pembayaran-{{ $editPayment->id }}" class="val-seri-drone block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" disabled>
                                                <option value="" hidden>Pilih Akun Bank</option>
                                                @foreach ($daftarAkun as $akun)
                                                    @if ($bankAkun == $akun->id)
                                                        <option value="{{ $akun->id }}" selected class="dark:bg-gray-700">{{ $akun->nama }}</option>
                                                    @else
                                                        <option value="{{ $akun->id }}" class="dark:bg-gray-700">{{ $akun->nama }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="no_rek" id="no-rek-{{ $editPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('no-rek-{{ $editPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ $noAkun }}" readonly>
                                        <label for="no-rek-{{ $editPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Rekening / VA</label>
                                    </div>
                                </div>
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="text" name="nama_akun" id="nama-akun-{{ $editPayment->id }}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('nama-akun-{{ $editPayment->id }}') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ $namaAkun }}" readonly>
                                    <label for="nama-akun-{{ $editPayment->id }}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Akun</label>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 md:gap-6 mt-2">
                                <div class="relative z-0 w-full group flex items-center">
                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                    <input type="text" name="nilai_belanja" id="nilai-belanja-{{ $editPayment->id }}" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ number_format($editPayment->nilai, 0, ',', '.') }}" readonly>
                                    <label for="nilai-belanja-{{ $editPayment->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Total Belanja</label>
                                </div>
                                <div class="relative z-0 w-full group flex items-center">
                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                    <input type="text" name="ongkir" id="ongkir-{{ $editPayment->id }}" class="ongkir-payment block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ number_format($editPayment->ongkir, 0, ',', '.') }}" oninput="this.value = this.value.replace(/\D/g, '')">
                                    <label for="ongkir-{{ $editPayment->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Ongkir</label>
                                </div>
                                <div class="relative z-0 w-full group flex items-center">
                                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                    <input type="text" name="pajak" id="pajak-{{ $editPayment->id }}" class="pajak-payment block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value="{{ number_format($editPayment->pajak, 0, ',', '.') }}" oninput="this.value = this.value.replace(/\D/g, '')">
                                    <label for="pajak-{{ $editPayment->id }}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Pajak</label>
                                </div>
                            </div>
                        </div>
                        {{-- Footer Modal --}}
                        <div class="flex justify-end p-3 border-t rounded-t dark:border-gray-600">
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
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach
