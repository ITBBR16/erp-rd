document.addEventListener('DOMContentLoaded', function(){
    const jenisSelect = document.getElementById('jenis_id');
    const kelengkapanSelect = document.getElementById('kelengkapan');
    const tambahForm = document.getElementById('add-kelengkapan');
    const formKelengkapan = document.getElementById('form-kelengkapan');
    const ekspedisiSelect = document.getElementById('ekspedisi');
    const layananSelect = document.getElementById('layanan');

    ekspedisiSelect.addEventListener('change', function () {
        const ekspedisiValue = ekspedisiSelect.value;

        if (ekspedisiValue) {
            fetch(`/kios/getLayanan/${ekspedisiValue}`)
                .then(response => response.json())
                .then(data => {
                    layananSelect.innerHTML = '';

                    const defaultOption = document.createElement('option');
                    defaultOption.textContent = '-- Jenis Pengiriman --';
                    defaultOption.setAttribute('hidden', true);
                    layananSelect.appendChild(defaultOption);

                    data.forEach(jenis_layanan => {
                        const option = document.createElement('option');
                        option.value = jenis_layanan.id;
                        option.textContent = jenis_layanan.nama_layanan;
                        option.classList.add('dark:bg-gray-700');
                        layananSelect.appendChild(option);
                    });
                });
        } else {
            layananSelect.innerHTML = '';
        }
    });

    jenisSelect.addEventListener('change', function () {
        const jenisValue = jenisSelect.value;

        if (jenisValue) {
            fetch(`/kios/getKelengkapan/${jenisValue}`)
                .then(response => response.json())
                .then(data => {
                    kelengkapanSelect.innerHTML = '';

                    const defaultOption = document.createElement('option');
                    defaultOption.textContent = '-- Kelengkapan Produk --';
                    defaultOption.setAttribute('hidden', true);
                    kelengkapanSelect.appendChild(defaultOption);

                    data.forEach(produk_kelengkapan => {
                        const option = document.createElement('option');
                        option.value = produk_kelengkapan.id;
                        option.textContent = produk_kelengkapan.kelengkapan;
                        option.classList.add('dark:bg-gray-700');
                        kelengkapanSelect.appendChild(option);
                    });
                });
        } else {
            kelengkapanSelect.innerHTML = '';
        }
    });

    tambahForm.addEventListener('click', function () {
        const jumlahForm = document.querySelectorAll('.form-kelengkapan-dd');
        const newForm = formKelengkapan.lastElementChild.cloneNode(true);

        formKelengkapan.appendChild(newForm);

        const removeKelengkapanButton = newForm.querySelector('.remove-kelengkapan');

        if(jumlahForm.length > 1){
            removeKelengkapanButton.style.display = 'block'
        }

        removeKelengkapanButton.style.display = 'inline-block';
        removeKelengkapanButton.addEventListener('click', function () {
            formKelengkapan.removeChild(newForm);
        });

    });

});
