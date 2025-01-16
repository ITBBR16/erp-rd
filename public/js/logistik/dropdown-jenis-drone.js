$(document).ready(function () {
    let formLength = 1;
    // For Sent to Repair
    $("#add-kelengkapan-str").on("click", function () {
        const jenisProduk = $("#str-jenis-drone").val();
        if (jenisProduk != '') {
            var statusTambah = "Tambah Kelengkapan";
            formLength++;
            let itemForm = `
                <div id="form-data-kelengkapan-str-${formLength}" class="grid grid-cols-4 gap-4 mt-5">
                    <div>
                        <label for="str-kelengkapan-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelengkapan :</label>
                        <select name="str_kelengkapan[]" id="str-kelengkapan-${formLength}" class="dd-kelengkapan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Kelengkapan</option>
                        </select>
                    </div>
                    <div>
                        <label for="str-quantity-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                        <input type="text" name="str_quantity[]" id="str-quantity-${formLength}" class="format-number bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
                    </div>
                    <div>
                        <label for="str-sn-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number : </label>
                        <input type="text" name="str_sn[]" id="str-sn-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                    </div>
                    <div class="grid grid-cols-2" style="grid-template-columns: 5fr 1fr">
                        <div>
                            <label for="str-keterangan-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan : </label>
                            <input type="text" name="str_keterangan[]" id="str-keterangan-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                        </div>
                        <div class="flex justify-center items-end pb-1.5">
                            <button type="button" class="remove-form-str" data-id="${formLength}">
                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            $('#container-data-kelengkapan-str').append(itemForm);
            getKelengkapan(jenisProduk, statusTambah, formLength);
        } else {
            alert('Pilih jenis produk dulu.');
        }

    });

    $(document).on('jenis-drone-changed', (e) => {
        const jenisProduk = e.originalEvent.detail.id;
        const statusGanti = "Rubah Jenis";
        getKelengkapan(jenisProduk, statusGanti);
    });

    $(document).on('click', '.remove-form-str', function () {
        let formId = $(this).data("id");
        $('#form-data-kelengkapan-str-' + formId).remove();
        formLength;
    });

    function getKelengkapan(jenisProduk, status, id) {
        var formDefault = $("#str-kelengkapan");
        var formKelengkapan = (status === 'Rubah Jenis') ? $(".dd-kelengkapan") : $("#str-kelengkapan-" + id);

        fetch(`/logistik/logistik-get-kelengkapan/${jenisProduk}`)
        .then(response => response.json())
        .then(data => {
            if (status === 'Rubah Jenis') {
                formDefault.empty();
                formKelengkapan.empty();
            }

            const defaultOption = $('<option>', {
                text: 'Select Kelengkapan',
                value: '',
                hidden: true
            });
            formDefault.append(defaultOption);
            formKelengkapan.append(defaultOption);

            data.forEach(kelengkapan => {
                const option = $('<option>', {
                    value: kelengkapan.id,
                    text: kelengkapan.kelengkapan
                }).addClass('bg-white dark:bg-gray-700');
                formDefault.append(option);
                formKelengkapan.append(option);
            });
        })
        .catch(error => {
            console.log('Error fetching data:' + error);
        });
    }
});