$(document).ready(function () {
    let number = 0;

    // Split Produk Baru
    $(document).on('paket-penjualan-split', (e) => {
        const jenisProduk = e.originalEvent.detail.id;
        const selectSN = $('#sn-produk-awal-split');
        var containerKelengkapan = $('#container-split-produk-baru');

        fetch(`/kios/product/get-sn-split/${jenisProduk}`)
        .then(response => response.json())
        .then(data => {
            containerKelengkapan.empty();
            selectSN.empty()

            const defaultOption = $('<option>')
                    .text('Pilih Serial Number')
                    .val('')
                    .attr('hidden', true)
                    .addClass('bg-white dark:bg-gray-700');
            selectSN.append(defaultOption);

            data.forEach(sn => {
                const option = $('<option>')
                        .val(sn.id)
                        .text(sn.serial_number);
                selectSN.append(option);
            });

            $('#modal-awal-produk-baru').val(0);
            $('#modal-awal-split').text("Rp. " + formatAngka(0));
            updateBoxSplitKios();
        })
        .catch(error => alert('Error fetching data : ' + error));

    });

    $(document).on('change', '#sn-produk-awal-split', function (){
        var idSn = $(this).val();
        var idPaketPenjualan = $('#paket-penjualan-awal-split').val();
        var containerKelengkapan = $('#container-split-produk-baru');
        if (idPaketPenjualan != '') {
            fetch(`/kios/product/get-kelengkapan-split/${idPaketPenjualan}/${idSn}`)
            .then(response => response.json())
            .then(data => {
                containerKelengkapan.empty();

                data.dataKelengkapan.forEach(kelengkapan => {
                    for (let i = 0; i < kelengkapan.pivot.quantity; i++) {

                        var formSplit = `
                            <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <input type="hidden" name="id_kelengkapan[]" value="${kelengkapan.id}">
                                    <input type="text" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 appearance-none dark:text-white focus:outline-none focus:ring-0" value="${kelengkapan.kelengkapan}" readonly>
                                </th>
                                <td class="px-6 py-4">
                                    <input type="text" name="serial_number[]" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" placeholder="SN123456789">
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="relative z-0 w-full group flex items-center">
                                        <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                        <input type="text" name="nilai_split[]" class="nilai-split-baru split-formated-rupiah block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="0" required>
                                    </div>
                                </td>
                            </tr>
                        `

                        containerKelengkapan.append(formSplit);
                    }
                });

                $('#modal-awal-produk-baru').val(data.modalAwal ?? 0);
                $('#modal-awal-split').text("Rp. " + formatAngka(data.modalAwal ?? 0));
            })
            .catch(error => alert('Error fetching data : ' + error));
            updateBoxSplitKios();
        } else {
            alert('Silahkan pilih jenis paket penjualan terlebih dahulu.');
        }
    });

    $(document).on("input", ".split-formated-rupiah", function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatAngka(parsedValue));
    });

    $(document).on('change', '.nilai-split-baru', function () {
        updateBoxSplitKios();
    });

    // Create Bnob
    $(document).on('click', '#add-kelengkapan-split', function () {
        var paketPenjualan = $('#paket-penjualan-bnob').val();
        if (paketPenjualan == '') {
            alert('Silahkan pilih paket penjualan terlebih dahulu.');
            return;
        }

        number++;
        let tambahKelengkapanBnob = `
            <div id="form-kelengkapan-bnob-${number}" class=" grid grid-cols-7 gap-4 md:gap-6 mt-5">
                <div class="relative z-0 col-span-2 w-full mb-6 group">
                    <label for="kelengkapan-bnob-${number}"></label>
                    <select name="kelengkapan_bnob[]" id="kelengkapan-bnob-${number}" data-id="${number}" class="kelengkapan-bnob block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                        <option value="" hidden>Kelengkapan Produk</option>
                    </select>
                </div>
                <div class="relative z-0 col-span-2 w-full mb-6 group">
                    <label for="sn-bnob-${number}"></label>
                    <select name="sn_bnob[]" id="sn-bnob-${number}" data-id="${number}" class="sn-bnob block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                        <option value="" hidden>Serial Number Kelengkapan</option>
                    </select>
                </div>
                <div class="relative z-0 col-span-2 w-full group items-center">
                    <span class="absolute bottom-8 start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                    <input type="text" name="harga_satuan_bnob[]" id="harga-satuan-bnob-${number}" data-id="${number}" class="block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly required>
                    <label for="harga-satuan-bnob-${number}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-8 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Harga Satuan</label>
                </div>
                <div class="flex col-span-1 justify-center items-center">
                    <button type="button" class="remove-kelengkapan-bnob" data-id="${number}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `

        $('#kelengkapan-split-baru').append(tambahKelengkapanBnob);

        fetch(`/kios/product/get-kelengkapan-bnob`)
        .then(response => response.json())
        .then(data => {

            $('#kelengkapan-bnob-' + number).html('');

            const defaultOption = $('<option>', {
                text: 'Kelengkapan Produk',
                hidden: true
            });
            $('#kelengkapan-bnob-' + number).append(defaultOption);

            const kelengkapanUnique = new Set();

            data.forEach(entry => {
                if (entry.produk_kelengkapan_id && !kelengkapanUnique.has(entry.produk_kelengkapan_id)) {
                    kelengkapanUnique.add(entry.produk_kelengkapan_id);

                    const option = $('<option>', {
                        value: entry.produk_kelengkapan_id,
                        text: entry.kelengkapan_produk.kelengkapan
                    });

                    $('#kelengkapan-bnob-' + number).append(option);
                }
            });
        })
        .catch(error => {
            alert('Error fetching data: ' + error);
        });

    });

    $(document).on('change', '.kelengkapan-bnob', function () {
        var dataId = $(this).data("id");
        var selectKelengkapan = $('#kelengkapan-bnob-' + dataId).val();

        fetch(`/kios/product/get-sn-bnob/${selectKelengkapan}`)
        .then(response => response.json())
        .then(data => {
            $('#sn-bnob-' + dataId).html('');

            data.forEach(entry => {
                const defaultOption = $('<option>', {
                    text: 'Serial Number Kelengkapan',
                    hidden: true
                });
                $('#sn-bnob-' + dataId).append(defaultOption);

                const option = $('<option>', {
                    value: entry.id,
                    text: entry.serial_number_split
                });
                $('#sn-bnob-' + dataId).append(option);
            });
        })
        .catch(error => {
            alert('Error fetching data:' + error);
        });
    });

    $(document).on("change", ".sn-bnob", function() {
        let snID = $(this).data("id");
        const valSn = $("#sn-bnob-"+snID).val();
        const priceSatuan = $('#harga-satuan-bnob-' + snID);

        fetch(`/kios/product/get-modal-bnob/${valSn}`)
        .then(response => response.json())
        .then(data => {
            priceSatuan.html('');

            priceSatuan.val(formatAngka(data));

            updateBoxBnob();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });

    });

    $(document).on('click', '.remove-kelengkapan-bnob', function () {
        var dataId = $(this).data("id");
        $('#form-kelengkapan-bnob-' + dataId).remove();
        updateBoxBnob();
    });

    $(document).on('change', '#harga-srp', function () {
        updateBoxBnob();
    })

    function updateBoxSplitKios() {
        const button = $('#btn-split-kios');
        let nominalAwal = $('#modal-awal-produk-baru').val();
        let totalNominal = 0;

        $('#container-split-produk-baru .split-formated-rupiah').each(function () {
            let nominal = parseFloat($(this).val().replace(/\./g, '')) || 0;
            totalNominal += nominal;
        });

        let sisaNominal = nominalAwal - totalNominal;
        $('#sisa-nominal-split-kios').text("Rp. " + formatAngka(sisaNominal));

        if (sisaNominal == 0) {
            button.removeClass('cursor-not-allowed').prop('disabled', false);
        } else {
            button.addClass('cursor-not-allowed').prop('disabled', true);
        }
    }

    function updateBoxBnob() {
        const button = $('#btn-bnob');
        var nilaiSrp = parseFloat($('#harga-srp').val().replace(/\./g, '')) || 0;
        var nilaiSatuanBnob = document.getElementsByName('harga_satuan_bnob[]');
        var totalModal = 0;

        for (var i = 0; i < nilaiSatuanBnob.length; i++) {
            var nilaiSatuan = parseFloat(nilaiSatuanBnob[i].value.replace(/\./g, '')) || 0;
            totalModal += nilaiSatuan;
        }

        if (nilaiSrp > totalModal ) {
            button.removeClass('cursor-not-allowed').prop('disabled', false);
        } else {
            button.addClass('cursor-not-allowed').prop('disabled', true);
        }

        $('#total-modal-bnob').val(totalModal);
        $('#total-modal-box-bnob').text("Rp. " + formatAngka(totalModal));
        $('#harga-srp-bnob').text("Rp. " + formatAngka(nilaiSrp));
    }

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }
});