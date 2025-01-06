<div class="hidden p-4" id="newCustomer" role="tabpanel" aria-labelledby="newCustomer-tab">
    <form action="{{ route('createNC') }}" method="POST" autocomplete="off">
        @csrf
        <div class="grid md:grid-cols-2 md:gap-4">
            <div>
                <label for="first-name" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">First Name <span class="text-red-500">*</span>:</label>
                <input type="text" name="first_name" id="first-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="First Name" required>
            </div>
            <div>
                <label for="last-name" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Last Name <span class="text-red-500">*</span>:</label>
                <input type="text" name="last_name" id="last-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="First Name" required>
            </div>
        </div>
        <div class="grid md:grid-cols-3 md:gap-4">
            <div>
                <label for="asal-informasi-customer" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Lead Source <span class="text-red-500">*</span>:</label>
                <select name="asal_informasi" id="asal-informasi-customer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>Lead Source</option>
                    @foreach ($infoPerusahaan as $info)
                        <option value="{{ $info->id }}" class="bg-white dark:bg-gray-700">{{ $info->asal }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="no-telpon" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">No Telpon <span class="text-red-500">*</span>:</label>
                <input type="text" name="no_telpon" id="no-telpon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="6285123456789" oninput="this.value = this.value.replace(/\D/g, '')" required>
            </div>
            <div>
                <label for="email" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Email :</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ujang@gmail.com">
            </div>
            <div>
                <label for="instansi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Instansi :</label>
                <input type="text" name="instansi" id="instansi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Instansi">
            </div>
            <div>
                <label for="provinsi" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Provinsi <span class="text-red-500">*</span>:</label>
                <select name="provinsi" id="provinsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>Pilih Provinsi</option>
                    @foreach ($dataProvinsi as $provinsi)
                        <option value="{{ $provinsi->id }}" class="bg-white dark:bg-gray-700">{{ $provinsi->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="kota-kabupaten" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kota Kabupaten :</label>
                <select name="kota_kabupaten" id="kota-kabupaten" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden></option>
                </select>
            </div>
            <div>
                <label for="kecamatan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kecamatan :</label>
                <select name="kecamatan" id="kecamatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" hidden></option>
                </select>
            </div>
            <div>
                <label for="kelurahan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelurahan :</label>
                <select name="kelurahan" id="kelurahan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" hidden></option>
                </select>
            </div>
            <div>
                <label for="kode-pos" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pos :</label>
                <input type="text" name="kode_pos" id="kode-pos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="65139" oninput="this.value = this.value.replace(/\D/g, '')">
            </div>
        </div>
        <div>
            <label for="nama-jalan" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Jalan :</label>
            <input type="text" name="nama_jalan" id="nama-jalan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jalan">
        </div>
        <div class="mt-4 text-end">
            <button type="submit" class="submit-button-form text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
            <div class="loader-button-form" style="display: none">
                <button type="submit" class="cursor-not-allowed text-white border border-blue-700 bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-white dark:bg-blue-500 dark:focus:ring-blue-800" disabled>
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