$(document).ready(function () {
    
    // Data Customer
    const idProvinsi = '#ongkir-provinsi';
    const idKota = '#ongkir-kota';
    const idKecamatan = '#ongkir-kecamatan';
    const idKelurahan = '#ongkir-kelurahan';
    
    const otherProvinsi = '#other-ongkir-provinsi';
    const otherKota = '#other-ongkir-kota';
    const otherKecamatan = '#other-ongkir-kecamatan';
    const otherKelurahan = '#other-ongkir-kelurahan';

    let selectedProvinsi = $('#ongkir-provinsi').data('selected');
    let selectedKota = $('#ongkir-kota').data('selected');
    let selectedKecamatan = $('#ongkir-kecamatan').data('selected');
    let selectedKelurahan = $('#ongkir-kelurahan').data('selected');

    if (selectedProvinsi) {
        getDataKota(selectedKota, idProvinsi, idKota, idKecamatan, idKelurahan);

        if (selectedKota) {
            getDataKecamatan(selectedKota, selectedKecamatan, idKota, idKecamatan, idKelurahan);

            if (selectedKecamatan) {
                getDataKelurahan(selectedKecamatan, selectedKelurahan, idKecamatan, idKelurahan);
            }
        }
    }

    $('#ongkir-provinsi').on('change', function () {
        getDataKota(null, idProvinsi, idKota, idKecamatan, idKelurahan);
    });

    $('#ongkir-kota').on('change', function () {
        getDataKecamatan(null, null, idKota, idKecamatan, idKelurahan);
    });

    $('#ongkir-kecamatan').on('change', function () {
        getDataKelurahan(null, null, idKecamatan, idKelurahan);
    });

    // Data Customer Other
    $('#other-ongkir-provinsi').on('change', function () {
        getDataKota(null, otherProvinsi, otherKota, otherKecamatan, otherKelurahan);
    });

    $('#other-ongkir-kota').on('change', function () {
        getDataKecamatan(null, null, otherKota, otherKecamatan, otherKelurahan);
    });

    $('#other-ongkir-kecamatan').on('change', function () {
        getDataKelurahan(null, null, otherKecamatan, otherKelurahan);
    });

    $(document).on('change', '#checkbox-ongkir-kasir-repair', function () {
        var formOngkirCustomer = $('#ongkir-repair-customer');
        var formOngkirBeda = $('#ongkir-repair-beda-penerima');
    
        // Misal hanya input tertentu yang wajib
        var requiredInputsCustomer = formOngkirCustomer.find('input.required, select.required');
        var requiredInputsBeda = formOngkirBeda.find('input.required, select.required');
    
        if ($(this).is(':checked')) {
            formOngkirBeda.show();
            formOngkirCustomer.hide();
    
            requiredInputsBeda.prop('required', true);
            requiredInputsCustomer.prop('required', false);
        } else {
            formOngkirBeda.hide();
            formOngkirCustomer.show();
    
            requiredInputsCustomer.prop('required', true);
            requiredInputsBeda.prop('required', false);
        }
    });    

    // Ekspedisi
    let selectedEkspedisi = $('#ongkir-ekspedisi-repair').data('selected');
    let selectedLayanan = $('#ongkir-layanan-repair').data('selected');

    if (selectedEkspedisi) {
        getDataLayanan(selectedEkspedisi, selectedLayanan);
    }

    $(document).on('change', '#ongkir-ekspedisi-repair', function () {
        getDataLayanan(null);
    });

    $(document).on('input', '.format-angka-ongkir-repair', function () {
        var inputActive = $(this).val();
        inputActive = inputActive.replace(/[^\d]/g, '');
        var parsedNumber = parseInt(inputActive, 10);
        $(this).val(formatAngka(parsedNumber));
    });

    $(document).on('change', '#nominal-produk-repair', function () {
        var nominalProduk = parseFloat($(this).val().replace(/\./g, ''));
        var nominalAsuransi

        if (nominalProduk >= 20000001) {
            nominalAsuransi = nominalProduk * 0.0027;
        } else if (nominalProduk >= 10000001) {
            nominalAsuransi = 38000;
        } else if (nominalProduk >= 5000001) {
            nominalAsuransi = 19000;
        } else if (nominalProduk >= 3000001) {
            nominalAsuransi = 8550;
        } else if (nominalProduk >= 1000001) {
            nominalAsuransi = 4750;
        } else if (nominalProduk <= 1000000) {
            nominalAsuransi = 950
        }


        $('#nominal-asuransi-repair').val(formatAngka(nominalAsuransi));
    });

    // Kasir Pelunasan
    $(document).on('click', '#add-metode-pembayaran-lunas', function () {
        let formLength = $('.form-mp-lunas').length;
        const contaienrMPLunas = $('#container-metode-pembayaran-lunas');

        formLength++;
        let formMPDP = `
            <div id="form-mp-lunas-${formLength}" class="form-mp-lunas grid grid-cols-4 gap-4 mb-4" style="grid-template-columns: 5fr 5fr 3fr 1fr">
                <div>
                    <label for="metode-pembayaran-pembayaran-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Select Metode Pembayaran :</label>
                    <select name="metode_pembayaran_pembayaran[]" id="metode-pembayaran-pembayaran-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Metode Pembayaran</option>`;
                        daftarAkun.forEach(function(akun) {
                            formMPDP += `<option value="${akun.id}">${akun.nama_akun}</option>`
                        });
                        formMPDP +=
                        `
                    </select>
                </div>
                <div>
                    <label for="nominal-pembayaran-lunas-repair-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Pembayaran :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="nominal_pembayaran[]" id="nominal-pembayaran-lunas-repair-${formLength}" class="format-angka-ongkir-repair nominal-lunas-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Files Bukti Transaksi :</label>
                    <div class="relative z-0 w-full">
                        <label 
                            for="file-bukti-transaksi-${formLength}" 
                            id="file-label" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            No file chosen
                        </label>
                        <input 
                            type="file" 
                            name="file_bukti_transaksi[]" 
                            id="file-bukti-transaksi-${formLength}" 
                            class="hidden"
                            onchange="updateFileName(this)"
                            required>
                    </div>
                </div>
                <div class="flex justify-center items-end pb-2">
                    <button type="button" class="remove-metode-pembayaran-lunas" data-id="${formLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `;
        contaienrMPLunas.append(formMPDP);
    });

    $(document).on(
        'change',
        '.nominal-lunas-repair, #nominal-discount-lunas, #nominal-saldo-customer-terpakai, #nominal-kerugian-lunas, #nominal-dikembalikan, #nominal-pll, #nominal-simpan-saldo-customer',
        function () {
            updateBoxPembayaranLunas();
            checkPembayaranLunas();
        }
    );

    $(document).on('click', '.remove-metode-pembayaran-lunas', function () {
        let idForm = $(this).data("id");
        $('#form-mp-lunas-' + idForm).remove()
        updateBoxPembayaranLunas();
        checkPembayaranLunas();
    });

    // Down Payment
    $(document).on('click', '#add-metode-pembayaran-dp', function () {
        let formLength = $('.form-mp-dp').length;
        const contaienrMPDP = $('#container-metode-pembayaran-dp');

        formLength++;
        let formMPDP = `
            <div id="form-mp-dp-${formLength}" class="form-mp-dp grid grid-cols-4 gap-4 mb-4" style="grid-template-columns: 5fr 5fr 3fr 1fr">
                <div>
                    <label for="metode-pembayaran-pembayaran-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Select Metode Pembayaran :</label>
                    <select name="metode_pembayaran_pembayaran[]" id="metode-pembayaran-pembayaran-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Metode Pembayaran</option>`;
                        daftarAkun.forEach(function(akun) {
                            formMPDP += `<option value="${akun.id}">${akun.nama_akun}</option>`
                        });
                        formMPDP +=
                        `
                    </select>
                </div>
                <div>
                    <label for="nominal-pembayaran-dp-repair-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Pembayaran :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="nominal_pembayaran[]" id="nominal-pembayaran-dp-repair-${formLength}" class="format-angka-ongkir-repair nominal-dp-repair rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Files Bukti Transaksi :</label>
                    <div class="relative z-0 w-full">
                        <label 
                            for="file-bukti-transaksi-${formLength}" 
                            id="file-label" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            No file chosen
                        </label>
                        <input 
                            type="file" 
                            name="file_bukti_transaksi[]" 
                            id="file-bukti-transaksi-${formLength}" 
                            class="hidden"
                            onchange="updateFileName(this)"
                            required>
                    </div>
                </div>
                <div class="flex justify-center items-end pb-2">
                    <button type="button" class="remove-metode-pembayaran-dp" data-id="${formLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `;
        contaienrMPDP.append(formMPDP);
    });

    $(document).on('click', '.remove-metode-pembayaran-dp', function () {
        let idForm = $(this).data("id");
        $('#form-mp-dp-' + idForm).remove();
        updateBoxPembayaran();
    });

    $(document).on('change', '.nominal-dp-repair', function () {
        updateBoxPembayaran();
    });

    // Function Ongkir Kasir
    function getDataKota(kotaId, idProvinsi, idKota, idKecamatan, idKelurahan) {
        const selectedProvinsi = $(idProvinsi).val();
        const containerKota = $(idKota);
        const containerKecamatan = $(idKecamatan);
        const containerKelurahan = $(idKelurahan);

        containerKecamatan.html('');
        containerKelurahan.html('');

        if (selectedProvinsi) {
            fetch(`/getKota/${selectedProvinsi}`)
                .then(response => response.json())
                .then(data => {
                    containerKota.html('');
                    if (data.length > 0) {
                        const defaultOption = $('<option>')
                            .text('Pilih Kota / Kabupaten')
                            .val('')
                            .attr('hidden', true);
                        containerKota.append(defaultOption);

                        data.forEach(kota => {
                            const option = $('<option>')
                                .val(kota.id)
                                .text(kota.name)
                                .addClass('bg-white dark:bg-gray-700');

                            if (kotaId && kota.id == kotaId) {
                                option.attr('selected', true);
                            }
                            containerKota.append(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    }

    function getDataKecamatan(kotaId, kecamatanId, idKota, idKecamatan, idKelurahan) {
        const selectedKota = (kotaId != null) ? kotaId : $(idKota).val();
        const containerKecamatan = $(idKecamatan);
        const containerKelurahan = $(idKelurahan);

        containerKelurahan.html('');

        if (selectedKota) {
            fetch(`/getKecamatan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {
                    containerKecamatan.html('');
                    if (data.length > 0) {
                        const defaultOption = $('<option>')
                            .text('Pilih Kecamatan')
                            .val('')
                            .attr('hidden', true);
                        containerKecamatan.append(defaultOption);

                        data.forEach(kecamatan => {
                            const option = $('<option>')
                                .val(kecamatan.id)
                                .text(kecamatan.name)
                                .addClass('bg-white dark:bg-gray-700');

                            if (kecamatanId && kecamatan.id == kecamatanId) {
                                option.attr('selected', true);
                            }
                            containerKecamatan.append(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    }

    function getDataKelurahan(kecamatanId, kelurahanId, idKecamatan, idKelurahan) {
        const selectedKecamatan = (kecamatanId != null) ? kecamatanId : $(idKecamatan).val();
        const containerKelurahan = $(idKelurahan);

        if (selectedKecamatan) {
            fetch(`/getKelurahan/${selectedKecamatan}`)
                .then(response => response.json())
                .then(data => {
                    containerKelurahan.empty();
                    if (data.length > 0) {
                        const defaultOption = $('<option>')
                            .text('Pilih Kelurahan')
                            .val('')
                            .attr('hidden', true)
                            .addClass('bg-white dark:bg-gray-700');
                        containerKelurahan.append(defaultOption);

                        let isOptionSelected = false;

                        data.forEach(kelurahan => {
                            const option = $('<option>')
                                .val(kelurahan.id)
                                .text(kelurahan.name);

                            if (kelurahanId && kelurahan.id == kelurahanId) {
                                option.attr('selected', true);
                                isOptionSelected = true;
                            }
                            containerKelurahan.append(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    }

    function getDataLayanan(ekspedisiId, layananId) {
        const selectedEkspedisi = (ekspedisiId != null) ? ekspedisiId : $('#ongkir-ekspedisi-repair').val();
        const containerLayanan = $('#ongkir-layanan-repair');

        if (selectedEkspedisi) {
            fetch(`/repair/csr/getLayanan/${selectedEkspedisi}`)
            .then(response => response.json())
            .then(data => {
                containerLayanan.empty();
    
                const defaultOption = $('<option>')
                        .text('Pilih Layanan')
                        .val('')
                        .attr('hidden', true)
                        .addClass('bg-white dark:bg-gray-700');
                containerLayanan.append(defaultOption);

                let isOptionSelected = false;
    
                data.forEach(layanan => {
                    const option = $('<option>')
                            .val(layanan.id)
                            .text(layanan.nama_layanan);
                    if (layananId && layananId == layanan.id) {
                        option.attr('selected', true);
                        isOptionSelected = true;
                    }
                    containerLayanan.append(option);
                });
            })
            .catch(error => alert('Error fetching data: ' + error));

        }
    }

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
    }

    function updateBoxPembayaran() {
        let totalNominal = 0;

        $('#container-metode-pembayaran-dp .form-mp-dp').each(function () {
            let nominal = parseFloat($(this).find('.nominal-dp-repair').val().replace(/\./g, '')) || 0;
            totalNominal += nominal;
        });

        $('#total-pembayaran-dp').text(formatRupiah(totalNominal));
        $('#total-pembayaran-dp-box').text(formatRupiah(totalNominal));
    }

    function updateBoxPembayaranLunas() {
        let totalNominal = 0;
        let nilaiDiscount = $('#nominal-discount-lunas').val().replace(/\./g, '') || 0
        let nilaiDp = $('#nominal-saldo-customer-terpakai').val().replace(/\./g, '') || 0

        $('#container-metode-pembayaran-lunas .form-mp-lunas').each(function () {
            let nominal = parseFloat($(this).find('.nominal-lunas-repair').val().replace(/\./g, '')) || 0;
            totalNominal += nominal;
        });

        $('#nilai-discount').text(formatRupiah(nilaiDiscount));
        $('#box-nilai-discount').text(formatRupiah(nilaiDiscount));
        $('#total-pembayaran-lunas').text(formatRupiah(totalNominal));
        $('#box-total-pembayaran-lunas').text(formatRupiah(totalNominal));
        $('#down-payment-invoice-lunas').text(formatRupiah(nilaiDp));
    }

    function checkPembayaranLunas() {
        let totalTagihan = parseFloat($('#total-tagihan').val())
        let totalPembayaranAwal = 0;
        let nominalDiscount = parseFloat($('#nominal-discount-lunas').val().replace(/\./g, '')) || 0;
        let nominalSaldoCustomerTerpakai = parseFloat($('#nominal-saldo-customer-terpakai').val().replace(/\./g, '')) || 0;
        let nominalKerugian = parseFloat($('#nominal-kerugian-lunas').val().replace(/\./g, '')) || 0;
        let nominalDikembalikan = parseFloat($('#nominal-dikembalikan').val().replace(/\./g, '')) || 0;
        let nominalPll = parseFloat($('#nominal-pll').val().replace(/\./g, '')) || 0;
        let nominalSaveSaldoCustomer = parseFloat($('#nominal-simpan-saldo-customer').val().replace(/\./g, '')) || 0;
        let statusBox = $('#status-box-lunas');

        $('#container-metode-pembayaran-lunas .form-mp-lunas').each(function () {
            let nominal = parseFloat($(this).find('.nominal-lunas-repair').val().replace(/\./g, '')) || 0;
            totalPembayaranAwal += nominal;
        });

        let totalTagihanAkhir = totalTagihan + nominalDikembalikan + nominalPll + nominalSaveSaldoCustomer;
        let totalPembayaranAkhir = totalPembayaranAwal + nominalDiscount + nominalSaldoCustomerTerpakai + nominalKerugian;

        console.log('Total Tagihan Akhir: ' + totalTagihanAkhir)
        console.log('Total Pembayaran Akhir: ' + totalTagihanAkhir)

        if (totalTagihanAkhir == totalPembayaranAkhir) {
            statusBox.text('Pass')
                .removeClass('bg-rose-100 text-rose-700 dark:bg-rose-800 dark:text-rose-300 bg-orange-100 text-orange-700 dark:bg-orange-800 dark:text-orange-300')
                .addClass('bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-300');
            $('#btn-kasir-lunas-repair').removeClass('cursor-not-allowed').removeAttr('disabled', true);

            if(!nominalDikembalikan && nominalDikembalikan !== 0 || 
                !nominalPll && nominalPll !== 0 || 
                !nominalSaveSaldoCustomer && nominalSaveSaldoCustomer !== 0) {

                    $('#form-pembayaran-lebih').hide();
                    $('#nominal-dikembalikan').val(0);
                    $('#nominal-pll').val(0);
                    $('#nominal-simpan-saldo-customer').val(0);
            
            }
        } else if(totalTagihan < totalPembayaranAkhir) {
            statusBox.text('Overpay')
                .removeClass('bg-rose-100 text-rose-700 dark:bg-rose-800 dark:text-rose-300 bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-300')
                .addClass('bg-orange-100 text-orange-700 dark:bg-orange-800 dark:text-orange-300');
            $('#form-pembayaran-lebih').show();
            $('#btn-kasir-lunas-repair').addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            statusBox.text('Not Pass')
                .removeClass('bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-300 bg-orange-100 text-orange-700 dark:bg-orange-800 dark:text-orange-300')
                .addClass('bg-rose-100 text-rose-700 dark:bg-rose-800 dark:text-rose-300');
            $('#form-pembayaran-lebih').hide();
            $('#nominal-dikembalikan').val(0);
            $('#nominal-pll').val(0);
            $('#nominal-simpan-saldo-customer').val(0);
            $('#btn-kasir-lunas-repair').addClass('cursor-not-allowed').prop('disabled', true);
        }
    }

});