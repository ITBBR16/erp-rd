$(document).ready(function () {
    $(document).on('change', '.check-all-penerimaan-req-part', function () {
        let idCheckbox = $(this).data("id");
        var checkboxAll = $('#checkbox-all-penerimaan-' + idCheckbox);
        var checkboxData = $('.check-data-penerimaan[data-id="' + idCheckbox + '"]');

        if (checkboxAll.prop('checked')) {
            checkboxData.each(function () {
                $(this).prop('checked', true);
            });
        } else {
            checkboxData.each(function () {
                $(this).prop('checked', false);
            });
        }

        buttonCheck(idCheckbox);
    });

    $(document).on('change', '.check-data-penerimaan', function() {
        let idCheckbox = $(this).data("id");
        var checkboxAll = $('#checkbox-all-penerimaan-' + idCheckbox);
        var checkboxData = $('.check-data-penerimaan[data-id="' + idCheckbox + '"]');

        if (checkboxData.length === checkboxData.filter(':checked').length) {
            checkboxAll.prop('checked', true);
        } else {
            checkboxAll.prop('checked', false);
        }

        buttonCheck(idCheckbox);
    })

    function buttonCheck(idForm) {
        var anyChecked = $('#container-data-penerimaan-req-part-' + idForm + ' input[type="checkbox"]:checked').length > 0;

        if (!anyChecked) {
            $("#button-penerimaan-req-part-" + idForm).addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            $("#button-penerimaan-req-part-" + idForm).removeClass('cursor-not-allowed').prop('disabled', false);
        }
    }
});
