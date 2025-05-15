$(document).ready(function() {
    
    $(document).on('click', '#add-edit-kelengkapan-second', function() {
        const containerEditKelengkapan = $('#container-edit-kelengkapan-second');
        let formLength = 20; //$('form-edit-kelengkapan-second').length;
        formLength++;

        let tambahFormKelengkapan = `
            <div id="form-edit-kelengkapan-second-${formLength}" class="form-edit-kelengkapan-second grid grid-cols-7 gap-4 mb-4 md:gap-6">
                <div class="relative z-0 col-span-2 w-full group">
                    <label for="select-edit-kelengkapan-second-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Kelengkapan Produk :</label>
                    <select name="kelengkapan_second[]" id="select-edit-kelengkapan-second-${formLength}" data-id="${formLength}" class="select-edit-kelengkapan-second bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Kelengkapan Produk</option>
                    </select>
                </div>
                <div class="relative z-0 col-span-2 w-full group">
                    <label for="edit-sn-second-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Serial Number :</label>
                    <select name="sn_second[]" id="edit-sn-second-${formLength}" data-id="${formLength}" class="edit-sn-second bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Serial Number</option>

                    </select>
                </div>
                <div class="relative z-0 col-span-2 w-full group items-center">
                    <label for="edit-harga-satuan-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Harga Satuan :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="harga_satuan_second[]" id="edit-harga-satuan-${formLength}" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly>
                    </div>
                </div>
                <div class="flex col-span-1 justify-center items-center">
                    <button type="button" class="remove-edit-kelengkapan-second" data-id="${formLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `;
        containerEditKelengkapan.append(tambahFormKelengkapan);

        fetch(`/kios/product/getKelengkapanSecond`)
        .then(response => response.json())
        .then(data => {

            $('#select-edit-kelengkapan-second-' + formLength).html('');

            const defaultOption = $('<option>', {
                text: 'Pilih Kelengkapan Produk',
                hidden: true
            });
            $('#select-edit-kelengkapan-second-' + formLength).append(defaultOption);

            const kelengkapanUnique = new Set();

            data.forEach(entry => {
                if (entry.produk_kelengkapan_id && !kelengkapanUnique.has(entry.produk_kelengkapan_id)) {
                    kelengkapanUnique.add(entry.produk_kelengkapan_id);

                    const option = $('<option>', {
                        value: entry.produk_kelengkapan_id,
                        text: entry.kelengkapans.kelengkapan
                    });

                    $('#select-edit-kelengkapan-second-' + formLength).append(option);
                }
            });
        })
        .catch(error => {
            alert('Error fetching data: ' + error);
        });

    });

    $(document).on('change', '.select-edit-kelengkapan-second', function () {
        let ksId = $(this).data("id");
        const valKelengkapan = $("#select-edit-kelengkapan-second-"+ksId).val();
        
        fetch(`/kios/product/getSNSecond/${valKelengkapan}`)
        .then(response => response.json())
        .then(data => {
            $('#edit-sn-second-' + ksId).html('');

            data.forEach(entry => {
                const defaultOption = $('<option>', {
                    text: 'Pilih Serial Number',
                    hidden: true
                });
                $('#edit-sn-second-' + ksId).append(defaultOption);

                const option = $('<option>', {
                    value: entry.pivot_qc_id,
                    text: entry.serial_number
                });
                $('#edit-sn-second-' + ksId).append(option);
            });
        })
        .catch(error => {
            alert('Error fetching data:' + error);
        });
    });

    $(document).on('change', '.edit-sn-second', function () {
        let snID = $(this).data("id");
        const valSn = $("#edit-sn-second-"+snID).val();
        const priceSatuan = $('#edit-harga-satuan-' + snID);
        
        fetch(`/kios/product/getPriceSecond/${valSn}`)
        .then(response => response.json())
        .then(data => {
            priceSatuan.html('');

            priceSatuan.val(formatRupiah(data));

            hitungNominalModalEdit();
            checkButtonEditKelengkapanSecond();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    });

    $(document).on('click', '.remove-edit-kelengkapan-second', function () {
        let formId = $(this).data("id");
        $(`#form-edit-kelengkapan-second-${formId}`).remove();
        hitungNominalModalEdit();
        checkButtonEditKelengkapanSecond();
    });

    $(document).on('change', '#edit-harga-jual-second', function () {
        checkButtonEditKelengkapanSecond();
    });

    function checkButtonEditKelengkapanSecond() {
        let nominalModalEdit = parseFloat($('#edit-modal-awal-second').val().replace(/\D/g, ''));
        let nominalSrpEdit = parseFloat($('#edit-harga-jual-second').val().replace(/\D/g, ''));

        if (nominalModalEdit < nominalSrpEdit) {
            $('#edit-data-produk-second').removeClass('cursor-not-allowed').removeAttr('disabled', true);
        } else {
            $('#edit-data-produk-second').addClass('cursor-not-allowed').attr('disabled', true);
        }
    }

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

    function hitungNominalModalEdit() {
        var nilaiSatuanInputs = document.getElementsByName('harga_satuan_second[]');
        var totalHargaSatuan = 0;

        for (var i = 0; i < nilaiSatuanInputs.length; i++) {
            var nilaiSatuan = parseFloat(nilaiSatuanInputs[i].value.replace(/\./g, ''));
            totalHargaSatuan += nilaiSatuan;
        }

        $('#edit-modal-awal-second').val(formatRupiah(totalHargaSatuan));
    }
});