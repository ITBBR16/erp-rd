$(document).ready(function () {
    $('#option-jenis-form').change(function () {
        var selectedValue = $(this).val();
        $('#table-form-pickup, #table-form-resi').hide();
        $('#option-ekspedisi').val('');

        if (selectedValue === 'form-pickup') {
            $('#table-form-pickup').show();
        } else if (selectedValue === 'form-input-resi') {
            $('#table-form-resi').show();
        }
    });

    $('#option-ekspedisi').change(function () {
        var selectedValue = $(this).val();
        var jenisForm = $('#option-jenis-form').val();
        
        if (jenisForm == 'form-pickup') {
            var containerForm = $('#container-pickup-logistik');
        } else if (jenisForm == 'form-input-resi') {
            var containerForm = $('#container-input-resi');
        } else {
            return alert('Jenis Form tidak terdeteksi silahkan pilih jenis form terlebih dahulu');
        }

        fetch(`/logistik/get-data-req-packing/${jenisForm}/${selectedValue}`)
        .then(response => response.json())
        .then(data => {
            containerForm.empty();

            if (data.length === 0) {
                var formKosong = `
                    <tr>
                        <td colspan="5" class="text-center p-4 text-black font-semibold">Data Ekspedisi Tidak Ada.</td>
                    </tr>
                `;
                containerForm.append(formKosong)
                return;
            }

            data.forEach(function(item) {
                let form = "";

                if (jenisForm == 'form-pickup') {
                    form = `
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="checkbox_select_pickup[]" id="checkbox-pickup-${item.id}" value="${item.id}" class="check-data-pickup w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                ${item.customer.first_name} ${item.customer.last_name} - ${item.customer.id}
                            </td>
                            <td class="px-6 py-2">
                                ${item.layanan_ekspedisi.ekspedisi.ekspedisi}
                            </td>
                        </tr>
                    `;
                } else if (jenisForm == 'form-input-resi') {
                    form = `
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="checkbox_select_resi[]" id="checkbox-resi-${item.id}" value="${item.id}" class="check-data-resi w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                ${item.customer.first_name} ${item.customer.last_name} - ${item.customer.id}
                            </td>
                            <td class="px-6 py-2">
                                <input type="text" name="no_resi[${item.id}]" id="no-resi-${item.id}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="No Resi">
                            </td>
                            <td class="px-6 py-2">
                                <input type="text" name="nominal_ongkir[${item.id}]" id="nominal-ongkir-${item.id}" class="format-angka-logistik rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nominal Ongkir">
                            </td>
                            <td class="px-6 py-2">
                                <input type="text" name="nominal_packing[${item.id}]" id="nominal-packing-${item.id}" class="format-angka-logistik rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nominal Packing">
                            </td>
                        </tr>
                    `;
                } else {
                    alert('Jenis Form tidak terdeteksi, silahkan pilih jenis form terlebih dahulu');
                    return;
                }

                containerForm.append(form);
            });
        })
        .catch(error => {
            alert('Error Fetching Data: ' + error);
        });

    });

    $(document).on('input', '.format-angka-logistik', function () {
        var inputActive = $(this).val();
        inputActive = inputActive.replace(/[^\d]/g, '');
        var parsedNumber = parseInt(inputActive, 10);
        $(this).val(formatAngka(parsedNumber));
    });

    $('#checkbox-all-pickup').on('change', function() {
        $('.check-data-pickup').prop('checked', this.checked);
        buttonCheckPickup()
    });

    $(document).on('change', '.check-data-pickup', function() {
        let totalCheckboxes = $('.check-data-pickup').length;
        let checkedCheckboxes = $('.check-data-pickup:checked').length;
        
        $('#checkbox-all-pickup').prop('checked', totalCheckboxes === checkedCheckboxes);
        buttonCheckPickup()
    });

    $('#checkbox-all-resi').on('change', function() {
        $('.check-data-resi').prop('checked', this.checked);
        buttonCheckResi()
    });

    $(document).on('change', '.check-data-resi', function() {
        let totalCheckboxes = $('.check-data-resi').length;
        let checkedCheckboxes = $('.check-data-resi:checked').length;
        
        $('#checkbox-all-pickup').prop('checked', totalCheckboxes === checkedCheckboxes);
        buttonCheckResi()
    });

    function buttonCheckResi() {
        let checkedCheckboxes = $('.check-data-resi:checked').length > 0;

        if (!checkedCheckboxes) {
            $("#btn-frp").addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            $("#btn-frp").removeClass('cursor-not-allowed').prop('disabled', false);
        }
    }

    function buttonCheckPickup() {
        let checkedCheckboxes = $('.check-data-pickup:checked').length > 0;

        if (!checkedCheckboxes) {
            $("#btn-frp").addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            $("#btn-frp").removeClass('cursor-not-allowed').prop('disabled', false);
        }
    }

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

});
