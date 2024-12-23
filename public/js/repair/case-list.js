$(document).ready(function () {
    const caseContainer = $("#container-data-kelengkapan-case");
    let formLength = 1;

    // For new case
    $("#add-kelengkapan-case").on("click", function () {
        const jenisProduk = $("#case-jenis-drone").val();
        if (jenisProduk != '') {
            var statusTambah = "Tambah Kelengkapan";
            formLength++;
            let itemForm = `
                <div id="form-data-kelengkapan-case-${formLength}" class="grid grid-cols-4 gap-4 mt-5">
                    <div>
                        <label for="case-kelengkapan-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Kelengkapan :</label>
                        <select name="case_kelengkapan[]" id="case-kelengkapan-${formLength}" class="dd-kelengkapan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Select Kelengkapan</option>
                        </select>
                    </div>
                    <div>
                        <label for="case-quantity-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                        <input type="text" name="case_quantity[]" id="case-quantity-${formLength}" class="format-number bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
                    </div>
                    <div>
                        <label for="case-sn-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number : </label>
                        <input type="text" name="case_sn[]" id="case-sn-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                    </div>
                    <div class="grid grid-cols-2" style="grid-template-columns: 5fr 1fr">
                        <div>
                            <label for="case-keterangan-${formLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan : </label>
                            <input type="text" name="case_keterangan[]" id="case-keterangan-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
                        </div>
                        <div class="flex justify-center items-end pb-1.5">
                            <button type="button" class="remove-form-dkcs" data-id="${formLength}">
                                <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            caseContainer.append(itemForm);
            getKelengkapan(jenisProduk, statusTambah, formLength);
        } else {
            alert('Pilih jenis produk dulu.');
        }

    })

    $(document).on('jenis-drone-changed', (e) => {
        const jenisProduk = e.originalEvent.detail.id;
        console.log('Jenis Drone Changed:', jenisProduk);
        const statusGanti = "Rubah Jenis";
        getKelengkapan(jenisProduk, statusGanti);
    });

    $(document).on('click', '.remove-form-dkcs', function () {
        let formId = $(this).data("id");
        $("#form-data-kelengkapan-case-"+formId).remove();
        formLength--;
    });

    $(document).on('input', '.format-number', function () {
        var inputNumber = $(this).val();
        inputNumber = inputNumber.replace(/[^\d]/g, '');

        if (inputNumber === '') {
            inputNumber = '0';
        }

        var parsedNumber = parseInt(inputNumber, 10);
        $(this).val(parsedNumber);
    });

    function getKelengkapan(jenisProduk, status, id) {
        var formDefault = $("#case-kelengkapan");
        var formKelengkapan = (status === 'Rubah Jenis') ? $(".dd-kelengkapan") : $("#case-kelengkapan-" + id);

        fetch(`/repair/csr/getKelengkapan/${jenisProduk}`)
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
                }).addClass('dark:bg-gray-700');
                formDefault.append(option);
                formKelengkapan.append(option);
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    }

    // Dropdown Wilayah
    const kotaSelect = $('#kota-kabupaten');
    const kecamatanSelect = $('#kecamatan');
    const kelurahanSelect = $('#kelurahan');

    $(document).on('change', '#provinsi', function () {
        const selectedProvinsi = $(this).val();

        if (selectedProvinsi) {
            fetch(`/getKota/${selectedProvinsi}`)
                .then(response => response.json())
                .then(data => {
                    kotaSelect.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kota / Kabupaten')
                        .val("")
                        .addClass('dark:bg-gray-700');
                    kotaSelect.append(defaultOption);

                    data.forEach(kota => {
                        const option = $('<option>')
                            .val(kota.id)
                            .text(kota.name)
                            .addClass('dark:bg-gray-700');
                        kotaSelect.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            kotaSelect.html('');
        }
    });

    $(document).on('change', '#kota-kabupaten', function () {
        const selectedKota = $(this).val();

        if (selectedKota) {
            fetch(`/getKecamatan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {
                    kecamatanSelect.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kecamatan')
                        .val("")
                        .addClass('dark:bg-gray-700');
                    kecamatanSelect.append(defaultOption);

                    data.forEach(kecamatan => {
                        const option = $('<option>')
                            .val(kecamatan.id)
                            .text(kecamatan.name)
                            .addClass('dark:bg-gray-700');
                        kecamatanSelect.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            kecamatanSelect.html('');
        }
    });

    $(document).on('change', '#kecamatan', function () {
        const selectedKota = kecamatanSelect.val();

        if (selectedKota) {
            fetch(`/getKelurahan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {
                    kelurahanSelect.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kelurahan')
                        .val("")
                        .addClass('dark:bg-gray-700');
                    kelurahanSelect.append(defaultOption);

                    data.forEach(kelurahan => {
                        const option = $('<option>')
                            .val(kelurahan.id)
                            .text(kelurahan.name)
                            .addClass('dark:bg-gray-700');
                        kelurahanSelect.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            kelurahanSelect.html('');
        }
    });

});