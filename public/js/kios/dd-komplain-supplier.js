$(document).ready(function() {

    $(document).on('change', '.status-komplain', function() {
        var inputId = $(this).data("id");
        const bankKomplain = $("#bank-transfer-id-" + inputId);
        const supplierKios = $("#container-komplain-supplier-" + inputId);
        const bankSelect = $("#bank-transfer-" + inputId);
        const statusKomplain = $(this).find("option:selected").text();
    
        bankKomplain.hide();
        supplierKios.hide();
        bankSelect.removeAttr("required");
        console.log(statusKomplain);
        if (statusKomplain == 'Refund Transfer') {
            bankKomplain.show();
            bankSelect.attr("required", true);
        } else if (statusKomplain == 'Refund Deposit') {
            supplierKios.show();
        }
    });

});