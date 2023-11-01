document.addEventListener('DOMContentLoaded', function () {
    const provinsiSelect = document.getElementById('select_provinsi');
    const kotaSelect = document.getElementById('select_kota_kab');
    const kecamatanSelect = document.getElementById('select_kecamatan');
    const kelurahanSelect = document.getElementById('select_kelurahan');

    provinsiSelect.addEventListener('change', function () {
        const selectedProvinsi = provinsiSelect.value;

        if (selectedProvinsi) {
        
            fetch(`/getKota/${selectedProvinsi}`)
                .then(response => response.json())
                .then(data => {

                    kotaSelect.innerHTML = '';

                    const defaultOption = document.createElement('option');
                    defaultOption.textContent = 'Pilih Kota / Kabupaten';
                    defaultOption.setAttribute('hidden', true);
                    kotaSelect.appendChild(defaultOption)

                    data.forEach(kota => {
                        const option = document.createElement('option');
                        option.value = kota.id;
                        option.textContent = kota.name;
                        kotaSelect.appendChild(option);
                    });
                });
        } else {
            kotaSelect.innerHTML = '';
        }
    });

    kotaSelect.addEventListener('change', function () {
        const selectedKota = kotaSelect.value;

        if(selectedKota) {
            fetch(`/getKecamatan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {

                    kecamatanSelect.innerHTML = '';

                    const defaultOption = document.createElement('option');
                    defaultOption.textContent = 'Pilih Kecamatan';
                    defaultOption.setAttribute('hidden', true);
                    kecamatanSelect.appendChild(defaultOption)

                    data.forEach(kecamatan => {
                        const option = document.createElement('option');
                        option.value = kecamatan.id;
                        option.textContent = kecamatan.name;
                        kecamatanSelect.appendChild(option);
                    });

                });
        } else {
            kecamatanSelect.innerHTML = '';
        }
    });

    kecamatanSelect.addEventListener('change', function () {
        const selectedKota = kecamatanSelect.value;

        if(selectedKota) {
            fetch(`/getKelurahan/${selectedKota}`)
                .then(response => response.json())
                .then(data => {

                    kelurahanSelect.innerHTML = '';

                    const defaultOption = document.createElement('option');
                    defaultOption.textContent = 'Pilih Kelurahan';
                    defaultOption.setAttribute('hidden', true);
                    kelurahanSelect.appendChild(defaultOption)

                    data.forEach(kelurahan => {
                        const option = document.createElement('option');
                        option.value = kelurahan.id;
                        option.textContent = kelurahan.name;
                        kelurahanSelect.appendChild(option);
                    });

                });
        } else {
            kelurahanSelect.innerHTML = '';
        }
    });

});