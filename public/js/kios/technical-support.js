$(document).ready(function () {
    $(document).on('change', '#checkbox-all', function () {
        var checkboxTs = $('.checkbox-ts');

        if (this.checked) {
            checkboxTs.each(function () {
                this.checked = true;
            });
            buttonCheckbox();
        } else {
            checkboxTs.each(function () {
                this.checked = false;
            });
        }

        buttonCheckbox();

    });

    $('#container-data-ts input[type="checkbox"]').change(function() {
        buttonCheckbox();
    });

    function buttonCheckbox() {
        var anyChecked = $('#container-data-ts input[type="checkbox"]:checked').length > 0;

        if (!anyChecked) {
            $("#button-checkbox").addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            $("#button-checkbox").removeClass('cursor-not-allowed').removeAttr('disabled', true);
        }
    }

});
