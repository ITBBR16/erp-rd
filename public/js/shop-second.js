$(document).ready(function(){
    const jenisDroneSecond = $('#jenis_drone_second');
    const container = $('#kelengkapan-second');
    const biayaPengambilan = $('#biaya_pengambilan');
    const biayaOngkir = $('#biaya_ongkir');
    const biayaSatuan = $('.biaya_satuan');
    const nomorCustomer = $('#no_customer_second');
    const idCustmer = $('#id_customer');
    const produkJenisId = $('#produk-jenis-id');
    const namaCustomer = $('#nama_customer');
    const tambahKelengkapan = $('#tambah-kelengkapan');
    const buttonAddKelengkapan = $('#add-second-belanja');
    const buttonAddAdditionalKelengkapan = $('#add-second-additional-belanja');
    const containerAdditional = $('#additional-kelengkapan-second');
    let uniqueNumberId = 20;
    
    jenisDroneSecond.on('change', function() {
        const subJenisId = jenisDroneSecond.val();
        
        if(subJenisId){
            fetch(`/kios/product/get-kelengkapan-second/${subJenisId}`)
            .then(response => response.json())
            .then(data => {
                container.html('');

                data.kelengkapans.forEach(function (kelengkapan) {
                    container.append(`
                        <div class="grid md:grid-cols-5 md:gap-6">
                            <div class="flex col-span-2 items-center mb-6">
                                <input name="kelengkapan_second[]" id="kelengkapan_second${kelengkapan.id}" type="checkbox" value="${kelengkapan.id}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="kelengkapan_second${kelengkapan.id}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">${kelengkapan.kelengkapan}</label>
                            </div>
                            <div class="relative col-span-2 z-0 w-full mb-6 group">
                                <input type="number" name="quantity_second[]" id="quantity_second${kelengkapan.id}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                                <label for="quantity_second${kelengkapan.id}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
                            </div>
                        </div>
                    `);
                });

                produkJenisId.val(data.idJenisProduk);
            })
            .catch(error => console.error('Error:', error));
        } else {
            container.html('');
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

    buttonAddKelengkapan.on('click', function () {
        uniqueNumberId++
        const jenisId = produkJenisId.val();

        let addKelengkapan = `
            <div id="tambah-kelengkapan-${uniqueNumberId}" class="grid md:grid-cols-5 md:gap-6">
                <div class="relative col-span-2 z-0 w-full mb-6 group">
                    <label for="kelengkapan_second${uniqueNumberId}" class="sr-only">Jenis Paket Produk</label>
                    <select name="kelengkapan_second[]" id="kelengkapan_second${uniqueNumberId}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                        <option value="" hidden>-- Kelengkapan --</option>
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

        if(jenisId){
            const ddJdDrone = $('#kelengkapan_second' + uniqueNumberId);
            fetch(`/kios/product/getAdditionalKelengkapan/${jenisId}`)
            .then(response => response.json())
            .then(data => {
                ddJdDrone.empty();

                const defaultOption = $('<option>', {
                    text: '-- Tambahan Kelengkapan --',
                    value: '',
                    hidden: true
                });
                ddJdDrone.append(defaultOption);

                data.forEach(kelengkapan => {
                    const option = $('<option>', {
                        value: kelengkapan.id,
                        text: kelengkapan.kelengkapan
                    })
                    .addClass('dark:bg-gray-700');
                    ddJdDrone.append(option);
                });
            })
            .catch(error => console.error('Error:', error));
        } else {
            ddJdDrone.html('');
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

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }
    
    biayaPengambilan.on('input', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

    biayaOngkir.on('input', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

    biayaSatuan.on('input', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

    // Cek nilai pada halaman qc second
    function cekNilai() {
        var nilaiSatuanInputs = document.getElementsByName('harga_satuan[]');
        var totalHargaSatuan = 0;
    
        for (var i = 0; i < nilaiSatuanInputs.length; i++) {
            var nilaiSatuan = parseFloat(nilaiSatuanInputs[i].value.replace(/\./g, ''));
            totalHargaSatuan += nilaiSatuan;
        }
    
        var nilaiTotalInput = parseFloat(document.getElementById('biaya_pengambilan').value.replace(/\./g, ''));

        if (!isNaN(nilaiTotalInput) && !isNaN(totalHargaSatuan) && nilaiTotalInput.toFixed(2) === totalHargaSatuan.toFixed(2)) {
            document.getElementById('submit_qc_second').removeAttribute('disabled');
            document.getElementById('submit_qc_second').classList.remove('cursor-not-allowed');
            // console.log("Nilai satuan sama dengan nilai total.");
        } else {
            // console.log("Nilai satuan tidak sama dengan nilai total.");
        }
    }

    var hargaSatuanInputs = document.querySelectorAll('input[name="harga_satuan[]"]');
    hargaSatuanInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            cekNilai();
        });
    });

});
