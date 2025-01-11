$(document).ready(function () {
    // Data Customer
    const provinsiSelect = $('.ongkir-provinsi-ori');
    const kotaSelect = $('.ongkir-kota-ori');
    const kecamatanSelect = $('.ongkir-kecamatan-ori');
    const modalUpdate = $('.ongkir-kasir-repair');

    modalUpdate.on('click', function () {
        let idModal = $(this).data("id");
        let customerId = $(this).data("customer-id");

        fetch(`/repair/csr/getDataCustomer/${customerId}`)
            .then(response => response.json())
            .then(data => {
                let kotaId = data.kota_kabupaten_id;
                let kecamatanId = data.kecamatan_id;
                let kelurahanId = data.kelurahan_id;

                getDataKota(idModal, kotaId);

                if (kotaId) {
                    getDataKecamatan(idModal, kotaId, kecamatanId);

                    if (kecamatanId) {
                        getDataKelurahan(idModal, kecamatanId, kelurahanId);
                    }
                }
            });
    });

    provinsiSelect.on('change', function () {
        let idFP = $(this).data("id");
        getDataKota(idFP, null);
    });

    kotaSelect.on('change', function () {
        let idKota = $(this).data("id");
        getDataKecamatan(idKota, null);
    });

    kecamatanSelect.on('change', function () {
        let idKecamatan = $(this).data("id");
        getDataKelurahan(idKecamatan, null);
    });

    $(document).on('change', '.checkbox-ongkir-kasir-repair', function () {
        let formId = $(this).data("id");
        var checkbox = $('#checkbox-ongkir-kasir-repair-' + formId);
        var formOngkirCustomer = $('#ongkir-repair-customer-' + formId);
        var formOngkirBeda = $('#ongkir-repair-beda-penerima-' + formId);
        var inputsBeda = formOngkirBeda.find('input, select');
        var inputsCustomer = formOngkirCustomer.find('input, select');

        if (checkbox.is(':checked')) {
            formOngkirBeda.show();
            formOngkirCustomer.hide();

            inputsBeda.prop('required', true);
            inputsCustomer.prop('required', false);
        } else {
            formOngkirBeda.hide();
            formOngkirCustomer.show();

            inputsCustomer.prop('required', true);
            inputsBeda.prop('required', false);
        }
        
    });

    // Ekspedisi

    $(document).on('change', '.ongkir-ekspedisi-repair', function () {
        let dataId = $(this).data("id");
        let ekspedisiId = $('#ongkir-ekspedisi-repair-' + dataId).val();
        getDataLayanan(dataId, ekspedisiId);
    });

    $(document).on('input', '.format-angka-ongkir-repair', function () {
        var inputActive = $(this).val();
        inputActive = inputActive.replace(/[^\d]/g, '');
        var parsedNumber = parseInt(inputActive, 10);
        $(this).val(formatAngka(parsedNumber));
    });

    $(document).on('change', '.nominal-produk-repair', function () {
        let formId = $(this).data("id");
        var nominalProduk = parseFloat($('#nominal-produk-repair-' + formId).val().replace(/\./g, ''));
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


        $('#nominal-asuransi-repair-' + formId).val(formatAngka(nominalAsuransi));
    });

    // Down Payment
    $(document).on('change', '#nominal-pembayaran-dp-repair', function () {
        var nominalPembayaran = $(this).val();
        var prsedNominal = parseFloat(nominalPembayaran.replace(/\D/g, ''));
        $('#total-pembayaran-dp').text(formatRupiah(prsedNominal));
    });

    // Function Ongkir Kasir
    function getDataKota(id, kotaId) {
        const selectedProvinsi = $('#ongkir-provinsi-ori-' + id).val();
        const containerKota = $('#ongkir-kota-ori-' + id);
        const containerKecamatan = $('#ongkir-kecamatan-ori-' + id);
        const containerKelurahan = $('#ongkir-kelurahan-ori-' + id);

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

    function getDataKecamatan(id, kotaId, kecamatanId) {
        const selectedKota = (kotaId != null) ? kotaId : $('#ongkir-kota-ori-' + id).val();
        const containerKecamatan = $('#ongkir-kecamatan-ori-' + id);
        const containerKelurahan = $('#ongkir-kelurahan-ori-' + id);

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

                        if (kecamatanId) {
                            getDataKelurahan(id, kecamatanId, null);
                        }
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    }

    function getDataKelurahan(id, kecamatanId, kelurahanId) {
        const selectedKecamatan = (kecamatanId != null) ? kecamatanId : $('#ongkir-kecamatan-ori-' + id).val();
        const containerKelurahan = $('#ongkir-kelurahan-ori-' + id);

        if (selectedKecamatan) {
            fetch(`/getKelurahan/${selectedKecamatan}`)
                .then(response => response.json())
                .then(data => {
                    containerKelurahan.html('');
                    if (data.length > 0) {
                        const defaultOption = $('<option>')
                            .text('Pilih Kelurahan')
                            .val('')
                            .attr('hidden', true)
                            .addClass('bg-white dark:bg-gray-700');
                        containerKelurahan.append(defaultOption);

                        data.forEach(kelurahan => {
                            const option = $('<option>')
                                .val(kelurahan.id)
                                .text(kelurahan.name);

                            if (kelurahanId && kelurahan.id == kelurahanId) {
                                option.attr('selected', true);
                            }
                            containerKelurahan.append(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    }

    function getDataLayanan(id, ekspedisiId) {
        const containerLayanan = $('#ongkir-layanan-repair-' + id);

        fetch(`/repair/csr/getLayanan/${ekspedisiId}`)
        .then(response => response.json())
        .then(data => {
            containerLayanan.empty();

            const defaultOption = $('<option>')
                    .text('Pilih Layanan')
                    .val('')
                    .attr('hidden', true)
                    .addClass('bg-white dark:bg-gray-700');
            containerLayanan.append(defaultOption);

            data.forEach(layanan => {
                const option = $('<option>')
                        .val(layanan.id)
                        .text(layanan.nama_layanan);
                containerLayanan.append(option);
            });
        })
        .catch(error => alert('Error fetching data: ' + error));
    }

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
    }

});
