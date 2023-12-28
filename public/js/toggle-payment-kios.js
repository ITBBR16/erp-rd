document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('new-metode-payment-edit').addEventListener('change', function() {
        console.log('halo halo');
        
        var havePaymentEdit = document.getElementById('have-payment-edit');
        var newPaymentEdit = document.getElementById('new-payment-metode-edit');
        
        console.log('this.checked:', this.checked);
    
        if (this.checked) {
            havePaymentEdit.style.display = 'none';
            newPaymentEdit.style.display = 'block';
        } else {
            havePaymentEdit.style.display = 'block';
            newPaymentEdit.style.display = 'none';
        }
    });
    
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
