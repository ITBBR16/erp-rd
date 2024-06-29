$(document).ready(function () {
    const containerAddRecap = $("#container-input-dr");

    $(document).on('change', '#keperluan_recap', function () {
        var keperluanRecap = $(this).find("option:selected").text();
        console.log(keperluanRecap);
        if (keperluanRecap == 'Technical Support') {
            inputTs(containerAddRecap);
        } else {
            console.log('Hayooo');
        }
    });

    function inputTs(container) {
        let itemForm = `
            <div id="input-ts">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="jenis_produk"></label>
                        <select name="jenis_produk" id="jenis_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Jenis Produk</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="kategori_permasalahan"></label>
                        <select name="kategori_permasalahan" id="kategori_permasalahan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Jenis Permasalahan</option>
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="permasalahan"></label>
                        <select name="permasalahan" id="permasalahan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Permasalahan</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="keterangan" id="keterangan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                        <label for="keterangan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
                    </div>
                </div>
                <label for="deskripsi-ts" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your message</label>
                <textarea id="deskripsi-ts" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Deskripsi Permasalahan . . ." readonly></textarea>
            </div>`

        container.append(itemForm)
        
    }

});