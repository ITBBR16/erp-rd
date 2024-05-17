$(document).ready(function () {
    const seriProduk = $('#seri_produk');
    const jenisProduk = $('#jenis_paket');

    seriProduk.on('change', function () {
        const selectSeri = seriProduk.val();
        
        if (selectSeri) {
        
            fetch(`/kios/product/get-paket-penjualan/${selectSeri}`)
                .then(response => response.json())
                .then(data => {
                    jenisProduk.empty();

                    const defaultOption = $('<option>', {
                        text: '-- Jenis Paket --',
                        hidden: true
                    });
                    jenisProduk.append(defaultOption);

                    data.forEach(produk_sub_jenis => {
                        const option = $('<option>', {
                            value: produk_sub_jenis.id,
                            text: produk_sub_jenis.paket_penjualan
                        }).addClass('dark:bg-gray-700');
                        jenisProduk.append(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        } else {
            jenisProduk.empty();
        }
    });
});
