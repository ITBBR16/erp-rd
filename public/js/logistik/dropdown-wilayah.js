$(document).ready(function () {
    // Dropdown Wilayah
    const kotaSelect = $('#kota-kabupaten');
    const kecamatanSelect = $('#kecamatan');
    const kelurahanSelect = $('#kelurahan');

    $(document).on('change', '#provinsi', function () {
        const selectedProvinsi = $(this).val();

        if (selectedProvinsi) {
            fetch(`/getKota/${selectedProvinsi}`)
                .then(response => response.json())
                .then(data => {
                    kotaSelect.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kota / Kabupaten')
                        .val("")
                        .addClass('bg-white dark:bg-gray-700');
                    kotaSelect.append(defaultOption);

                    data.forEach(kota => {
                        const option = $('<option>')
                            .val(kota.id)
                            .text(kota.name)
                            .addClass('bg-white dark:bg-gray-700');
                        kotaSelect.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            kotaSelect.html('');
        }
    });

    $(document).on('change', '#kota-kabupaten', function () {
        const selectedKota = $(this).val();

        if (selectedKota) {
            fetch(`/getKecamatan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {
                    kecamatanSelect.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kecamatan')
                        .val("")
                        .addClass('bg-white dark:bg-gray-700');
                    kecamatanSelect.append(defaultOption);

                    data.forEach(kecamatan => {
                        const option = $('<option>')
                            .val(kecamatan.id)
                            .text(kecamatan.name)
                            .addClass('bg-white dark:bg-gray-700');
                        kecamatanSelect.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            kecamatanSelect.html('');
        }
    });

    $(document).on('change', '#kecamatan', function () {
        const selectedKota = kecamatanSelect.val();

        if (selectedKota) {
            fetch(`/getKelurahan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {
                    kelurahanSelect.html('');

                    const defaultOption = $('<option>')
                        .text('Pilih Kelurahan')
                        .val("")
                        .addClass('bg-white dark:bg-gray-700');
                    kelurahanSelect.append(defaultOption);

                    data.forEach(kelurahan => {
                        const option = $('<option>')
                            .val(kelurahan.id)
                            .text(kelurahan.name)
                            .addClass('bg-white dark:bg-gray-700');
                        kelurahanSelect.append(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            kelurahanSelect.html('');
        }
    });
});