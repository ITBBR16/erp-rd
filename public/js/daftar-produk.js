$(document).ready(function () {
    const hargaJual = $('.harga_jual');
    const hargaPromo = $('.harga_promo');
    const srpDPS = $('.srp-daftar-produk-second');
    const srpDPB = $('.update-srp-baru');
    
    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

    // Daftar produk baru
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

    srpDPB.on('input', function () {
        var srpPBaru = $(this).val();
        srpPBaru = srpPBaru.replace(/[^\d]/g, '');
        var parsedSrpBaru = parseInt(srpPBaru, 10);
        $(this).val(formatRupiah(parsedSrpBaru));
    });

    $('input[id^="update-srp-baru-"]').on('input', function() {
        var productId = $(this).data('id');
        var srp = $(this).val();
        var newSrp = srp.replace(/[^\d]/g, '');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/kios/product/update-srp-baru',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                productId: productId,
                newSrp: newSrp
            },
            success: function(response) {
                // console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    function showFilterData(id, text) {
        var containerFilter = $('#container-filter');
        let kategoriFilter = `
            <div id="kategori-filter-${id}" class="flex items-center p-2 mb-4 text-gray-400 border border-gray-300 rounded-2xl bg-transparent max-w-fit">
                <div class="text-sm font-medium">
                    ${text}
                </div>
                <button type="button" data-id="${id}" class="ml-2 -mx-1.5 -my-1.5 rounded-lg text-gray-400 focus:ring-2 p-2 hover:bg-gray-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#kategori-filter-${id}">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        `

        containerFilter.append(kategoriFilter);

    }

    function getFilterData() {
        var selectedCategoriesProduk = [];
        var selectedCategoriesPaket = [];

        $('input[name="categories_produk[]"]:checked').each(function(){
            selectedCategoriesProduk.push($(this).val());
        });

        $('input[name="categories_paket[]"]:checked').each(function(){
            selectedCategoriesPaket.push($(this).val());
        });

        $.ajax({
            url: "/kios/product/list-product",
            type: "GET",
            data: {
                categories_produk: selectedCategoriesProduk,
                categories_paket: selectedCategoriesPaket
            },
            success: function(response){
                $('#produk-table').html(response);

                if ($('#produk-table tbody tr').length == 0) {
                    $('#no-results').removeClass('hidden');
                } else {
                    $('#no-results').addClass('hidden');
                }
            },
            error: function(xhr){
                $('#produk-table').addClass('hidden');
                $('#no-results').removeClass('hidden');
                console.log(xhr.responseText);
            }
        });
    }

    $(document).on('change', '.category-checkbox', function () {
        var categoryId = $(this).data("id");
        var categoryText = $(this).next('label').text();
        getFilterData();
        showFilterData(categoryId, categoryText);
    });

    // Daftar produk bekas
    srpDPS.on('input', function() {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

    $('input[id^="srp-daftar-produk-second-"]').on('input', function() {
        var productId = $(this).data('id');
        var srp = $(this).val();
        var newSrp = srp.replace(/[^\d]/g, '');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/kios/product/update-srp-second',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                productId: productId,
                newSrp: newSrp
            },
            success: function(response) {
                // console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

});