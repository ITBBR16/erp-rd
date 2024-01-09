$(document).ready(function() {
    const statusKomplain = $("#status-komplain");
    const bankKomplain = $("#bank-transfer-id");

    statusKomplain.on('change', function() {
        const valueStatus = statusKomplain.val();
        console.log(valueStatus);
        if(valueStatus == 'Refund Transfer') {
            bankKomplain.show();
        } else {
            bankKomplain.hide();
        }

    });

});