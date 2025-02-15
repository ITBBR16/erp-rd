$(document).ready(function () {
    $(document).on('change', '#payment-ekspedisi', function () {
        var selectedValue = $(this).val();
        const containerForm = $('#container-request-payment');
        
        fetch(`/logistik/get-data-req-payment/${selectedValue}`)
        .then(respone => respone.json())
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
                var asuransi = formatAngka(item.nominal_asuransi)
                var form = `
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="check_box_payment[]" id="checkbox-payment-${item.id}" value="${item.id}" class="check-data-payment w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                ${item.no_resi}
                            </td>
                            <td class="px-6 py-2">
                                <input type="text" name="nominal_ongkir[${item.id}]" id="nominal-ongkir-${item.id}" data-id="${item.id}" class="format-angka-logistik payment-ongkir rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly>
                            </td>
                            <td class="px-6 py-2">
                                <input type="text" name="nominal_packing[${item.id}]" id="nominal-packing-${item.id}" data-id="${item.id}" class="format-angka-logistik payment-packing rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly>
                            </td>
                            <td class="px-6 py-2">
                                <input type="text" name="nominal_asuransi[${item.id}]" id="nominal-asuransi-${item.id}" data-id="${item.id}" class="format-angka-logistik payment-asuransi rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" value="${asuransi}" readonly>
                            </td>
                        </tr>
                    `;
                containerForm.append(form);
            });
        });
    });

    $('#checkbox-all-req-payment').on('change', function() {
        $('.check-data-payment').prop('checked', this.checked);
        buttonCheckPayment();
    });

    $(document).on('change', '.check-data-payment', function() {
        let totalCheckboxes = $('.check-data-payment').length;
        let checkedCheckboxes = $('.check-data-payment:checked').length;
        
        $('#checkbox-all-req-payment').prop('checked', totalCheckboxes === checkedCheckboxes);
        updateBoxTagihan();
        buttonCheckPayment();
    });

    $(document).on('change', '.payment-ongkir, .payment-packing, .payment-asuransi, #biaya-lain-lain', function () {
        updateBoxTagihan();
    });

    $("input[value='Ongkir'], input[value='Packing']").on("change", updateReadonly);

    function updateReadonly() {
        let ongkirChecked = $("input[value='Ongkir']").is(":checked");
        let packingChecked = $("input[value='Packing']").is(":checked");
        
        if (ongkirChecked && packingChecked) {
            $(".payment-ongkir, .payment-packing").prop("readonly", false);
        } else {
            $(".payment-ongkir").prop("readonly", !ongkirChecked);
            $(".payment-packing").prop("readonly", !packingChecked);
        }
    }

    function buttonCheckPayment() {
        let checkedCheckboxes = $('.check-data-payment:checked').length > 0;

        if (!checkedCheckboxes) {
            $("#btn-req-payment-logistik").addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            $("#btn-req-payment-logistik").removeClass('cursor-not-allowed').prop('disabled', false);
        }
    }

    function updateBoxTagihan() {
        var totalOngkir = 0;
        var totalPacking = 0;
        var totalAsuransi = 0;
        var biayaLainlain = parseFloat(($('#biaya-lain-lain').val() || "0").replace(/\D/g, '')) || 0;

        if ($('#checkbox-input-ongkir').prop('checked')) {
            $('.payment-ongkir').each(function () {
                var row = $(this).closest('tr');
                if (row.find('.check-data-payment').prop('checked')) {
                    let ongkir = parseFloat(($(this).val() || "0").replace(/\D/g, '')) || 0;
                    totalOngkir += ongkir;
                }
            });
    
            $('.payment-asuransi').each(function () {
                var row = $(this).closest('tr');
                if (row.find('.check-data-payment').prop('checked')) {
                    let asuransi = parseFloat(($(this).val() || "0").replace(/\D/g, '')) || 0;
                    totalAsuransi += asuransi;
                }
            });
        }

        if ($('#checkbox-input-packing').prop('checked')) {
            $('.payment-packing').each(function () {
                var row = $(this).closest('tr');
                if (row.find('.check-data-payment').prop('checked')) {
                    let packing = parseFloat(($(this).val() || "0").replace(/\D/g, '')) || 0;
                    totalPacking += packing;
                }
            });
        }

        var nilaiTotal = totalOngkir + totalPacking + totalAsuransi + biayaLainlain;

        $('#resume-ongkir').text(formatRupiah(totalOngkir));
        $('#resume-packing').text(formatRupiah(totalPacking));
        $('#resume-asuransi').text(formatRupiah(totalAsuransi));
        $('#resume-biaya-lain-lain').text(formatRupiah(biayaLainlain));
        $('#resume-nilai-total').text(formatRupiah(nilaiTotal));
    }

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
    }

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }
})