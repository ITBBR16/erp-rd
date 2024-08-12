$(document).ready(function () {
    $(document).on('click', '#button-print-penerimaan', function (e) {
        e.preventDefault();
        window.print();
    });
})