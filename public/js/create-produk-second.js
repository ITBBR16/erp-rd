$(document).ready(function(){
    const hargaModal = $('#modal_produk_second');
    const hargaJual = $('#harga_jual_produk_second');
    const tambahKelengkapanSecond = $('#add-kelengkapan-second');
    const kelengkapanSecondContainer = $('#kelengkapan-jual-second');
    let nomorKelengkapan = 1;

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }

    function hitungModal() {
        var nilaiSatuanInputs = document.getElementsByName('harga_satuan_second[]');
        var totalHargaSatuan = 0;
    
        for (var i = 0; i < nilaiSatuanInputs.length; i++) {
            var nilaiSatuan = parseFloat(nilaiSatuanInputs[i].value.replace(/\./g, ''));
            totalHargaSatuan += nilaiSatuan;
        }

        hargaModal.val(formatRupiah(totalHargaSatuan));
    }

    hargaJual.on('input', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

    tambahKelengkapanSecond.on('click', function () {
        nomorKelengkapan++
        let tambahFormKelengkapan = `
        <div id="form-kelengkapan-second-${nomorKelengkapan}" class="grid grid-cols-7 gap-4 md:gap-6 mt-5">
            <div class="relative z-0 col-span-2 w-full mb-6 group">
                <label for="kelengkapan-second-${nomorKelengkapan}"></label>
                <select name="kelengkapan_second[]" id="kelengkapan-second-${nomorKelengkapan}" data-id="${nomorKelengkapan}" class="kelengkapan-second block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                    <option value="" hidden>-- Kelengkapan Produk --</option>
                </select>
            </div>
            <div class="relative z-0 col-span-2 w-full mb-6 group">
                <label for="sn-second-${nomorKelengkapan}"></label>
                <select name="sn_second[]" id="sn-second-${nomorKelengkapan}" data-id="${nomorKelengkapan}" class="sn-second block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                    <option value="" hidden>-- SN Produk --</option>
                </select>
            </div>
            <div class="relative z-0 col-span-2 w-full group items-center">
                <span class="absolute bottom-8 start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                <input type="text" name="harga_satuan_second[]" id="harga_satuan_second-${nomorKelengkapan}" data-id="${nomorKelengkapan}" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly required>
                <label for="harga_satuan_second-${nomorKelengkapan}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Harga Satuan</label>
            </div>
            <div class="flex col-span-1 justify-center items-center">
                <button type="button" class="remove-kelengkapan-second" data-id="${nomorKelengkapan}">
                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                </button>
            </div>
        </div>
        `
        kelengkapanSecondContainer.append(tambahFormKelengkapan);
    
        fetch(`/kios/getKelengkapanSecond`)
        .then(response => response.json())
        .then(data => {
            $('#kelengkapan-second-' + nomorKelengkapan).html('');

            data.forEach(entry => {
                if (entry.kelengkapans && entry.kelengkapans.length > 0) {
                    const defaultOption = $('<option>', {
                        text: '-- Kelengkapan Produk --',
                        hidden: true
                    });
                    $('#kelengkapan-second-' + nomorKelengkapan).append(defaultOption);
    
                    entry.kelengkapans.forEach(kelengkapan => {
                        const option = $('<option>', {
                            value: kelengkapan.pivot.produk_kelengkapan_id,
                            text: kelengkapan.kelengkapan
                        });
                        $('#kelengkapan-second-' + nomorKelengkapan).append(option);
                    });
                } else {
                    console.log('Data kelengkapans kosong untuk entri dengan id ' + entry.id);
                }
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    });

    $(document).on("click", ".remove-kelengkapan-second", function() {
        let formId = $(this).data("id");
        $("#form-kelengkapan-second-"+formId).remove();
        nomorKelengkapan--;
        hitungModal()
   });

    $(document).on("change", ".kelengkapan-second", function() {
        let ksId = $(this).data("id");
        const valKelengkapan = $("#kelengkapan-second-"+ksId).val();
        
        fetch(`/kios/getSNSecond/${valKelengkapan}`)
        .then(response => response.json())
        .then(data => {
            $('#sn-second-' + ksId).html('');

            data.forEach(entry => {
                if (entry.kelengkapans && entry.kelengkapans.length > 0) {
                    const defaultOption = $('<option>', {
                        text: '-- SN Produk --',
                        hidden: true
                    });
                    $('#sn-second-' + ksId).append(defaultOption);
    
                    entry.kelengkapans.forEach(kelengkapan => {
                        const option = $('<option>', {
                            value: kelengkapan.pivot.pivot_qc_id,
                            text: kelengkapan.pivot.serial_number
                        });
                        $('#sn-second-' + ksId).append(option);
                    });
                } else {
                    console.log('Data kelengkapans kosong untuk entri dengan id ' + entry.id);
                }
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });

   });

    $(document).on("change", ".sn-second", function() {
        let snID = $(this).data("id");
        const valSn = $("#sn-second-"+snID).val();
        const priceSatuan = $('#harga_satuan_second-' + snID);
        
        fetch(`/kios/getPriceSecond/${valSn}`)
        .then(response => response.json())
        .then(data => {
            priceSatuan.html('');

            priceSatuan.val(formatRupiah(data));

            hitungModal();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });

   });


 });