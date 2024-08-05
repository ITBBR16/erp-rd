$(document).ready(function () {
    let countJenisProduk = 1;

    $(document).on('change', '#checkbox-all', function () {
        var checkboxTs = $('.checkbox-ts');

        if (this.checked) {
            checkboxTs.each(function () {
                this.checked = true;
            });
            buttonCheckbox();
        } else {
            checkboxTs.each(function () {
                this.checked = false;
            });
        }

        buttonCheckbox();

    });

    $('#container-data-ts input[type="checkbox"]').change(function() {
        buttonCheckbox();
    });

    $(document).on('change', '#add-jenis-produk-ts', function () {
        addToBoxJenisProduk();
        checkJenisID();
        $(this).find('option:selected').remove();
    });

    $(document).on('click', '.button-delete-pdts', function () {
        let formId = $(this).data("id");
        let selectedJenisValue = $('#ajts-value-' + formId).val();
        let selectedJenisText = $('#ajts-text-' + formId).val();

        $('#add-jenis-produk-ts').append($('<option>', {
            value: selectedJenisValue,
            text: selectedJenisText
        })
        .addClass('dark:bg-gray-700'));

        $('#ajts-' + formId).remove();
        countJenisProduk--;

        checkJenisID();

    });

    $(document).on('change', '.lanjut-jp-ts', function () {
        let idForm = $(this).data("id");
        addToBoxJPLanjut(idForm);
        checkJenisLanjut(idForm);
        $('#lanjut-jenis-produk-ts-' + idForm).find('option:selected').remove();
    });

    $(document).on('click', '.button-delete-ljts', function () {
        let formId = $(this).data("id");
        let idJp = $(this).data("id-jp");
        let selectedJenisValue = $('#ljts-value-' + formId).val();
        let selectedJenisText = $('#ljts-text-' + formId).val();

        $('#lanjut-jenis-produk-ts-' + idJp).append($('<option>', {
            value: selectedJenisValue,
            text: selectedJenisText
        })
        .addClass('dark:bg-gray-700'));

        $('#ljts-' + formId).remove();
        countJenisProduk--;

        checkJenisLanjut();

    });

    $(document).on('change', '.new-permasalahan', function () {
        let tsPermasalahanCheckID = $(this).data("id");
        var ddPermasalahan = $('#dd-permasalahan-'+tsPermasalahanCheckID);
        var selectPermasalahan = $('#permasalahan-lanjut-'+tsPermasalahanCheckID);
        var newPermasalahan = $('#new-permasalahan-'+tsPermasalahanCheckID);
        var inputPermasalahan = $('#add-permasalahan-'+tsPermasalahanCheckID);

        if ($(this).is(':checked')) {
            ddPermasalahan.hide();
            selectPermasalahan.prop("required", false)
            newPermasalahan.show();
            inputPermasalahan.prop("required", true)
        } else {
            newPermasalahan.hide();
            inputPermasalahan.prop("required", false)
            ddPermasalahan.show();
            selectPermasalahan.prop("required", true).val("");
        }
    })

    function buttonCheckbox() {
        var anyChecked = $('#container-data-ts input[type="checkbox"]:checked').length > 0;

        if (!anyChecked) {
            $("#button-checkbox").addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            $("#button-checkbox").removeClass('cursor-not-allowed').removeAttr('disabled', true);
        }
    }

    function addToBoxJPLanjut(id)
    {
        countJenisProduk++;
        var boxJenisProdukTS = $('#box-selected-lanjut-jenis-ts-' + id);
        var valueSelected = $('#lanjut-jenis-produk-ts-'+id+' option:selected').val();
        var selectedText = $('#lanjut-jenis-produk-ts-'+id+' option:selected').text();

        let addFormJenisProduk = `
            <div id="ljts-${id}${countJenisProduk}" class="flex items-center text-gray-800 border-gray-300 bg-transparent dark:text-white dark:border-gray-800">
                <div class="text-sm">
                    <input type="hidden" name="lanjut_jenis_ts_id[]" id="ljts-value-${id}${countJenisProduk}" value="${valueSelected}">
                    <input type="hidden" name="aj_ts_text" id="ljts-text-${id}${countJenisProduk}" value="${selectedText}">
                    ${selectedText}
                </div>
                <button type="button" data-id-jp="${id}" data-id="${id}${countJenisProduk}" class="button-delete-ljts ml-auto -mx-1.5 -my-1.5 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-7 w-7 bg-transparent dark:text-gray-400 dark:hover:bg-gray-700" data-dismiss-target="#jp-1" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </button>
            </div>
        `

        boxJenisProdukTS.append(addFormJenisProduk);
    }

    function checkJenisLanjut(id) {
        let ekJenisID = $('#box-selected-lanjut-jenis-ts-' + id).find('input[name="lanjut_jenis_ts_id[]"]')
        if (ekJenisID.length === 0) {
            $('#lanjut-jenis-produk-ts-' + id).attr('required', 'required');
        } else {
            $('#lanjut-jenis-produk-ts-' + id).removeAttr('required', true);
        }

    }

    function addToBoxJenisProduk()
    {
        countJenisProduk++;
        var boxJenisProdukTS = $('#box-selected-jenis-ts');
        var valueSelected = $('#add-jenis-produk-ts option:selected').val();
        var selectedText = $('#add-jenis-produk-ts option:selected').text();

        let addFormJenisProduk = `
            <div id="ajts-${countJenisProduk}" class="flex items-center text-gray-800 border-gray-300 bg-transparent dark:text-white dark:border-gray-800">
                <div class="text-sm">
                    <input type="hidden" name="add_jenis_ts_id[]" id="ajts-value-${countJenisProduk}" value="${valueSelected}">
                    <input type="hidden" name="aj_ts_text" id="ajts-text-${countJenisProduk}" value="${selectedText}">
                    ${selectedText}
                </div>
                <button type="button" data-id="${countJenisProduk}" class="button-delete-pdts ml-auto -mx-1.5 -my-1.5 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-7 w-7 bg-transparent dark:text-gray-400 dark:hover:bg-gray-700" data-dismiss-target="#jp-1" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </button>
            </div>
        `

        boxJenisProdukTS.append(addFormJenisProduk);
    }

    function checkJenisID() {
        let ekJenisID = $('#box-selected-jenis-ts').find('input[name="add_jenis_ts_id[]"]')
        if (ekJenisID.length === 0) {
            $('#add-jenis-produk-ts').attr('required', 'required');
        } else {
            $('#add-jenis-produk-ts').removeAttr('required', true);
        }

    }

});
