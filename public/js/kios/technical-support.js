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

    $(document).on('change', '#new_permasalahan', function () {
        let tsPermasalahanCheckID = $(this).data("id");
        var formTsLanjut = $('form-ts-lanjut-' + tsPermasalahanCheckID);

        if ($(this).is(':checked')) {
            $('#permasalahan-lanjut-' + tsPermasalahanCheckID).remove();
            let inputPermasalahan = `
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="add_permasalahan" id="add-permasalahan-${tsPermasalahanCheckID}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                    <label for="add-permasalahan-${tsPermasalahanCheckID}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Permsaalahan</label>
                </div>
            `
            formTsLanjut.append(inputPermasalahan);
        } else {
            $('#add-permasalahan-' + tsPermasalahanCheckID).remove();
            let inputPermasalahan = `
                <div class="relative z-0 w-full mb-6 group">
                    <label for="permasalahan-lanjut-${tsPermasalahanCheckID}"></label>
                    <select name="permasalahan_lanjut" id="permasalahan-lanjut-${tsPermasalahanCheckID}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                        <option value="" hidden>Permasalahan</option>
                    </select>
                </div>
            `
            formTsLanjut.append(inputPermasalahan);
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
