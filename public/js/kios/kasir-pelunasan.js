function formatRupiah(angka) {
    return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
}

function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

function updateBoxPelunasan() {
    const inputTax = $("#pelunasan-tax");
    let pelunasanSubtotal = 0;
    let pelunasanTotalTax = 0;
    let pelunasanDp = $("#nominal_dp").val();
    let pelunasanDiscount = parseFloat($("#pelunasan-discount").val().replace(/\./g, '')) || 0;
    let pelunasanOngkir = parseFloat($("#pelunasan-ongkir").val().replace(/\./g, '')) || 0;

    $("#pelunasan-container tr").each(function() {
        var kasirPrice = $(this).find("[name='kasir_harga[]']").val();
        var nilai = parseFloat(kasirPrice.replace(/\D/g, ''));
        pelunasanSubtotal += nilai;

        var isChecked = $(this).find("[name='checkbox_tax_pelunasan[]']").prop('checked');
        
        if(isChecked) {
            var taxNilai = nilai * 11 / 100;
            pelunasanTotalTax += taxNilai;
        }
    });

    var totalPayment = pelunasanSubtotal - pelunasanDp - pelunasanDiscount + pelunasanOngkir + pelunasanTotalTax;
    var showDiscount = formatRupiah(pelunasanDiscount);
    var showOngkir = formatRupiah(pelunasanOngkir);
    var showTax = formatRupiah(pelunasanTotalTax);

    inputTax.val(pelunasanTotalTax);
    $("#pelunasan-box-subtotal").text(formatRupiah(pelunasanSubtotal));
    $("#pelunasan-box-discount").text(showDiscount);
    $("#pelunasan-box-ongkir").text(showOngkir);
    $("#pelunasan-box-tax").text(showTax);
    $("#pelunasan-box-total").text(formatRupiah(totalPayment));
}

function getSNPelunasan(jenisTransaksi, itemId, index) {

    fetch(`/kios/kasir/getSerialNumber/${jenisTransaksi}/${itemId}`)
    .then(response => response.json())
    .then(data => {
        var formSN = $('#pelunasan-sn-' + index);
        formSN.empty();

            const defaultOption = $('<option>', {
                text: 'Pilih SN',
                value: '',
                hidden: true
            });
            formSN.append(defaultOption);

            data.data_sn.forEach(serialnumber => {
                const option = $('<option>', {
                    value: serialnumber.id,
                    text: serialnumber.serial_number
                })
                .addClass('dark:bg-gray-700');
                formSN.append(option);
            });

    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
}

function updatePelunasanInvoice() {
    let subTotal = 0;
    let totalTax = 0;
    let dp = $("#nominal_dp").val() || 0;
    let discount = parseFloat($("#pelunasan-discount").val().replace(/\./g, '')) || 0;
    let ongkir = parseFloat($("#pelunasan-ongkir").val().replace(/\./g, '')) || 0;
    let invoiceContent = "";

    $("#pelunasan-container tr").each(function() {
        var jenisTransaksiKasir = $(this).find("select[name='jenis_transaksi[]'] option:selected").text();
        var resultKeteranganProduk = (jenisTransaksiKasir === 'Drone Baru') ? 
                                        'Unit Baru, Garansi 1 Tahun Serial Number' : 
                                            ((jenisTransaksiKasir === 'Drone Bekas') 
                                                ? 'Unit Second, Garansi 6 Bulan Serial Number' : '');

        var itemName = $(this).find("[name='item_name[]']").val();
        var kasirSn = $(this).find("select[name='kasir_sn[]'] option:selected").text();
        var price = $(this).find("[name='kasir_harga[]']").val();
        var totalRupiah = formatRupiah(parseFloat(price.replace(/\D/g, '')));
        var nilai = parseFloat(price.replace(/\D/g, ''));
        
        subTotal += nilai;

        var isChecked = $(this).find("[name='checkbox_tax_pelunasan[]']").prop('checked');
        
        if(isChecked) {
            var taxNilai = nilai * 11 / 100;
            totalTax += taxNilai;
        }

        invoiceContent += `
        <tr class="bg-white dark:bg-gray-800">
            <td class="px-2 py-1">${itemName}</td>
            <td class="px-2 py-1 text-xs">${resultKeteranganProduk} ${kasirSn}</td>
            <td class="px-2 py-1">1</td>
            <td class="px-2 py-1">${price}</td>
            <td class="px-2 py-1">${totalRupiah}</td>
        </tr>
        `;
    });

    var totalPayment = subTotal - dp - discount + ongkir + totalTax;
    var showDiscount = formatRupiah(discount);
    var showOngkir = formatRupiah(ongkir);
    var showTax = formatRupiah(totalTax);

    $("#invoice-subtotal").text(formatRupiah(subTotal));
    $("#invoice-dp").text(formatRupiah(dp));
    $("#invoice-discount").text(showDiscount);
    $("#invoice-ongkir").text(showOngkir);
    $("#invoice-tax").text(showTax);
    $("#invoice-total").text(formatRupiah(totalPayment));
    $("#invoice-pelunasan-container").html(invoiceContent);
}

function setupAutocomplete(data, itemNameId) {
    $(`#item-name-pelunasan-${itemNameId}`).autocomplete({
        source: (request, response) => {
            const term = request.term.toLowerCase();
            const filteredData = data.filter(part => part.nama_part.toLowerCase().includes(term));

            const formattedData = filteredData.map(part => ({
                label: part.nama_part,
                value: part.nama_part,
                id: part.sku
            }));

            response(formattedData);
        },
        autoFocus: true,
        select: (event, ui) => {
            const { id } = ui.item;
            $(`#item-id-pelunasan-${itemNameId}`).val(id);
        }
    }).autocomplete("widget").addClass("cursor-pointer px-2 w-64 h-60 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500");
}

function initializeSnPelunasan() {
    $('.item-pelunasan').each(function() {
        let index = $(this).data("id");
        let jenisTransaksi = $('#jenis-transaksi-'+index).val();
        var itemId = $('#item-id-pelunasan-'+index).val();

        getSNPelunasan(jenisTransaksi, itemId, index);
    });
}

$(document).ready(function(){
    const pelunasanContainer = $("#pelunasan-container");
    let itemCount = $("#pelunasan-container tr").length;

    initializeSnPelunasan();

    $("#add-item-pelunasan").on("click", function () {
         itemCount++
         let itemForm = `
         <tr id="pelunasan-item-${itemCount}" class="bg-white dark:bg-gray-800">
            <td class="px-4 py-4">
                <label for="jenis-transaksi-${itemCount}"></label>
                <select name="jenis_transaksi[]" id="jenis-transaksi-${itemCount}" data-id="${itemCount}" class="jenis_produk bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>Pilih Jenis Transaksi</option>
                    <option value="drone_baru" class="bg-white dark:bg-gray-700">Drone Baru</option>
                    <option value="drone_bekas" class="bg-white dark:bg-gray-700">Drone Bekas</option>
                    <option value="part_baru" class="bg-white dark:bg-gray-700">Part Baru</option>
                    <option value="part_bekas" class="bg-white dark:bg-gray-700">Part Bekas</option>
                </select>
            </td>
            <td class="px-4 py-4">
                <input type="hidden" name="item_id[]" id="item-id-pelunasan-${itemCount}" class="item_id bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
                <input type="text" name="item_name[]" id="item-name-pelunasan-${itemCount}" data-id="${itemCount}" class="item-pelunasan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
            </td>
            <td class="px-4 py-4">
                <label for="pelunasan-sn-${itemCount}"></label>
                <select name="kasir_sn[]" id="pelunasan-sn-${itemCount}" data-id="${itemCount}" class="pelunasan-sn bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>Pilih SN</option>
                </select>
            </td>
            <td class="px-4 py-4">
                <input type="hidden" name="kasir_modal_part[]" id="pelunasan-modal-part-${itemCount}">
                <input type="text" name="kasir_harga[]" id="pelunasan-harga-${itemCount}" data-id="${itemCount}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp. 0" readonly required>
            </td>
            <td class="px-4 py-4">
                <input type="checkbox" name="checkbox_tax_pelunasan[]" id="checkbox-tax-${itemCount}" data-id="${itemCount}" class="pelunasan-checkbox-tax w-10 h-6 bg-gray-100 border border-gray-300 text-green-600 text-lg rounded-lg focus:ring-green-600 focus:ring-2 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:ring-offset-gray-800">
            </td>
            <td class="px-4 py-4">
                <button type="button" class="remove-pelunasan-item" data-id="${itemCount}">
                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                </button>
            </td>
        </tr>
         `;
         pelunasanContainer.append(itemForm);
         updatePelunasanInvoice();

    });

    $(document).on('focus', '.item-pelunasan', function () {
        let itemNameId = $(this).data("id");
        let jenisTransaksi = $('#jenis-transaksi-'+itemNameId).val();
        let autocompleteData = [];

        if (jenisTransaksi === 'part_baru' || jenisTransaksi === 'part_bekas') {

            if (autocompleteData[jenisTransaksi]) {
                setupAutocomplete(autocompleteData[jenisTransaksi], itemNameId);
            } else {
                $.get(`/kios/kasir/autocomplete/${jenisTransaksi}`)
                    .done((data) => {
                        console.table(data);
                        autocompleteData[jenisTransaksi] = data;
                        setupAutocomplete(data, itemNameId);
                    })
                    .fail((error) => {
                        alert('Error : ' + error);
                    });
            }

        } else {

            $.get(`/kios/kasir/autocomplete/${jenisTransaksi}`, function(data) {
                $("#item-name-pelunasan-"+itemNameId).autocomplete({
                    source: function(request, response) {

                        var term = request.term.toLowerCase();
                        var filteredData = data.filter(function(item) {
                            return (item.subjenis.produkjenis.jenis_produk.toLowerCase().indexOf(term) !== -1) || 
                                    (item.subjenis.paket_penjualan.toLowerCase().indexOf(term) !== -1);
                        });

                        var formattedData = filteredData.map(function(item) {
                            return {
                                label: item.subjenis.produkjenis.jenis_produk + ' ' + item.subjenis.paket_penjualan,
                                value: item.subjenis.produkjenis.jenis_produk + ' ' + item.subjenis.paket_penjualan,
                                id: item.subjenis.id
                            };
                        });

                        response(formattedData);
                    },
                    autoFocus: true,
                    select: function(event, ui) {
                        var selectedValue = ui.item.value;
                        var selectedLabel = ui.item.label;
                        var selectedId = ui.item.id;

                        $("#item-id-pelunasan-"+itemNameId).val(selectedId);
                    }
                }).autocomplete("widget").addClass("cursor-pointer px-2 w-64 h-60 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500");

            }).fail(function(error) {
                console.error('Error:', error);
            });

        }
    });

    $(document).on('change', '.item-pelunasan', function () {
        let formIdItem = $(this).data("id");
        var formSN = $('#pelunasan-sn-'+formIdItem);
        var formHarga = $('#pelunasan-harga-'+formIdItem);
        var formModalPart = $('#pelunasan-modal-part-'+formIdItem);
        let jenisTransaksi = $('#jenis-transaksi-'+formIdItem).val();
        var idItem = $('#item-id-pelunasan-'+formIdItem).val();
        fetch(`/kios/kasir/getSerialNumber/${jenisTransaksi}/${idItem}`)
        .then(response => response.json())
        .then(data => {

            formSN.empty();

            const defaultOption = $('<option>', {
                text: 'Pilih SN',
                value: '',
                hidden: true
            });
            formSN.append(defaultOption);

            if (jenisTransaksi == 'part_baru' || jenisTransaksi == 'part_bekas') {
                data.data_sn.forEach(dataII => {
                    const option = $('<option>', {
                        value: dataII.idItem,
                        text: dataII.idItem,
                    })
                    .addClass('dark:bg-gray-700');
                    formSN.append(option);
                });

                var nilaiPart = formatRupiah(data.nilai.nilai);
                formHarga.val(nilaiPart);
                formModalPart.val(data.nilai.modal);

                updateSubtotalBox();

            } else {
                data.data_sn.forEach(serialnumber => {
                    const option = $('<option>', {
                        value: serialnumber.id,
                        text: serialnumber.serial_number
                    })
                    .addClass('dark:bg-gray-700');
                    formSN.append(option);
                });

            }

            updateBoxPelunasan();

        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    });

    $(document).on('change', '.pelunasan-sn', function () {
        let formIdItem = $(this).data("id");
        var formSN = $('#pelunasan-sn-'+formIdItem);
        var formHarga = $('#pelunasan-harga-'+formIdItem);
        let jenisTransaksi = $('#jenis-transaksi-'+formIdItem).val();
        var idItem = $('#item-id-pelunasan-'+formIdItem).val();
        let cekSn = formSN.find('option:selected').text();

        fetch(`/kios/kasir/getSerialNumber/${jenisTransaksi}/${idItem}`)
        .then(response => response.json())
        .then(data => {
            var harga = formatRupiah(data.nilai);
            formHarga.val(harga);
            
            updateBoxPelunasan();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });

    });

    $(document).on('change', '.pelunasan-checkbox-tax', function() {
        updatePelunasanInvoice();
        updateBoxPelunasan();
    });
 
    $(document).on("click", ".remove-pelunasan-item", function() {
         let itemNameId = $(this).data("id");
         $("#pelunasan-item-"+itemNameId).remove();
         itemCount--;
         updatePelunasanInvoice()
         updateBoxPelunasan();
    });
 
    $(document).on("click", "#pelunasan-review-invoice", function () {
        var invoiceNamaCus = $('#invoice-nama-customer');
        var invoiceTlp = $('#invoice-no-tlp');
        var invoiceJalan = $('#invoice-jalan');
        var namaCustomer = $('#id_customer').val();
        fetch(`/kios/kasir/getCustomer/${namaCustomer}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(customer => {
                var fullName = customer.first_name + ' ' + customer.last_name;
    
                invoiceNamaCus.text(fullName);
                invoiceTlp.text(customer.no_telpon);
                invoiceJalan.text(customer.nama_jalan);
            })
        })
        .catch(error => console.error('Error:', error));

        updatePelunasanInvoice();
    });

    $(document).on("change", "#pelunasan-discount", function () {
        updateBoxPelunasan();
        updatePelunasanInvoice();
    });

    $(document).on("change", "#pelunasan-ongkir", function () {
        updateBoxPelunasan();
        updatePelunasanInvoice();
    });

    $(document).on("input", ".pelunasan-formated-rupiah", function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatAngka(parsedValue));
    });

    $(document).on("click", "#button-print-invoice", function (e) {
        e.preventDefault();
        printInvoice();
    });

    $('#button-download-invoice').click(function() {
        downloadPdf();
    });

 });
