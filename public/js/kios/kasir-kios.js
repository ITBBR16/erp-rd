function formatRupiah(angka) {
    return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
}

function printInvoice() {
    window.print();
}

function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

function updateSubtotalBox() {
    const inputTax = $("#kasir-tax");
    let kasirSubtotal = 0;
    let totalTax = 0;
    let kasirDiscount = parseFloat($("#kasir-discount").val().replace(/\./g, '')) || 0;
    let kasirOngkir = parseFloat($("#kasir-ongkir").val().replace(/\./g, '')) || 0;

    $("#kasir-container tr").each(function() {
        var kasirPrice = $(this).find("[name='kasir_harga[]']").val();
        var nilai = parseFloat(kasirPrice.replace(/\D/g, ''));
        kasirSubtotal += nilai;

        var isChecked = $(this).find("[name='checkbox_tax[]']").prop('checked');
        
        if(isChecked) {
            var taxNilai = nilai * 11 / 100;
            totalTax += taxNilai;
        }
    });

    var totalPayment = kasirSubtotal - kasirDiscount + kasirOngkir + totalTax;
    var showDiscount = formatRupiah(kasirDiscount);
    var showOngkir = formatRupiah(kasirOngkir);
    var showTax = formatRupiah(totalTax);

    inputTax.val(totalTax);
    $("#kasir-box-subtotal").text(formatRupiah(kasirSubtotal));
    $("#kasir-box-discount").text(showDiscount);
    $("#kasir-box-ongkir").text(showOngkir);
    $("#kasir-box-tax").text(showTax);
    $("#kasir-box-total").text(formatRupiah(totalPayment));
}

function updateInvoice() {
    let subTotal = 0;
    let totalTax = 0;
    let discount = parseFloat($("#kasir-discount").val().replace(/\./g, '')) || 0;
    let ongkir = parseFloat($("#kasir-ongkir").val().replace(/\./g, '')) || 0;
    let invoiceContent = "";

    $("#kasir-container tr").each(function() {
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

        var isChecked = $(this).find("[name='checkbox_tax[]']").prop('checked');
        
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

    var totalPayment = subTotal - discount + ongkir + totalTax;
    var showDiscount = formatRupiah(discount);
    var showOngkir = formatRupiah(ongkir);
    var showTax = formatRupiah(totalTax);

    $("#invoice-subtotal").text(formatRupiah(subTotal));
    $("#invoice-discount").text(showDiscount);
    $("#invoice-ongkir").text(showOngkir);
    $("#invoice-tax").text(showTax);
    $("#invoice-total").text(formatRupiah(totalPayment));
    $("#invoice-kasir-container").html(invoiceContent);
}

function downloadPdf() {
    var noInvoice = $('#invoice-number').val();
    var invoiceContent = $('#print-invoice-kios').html();

    var requestData = {
        no_invoice: noInvoice,
        content: invoiceContent
    };

    $.ajax({
        type: 'POST',
        url: '/kios/kasir/generate-pdf',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(data) {
            alert('Success Download Invoice.');
        },
        error: function(xhr, status, error) {
            alert('Terjadi kesalahan saat mengunduh invoice : ' + error);
        }
    });
}

function setupAutocomplete(data, itemNameId) {
    $(`#item-name-${itemNameId}`).autocomplete({
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
            $(`#item-id-${itemNameId}`).val(id);
        }
    }).autocomplete("widget").addClass("cursor-pointer px-2 w-64 h-60 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500");
}

$(document).ready(function(){
    const kasirContainer = $("#kasir-container");
    let itemCount = $("#kasir-container tr").length;
    let autocompleteData = [];

    $("#add-item-kasir").on("click", function () {
         itemCount++
         let itemForm = `
         <tr id="kasir-item-${itemCount}" class="bg-white dark:bg-gray-800">
            <td class="px-4 py-4">
                <label for="jenis-transaksi-${itemCount}"></label>
                <select name="jenis_transaksi[]" id="jenis-transaksi-${itemCount}" data-id="${itemCount}" class="jenis_produk bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>Pilih Jenis Transaksi</option>
                    <option value="drone_baru">Drone Baru</option>
                    <option value="drone_bekas">Drone Bekas</option>
                    <option value="part_baru">Part Baru</option>
                    <option value="part_bekas">Part Bekas</option>
                </select>
            </td>
            <td class="px-4 py-4">
                <input type="hidden" name="item_id[]" id="item-id-${itemCount}" class="item_id" required>
                <input type="text" name="item_name[]" id="item-name-${itemCount}" data-id="${itemCount}" class="item_name bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
            </td>
            <td class="px-4 py-4">
                <label for="kasir_sn-${itemCount}"></label>
                <select name="kasir_sn[]" id="kasir_sn-${itemCount}" data-id="${itemCount}" class="kasir_sn bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>Pilih SN</option>
                </select>
            </td>
            <td class="px-4 py-4">
                <input type="hidden" name="kasir_modal_part[]" id="kasir-modal-part-${itemCount}">
                <input type="text" name="kasir_harga[]" id="kasir-harga-${itemCount}" data-id="${itemCount}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp. 0" readonly required>
            </td>
            <td class="px-4 py-4">
                <input type="checkbox" name="checkbox_tax[]" id="checkbox-tax-${itemCount}" data-id="${itemCount}" class="checkbox-tax w-10 h-6 bg-gray-100 border border-gray-300 text-green-600 text-lg rounded-lg focus:ring-green-600 focus:ring-2 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:ring-offset-gray-800">
            </td>
            <td class="px-4 py-4">
                <button type="button" class="remove-kasir-item" data-id="${itemCount}">
                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                </button>
            </td>
        </tr>
         `;
         kasirContainer.append(itemForm);
         updateInvoice();

    });

    $(document).on('focus', '.item_name', function () {
        const itemNameId = $(this).data("id");
        const jenisTransaksi = $(`#jenis-transaksi-${itemNameId}`).val();

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
                $("#item-name-"+itemNameId).autocomplete({
                    source: function(request, response) {

                        var term = request.term.toLowerCase();
                        var filteredData = data.filter(function(item) {
                            return (item.subjenis.paket_penjualan.toLowerCase().indexOf(term) !== -1);
                        });
    
                        var formattedData = filteredData.map(function(item) {
                            return {
                                label: item.subjenis.paket_penjualan,
                                value: item.subjenis.paket_penjualan,
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

                        $("#item-id-"+itemNameId).val(selectedId);
                    }
                }).autocomplete("widget").addClass("cursor-pointer px-2 w-64 h-60 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500");
    
            }).fail(function(error) {
                alert('Error : ' + error);
            });

        }
    });

    $(document).on('change', '.item_name', function () {
        let formIdItem = $(this).data("id");
        var formHarga = $('#kasir-harga-'+formIdItem);
        var formModalPart = $('#kasir-modal-part-'+formIdItem);
        var formSN = $('#kasir_sn-'+formIdItem);
        let jenisTransaksi = $('#jenis-transaksi-'+formIdItem).val();
        var idItem = $('#item-id-'+formIdItem).val();
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

        })
        .catch(error => {
            alert('Error fetching data:' + error);
        });
    });

    $(document).on('change', '.kasir_sn', function () {
        let formIdItem = $(this).data("id");
        var formHarga = $('#kasir-harga-'+formIdItem);
        let jenisTransaksi = $('#jenis-transaksi-'+formIdItem).val();
        var idItem = $('#item-id-'+formIdItem).val();

        fetch(`/kios/kasir/getSerialNumber/${jenisTransaksi}/${idItem}`)
        .then(response => response.json())
        .then(data => {
            if (jenisTransaksi == 'part_baru' || jenisTransaksi == 'part_bekas') {
                
            } else {
                var nilaiDrone = formatRupiah(data.nilai);
                formHarga.val(nilaiDrone);
            }

            updateSubtotalBox();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
 
    });

    $(document).on('change', '.checkbox-tax', function() {
        updateInvoice();
        updateSubtotalBox();
    });

    $(document).on("click", ".remove-kasir-item", function() {
         let itemNameId = $(this).data("id");
         $("#kasir-item-"+itemNameId).remove();
         itemCount--;
         updateInvoice()
         updateSubtotalBox();
    });

    $(document).on("click", ".review-invoice", function () {
        var invoiceNamaCus = $('#invoice-nama-customer');
        var invoiceTlp = $('#invoice-no-tlp');
        var invoiceJalan = $('#invoice-jalan');
        var namaCustomer = $('#kasir-nama-customer').val();
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

        updateInvoice();
    });

    $(document).on("change", "#kasir-discount", function () {
        updateSubtotalBox();
        updateInvoice();
    });

    $(document).on("change", "#kasir-ongkir", function () {
        updateSubtotalBox();
        updateInvoice();
    });

    $(document).on("input", ".kasir-formated-rupiah", function () {
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
    })

 });
