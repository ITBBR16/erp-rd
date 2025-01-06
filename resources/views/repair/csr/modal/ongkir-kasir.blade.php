@foreach ($dataCase as $case)
    @if ($case->jenisStatus->jenis_status == 'Proses Menunggu Pembayaran (Lanjut)')
        <div id="ongkir-kasir-{{ $case->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-5xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Ongkir {{ $case->customer->first_name }} {{ $case->customer->last_name }}-{{ $case->customer->id }}-{{ $case->id }}</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="ongkir-kasir-{{ $case->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form action="{{ route('createOngkirKasir', $case->id) }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="px-2 py-2 lg:px-8 lg:py-6 bg-gray-50 dark:bg-gray-600">
                            <div class="grid grid-cols-2 gap-x-4 relative">
                                <div class="relative px-4 py-4 rounded-md shadow-lg border border-gray-200 bg-white dark:bg-gray-700 dark:border-gray-600">
                                    <div class="pb-2 border-b flex justify-between items-center">
                                        <h2 class="text-base font-semibold mb-4 dark:text-white">Data Customer</h2>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="checkbox_customer_kasir" id="checkbox-ongkir-kasir-repair-{{ $case->id }}" data-id="{{ $case->id }}" class="checkbox-ongkir-kasir-repair sr-only peer">
                                            <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-500"></div>
                                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Beda Penerima</span>
                                        </label>
                                    </div>
                                    <div id="ongkir-repair-customer-{{ $case->id }}" class="space-y-4">
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Nama Customer :
                                            </div>
                                            <div class="col-span-2">
                                                <input type="hidden" name="customer_id" value="{{ $case->customer_id }}">
                                                <input type="text" id="nama-customer-ori-{{ $case->id }}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Customer" value="{{ $case->customer->first_name }} {{ $case->customer->last_name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Provinsi :
                                            </div>
                                            <div class="col-span-2">
                                                <select name="provinsi_customer" id="ongkir-provinsi-ori-{{ $case->id }}" data-id="{{ $case->id }}" class="ongkir-provinsi-ori bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                    <option value="" hidden>Pilih Provinsi</option>
                                                    @foreach ($dataProvinsi as $provinsi)
                                                        @if ($case->customer->provinsi_id == $provinsi->id)
                                                            <option value="{{ $provinsi->id }}" selected>{{ $provinsi->name }}</option>
                                                        @else
                                                            <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Kota / Kabupaten :
                                            </div>
                                            <div class="col-span-2">
                                                <select name="kota_customer" id="ongkir-kota-ori-{{ $case->id }}" data-id="{{ $case->id }}" class="ongkir-kota-ori bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                    <option value="" hidden>Pilih Kota / Kabupaten</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Kecamatan :
                                            </div>
                                            <div class="col-span-2">
                                                <select name="kecamatan_customer" id="ongkir-kecamatan-ori-{{ $case->id }}" data-id="{{ $case->id }}" class="ongkir-kecamatan-ori bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                    <option value="" hidden>Pilih Kecamatan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Kelurahan :
                                            </div>
                                            <div class="col-span-2">
                                                <select name="kelurahan_customer" id="ongkir-kelurahan-ori-{{ $case->id }}" data-id="{{ $case->id }}" class="ongkir-kelurahan-ori bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                    <option value="" hidden>Pilih Kelurahan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Kode Pos :
                                            </div>
                                            <div class="col-span-2">
                                                <input type="text" name="kode_pos_customer" id="ongkir-kodepos-ori-{{ $case->id }}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Kode Pos" value="{{ $case->customer->kode_pos }}" required>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Nama Jalan :
                                            </div>
                                            <div class="col-span-2">
                                                <input type="text" name="alamat_customer" id="ongkir-alamat-ori-{{ $case->id }}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jalan" value="{{ $case->customer->nama_jalan }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Form Beda Penerima --}}
                                    <div id="ongkir-repair-beda-penerima-{{ $case->id }}" class="space-y-4" style="display: none">
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Nama Customer :
                                            </div>
                                            <div class="col-span-2">
                                                <input type="text" name="nama_penerima" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Customer">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                No Telpon :
                                            </div>
                                            <div class="col-span-2">
                                                <input type="text" name="no_telpon" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Customer">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Provinsi :
                                            </div>
                                            <div class="col-span-2">
                                                <select name="provinsi_penerima" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="" hidden>Pilih Provinsi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Kota / Kabupaten :
                                            </div>
                                            <div class="col-span-2">
                                                <select name="kota_penerima" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="" hidden>Pilih Kota / Kabupaten</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Kecamatan :
                                            </div>
                                            <div class="col-span-2">
                                                <select name="kecamatan_penerima" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="" hidden>Pilih Kecamatan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Kelurahan :
                                            </div>
                                            <div class="col-span-2">
                                                <select name="kelurahan_penerima" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option value="" hidden>Pilih Kelurahan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Kode Pos :
                                            </div>
                                            <div class="col-span-2">
                                                <input type="text" name="kode_pos_penerima" id="dp-nama-alias" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Kode Pos">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 items-center">
                                            <div class="col-span-1">
                                                Nama Jalan :
                                            </div>
                                            <div class="col-span-2">
                                                <input type="text" name="nama_jalan_penerima" id="dp-nama-alias" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jalan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative space-y-4 px-4 py-4 rounded-md shadow-lg border bg-white dark:bg-gray-700">
                                    <h2 class="text-base font-semibold mb-4 dark:text-white pb-2 border-b">Data Ekspedisi</h2>
                                    <div class="grid grid-cols-3 items-center">
                                        <div class="col-span-1">
                                            Ekspedisi :
                                        </div>
                                        <div class="col-span-2">
                                            <select id="ongkir-ekspedisi-repair-{{ $case->id }}" data-id="{{ $case->id }}" class="ongkir-ekspedisi-repair bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option value="" hidden>Pilih Ekspedisi</option>
                                                @foreach ($dataEkspedisi as $ekspedisi)
                                                    <option value="{{ $ekspedisi->id }}">{{ $ekspedisi->ekspedisi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 items-center">
                                        <div class="col-span-1">
                                            Layanan :
                                        </div>
                                        <div class="col-span-2">
                                            <select name="layanan_ongkir_repair" id="ongkir-layanan-repair-{{ $case->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option value="" hidden>Pilih Layanan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 items-center">
                                        <div class="col-span-1">
                                            Nominal Ongkir :
                                        </div>
                                        <div class="col-span-2">
                                            <div class="flex">
                                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                                <input type="text" name="nominal_ongkir_repair" id="nominal-ongkir-repair-{{ $case->id }}" class="format-angka-ongkir-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 items-center">
                                        <div class="col-span-1">
                                            Nominal Paking :
                                        </div>
                                        <div class="col-span-2">
                                            <div class="flex">
                                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                                <input type="text" name="nominal_packing_repair" id="nominal-packing-repair-{{ $case->id }}" class="format-angka-ongkir-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                                            </div>
                                        </div>
                                    </div>
                                    <h2 class="text-base font-semibold my-4 dark:text-white pb-2 border-b">Data Asuransi</h2>
                                    <div class="grid grid-cols-3 items-center">
                                        <div class="col-span-1">
                                            Nominal Produk :
                                        </div>
                                        <div class="col-span-2">
                                            <div class="flex">
                                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                                <input type="text" name="nominal_produk" id="nominal-produk-repair-{{ $case->id }}" data-id="{{ $case->id }}" class="format-angka-ongkir-repair nominal-produk-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 items-center">
                                        <div class="col-span-1">
                                            Nominal Asuransi :
                                        </div>
                                        <div class="col-span-2">
                                            <div class="flex">
                                                <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                                                <input type="text" name="nominal_asuransi" id="nominal-asuransi-repair-{{ $case->id }}" class="format-angka-ongkir-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end p-3 border-t">
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
