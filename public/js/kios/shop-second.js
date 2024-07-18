$(document).ready(function(){
    const paketPenjualanSecond = $('#paket_penjualan_second');
    const biayaSatuan = $('.biaya_satuan');
    const nomorCustomer = $('#no_customer_second');
    const idCustmer = $('#id_customer');
    const namaCustomer = $('#nama_customer');
    const tambahKelengkapan = $('#tambah-kelengkapan');
    const buttonAddKelengkapan = $('#add-second-belanja');
    const buttonAddAdditionalKelengkapan = $('#add-second-additional-belanja');
    const containerAdditional = $('#additional-kelengkapan-second');
    let uniqueNumberId = 20;

    $(document).on('change', '#come_from', function () {
        var statusCome = $(this).val();
        var containerMpl = $('#marketplaceContainer');
        var asalBeli = $('#asal-jual');
        var marketPlace = $('#shop-second-marketplace');
        var alasanJual = $('#alasan-container');
        var inputAlasan = $('#alasan-jual');

        containerMpl.show();
        if(statusCome == 'Customer') {
            asalBeli.hide();
            marketPlace.prop('required', false);
            alasanJual.show();
            inputAlasan.prop('required', true).val("");
        } else {
            asalBeli.show();
            marketPlace.prop('required', true).val("");
            alasanJual.hide();
            inputAlasan.prop('required', false);
        }
    });

    nomorCustomer.on('change', function() {
        const idValue = nomorCustomer.val();
        const nomor = idValue.replace(/\D/g, "");

        if(nomor != '') {
            fetch(`/kios/product/getCustomerbyNomor/${nomor}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    idCustmer.val('');
                    namaCustomer.val('Nomor Belum Terdaftar').addClass('border-red-500 text-red-500');
                    $('#nama_customer_label').addClass('text-red-500')
                } else {
                    data.forEach(customer => {
                        var namaLengkap = customer.first_name + " " + customer.last_name;
                        idCustmer.val(customer.id);
                        namaCustomer.val(namaLengkap).removeClass('border-red-500 text-red-500');
                        $('#nama_customer_label').removeClass('text-red-500')
                    });
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            idCustmer.val('');
            namaCustomer.val('').removeClass('border-red-500 text-red-500');
            $('#nama_customer_label').removeClass('text-red-500')
        }

    });

    paketPenjualanSecond.on('change', function () {
        const idPaket = $(this).val();
        tambahKelengkapanSecond(idPaket);
    });

    buttonAddKelengkapan.on('click', function () {
        const paketId = paketPenjualanSecond.val();

        if(paketId){
            uniqueNumberId++
            let addKelengkapan = `
                <div id="tambah-kelengkapan-${uniqueNumberId}" class="grid md:grid-cols-5 md:gap-6">
                    <div class="relative col-span-2 z-0 w-full mb-6 group">
                        <label for="kelengkapan_second${uniqueNumberId}" class="sr-only">Jenis Paket Produk</label>
                        <select name="kelengkapan_second[]" id="kelengkapan_second${uniqueNumberId}" class="kelengkapan_second block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Pilih Kelengkapan</option>
                        </select>
                    </div>
                    <div class="relative col-span-2 z-0 w-full mb-6 group">
                        <input type="number" name="quantity_second[]" id="quantity_second${uniqueNumberId}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                        <label for="quantity_second${uniqueNumberId}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
                    </div>
                    <div class="flex justify-center items-center col-span-1">
                        <button type="button" class="remove-second-belanja" data-id="${uniqueNumberId}">
                            <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                        </button>
                    </div>
                </div>
            `;

            tambahKelengkapan.append(addKelengkapan);
            tambahKelengkapanSecond(paketId, uniqueNumberId);

        } else {
            alert('Silahkan pilih paket penjualan terlebih dahulu.')
        }
    });

    buttonAddAdditionalKelengkapan.on('click', function () {
        uniqueNumberId++
        let additonalKelengkapan = `
            <div id="additional-kelengkapan-${uniqueNumberId}" class="grid md:grid-cols-5 md:gap-6">
                <div class="relative col-span-2 z-0 w-full mb-6 group">
                    <input type="text" name="additional_kelengkapan_second[]" id="additional-kelengkapan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                    <label id="additional-kelengkapan" for="additional-kelengkapan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Additional Kelengkapan</label>
                </div>
                <div class="relative col-span-2 z-0 w-full mb-6 group">
                    <input type="number" name="additional_quantity_second[]" id="quantity_second${uniqueNumberId}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                    <label for="quantity_second${uniqueNumberId}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
                </div>
                <div class="flex justify-center items-center col-span-1">
                    <button type="button" class="remove-second-additional-belanja" data-id="${uniqueNumberId}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `

        containerAdditional.append(additonalKelengkapan);
    });

    $(document).on("click", ".remove-second-belanja", function() {
        let itemNameId = $(this).data("id");
        $("#tambah-kelengkapan-"+itemNameId).remove();
        uniqueNumberId--;
   });

    $(document).on("click", ".remove-second-additional-belanja", function() {
        let itemNameId = $(this).data("id");
        $("#additional-kelengkapan-"+itemNameId).remove();
        uniqueNumberId--;
   });

    biayaSatuan.on('input', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

    function tambahKelengkapanSecond(id, dataId) {
        const ddKelengkapanSecond = $('#kelengkapan_second' + dataId);
            fetch(`/kios/product/getKelengkapanSecond/${id}`)
            .then(response => response.json())
            .then(data => {
                ddKelengkapanSecond.empty();

                const defaultOption = $('<option>', {
                    text: 'Pilih Kelengkapan',
                    value: '',
                    hidden: true
                });
                ddKelengkapanSecond.append(defaultOption);

                data.forEach(kelengkapan => {
                    const option = $('<option>', {
                        value: kelengkapan.id,
                        text: kelengkapan.kelengkapan
                    })
                    .addClass('dark:bg-gray-700');
                    ddKelengkapanSecond.append(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

});
