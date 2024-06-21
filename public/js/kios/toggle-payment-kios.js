$(document).ready(function() {
    $(document).on('change', '#new-metode-payment-edit', function() {
        let formId = $(this).data("id");
       
        var editMediaPembayaran = $('#media-pembayaran-' + formId);
        var editNoRek = $('#no-rek-' + formId);
        var editNamaAkun = $('#nama-akun-' + formId);
        
        if ($(this).is(':checked')) {
            editMediaPembayaran.prop("readonly", false);
            editNoRek.prop("readonly", false);
            editNamaAkun.prop("readonly", false);
        } else {
            editMediaPembayaran.prop("readonly", true);
            editNoRek.prop("readonly", true);
            editNamaAkun.prop("readonly", true);
        }
    });
    
    $('#new-metode-payment').on('change', function() {
        var havePayment = $('#have-payment');
        var newPayment = $('#new-paymment-metode');
        
        if ($(this).is(':checked')) {
            havePayment.hide();
            newPayment.show();
        } else {
            havePayment.show();
            newPayment.hide();
        }
    });

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

    $(document).on('input', '.ongkir-payment', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

    $(document).on('input', '.pajak-payment', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

});

