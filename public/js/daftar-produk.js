$(document).ready(function () {
    const hargaJual = $('.harga_jual');
    const hargaPromo = $('.harga_promo');

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }
    
    hargaJual.on('input', function () {
        var srpValue = $(this).val();
        srpValue = srpValue.replace(/[^\d]/g, '');
        var parsedSrp = parseInt(srpValue, 10);
        $(this).val(formatRupiah(parsedSrp));
    });

    hargaPromo.on('input', function () {
        var promoValue = $(this).val();
        promoValue = promoValue.replace(/[^\d]/g, '');
        var parsedPromo = parseInt(promoValue, 10);
        $(this).val(formatRupiah(parsedPromo));
    });

});