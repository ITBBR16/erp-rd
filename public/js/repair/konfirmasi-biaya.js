function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

$(document).ready(function () {
    let countForm = $('#container-estimasi-active tr').length;

    // Active Form
    $(document).on('click', '#add-ubah-estimasi', function () {
        countForm++;
        const containerEstimasi = $('#container-estimasi-active');
        const containerGudang = $('#container-data-gudang-active');
        let itemForm = `
            <tr id="konfirmasi-estimasi-${countForm}" class="bg-white dark:bg-gray-800">
                <td class="px-2 py-4">
                    <select name="jenis_transaksi[]" id="estimasi-jt-${countForm}" data-id="${countForm}" class="estimasi-jt bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Transaksi</option>`;
                        jenisTransaksi.forEach(function(item) {
                            itemForm += `<option value="${item.id}">${item.code_jt}</option>`
                        });
                        itemForm += `
                    </select>
                </td>
                <td class="px-2 py-4" id="konfirmasi-jpj-container-${countForm}">
                    <select name="jenis_part_jasa[]" id="konfirmasi-jp-${countForm}" data-id="${countForm}" class="konfirmasi-jp bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Produk</option>
                    </select>
                </td>
                <td class="px-2 py-4" id="konfirmasi-part-jasa-container-${countForm}">
                    <select name="nama_part_jasa[]" id="konfirmasi-part-${countForm}" data-id="${countForm}" class="konfirmasi-part bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
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
                    <button type="button" data-id="${countForm}" class="remove-form-konfirmasi">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </td>
            </tr>
        `

        let itemFG = `
            <tr id="konfirmasi-data-gudang-${countForm}" class="bg-white dark:bg-gray-800">
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
                    <input type="hidden" name="modal_gudang[]" id="konfirmasi-modal-gudang-${countForm}">
                    <div class="relative z-0 w-full group flex items-center">
                        <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                        <input name="harga_gudang[]" id="harga-gudang-${countForm}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly>
                    </div>
                </td>
            </tr>
        `

        containerEstimasi.append(itemForm);
        containerGudang.append(itemFG);
        buttonCheckbox();
    });

    $(document).on('click', '.remove-form-konfirmasi', function () {
        let idForm = $(this).data("id");
        $('#konfirmasi-estimasi-' + idForm).remove();
        $('#konfirmasi-data-gudang-' + idForm).remove();
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

        $('#konfirmasi-jp-' + formId).remove();
        $('#konfirmasi-part-' + formId).remove();

        $('#konfirmasi-part-' + formId).val('');
        $('#nama-alias-' + formId).val('');
        $('#harga-customer-' + formId).val('');

        $('#stok-part-' + formId).val('');
        $('#harga-repair-' + formId).val('');
        $('#harga-gudang-' + formId).val('');
        $('#harga-promo-part-' + formId).val('');
        $('#konfirmasi-modal-gudang-' + formId).val('');
        
        if (jenisTransaksi  == 'P.Baru' || jenisTransaksi == 'P.Bekas') {
            let itemJpPart = `
                        <select name="jenis_part_jasa[]" id="konfirmasi-jp-${formId}" data-id="${formId}" class="konfirmasi-jp bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" hidden>Pilih Jenis Produk</option>
                        </select>
            `

            let itemNpjPart = `
                <select name="nama_part_jasa[]" id="konfirmasi-part-${formId}" data-id="${formId}" class="konfirmasi-part bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>Pilih Part</option>
                </select>
            `
            $('#konfirmasi-jpj-container-' + formId).append(itemJpPart)
            $('#konfirmasi-part-jasa-container-' + formId).append(itemNpjPart)

            konfirmasiGetJenisDrone(formId);
        } else {
            let itemJpJasa = `<input type="text" name="jenis_part_jasa[]" id="konfirmasi-jp-${formId}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jenis Jasa">`
            let itemNpjJasa = `<input type="text" name="nama_part_jasa[]" id="konfirmasi-part-${formId}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Jasa">`
            $('#konfirmasi-jpj-container-' + formId).append(itemJpJasa)
            $('#konfirmasi-part-jasa-container-' + formId).append(itemNpjJasa)
        }

    });

    $(document).on('change', '.konfirmasi-jp', function () {
        let jpId = $(this).data("id");
        var jpValue = $(this).val();
        var jenisTransaksi = $('#estimasi-jt-' + jpId + ' option:selected').text();
        
        if (jenisTransaksi  == 'P.Baru' || jenisTransaksi == 'P.Bekas') {
            konfirmasiGetNamaPart(jpId, jpValue);
        }
    });

    $(document).on('change', '.konfirmasi-part', function () {
        let partId = $(this).data("id");
        var sku = $(this).val();
        var jenisTransaksi = $('#estimasi-jt-' + partId + ' option:selected').text();
        console.log(sku);
        if (jenisTransaksi  == 'P.Baru' || jenisTransaksi == 'P.Bekas') {
            konfirmasiGetDetailPart(partId, sku);
        }
    });

    // Deactive Form
    $(document).on('click', '.deactive-form-estimasi', function() {
        var index = $(this).data("id");
        var estimasiActive = $('#konfirmasi-estimasi-' + index);
        var gudangActive = $('#konfirmasi-data-gudang-' + index);
        var statusActive = $('#status-active-' + index);
        var deactiveContainerEstimasi = $('#container-estimasi-deactive');
        var deactiveContainerGudang = $('#container-data-gudang-deactive');

        estimasiActive.appendTo(deactiveContainerEstimasi);
        statusActive.val('Deactive');

        $(this).removeClass('deactive-form-estimasi').addClass('activate-button');
        $(this).find('span').text('add_circle');

        gudangActive.appendTo(deactiveContainerGudang);
    });

    $(document).on('click', '.activate-button', function() {
        var index = $(this).data("id");
        var deactiveEstimasi = $('#konfirmasi-estimasi-' + index);
        var deactiveGudang = $('#konfirmasi-data-gudang-' + index);
        var statusActive = $('#status-active-' + index);
        var activeContainerEstimasi = $('#container-estimasi-active');
        var activeContainerGudang = $('#container-data-gudang-active');

        deactiveEstimasi.appendTo(activeContainerEstimasi);
        statusActive.val('Active');

        $(this).removeClass('activate-button').addClass('deactive-form-estimasi');
        $(this).find('span').text('delete');

        deactiveGudang.appendTo(activeContainerGudang);
    });

    $(document).on('click', '.submit-konfirmasi-estimasi', function () {
        let idForm = $(this).data("id");
        var value = $(this).val();
        var formInput = $('#konfirmasi-customer-' + idForm);
        formInput.val(value);
    });

    // All function need
    function konfirmasiGetJenisDrone(formId) {
        var inputJP = $('#konfirmasi-jp-' + formId);
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

    function konfirmasiGetNamaPart(formId, jenisDrone) {
        var inputPart = $('#konfirmasi-part-' + formId);
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

    function konfirmasiGetDetailPart(formId, sku) {
        var stockPart = $('#stok-part-' + formId);
        var hargaJualRepair = $('#harga-repair-' + formId);
        var hargaJualGudang = $('#harga-gudang-' + formId);
        var hargaPromoGudang = $('#harga-promo-part-' + formId);
        var hargaModalGudang = $('#konfirmasi-modal-gudang-' + formId);

        fetch(`/repair/estimasi/getDetailGudang/${sku}`)
        .then(response => response.json())
        .then(data => {
            
            var stock = data.stock || 0
            var hargaGlobal = data.detail.harga_global || 0
            var hargaInternal = data.detail.harga_internal || 0
            var hargaPromo = data.detail.harga_promo || 0

            stockPart.val(stock);
            hargaJualRepair.val(formatAngka(hargaInternal));
            hargaJualGudang.val(formatAngka(hargaGlobal));
            hargaModalGudang.val(formatAngka(0));
            hargaPromoGudang.val(formatAngka(hargaPromo));

        });
    }

    function buttonCheckbox() {
        var anyChecked = $('#container-estimasi-active tr').length > 0;

        if (!anyChecked) {
            $("#ubah-estimasi").addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            $("#ubah-estimasi").removeClass('cursor-not-allowed').removeAttr('disabled', true);
        }
    }

});