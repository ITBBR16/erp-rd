$(document).ready(function () {

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

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }
});