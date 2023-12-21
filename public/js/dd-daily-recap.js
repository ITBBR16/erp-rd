document.addEventListener('DOMContentLoaded', function () {
    const seriProduk = document.getElementById('seri_produk');
    const jenisProduk = document.getElementById('jenis_paket');

    seriProduk.addEventListener('change', function () {
        const selectSeri = seriProduk.value;
        
        if (selectSeri) {
        
            fetch(`/kios/get-paket-penjualan/${selectSeri}`)
                .then(response => response.json())
                .then(data => {

                    jenisProduk.innerHTML = '';

                    const defaultOption = document.createElement('option');
                    defaultOption.textContent = '-- Jenis Paket --';
                    defaultOption.setAttribute('hidden', true);
                    jenisProduk.appendChild(defaultOption)

                    data.forEach(produk_sub_jenis => {
                        const option = document.createElement('option');
                        option.value = produk_sub_jenis.id;
                        option.textContent = produk_sub_jenis.paket_penjualan;
                        option.classList.add('dark:bg-gray-700');
                        jenisProduk.appendChild(option);
                    });
                });
        } else {
            jenisProduk.innerHTML = '';
        }
    });

});