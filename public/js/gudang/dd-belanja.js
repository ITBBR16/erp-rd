$(document).ready(function () {
    let formBelanjaLength = 0;

    $(document).on('click', '#add-list-belanja', function () {
        let lastSelect = $(`#belanja-spareparts-${formBelanjaLength}`);
        if (lastSelect.length && lastSelect.val() === "") {
            alert("Selesaikan list belanja sebelumnya");
            return;
        }
        formBelanjaLength++;
        const containerListBelanja = $('#container-list-belanja');
        let formListBelanja = `
            <div id="form-list-belanja-${formBelanjaLength}" class="form-lb grid grid-cols-5 gap-6" style="grid-template-columns: 5fr 5fr 2fr 3fr 1fr">
                <div>
                    <label for="belanja-jenis-drone-${formBelanjaLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                    <select name="jenis_drone[]" id="belanja-jenis-drone-${formBelanjaLength}" data-id="${formBelanjaLength}" class="jd-belanja bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Drone</option>`;
                        jenisProduk.forEach(function(jenis) {
                            formListBelanja += `<option value="${jenis.id}">${jenis.jenis_produk}</option>`
                        });
                        formListBelanja +=
                        `
                    </select>
                </div>
                <div>
                    <label for="belanja-spareparts-${formBelanjaLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sparepart :</label>
                    <select name="spareparts[]" id="belanja-spareparts-${formBelanjaLength}" data-id="${formBelanjaLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Sparepart</option>
                    </select>
                </div>
                <div>
                    <label for="belanja-sparepart-qty-${formBelanjaLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                    <input type="text" name="sparepart_qty[]" id="belanja-sparepart-qty-${formBelanjaLength}" class="number-format belanja-sparepart-qty bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                </div>
                <div>
                    <label for="belanja-nominal-pcs-${formBelanjaLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Harga / Pcs :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="nominal_pcs[]" id="belanja-nominal-pcs-${formBelanjaLength}" class="format-angka-rupiah belanja-nominal-pcs rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </div>
                <div class="flex justify-center mt-10">
                    <button type="button" class="remove-list-belanja" data-id="${formBelanjaLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `;
        containerListBelanja.append(formListBelanja);
    });

    $(document).on('change', '.jd-belanja', function () {
        let idForm = $(this).data("id");
        getSparepart(idForm);
    });

    $(document).on('click', '.remove-list-belanja', function () {
        let idForm = $(this).data("id");
        $('#form-list-belanja-' + idForm).remove();
        formBelanjaLength--;
        updateOrderSummary();
    });

    $(document).on('change', '.belanja-sparepart-qty, .belanja-nominal-pcs, #nominal-ongkir-bg, #nominal-pajak-bg', function () {
        updateOrderSummary();
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

    $(document).on('input', '.format-angka-rupiah', function () {
        var inputNominal = $(this).val();
        inputNominal = inputNominal.replace(/[^\d]/g, '');
        var parsedNumber = parseInt(inputNominal, 10);
        $(this).val(formatAngka(parsedNumber));
    });

    function getSparepart(idForm) {
        var jenisDroneId = $('#belanja-jenis-drone-' + idForm).val();
        var formSparepart = $('#belanja-spareparts-' + idForm);

        fetch(`/gudang/purchasing/sparepart-bjenis/${jenisDroneId}`)
        .then(response => response.json())
        .then(data => {
            formSparepart.empty();

            const defaultOption = $('<option>')
                .text('Pilih Sparepart')
                .val('')
                .attr('hidden', true)
                .addClass('dark:bg-gray-700');
            formSparepart.append(defaultOption);

            data.forEach(part => {
                const option = $('<option>')
                    .val(part.id)
                    .text(part.nama_internal)
                formSparepart.append(option);
            });
        })
        .catch(error => alert('Error fetching data:', error));
    }

    function updateOrderSummary() {
        let ongkirGudang = parseFloat($('#nominal-ongkir-bg').val().replace(/\./g, '')) || 0;
        let pajakGudang = parseFloat($('#nominal-pajak-bg').val().replace(/\./g, '')) || 0;
        let totalQty = 0;
        let totalNominal = 0;

        $('#container-list-belanja .form-lb').each(function () {
            let qty = parseFloat($(this).find('.belanja-sparepart-qty').val()) || 0;
            let nominal = parseFloat($(this).find('.belanja-nominal-pcs').val().replace(/\./g, '')) || 0;
            let hasilNominal = nominal * qty;

            totalQty += qty;
            totalNominal += hasilNominal
        });

        let totalBiaya = totalNominal + ongkirGudang + pajakGudang;

        $('#total-item-belanja').text(totalQty + " Unit");
        $('#total-biaya-belanja').text("Rp. " + formatAngka(totalBiaya));

    }

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

})