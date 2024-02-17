$(document).ready(function() {
    let nomorFormBelanja = 1;
    let nomorFormValidasi = 1;
    const containerFormBelanjaBaru = $('#form-new-belanja');
    const containerFormValidasi = $('#form-validasi');
    const tambahFormBelanjaBaru = $('#add-new-belanja');
    const tambahFormValidasi = $('#add-form-validasi-belanja');

    tambahFormBelanjaBaru.on('click', function () {
        nomorFormBelanja++
        let newFormBelanja = `
            <div id="data-form-belanja-baru-${nomorFormBelanja}" class="grid md:w-full md:grid-cols-5 md:gap-4">
                <div class="col-span-2">
                    <label for="paket_penjualan${nomorFormBelanja}" class="sr-only"></label>
                    <select name="paket_penjualan[]" id="paket_penjualan${nomorFormBelanja}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer" required>
                        <option value="" hidden>-- Paket Penjualan --</option>`;
                        paketPenjualan.forEach(function(item) {
                            newFormBelanja += `<option value="${item.id}" class="dark:bg-gray-700">${item.produkjenis.jenis_produk} ${item.paket_penjualan}</option>`;
                        });
                        newFormBelanja += `
                    </select>
                </div>
                <div class="relative z-0 w-full mb-4 group col-span-2">
                    <input type="number" name="quantity[]" id="quantity${nomorFormBelanja}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                    <label for="quantity${nomorFormBelanja}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                </div>
                <div class="flex justify-center items-center col-span-1">
                    <button type="button" class="remove-form-pembelian" data-id="${nomorFormBelanja}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span>
                    </button>
                </div>
            </div>
        `
        containerFormBelanjaBaru.append(newFormBelanja);
    });

    $(document).on("click", ".remove-form-pembelian", function() {
        let formId = $(this).data("id");
        $("#data-form-belanja-baru-"+formId).remove();
        nomorFormBelanja--;
    });

   tambahFormValidasi.on('click', function () {
    nomorFormValidasi++
    let containerId = $(this).data("id");
    let newFormValidasi = `
    <div id="form-validasi-${nomorFormValidasi}" class="grid grid-cols-5 mb-4 gap-4">
        <div class="relative col-span-2 z-0 w-full group">
            <select name="jenis_paket[]" id="jenis_paket${nomorFormValidasi}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                <option value="" hidden>-- Seri Drone --</option>`;
                paketPenjualan.forEach(function(item) {
                    newFormValidasi += `<option value="${item.id}" class="dark:bg-gray-700">${item.produkjenis.jenis_produk} ${item.paket_penjualan}</option>`;
                });
                newFormValidasi += `
            </select>
        </div>
        <div class="relative z-0 w-full group">
            <input type="number" name="quantity[]" id="quantity${nomorFormValidasi}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="0" required>
            <label for="quantity${nomorFormValidasi}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
        </div>
        <div class="relative z-0 w-full group">
            <input type="number" name="nilai[]" id="nilai${nomorFormValidasi}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="0" required>
            <label for="nilai${nomorFormValidasi}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Harga /pcs</label>
        </div>
        <div class="flex justify-center items-center col-span-1">
            <button type="button" class="remove-form-validasi" data-id="${nomorFormValidasi}">
                <span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span>
            </button>
        </div>
    </div>
    `

    $('#form-validasi-'+containerId).append(newFormValidasi);
   });

    $(document).on("click", ".remove-form-validasi", function() {
        let formId = $(this).data("id");
        $("#form-validasi-"+formId).remove();
        nomorFormBelanja--;
    });

});
