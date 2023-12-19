<div class="hidden p-4" id="second-product" role="tabpanel" aria-labelledby="second-product-tab">
    <form action="#" method="POST" autocomplete="off">
        @csrf
        <h3 class="my-3 text-gray-900 dark:text-white font-semibold text-xl">Data Supplier</h3>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="first_name" id="first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('first_name') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('first_name') }}" required>
                <label for="first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First Name</label>
                @error('first_name')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="last_name" id="last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('last_name') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('last_name') }}" required>
                <label for="last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last Name</label>
                @error('last_name')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="number" name="no_telpon" id="no_telpon" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('no_telpon') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('no_telpon') }}" required>
                <label for="no_telpon" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Telphone</label>
                @error('no_telpon')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <label for="provinsi" class="sr-only">Provinsi</label>
                <select name="provinsi" id="provinsi" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('provinsi') border-red-600 dark:border-red-500 @enderror">
                    <option hidden>Domisili</option>
                </select>
                @error('provinsi')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Informasi Pembelian</h3>
        <div class="grid md:grid-cols-3 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="order_id" id="order_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('order_id') border-red-600 dark:border-red-500 @enderror" placeholder="" value="KS-666" readonly required>
                <label for="order_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Order ID</label>
                @error('order_id')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <label for="jenis_drone" class="sr-only">jenis_drone</label>
                <select name="jenis_drone" id="jenis_drone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('jenis_drone') border-red-600 dark:border-red-500 @enderror">
                    <option hidden>Jenis Drone</option>
                </select>
                @error('jenis_drone')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('tanggal_pembelian') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('tanggal_pembelian') }}" required>
                <label for="tanggal_pembelian" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal Pembelian</label>
                @error('tanggal_pembelian')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <h3 class="my-4 text-gray-900 dark:text-white font-semibold text-xl">Kondisi Kelengkapan</h3>
        <div class="grid md:grid-cols-4 md:gap-6">
            <div class="flex items-center mb-6">
                <input id="kelengkapan-cb1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="kelengkapan-cb1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">DJI Mavic 3</label>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="kondisi1" id="kondisi1" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer @error('kondisi1') border-red-600 dark:border-red-500 @enderror" placeholder="" value="{{ old('kondisi1') }}" required>
                <label for="kelengkapan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kondisi</label>
                @error('kondisi1')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        {{-- <div class="mt-4 text-end">
            <button type="submit" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Submit</button>
        </div> --}}
    </form>
</div>