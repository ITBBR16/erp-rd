$(document).ready(function() {

    $(document).on('change', '.status-komplain', function() {
        var inputId = $(this).data("id");
        const bankKomplain = $("#bank-transfer-id-" + inputId);
        const bankSelect = $("#bank-transfer-" + inputId);
        const statusKomplain = $("#status-komplain-" + inputId);
        const valueStatus = statusKomplain.val();
        console.log(valueStatus);
        if(valueStatus == 'Refund Transfer') {
            bankKomplain.show();
            bankSelect.attr("required", true);
        } else {
            bankKomplain.hide();
            bankSelect.removeAttr("required");
        }
    });

});