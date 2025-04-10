<div class="hidden p-4" id="manualInput" role="tabpanel" aria-labelledby="manualInput-tab">
    <form action="{{ route('penerimaan-logistik.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            {{-- Data Customer --}}
            <div>
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Customer :</h3>
                </div>
                <div class="grid grid-cols-3 mb-4 gap-y-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="no-register" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">No Register</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="no-register" name="no_register" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="No Register" required>
                    </div>
                    
                    <div class="col-span-1 text-end pr-6">
                        <label for="nama-lengkap" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="nama-lengkap" name="nama_lengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Nama Lengkap" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="no-whatsapp" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">No Whatsapp</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="no-whatsapp" name="no_whatsapp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="628123456789" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="provinsi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Provinsi</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="provinsi" name="provinsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Provinsi" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="kota-kabupaten" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kota / Kabupaten</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="kota-kabupaten" name="kota_kabupaten" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kota / Kabupaten" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="kecamatan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kecamatan</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="kecamatan" name="kecamatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kecamatan" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="kelurahan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelurahan</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" id="kelurahan" name="kelurahan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kelurahan" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="kode-pos" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pos</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="kode_pos" id="kode-pos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="65139" oninput="this.value = this.value.replace(/\D/g, '')">
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="alamat-lengkap" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="alamat" id="alamat-lengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Alamat lengkap . . .">
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="tanggal-dikirim" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Dikirim</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input datepicker id="tanggal-dikirim" type="text" name="tanggal_dikirim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tanggal Dikirim">
                        </div>
                    </div>
                </div>
            </div>
            {{-- Data Kronologi --}}
            <div>
                <div class="mb-4 pb-2">
                    <h3 class="text-gray-900 font-semibold text-xl dark:text-white">Data Kronologi : </h3>
                </div>
                <div class="grid grid-cols-3 mb-4 gap-y-4">
                    <div class="col-span-1 text-end pr-6">
                        <label for="jenis-drone" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="jenis_drone" id="jenis-drone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Jenis Drone" required>
                    </div>
    
                    <div class="col-span-1 text-end pr-6">
                        <label for="fungsional-drone" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Fungsional Drone</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="fungsional_drone" id="fungsional-drone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fungsional Drone" required>
                    </div>
    
                    <div class="col-span-1 text-end pr-6">
                        <label for="keluhan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keluhan</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="keluhan" id="keluhan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Keluhan" required>
                    </div>
    
                    <div class="col-span-1 text-end pr-6">
                        <label for="kronologi-kerusakan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kronologi Kerusakan</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="kronologi_kerusakan" id="kronologi-kerusakan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Kronologi Kerusakan" required>
                    </div>
    
                    <div class="col-span-1 text-end pr-6">
                        <label for="penanganan-crash" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Penanganan After Crash</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="penanganan_crash" id="penanganan-crash" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Penanganan After Crash" required>
                    </div>
    
                    <div class="col-span-1 text-end pr-6">
                        <label for="riwayat-penggunaaan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Riwayat Penggunaan</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="riwayat_penggunaan" id="riwayat-penggunaaan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Riwayat Penggunaan" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="dokumen-customer" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Dokumen Customer</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="dokumen_customer" id="dokumen-customer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Dokumen Customer" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="ekspedisi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Ekspedisi</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="ekspedisi" id="ekspedisi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ekspedisi" required>
                    </div>

                    <div class="col-span-1 text-end pr-6">
                        <label for="no-resi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Resi</label>
                    </div>
                    <div class="col-span-2 text-start">
                        <input type="text" name="no_resi" id="no-resi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nomor Resi" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 text-end">
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