$(document).ready(function () {
    const provinsiSelect = $('#provinsi');
    const kotaSelect = $('#kota_kabupaten');
    const kecamatanSelect = $('#kecamatan');
    const kelurahanSelect = $('#kelurahan');

    provinsiSelect.on('change', function () {
        const selectedProvinsi = provinsiSelect.val();

        if (selectedProvinsi) {
            fetch(`/getKota/${selectedProvinsi}`)
                .then(response => response.json())
                .then(data => {
                    kotaSelect.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kota / Kabupaten')
                        .attr('hidden', true);
                    kotaSelect.append(defaultOption);

                    data.forEach(kota => {
                        const option = $('<option>')
                            .val(kota.id)
                            .text(kota.name)
                            .addClass('dark:bg-gray-700');
                        kotaSelect.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            kotaSelect.html('');
        }
    });

    kotaSelect.on('change', function () {
        const selectedKota = kotaSelect.val();

        if (selectedKota) {
            fetch(`/getKecamatan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {
                    kecamatanSelect.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kecamatan')
                        .attr('hidden', true);
                    kecamatanSelect.append(defaultOption);

                    data.forEach(kecamatan => {
                        const option = $('<option>')
                            .val(kecamatan.id)
                            .text(kecamatan.name)
                            .addClass('dark:bg-gray-700');
                        kecamatanSelect.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            kecamatanSelect.html('');
        }
    });

    kecamatanSelect.on('change', function () {
        const selectedKota = kecamatanSelect.val();

        if (selectedKota) {
            fetch(`/getKelurahan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {
                    kelurahanSelect.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kelurahan')
                        .attr('hidden', true)
                        .addClass('dark:bg-gray-700');
                    kelurahanSelect.append(defaultOption);

                    data.forEach(kelurahan => {
                        const option = $('<option>')
                            .val(kelurahan.id)
                            .text(kelurahan.name);
                        kelurahanSelect.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            kelurahanSelect.html('');
        }
    });
});
