@foreach ($dataCase as $case)
    @if ($case->jenisStatus->jenis_status == 'Proses Konfirmasi Estimasi Biaya')
        <div id="kirim-pesan-{{ $case->id }}" tabindex="-1" class="modal fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    {{-- Header Modal --}}
                    <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Kirim Pesan {{ $case->customer->first_name }} {{ $case->customer->last_name }} - {{ $case->customer->id }}
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="kirim-pesan-{{ $case->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    {{-- Body Modal --}}
                    <form action="{{ route('kirimPesanEstimasi') }}" method="POST" autocomplete="off">
                        <div class="px-4 py-4 lg:px-6 bg-gray-50">
                            @csrf
                            <div class="bg-white rounded-lg shadow-lg text-sm p-2 dark:text-white">
                                <input type="hidden" name="no_customer" value="{{ $case->customer->no_telpon }}">
                                <input type="hidden" name="nama_customer" value="{{ $case->customer->first_name }} {{ $case->customer->last_name }}">
                                <input type="hidden" name="nama_nota" value="{{ $case->customer->first_name }} {{ $case->customer->last_name }}-{{ $case->customer->id }}-{{ $case->id }}">
                                <input type="hidden" name="jenis_drone" value="{{ $case->jenisProduk->jenis_produk }}">
                                <input type="hidden" name="serial_number" value="-">

                                <h3 class="text-black dark:text-white">Selamat {{ $greeting }} {{ $case->customer->first_name }} {{ $case->customer->last_name }} 😊</h3><br>
                                <p class="text-black dark:text-white">Kami dari Rumah Drone ingin menginformasikan hasil troubleshooting dari :</p><br>
                                <p class="text-black dark:text-white">Drone Atas Nama : {{ $case->customer->first_name }} {{ $case->customer->last_name }}-{{ $case->customer->id }}-{{ $case->id }}</p>
                                <p class="text-black dark:text-white">Jenis Drone : {{ $case->jenisProduk->jenis_produk }}</p>
                                <p class="text-black dark:text-white">SN : -</p>

                                <div class="my-3 border p-2 grid grid-cols-2">
                                    <div class="mr-4">
                                        <input type="hidden" name="hasil_analisa_ts" value="{{ $case->estimasi->estimasiChat->isi_chat ?? "-" }}">
                                        <h3 class="text-black dark:text-white">Berikut hasil analisa dan troubleshooting teknisi kami :</h3>
                                        <p class="text-black dark:text-white">{!! nl2br(e($case->estimasi->estimasiChat->isi_chat ?? "-")) !!}</p>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-black dark:text-white">Estimasi Biaya</h3>
                                        <ul class="space-y-1 list-disc list-inside dark:text-white">
                                            @php
                                                $totalNilai = 0;
                                            @endphp
                                        
                                            @foreach (array_merge($case->estimasi->estimasiPart->all(), $case->estimasi->estimasiJrr->all()) as $item)
                                                @if ($item->active == 'Active')
                                                    <li class="flex justify-between text-black">
                                                        <span>
                                                            @if (isset($item->gudang_produk_id))
                                                                <input type="hidden" name="data_estimasi[]" value="{{ (!empty($item->nama_alias)) ? $item->nama_alias : $item->sparepartGudang->produkSparepart->nama_internal }}">
                                                                {{ (!empty($item->nama_alias)) ? $item->nama_alias : $item->sparepartGudang->produkSparepart->nama_internal }}
                                                            @else
                                                                <input type="hidden" name="data_estimasi[]" value="{{ $item->nama_jasa }}">
                                                                {{ $item->nama_jasa }}
                                                            @endif
                                                        </span>
                                                        <span>
                                                            <input type="hidden" name="estimasi_harga_customer[]" value="Rp. {{ number_format($item->harga_customer, 0, ',', '.') }}">
                                                            Rp. {{ number_format($item->harga_customer, 0, ',', '.') }}
                                                        </span>
                                                    </li>
                                        
                                                    @php
                                                        $totalNilai += $item->harga_customer;
                                                    @endphp
                                                @endif    
                                            @endforeach
                                            
                                            <li class="flex justify-between">
                                                <input type="hidden" name="total_biaya_estimasi" value="Rp. {{ number_format($totalNilai, 0, ',', '.') }}">
                                                <span class="text-black font-semibold dark:text-white">TOTAL BIAYA :</span>
                                                <span class="text-black font-semibold dark:text-white">Rp. {{ number_format($totalNilai, 0, ',', '.') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mt-2 space-y-2">
                                    <h3 class="text-black dark:text-white">Untuk foto dokumentasi saat troubleshooting dapat dilihat pada link dibawah :</h3>
                                    <input type="hidden" name="link_doc" value="{{ $case->link_doc }}">
                                    <a href="{{ $case->link_doc }}" target="_blank" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $case->link_doc }}</a>
                                </div>

                                <div class="mt-2">
                                    <p class="text-black dark:text-white">Mohon konfirmasi apakah pengerjaan di lanjut atau di batalkan</p>
                                    <p class="text-black dark:text-white">Jika ada kerusakan lain di tengah pengerjaan kami akan menginformasikan ulang</p>
                                    <p class="text-black dark:text-white">Misal informasi yang kami sampaikan kurang jelas bisa langsung ngobrol via telfon ya kak 🙏😊</p>
                                </div>

                                <div class="mt-2 text-black dark:text-white">
                                    <h3 class="font-semibold text-black dark:text-white">Note : </h3>
                                    <p>- Jasa sudah termasuk include kalibrasi IMU, Gimbal, Vision, pembersihan total dan pergantian pasta</p>
                                    <p>- Garansi 1 Bulan *Syarat dan Ketentukan berlaku</p>
                                    <p>- Khusus Mavic 3, mavic air 3 dan case masuk air, akan dikenakan biaya minimal Rp 300.000 tergantung penanganan yang telah diberikan (jika dicancel)</p>
                                    <p>- Jika tidak segera dilakukan konfirmasi maka biaya dapat berubah tergantung harga sparepart saat konfirmasi pengerjaan</p>
                                </div>

                                <div class="mt-2 text-black">
                                    <p>Terimakasih, Salam satu langit 🙏😊🚁</p>
                                </div>
                            </div>
                        </div>
                        {{-- Footer Modal --}}
                        <div class="flex justify-end p-3 border-t border-gray-200 rounded-t dark:border-gray-600">
                            <button type="submit" class="submit-button-form text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-500 dark:focus:ring-green-800">Kirim Pesan</button>
                            <div class="loader-button-form" style="display: none">
                                <button class="cursor-not-allowed text-white border border-green-700 bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-white dark:bg-green-500 dark:focus:ring-green-800" disabled>
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