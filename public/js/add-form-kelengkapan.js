$(document).ready(function() {
    const jenisSelect = $('#jenis_id');
    const kelengkapanSelect = $('#kelengkapan');
    const tambahForm = $('#add-kelengkapan');
    const formKelengkapan = $('#form-kelengkapan');

    jenisSelect.on('change', function () {
        const jenisValue = jenisSelect.val();

        if (jenisValue) {
            fetch(`/kios/getKelengkapan/${jenisValue}`)
                .then(response => response.json())
                .then(data => {
                    kelengkapanSelect.html('');

                    const defaultOption = $('<option>', {
                        text: '-- Kelengkapan Produk --',
                        hidden: true
                    });
                    kelengkapanSelect.append(defaultOption);

                    data.forEach(produk_kelengkapan => {
                        const option = $('<option>', {
                            value: produk_kelengkapan.id,
                            text: produk_kelengkapan.kelengkapan
                        }).addClass('dark:bg-gray-700');
                        kelengkapanSelect.append(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        } else {
            kelengkapanSelect.html('');
        }
    });

    tambahForm.on('click', function () {
        const jumlahForm = $('.form-kelengkapan-dd');
        const newForm = formKelengkapan.children(':last').clone(true);

        formKelengkapan.append(newForm);

        const removeKelengkapanButton = newForm.find('.remove-kelengkapan');

        if (jumlahForm.length > 1) {
            removeKelengkapanButton.css('display', 'block');
        }

        removeKelengkapanButton.css('display', 'inline-block');
        removeKelengkapanButton.on('click', function () {
            newForm.remove();
        });
    });
});
