function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

$(document).ready(function () {
    let countForm = 1;

    $(document).on('click', '#add-item-estimasi', function () {
        countForm++;
        const containerEstimasi = $('#container-input-estimasi');
        const containerGudang = $('#container-data-gudang');
        let itemForm = `
            <tr id="input-estimasi-${countForm}" class="bg-white dark:bg-gray-800">
                <td class="px-2 py-4">
                    <select name="jenis_transaksi[]" id="estimasi-jt-${countForm}" data-id="${countForm}" class="estimasi-jt bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Transaksi</option>`;
                        jenisTransaksi.forEach(function(item) {
                            itemForm += `<option value="${item.id}">${item.code_jt}</option>`
                        });
                        itemForm += `
                    </select>
                </td>
                <td class="px-2 py-4" id="estimasi-jpj-container-${countForm}">
                    <select name="jenis_part_jasa[]" id="estimasi-jp-${countForm}" data-id="${countForm}" class="estimasi-jp bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Produk</option>
                    </select>
                </td>
                <td class="px-2 py-4" id="estimasi-part-jasa-container-${countForm}">
                    <select name="nama_part_jasa[]" id="estimasi-part-${countForm}" data-id="${countForm}" class="estimasi-part bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Part</option>
                    </select>
                </td>
                <td class="px-2 py-4">
                    <input type="text" name="nama_alias[]" id="nama-alias-${countForm}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Alias">
                </td>
                <td class="px-2 py-4">
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="harga_customer[]" id="harga-customer-${countForm}" class="format-angka-estimasi rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </td>
                <td class="px-2 py-4 text-center">
                    <button type="button" data-id="${countForm}" class="remove-form-estimasi">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </td>
            </tr>
        `;

        let itemFG = `
            <tr id="data-gudang-${countForm}" class="bg-white dark:bg-gray-800">
                <td class="px-2 py-4">
                    <div class="relative z-0 w-full">
                        <input name="stok_part[]" id="stok-part-${countForm}" type="text" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly>
                    </div>
                </td>
                <td class="px-2 py-4">
                    <div class="relative z-0 w-full group flex items-center">
                        <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                        <input name="harga_promo_part[]" id="harga-promo-part-${countForm}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly>
                    </div>
                </td>
                <td class="px-2 py-4">
                    <div class="relative z-0 w-full group flex items-center">
                        <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                        <input name="harga_repair[]" id="harga-repair-${countForm}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly>
                    </div>
                </td>
                <td class="px-2 py-4">
                    <input type="hidden" name="modal_gudang[]" id="estimasi-modal-gudang-${countForm}">
                    <div class="relative z-0 w-full group flex items-center">
                        <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                        <input name="harga_gudang[]" id="harga-gudang-${countForm}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly>
                    </div>
                </td>
            </tr>
        `;

        containerEstimasi.append(itemForm);
        containerGudang.append(itemFG);
        buttonCheckbox();
    });

    $(document).on('click', '.remove-form-estimasi', function () {
        let idForm = $(this).data("id");
        $('#input-estimasi-' + idForm).remove();
        $('#data-gudang-' + idForm).remove();
        countForm--;
        buttonCheckbox();
    });

    $(document).on('input', '.format-angka-estimasi', function () {
        var inputActive = $(this).val();
        inputActive = inputActive.replace(/[^\d]/g, '');
        var parsedNumber = parseInt(inputActive, 10);
        $(this).val(formatAngka(parsedNumber));
    });

    $(document).on('change', '.estimasi-jt', function () {
        let formId = $(this).data("id");
        var jenisTransaksi = $('#estimasi-jt-' + formId +' option:selected').text();

        $('#estimasi-jp-' + formId).remove();
        $('#estimasi-part-' + formId).remove();

        $('#estimasi-part-' + formId).val('');
        $('#nama-alias-' + formId).val('');
        $('#harga-customer-' + formId).val('');

        $('#stok-part-' + formId).val('');
        $('#harga-repair-' + formId).val('');
        $('#harga-gudang-' + formId).val('');
        $('#harga-promo-part-' + formId).val('');
        $('#estimasi-modal-gudang-' + formId).val('');
        
        if (jenisTransaksi  == 'P.Baru' || jenisTransaksi == 'P.Bekas') {
            let itemJpPart = `
                <select name="jenis_part_jasa[]" id="estimasi-jp-${formId}" data-id="${formId}" class="estimasi-jp bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>Pilih Jenis Produk</option>
                </select>
            `;

            let itemNpjPart = `
                <select name="nama_part_jasa[]" id="estimasi-part-${formId}" data-id="${formId}" class="estimasi-part bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>Pilih Part</option>
                </select>
            `;
            $('#estimasi-jpj-container-' + formId).append(itemJpPart);
            $('#estimasi-part-jasa-container-' + formId).append(itemNpjPart);

            getJenisDrone(formId);
        } else {
            let itemJpJasa = `<input type="text" name="jenis_part_jasa[]" id="estimasi-jp-${formId}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" disabled>`
            let itemNpjJasa = `<input type="text" name="nama_part_jasa[]" id="estimasi-part-${formId}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jasa" required>`
            $('#estimasi-jpj-container-' + formId).append(itemJpJasa)
            $('#estimasi-part-jasa-container-' + formId).append(itemNpjJasa)
        }

    });

    $(document).on('change', '.estimasi-jp', function () {
        let jpId = $(this).data("id");
        var jpValue = $(this).val();
        var jenisTransaksi = $('#estimasi-jt-' + jpId + ' option:selected').text();
        
        if (jenisTransaksi  == 'P.Baru' || jenisTransaksi == 'P.Bekas') {
            getNamaPart(jpId, jpValue);
        }
    });

    $(document).on('change', '.estimasi-part', function () {
        let partId = $(this).data("id");
        var sku = $(this).val();
        var textNamaPart = $('#estimasi-part-' + partId + ' option:selected').text();
        var inputNamaPart = $('#nama-part-' + partId);
        var jenisTransaksi = $('#estimasi-jt-' + partId + ' option:selected').text();
        inputNamaPart.val('');

        if (jenisTransaksi  == 'P.Baru' || jenisTransaksi == 'P.Bekas') {
            inputNamaPart.val(textNamaPart);
            getDetailPart(partId, sku);
        }
    });

    function getJenisDrone(formId) {
        var inputJP = $('#estimasi-jp-' + formId);
        fetch(`/repair/estimasi/jenisDrone`)
        .then(response => response.json())
        .then(data => {
            inputJP.empty();

            const defaultOption = $('<option>', {
                text: 'Pilih Jenis Produk',
                value: '',
                hidden: true
            });
            inputJP.append(defaultOption);

            data.forEach(produk => {
                const option = $('<option>', {
                    value: produk.id,
                    text: produk.jenis_produk
                })
                .addClass('bg-white dark:bg-gray-700')
                inputJP.append(option)
            });

        });
    }

    function getNamaPart(formId, jenisDrone) {
        var inputPart = $('#estimasi-part-' + formId);
        fetch(`/repair/estimasi/getPartGudang/${jenisDrone}`)
        .then(response => response.json())
        .then(data => {
            inputPart.empty();

            const defaultOption = $('<option>', {
                text: 'Pilih Part',
                value: '',
                hidden: true
            });
            inputPart.append(defaultOption);

            data.forEach(part => {
                const option = $('<option>', {
                    value: part.id,
                    text: part.nama_internal
                })
                .addClass('bg-white dark:bg-gray-700')
                inputPart.append(option)
            });

        });
    }

    function getDetailPart(formId, sku) {
        var stockPart = $('#stok-part-' + formId);
        var hargaJualRepair = $('#harga-repair-' + formId);
        var hargaJualGudang = $('#harga-gudang-' + formId);
        var hargaPromoGudang = $('#harga-promo-part-' + formId);
        var hargaModalGudang = $('#estimasi-modal-gudang-' + formId);

        fetch(`/repair/estimasi/getDetailGudang/${sku}`)
        .then(response => response.json())
        .then(data => {
            
            stockPart.val(data.stock);
            hargaJualRepair.val(formatAngka(data.detail.harga_internal));
            hargaJualGudang.val(formatAngka(data.detail.harga_global));
            hargaModalGudang.val(formatAngka(data.detail.modal_awal));
            hargaPromoGudang.val(formatAngka(data.detail.harga_promo));

        });
    }

    function buttonCheckbox() {
        var anyChecked = $('#container-input-estimasi tr').length > 0;

        if (!anyChecked) {
            $("#estimasi-button").addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            $("#estimasi-button").removeClass('cursor-not-allowed').removeAttr('disabled', true);
        }
    }

});