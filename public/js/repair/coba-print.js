$(document).ready(function () {
    $(document).on('click', '.button-print-penerimaan', function (e) {
        e.preventDefault();
        let formId = $(this).data("id");
        let modalPrintPenerimaan = $('#invoice-penerimaan-repair-' + formId);
        window.print(modalPrintPenerimaan);
    });
});