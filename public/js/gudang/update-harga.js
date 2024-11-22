$(document).ready(function () {
    $(document).on('change', '.harga-internal, .harga-global', function () {
        let dataId = $(this).data("id");
        var hargaInternal = $('#harga-internal-' + dataId).val();
        var hargaGlobal = $('#harga-global-' + dataId).val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/gudang/produk/update-harga-sparepart/' + dataId,
            method: 'POST',
            headers : {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                harga_internal: hargaInternal,
                harga_global: hargaGlobal
            },
            success: function(response) {

            },
            error: function(xhr, status, error) {
                // console.log(xhr.responseText);
            }
        });
    });
})