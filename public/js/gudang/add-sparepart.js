$(document).ready(function () {

    $(document).on('click', '#tambah-sparerpart-baru', function () {
        let formLength = $('.type-part').length;
        let lastSelect = $('#type-part-' + formLength);
        if (lastSelect.length && lastSelect.val() === '') {
            alert("Form sebelumnya tidak boleh kosong");
            return;
        }
        formLength++;
        const containerAddSparepart = $('#container-form-add-sparepart');

        let formSparepart = `
            <div id="form-add-sparepart-${formLength}" class="grid grid-cols-10 gap-4" style="grid-template-columns: 3fr 3fr 3fr 3fr 3fr 3fr 3fr 5fr 5fr 1fr">
                <div>
                    <label for="type-part-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Type Part :</label>
                    <select name="type_part[]" id="type-part-${formLength}" class="type-part bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Type Part</option>`;
                        typePart.forEach(function(typePart) {
                            formSparepart += `<option value="${typePart.id}">${typePart.type}</option>`
                        });
                        formSparepart += `
                    </select>
                </div>
                <div>
                    <label for="model-part-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Model Part :</label>
                    <select name="model_part[]" id="model-part-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Model Part</option>`;
                        modelPart.forEach(function(modelPart) {
                            formSparepart += `<option value="${modelPart.id}">${modelPart.nama}</option>`
                        });
                        formSparepart += `
                    </select>
                </div>
                <div>
                    <label for="jenis-produk-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Produk :</label>
                    <select name="jenis_produk[]" id="jenis-produk-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Produk</option>`;
                        jenisProduk.forEach(function(jenisProduk) {
                            formSparepart += `<option value="${jenisProduk.id}">${jenisProduk.jenis_produk}</option>`
                        });
                        formSparepart += `
                    </select>
                </div>
                <div>
                    <label for="bagian-part-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Bagian Part :</label>
                    <select name="bagian_part[]" id="bagian-part-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Bagian Part</option>`;
                        bagianPart.forEach(function(bagianPart) {
                            formSparepart += `<option value="${bagianPart.id}">${bagianPart.nama}</option>`
                        });
                        formSparepart += `
                    </select>
                </div>
                <div>
                    <label for="sub-bagian-part-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sub Bagian Part :</label>
                    <select name="sub_bagian_part" id="sub-bagian-part-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Sub Bagian Part</option>`;
                        subBagianPart.forEach(function(subBagianPart) {
                            formSparepart += `<option value="${subBagianPart.id}">${subBagianPart.nama}</option>`
                        });
                        formSparepart += `
                    </select>
                </div>
                <div>
                    <label for="sifat-part-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sifat Part :</label>
                    <select name="sifat_part[]" id="sifat-part-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Sifat Part</option>`;
                        sifatPart.forEach(function(sifatPart) {
                            formSparepart += `<option value="${sifatPart.id}">${sifatPart.sifat}</option>`
                        });
                        formSparepart += `
                    </select>
                </div>
                <div>
                    <label for="sku-external-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">SKU Eksternal : </label>
                    <input type="text" name="sku_external[]" id="sku-external-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="SKU External">
                </div>
                <div>
                    <label for="nama-eksternal-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Eksternal : </label>
                    <input type="text" name="nama_eksternal[]" id="nama-eksternal-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama External">
                </div>
                <div>
                    <label for="nama-internal-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Internal : </label>
                    <input type="text" name="nama_internal[]" id="nama-internal-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Internal" required>
                </div>
                <div class="flex justify-center mt-10">
                    <button type="button" class="remove-form-sparepart" data-id="${formLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `;
        containerAddSparepart.append(formSparepart);
    });

    $(document).on('click', '.remove-form-sparepart', function () {
        let idForm = $(this).data("id");
        $('#form-add-sparepart-' + idForm).remove();
    });
});