$(document).ready(function(){
    let itemCount = $("#kasir-container tr").length;

    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
    }

    function updateSubtotalBox() {
        let kasirSubtotal = 0;
        let kasirDiscount = parseFloat($("#kasir-discount").val()) || 0;
        let kasirTax = parseFloat($("#kasir-tax").val()) || 0;
        
        $("#kasir-container tr").each(function() {
            var kasirQty = $(this).find("[name='kasir_qty[]']").val();
            var kasirPrice = $(this).find("[name='kasir_harga[]']").val();

            kasirSubtotal += parseFloat(kasirPrice.replace(/\D/g, '')) * kasirQty;
        });

        var totalDiscount = kasirSubtotal * kasirDiscount / 100;
        var totalTax = kasirSubtotal * kasirTax / 100;
        var totalPayment = kasirSubtotal - totalDiscount + totalTax;
        var showDiscount = "(" + kasirDiscount + "%) " + formatRupiah(totalDiscount);
        var showTax = "(" + kasirTax + "%) " + formatRupiah(totalTax);

        $("#kasir-box-subtotal").text(formatRupiah(kasirSubtotal));
        $("#kasir-box-discount").text(showDiscount);
        $("#kasir-box-tax").text(showTax);
        $("#kasir-box-total").text(formatRupiah(totalPayment));
    }

    function updateInvoice() {
        let subTotal = 0;
        let discount = parseFloat($("#kasir-discount").val()) || 0;
        let tax = parseFloat($("#kasir-tax").val()) || 0;
        let invoiceContent = "";

        $("#kasir-container tr").each(function() {
            var itemName = $(this).find("[name='item_name[]']").val();
            var kasirSn = $(this).find("option:selected").text();
            var qty = $(this).find("[name='kasir_qty[]']").val();
            var price = $(this).find("[name='kasir_harga[]']").val();
            var totalRupiah = formatRupiah(parseFloat(price.replace(/\D/g, '')) * qty);
            
            subTotal += parseFloat(price.replace(/\D/g, '')) * qty;

            invoiceContent += `
            <tr class="bg-white dark:bg-gray-800">
                <td class="px-2 py-1">${itemName}</td>
                <td class="px-2 py-1 text-xs">${kasirSn}</td>
                <td class="px-2 py-1">${qty}</td>
                <td class="px-2 py-1">${price}</td>
                <td class="px-2 py-1">${totalRupiah}</td>
            </tr>
            `;
        });

        var totalDiscount = subTotal * discount / 100;
        var totalTax = subTotal * tax / 100;
        var totalPayment = subTotal - totalDiscount + totalTax;
        var showDiscount = "(" + discount + "%) " + formatRupiah(totalDiscount);
        var showTax = "(" + tax + "%) " + formatRupiah(totalTax);

        $("#invoice-subtotal").text(formatRupiah(subTotal));
        $("#invoice-discount").text(showDiscount);
        $("#invoice-tax").text(showTax);
        $("#invoice-total").text(formatRupiah(totalPayment));
        $("#invoice-kasir-container").html(invoiceContent);
    }

    function savePDF() {
        var modalContent = $('#print-invoice').html();
        var customerName = $('#invoice-nama-customer').text();

        var opt = {
            margin:       1,
            filename:     customerName + '_invoice.pdf',
            image:        { type: 'png', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        };

        html2pdf().from(modalContent).set(opt).save();
    }

    // function checkContent() {
    //     var modalContent = $('#print-invoice').html();
    //     var customerName = $('#invoice-nama-customer').text();

    //     if (modalContent.trim() !== '') {
    //         savePDF();
    //     } else {
    //         setTimeout(checkContent, 500);
    //     }
    // }

    // checkContent();

    function printInvoice() {
        window.print();
    }

    $("#add-item-kasir").on("click", function () {
         itemCount++
         let itemForm = `
         <tr id="kasir-item-${itemCount}" class="bg-white dark:bg-gray-800">
            <td class="px-4 py-4">
                <input type="hidden" name="item_id[]" id="item-id-${itemCount}" class="item_id bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
                <input type="text" name="item_name[]" id="item-name-${itemCount}" data-id="${itemCount}" class="item_name bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
            </td>
            <td class="px-4 py-4">
                <label for="kasir_sn-${itemCount}"></label>
                <select name="kasir_sn[]" id="kasir_sn-${itemCount}" data-id="${itemCount}" class="kasir_sn bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" hidden>-- Pilih SN --</option>
                </select>
            </td>
            <td class="px-4 py-4">
                <input type="text" name="kasir_qty[]" id="kasir-qty-${itemCount}" data-id="${itemCount}" class="kasir_qty bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1" required>
            </td>
            <td class="px-4 py-4">
                <input type="text" name="kasir_harga[]" id="kasir-harga-${itemCount}" data-id="${itemCount}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp. 0" readonly required>
            </td>
            <td class="px-4 py-4">
                <button type="button" class="remove-kasir-item" data-id="${itemCount}">
                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span>
                </button>
            </td>
        </tr>
         `;
         $("#kasir-container").append(itemForm);
         updateInvoice();

    });

    $(document).on('focus', '.item_name', function () {
        let itemNameId = $(this).data("id");
        $.get('/kios/autocomplete', function(data) {
            $("#item-name-"+itemNameId).autocomplete({
                source: function(request, response) {
                    
                    var term = request.term.toLowerCase();
                    var filteredData = data.filter(function(item) {
                        return (item.produkjenis.jenis_produk.toLowerCase().indexOf(term) !== -1) || 
                                (item.paket_penjualan.toLowerCase().indexOf(term) !== -1);
                    });

                    var formattedData = filteredData.map(function(item) {
                        return {
                            label: item.produkjenis.jenis_produk + ' ' + item.paket_penjualan,
                            value: item.produkjenis.jenis_produk + ' ' + item.paket_penjualan,
                            id: item.id
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
            console.error('Error:', error);
        });
    });

    $(document).on('change', '.item_name', function () {
        let formIdItem = $(this).data("id");
        var formSN = $('#kasir_sn-'+formIdItem);
        var formHarga = $('#kasir-harga-'+formIdItem);
        var idItem = $('#item-id-'+formIdItem).val();
        fetch('/kios/getSerialNumber/' + idItem)
        .then(response => response.json())
        .then(data => {

            formSN.empty();

            const defaultOption = $('<option>', {
                text: '-- Pilih SN --',
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
            
            var toHarga = formatRupiah(data.data_produk);
            formHarga.val(toHarga);

        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
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
        var namaCustomer = $('#nama_customer').val();
        fetch(`/kios/getCustomer/${namaCustomer}`)
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

    updateInvoice()

    $(document).on("change", "#kasir-discount", function () {
        updateSubtotalBox();
    });

    $(document).on("change", "#kasir-tax", function () {
        updateSubtotalBox();
    });

    $(document).on("change", ".kasir_qty", function () {
        updateSubtotalBox();
    });

    // $(document).on("click", "#button-download-invoice", function (e) {
    //     e.preventDefault();
    //     checkContent();
    // });

    $(document).on("click", "#button-print-invoice", function (e) {
        e.preventDefault();
        printInvoice();
    });

 });