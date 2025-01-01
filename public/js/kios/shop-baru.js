$(document).ready(function() {

    $(document).on('change', '.select-new-belanja', function () {
        updateOptionNewBelanja();
        updateOrderSummaryBaru();
    });

    $(document).on('change', '.kios-baru-qty', function () {
        updateOrderSummaryBaru();
    });

    $(document).on('input', '.number-format', function () {
        var inputNumber = $(this).val();
        inputNumber = inputNumber.replace(/[^\d]/g, '');

        if (inputNumber === '') {
            inputNumber = '0';
        }

        var parsedNumber = parseInt(inputNumber, 10);
        $(this).val(parsedNumber);
    });

    $(document).on('click', '#add-new-belanja', function () {
        let formBBLength = $('.select-new-belanja').length;
        let lastSelect = $('#paket-penjualan-' + formBBLength);

        if (lastSelect.length && lastSelect.val() === '') {
            alert("Selesaikan list belanja sebelumnya.");
            return
        }
        
        formBBLength++
        let newFormBelanja = `
            <div id="data-form-belanja-baru-${formBBLength}" class="form-kb grid grid-cols-3 gap-6" style="grid-template-columns: 5fr 3fr 1fr">
                <div>
                    <label for="paket-penjualan-${formBBLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                    <select name="paket_penjualan[]" id="paket-penjualan-${formBBLength}" class="select-new-belanja bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Paket Penjualan</option>`;
                        paketPenjualan.forEach(function(item) {
                            newFormBelanja += `<option value="${item.id}" class="bg-white dark:bg-gray-700">${item.paket_penjualan}</option>`;
                        });
                        newFormBelanja += `
                    </select>
                </div>
                <div>
                    <label for="quantity-${formBBLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Quantity : </label>
                    <input type="text" name="quantity[]" id="quantity-${formBBLength}" class="number-format kios-baru-qty bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                </div>
                <div class="flex justify-center mt-10">
                    <button type="button" class="remove-form-pembelian" data-id="${formBBLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span>
                    </button>
                </div>
            </div>
        `
        $('#form-new-belanja').append(newFormBelanja);

        updateOptionNewBelanja();
    });

    $(document).on("click", ".remove-form-pembelian", function() {
        let formId = $(this).data("id");
        $("#data-form-belanja-baru-"+formId).remove();
        updateOrderSummaryBaru();
    });

    $(document).on('click', '#add-form-validasi-belanja', function () {
        let formValLength = $('.val-seri-drone').length;
        let lastSelect = $(`#val-qty-buy-baru-${formValLength}`);
        if (lastSelect.length && lastSelect.val() === '') {
            alert("Selesaikan list belanja sebelumnya.");
            return
        }
        formValLength++
        let newFormValidasi = `
            <div id="container-form-validasi-${formValLength}" class="container-form-val grid grid-cols-4 mb-4 gap-4" style="grid-template-columns: 5fr 2fr 4fr 1fr">
                <div class="relative z-0 w-full group">
                    <select name="jenis_paket[]" id="jenis-paket${formValLength}" class="val-seri-drone block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                        <option value="" hidden>Paket Penjualan</option>`;
                        paketPenjualan.forEach(function(item) {
                            newFormValidasi += `<option value="${item.id}" class="bg-white dark:bg-gray-700">${item.paket_penjualan}</option>`;
                        });
                        newFormValidasi += `
                    </select>
                </div>
                <div class="relative z-0 w-full group">
                    <input type="text" name="quantity[]" id="val-qty-buy-baru-${formValLength}" class="format-angka block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="0" required>
                    <label for="val-qty-buy-baru-${formValLength}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label>
                </div>
                <div class="relative z-0 w-full group flex items-center">
                    <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                    <input type="text" name="nilai[]" id="val-nilai-buy-baru${formValLength}" class="val-nilai-buy-baru block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="0" required>
                    <label for="val-nilai-buy-baru${formValLength}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Harga /pcs</label>
                </div>
                <div class="flex justify-center items-center col-span-1">
                    <button type="button" class="remove-form-validasi" data-id="${formValLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `

        $('#form-validasi').append(newFormValidasi);
        updateOptionValidasiBelanja();
    });

    $(document).on("click", ".remove-form-validasi", function() {
        let formId = $(this).data("id");
        $("#container-form-validasi-"+formId).remove();
        updateOptionValidasiBelanja();
        updateOrderSummaryValidasi();
    });

    $(document).on('change', '.val-seri-drone, .val-qty-baru, .val-nilai-buy-baru', function () {
        updateOrderSummaryValidasi();
    });

    $(document).on('input', '.val-nilai-buy-baru', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatAngka(parsedValue));
    });

    $(document).on('input', '.format-angka', function () {
        var inputAngka = $(this).val();
        inputAngka = inputAngka.replace(/\D/g, '');
        $(this).val(inputAngka);
    });

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

    function updateOptionNewBelanja() {
        var selectedValue = [];
        $('.select-new-belanja').each(function () {
            selectedValue.push($(this).val());
        })

        $('.select-new-belanja').each(function () {
            var currentSelect = $(this);
            currentSelect.find('option').each(function () {
                if (selectedValue.includes($(this).val())) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    }

    function updateOptionValidasiBelanja() {
        var selectedValue = [];
        $('.val-seri-drone').each(function () {
            selectedValue.push($(this).val());
        });

        $('.val-seri-drone').each(function () {
            var currentSelect = $(this);
            currentSelect.find('option').each(function () {
                if (selectedValue.includes($(this).val())) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    }

    function updateOrderSummaryBaru() {
        let totalItem = 0;
        let totalQty = 0;

        $('#form-new-belanja .form-kb').each(function () {
            let totalJenis = $(this).find('.select-new-belanja').length;
            let qty = parseFloat($(this).find('.kios-baru-qty').val()) || 0;

            totalItem += totalJenis;
            totalQty += qty;
        });

        $('#total-item-belanja-baru').text(totalItem + " Unit");
        $('#total-qty-belanja-baru').text(totalQty + " Unit");
    }

    function updateOrderSummaryValidasi() {
        let totalItemVal = 0;
        let totalQtyVal = 0;
        let totalNominalVal = 0;

        $('#form-validasi .container-form-val').each(function () {
            let totalSeriVal = $(this).find('.val-seri-drone').length;
            let qtyVal = parseFloat($(this).find('.val-qty-baru').val()) || 0;
            let nominalVal = parseFloat($(this).find('.val-nilai-buy-baru').val().replace(/\./g, '')) || 0;
            let total = qtyVal * nominalVal;
            totalItemVal += totalSeriVal;
            totalQtyVal += qtyVal;
            totalNominalVal += total;
        });

        $('#validasi-item-total').text(totalItemVal + " Unit");
        $('#validasi-total-qty').text(totalQtyVal + " Unit");
        $('#validasi-total-nominal').text("Rp. " + formatAngka(totalNominalVal));
    }

});
