document.getElementById('new-metode-payment').addEventListener('change', function() {
    var havePayment = document.getElementById('have-payment');
    var newPayment = document.getElementById('new-paymment-metode');

    if (this.checked) {
        havePayment.style.display = 'none';
        newPayment.style.display = 'block';
    } else {
        havePayment.style.display = 'block';
        newPayment.style.display = 'none';
    }
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
