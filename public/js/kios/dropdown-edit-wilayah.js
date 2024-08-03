$(document).ready(function () {
    const provinsiSelect = $('.edit-provinsi-kios');
    const kotaSelect = $('.edit-kota-kabupaten-kios');
    const kecamatanSelect = $('.edit-kecamatan-kios');
    const modalUpdate = $('.update-customer-kios');

    modalUpdate.on('click', function () {
        let idModal = $(this).data("id");
        fetch(`/kios/customer/getDataCustomer/${idModal}`)
        .then(response => response.json())
        .then(data => {
            let kotaId = data.kota_kabupaten;
            let kecamatanId = data.kecamatan;
            let kelurahanId = data.kelurahan;

            getDataKota(idModal, kotaId);

            if (kecamatanId != null) {
                getDataKecamatan(idModal, kotaId, kecamatanId);

                if (kelurahanId != null) {
                    getDataKelurahan(idModal, kecamatanId, kelurahanId);
                }
            }

        });
    })

    provinsiSelect.on('change', function () {
        let idFP = $(this).data("id");
        getDataKota(idFP, null, null);
    });

    kotaSelect.on('change', function () {
        let idKota = $(this).data("id");
        getDataKecamatan(idKota, null, null);
    });

    kecamatanSelect.on('change', function () {
        let idKecamatan = $(this).data("id");
        getDataKelurahan(idKecamatan, null, null);
    });

    function getDataKota(id,kotaId) {
        const selectedProvinsi = $('#edit-provinsi-' + id).val();
        const containerKota = $('#edit-kota-kabupaten-' + id);
        const containerKecamatan = $('#edit-kecamatan-' + id);
        const containerKelurahan = $('#edit-kelurahan-' + id);

        if (selectedProvinsi) {
            fetch(`/getKota/${selectedProvinsi}`)
                .then(response => response.json())
                .then(data => {
                    containerKota.html('');
                    containerKecamatan.html('');
                    containerKelurahan.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kota / Kabupaten')
                        .attr('hidden', true);
                    containerKota.append(defaultOption);

                    data.forEach(kota => {
                        const option = $('<option>')
                            .val(kota.id)
                            .text(kota.name)
                            .addClass('dark:bg-gray-700');

                        if (kotaId && kota.id == kotaId) {
                            option.attr('selected', true);
                        }
                        containerKota.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            const defaultOption = $('<option>')
                .text('Data Not Found')
                .attr('hidden', true);
            containerKota.append(defaultOption);
        }
    }

    function getDataKecamatan(id,kotaId,kecamatanId) {
        const selectedKota = (kotaId != null) ? kotaId : $('#edit-kota-kabupaten-' + id).val();
        const containerKecamatan = $('#edit-kecamatan-' + id);
        const containerKelurahan = $('#edit-kelurahan-' + id);

        if (selectedKota) {
            fetch(`/getKecamatan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {
                    containerKecamatan.html('');
                    containerKelurahan.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kecamatan')
                        .attr('hidden', true);
                    containerKecamatan.append(defaultOption);

                    data.forEach(kecamatan => {
                        const option = $('<option>')
                            .val(kecamatan.id)
                            .text(kecamatan.name)
                            .addClass('dark:bg-gray-700');

                        if (kecamatanId && kecamatan.id == kecamatanId) {
                            option.attr('selected', true);
                        }
                        containerKecamatan.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            const defaultOption = $('<option>')
                .text('Data Not Found')
                .attr('hidden', true);
            containerKecamatan.append(defaultOption);
        }
    }

    function getDataKelurahan(id,kecamatanId,kelurahanId) {
        const selectKecamatan = (kecamatanId != null) ? kecamatanId : $('#edit-kecamatan-' + id).val();
        const containerKelurahan = $('#edit-kelurahan-' + id);

        if (selectKecamatan) {
            fetch(`/getKelurahan/${selectKecamatan}`)
                .then(response => response.json())
                .then(data => {
                    containerKelurahan.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kelurahan')
                        .attr('hidden', true)
                        .addClass('dark:bg-gray-700');
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
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            const defaultOption = $('<option>')
                .text('Data Not Found')
                .attr('hidden', true)
                .addClass('dark:bg-gray-700');
            containerKelurahan.append(defaultOption);
        }
    }
});
