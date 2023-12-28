$(document).ready(function() {
    $(document).on('change', '#new-metode-payment-edit', function() {
        let formId = $(this).data("id");
       
        var havePaymentEdit = $("#have-payment-edit-"+formId);
        var newPaymentEdit = $("#new-payment-metode-edit-"+formId);
        
        if ($(this).is(':checked')) {
            havePaymentEdit.hide();
            newPaymentEdit.show();
        } else {
            havePaymentEdit.show();
            newPaymentEdit.hide();
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
