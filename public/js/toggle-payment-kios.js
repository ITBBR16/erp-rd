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

function toggleFormPayment(formId) {
    var forms = ['unpaid-kios', 'done-payment-kios'];
    var activeButtonId = formId === 'unpaid-kios' ? 'belum-bayar' : 'sudah-bayar';
    var inactiveButtonId = formId === 'unpaid-kios' ? 'sudah-bayar' : 'belum-bayar';

    forms.forEach(function (form) {
        document.getElementById(form).style.display = 'none';
    });

    document.getElementById(formId).style.display = 'block';

    document.getElementById(activeButtonId).classList.remove('text-rose-600');
    document.getElementById(activeButtonId).classList.add('text-white', 'bg-rose-700');

    document.getElementById(inactiveButtonId).classList.remove('text-white', 'bg-rose-700');
    document.getElementById(inactiveButtonId).classList.add('text-rose-600');
}
