function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

$(document).ready(function () {
    let numberPTM = 0;
    let numberPTT = 0;

    $(document).on('input', '.format-angka', function () {
        var inputActive = $(this).val();
        inputActive = inputActive.replace(/[^\d]/g, '');
        var parsedNumber = parseInt(inputActive, 10);
        $(this).val(formatAngka(parsedNumber));
    })
    
    // Pencocokan Mutasi
    $(document).on('click', '#add-form-ptm', function () {
        let lastSelect = $(`#pilih-mutasi-${numberPTM}`);
        if (lastSelect.length && lastSelect.val() === "") {
            alert("Pilih mutasi sebelumnya terlebih dahulu!");
            return;
        }
        numberPTM++;
        const containerPTM = $('#container-pencocokan-mutasi');
        let formPTM = `
            <div id="form-pencocokan-mutasi-${numberPTM}" class="grid grid-cols-3 gap-4" style="grid-template-columns: 5fr 5fr 1fr">
                <div>
                    <label for="pilih-mutasi-${numberPTM}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Mutasi :</label>
                    <select name="data_mutasi[]" id="pilih-mutasi-${numberPTM}" data-id="${numberPTM}" class="select-mutasi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Mutasi</option>`;
                        mutasiSementara.forEach(function(mutasi) {
                            formPTM += `<option value="${mutasi.id}">M-${mutasi.id}</option>`
                        });
                        formPTM += `
                    </select>
                </div>
                <div>
                    <label for="nominal-mutasi-${numberPTM}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input name="nominal_mutasi[]" id="nominal-mutasi-${numberPTM}" type="text" class="nominal_mutasi rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly>
                    </div>
                </div>
                <div class="flex justify-center items-end pb-2">
                    <button type="button" class="remove-form-prtr" data-id="${numberPTM}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `
        containerPTM.append(formPTM);
        updateSelectOptions();
    });

    $(document).on('click', '.remove-form-prtr', function () {
        let numberId = $(this).data("id");
        $('#form-pencocokan-mutasi-' + numberId).remove();
        numberPTM--
        updateSelectOptions();
        checkNominalPencocokan();
    });

    $(document).on('change', '.select-mutasi', function () {
        let idData = $(this).data("id");
        var idMutasi = $('#pilih-mutasi-' + idData).val();
        var inputNominal = $('#nominal-mutasi-' + idData);

        fetch(`/repair/csr/findMutasiSementara/${idMutasi}`)
        .then(response => response.json())
        .then(data => {
            console.table(data)
            inputNominal.val(formatAngka(data.nominal));
            checkNominalPencocokan();
            updateSelectOptions();
        });
    });

    // Pencocokan Transaksi
    $(document).on('click', '#add-form-ptt', function () {
        numberPTT++;
        const containerPTT = $('#container-pencocokan-transaksi')
        let formPTT = `
            <div id="form-pencocokan-transaksi-${numberPTT}" class="grid grid-cols-3 gap-4" style="grid-template-columns: 5fr 5fr 1fr">
                <div>
                    <label for="pilih-transaksi-${numberPTT}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Transaksi :</label>
                    <select name="data_transaksi[]" id="pilih-transaksi-${numberPTT}" data-id="${numberPTT}" class="select-transaksi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Transaksi</option>`;
                        allTransaksi.forEach(function(transaksi) {
                            formPTT += `<option value="${transaksi.transaksi_id}">${transaksi.transaksi_id}</option>`
                        });
                        formPTT += `
                    </select>
                </div>
                <div>
                    <label for="nominal-transaksi-${numberPTT}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nominal :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input name="nominal_transaksi[]" id="nominal-transaksi-${numberPTT}" type="text" class="nominal_transaksi rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly>
                    </div>
                </div>
                <div class="flex justify-center items-end pb-2">
                    <button type="button" class="remove-form-prtt" data-id="${numberPTT}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `

        containerPTT.append(formPTT);
    });

    $(document).on('click', '.remove-form-prtt', function () {
        let numberId = $(this).data("id");
        $('#form-pencocokan-transaksi-' + numberId).remove();
        numberPTT--;
        checkNominalPencocokan();
    });

    $(document).on('change', '.select-transaksi', function () {
        let idData = $(this).data("id");
        var selectTransaksi = $('#pilih-transaksi-' + idData).val();
        var matchData = selectTransaksi.match(/^([A-Za-z]+)(\d+)$/);
        var source = matchData[1];
        var idTransaksi = matchData[2];
        var inputNominal = $('#nominal-transaksi-' + idData);
        
        fetch(`/repair/csr/findTransaksi/${source}/${idTransaksi}`)
        .then(response => response.json())
        .then(data => {
            console.table(data);
            if (source == 'R') {
                var nominalTransaksi = data.total_pembayaran;
            } else if (source == 'K') {
                var nominalTransaksi = data.ongkir + data.tax + data.total_harga - data.discount;
            }
            inputNominal.val(formatAngka(nominalTransaksi));
            checkNominalPencocokan();
        });
    });

    // Recap
    $(document).on('change', '#select-akun-mutasi', function () {
        var akunid = $(this).val();
        var saldoAkhirInput = $('#saldo-akhir-sebelum-mutasi');
    
        fetch(`/repair/csr/getSaldoAkhirMutasi/${akunid}`)
        .then(response => response.json())
        .then(data => {
            var saldoAkhir = data.saldo_akhir ? data.saldo_akhir : data.saldo_awal;
            saldoAkhirInput.val(formatAngka(saldoAkhir));
        });
    });

    // List Function
    function checkNominalPencocokan() {
        const button = $('#button-pencocokan');
        const nominalMutasi = $('.nominal_mutasi');
        const nominalTransaksi = $('.nominal_transaksi');

        const sumValues = (elements) => {
            return elements.toArray().reduce((total, element) => {
                let value = $(element).val();
                let parsedValue = parseFloat(value.replace(/\D/g, '')) || 0;
                return total + parsedValue;
            }, 0);
        };
    
        const hasilMutasi = sumValues(nominalMutasi);
        const hasilTransaksi = sumValues(nominalTransaksi);

        if (hasilMutasi > 0 && hasilTransaksi > 0) {
            if (hasilMutasi === hasilTransaksi) {
                button.removeClass('cursor-not-allowed').prop('disabled', false);
            } else {
                button.addClass('cursor-not-allowed').prop('disabled', true);
            }
        } else {
            button.addClass('cursor-not-allowed').prop('disabled', true);
        }
    }

    function updateSelectOptions() {
        const selectedOptions = [];
        $('.select-mutasi').each(function() {
            const selectedValue = $(this).val();
            if (selectedValue) {
                selectedOptions.push(selectedValue);
            }
        });

        $('.select-mutasi').each(function() {
            const currentSelect = $(this);
            const currentValue = currentSelect.val();
    
            currentSelect.find('option').each(function() {
                const optionValue = $(this).val();

                if (selectedOptions.includes(optionValue) && optionValue !== currentValue) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    }
    
});