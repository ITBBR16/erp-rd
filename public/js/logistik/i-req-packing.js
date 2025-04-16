$(document).ready(function () {
    let iReqPackingLength = 1;

    // Data Customer
    $(document).on('customer-changed', (e) => {
        const customerId = e.originalEvent.detail.id;
        
        fetch(`/logistik/get-customer-packing/${customerId}`)
        .then(response => response.json())
        .then(data => {

            let provinsiId = data[0].provinsi_id;
            let kotaId = data[0].kota_kabupaten_id;
            let kecamatanId = data[0].kecamatan_id;
            let kelurahanId = data[0].kelurahan_id;
            $('#no-whatsapp').val(data[0].no_telpon);

            if (provinsiId) {
                const containerProvinsi = $('#provinsi');
                fetch(`/getProvinsi`)
                .then(response => response.json())
                .then(data => {
                   containerProvinsi.html('');
                   const defaultOption = $('<option>')
                        .text('Pilih Provinsi')
                        .val('')
                        .attr('hidden', true);
                    containerProvinsi.append(defaultOption);

                    data.forEach(provinsi => {
                        const option = $('<option>')
                            .val(provinsi.id)
                            .text(provinsi.name)
                            .addClass('bg-white dark:bg-gray-700');

                        if (Number(provinsi.id) === Number(provinsiId)) {
                            option.attr('selected', true);
                        }

                        containerProvinsi.append(option);
                    });

                    getKota(kotaId, () => {
                        if (kecamatanId) {
                            getKecamatan(kecamatanId, () => {
                                if (kelurahanId) {
                                    getKelurahan(kelurahanId);
                                }
                            });
                        }
                    });
                });
            }

            $('#kode-pos').val(data[0].kode_pos);
            $('#alamat-lengkap').val(data[0].nama_jalan);
        })
    });

    $(document).on('change', '#provinsi', function () {
        getKota();
    });

    $(document).on('change', '#kota-kabupaten', function () {
        getKecamatan();
    });

    $(document).on('change', '#kecamatan', function () {
        getKelurahan();
    });

    $(document).on('change', '#checkbox-data-customer', function () {
        const checkbox = $(this);
        const formCustomerRd = $('#customer-rd');
        const formCustomerNonRd = $('#customer-non-rd');
        const iCustomerRd = $('#i-customer-rd');
        const iCustomerNonRd = $('#i-customer-non-rd');

        iCustomerRd.val('');
        iCustomerNonRd.val('');
        $('#select-customer-rd').val('');
        $('#provinsi').val('');
        $('#kota-kabupaten').html('');
        $('#kecamatan').html('');
        $('#kelurahan').html('');
        $('#no-whatsapp').val('');
        $('#kode-pos').val('');
        $('#alamat-lengkap').val('');

        if (checkbox.is(':checked')) {
            formCustomerRd.hide();
            formCustomerNonRd.show();

            iCustomerRd.prop('required', false);
            iCustomerNonRd.prop('required', true);
        } else {
            formCustomerRd.show();
            formCustomerNonRd.hide();

            iCustomerRd.prop('required', true);
            iCustomerNonRd.prop('required', false);
        }
        
    });

    // Data Logistik
    $(document).on('change', '#ekspedisi-req-packing', function () {
        const selectedEkspedisi = $(this).val();
        const containerLayanan = $('#layanan-ekspedisi');

        fetch(`/logistik/get-layanan-ekspedisi/${selectedEkspedisi}`)
            .then(response => response.json())
            .then(data => {
                containerLayanan.empty();
    
                const defaultOption = $('<option>')
                        .text('Pilih Jenis Layanan')
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
    });

    // Isi Paket
    $(document).on('click', '#add-item-ireq', function () {
        var containerIsiPaket = $('#iReqPacking');

        iReqPackingLength++;
        let itemForm = `
            <tr id="isi-paket-${iReqPackingLength}" class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">
                    <input type="text" name="nama_item[]" class="block py-2.5 px-0 w-full text-xs text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" placeholder="Nama Item" required>
                </td>
                <td class="px-6 py-4">
                    <input type="text" name="quantity[]" class="format-number block py-2.5 px-0 w-full text-xs text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" placeholder="0" required>
                </td>
                <td class="px-6 py-4">
                    <input type="text" name="keterangan_isi_paket[]" class="block py-2.5 px-0 w-full text-xs text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" placeholder="Keterangan">
                </td>
                <td class="px-6 py-4 text-center">
                    <button type="button" class="remove-isi-paket" data-id="${iReqPackingLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">close</span>
                    </button>
                </td>
            </tr>
        `;

        containerIsiPaket.append(itemForm);
    });

    $(document).on('click', '.remove-isi-paket', function () {
        const id = $(this).data('id');
        $(`#isi-paket-${id}`).remove();
    });

    $(document).on('input', '.format-number', function () {
        let value = $(this).val();
        value = value.replace(/[^0-9]/g, '');
        $(this).val(value);
    });

    $(document).on('input', '.format-rupiah', function () {
        let value = $(this).val();
        value = value.replace(/[^0-9]/g, '');
        var parsedNumber = parseInt(value, 10);
        $(this).val(formatAngka(parsedNumber));
    });

    function getKota(kotaId, callback) {
        const selectedProvinsi = $('#provinsi').val();
        const containerKota = $('#kota-kabupaten');
        const containerKecamatan = $('#kecamatan');
        const containerKelurahan = $('#kelurahan');

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

                            if (kotaId && Number(kota.id) == Number(kotaId)) {
                                option.attr('selected', true);
                            }

                            containerKota.append(option);
                        });

                        containerKota.val(kotaId);
                        if (callback) callback();
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    }

    function getKecamatan(kecamtaanId, callback) {
        const selectedKota = $('#kota-kabupaten').val();
        const containerKecamatan = $('#kecamatan');
        const containerKelurahan = $('#kelurahan');

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

                            if (Number(kecamtaanId) && Number(kecamatan.id) == Number(kecamtaanId)) {
                                option.attr('selected', true);
                            }

                            containerKecamatan.append(option);
                        });
                        containerKecamatan.val(kecamtaanId);
                        if (callback) callback();
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    }

    function getKelurahan(kelurahanId) {
        const selectedKecamatan = $('#kecamatan').val();
        const containerKelurahan = $('#kelurahan');

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

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

});