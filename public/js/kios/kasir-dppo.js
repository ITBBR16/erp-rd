function formatRupiah(angka) {
    return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
}

function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

function updateBoxDPPO() {
    let dppoSubtotal = 0;
    let dppoNominal = parseFloat($("#dppo-nominal").val().replace(/\./g, '')) || 0;

    $("#dppo-container tr").each(function() {
        var dppoPrice = $(this).find("[name='dppo_harga[]']").val();
        var qtyProduct = parseFloat($(this).find("[name='dppo_qty_produk[]']").val());

        if (isNaN(qtyProduct) || qtyProduct <= 0) {
            qtyProduct = 1;
        }

        var nilai = parseFloat(dppoPrice.replace(/\D/g, ''));
        var totalNilai = nilai * qtyProduct;
        dppoSubtotal += totalNilai;
    });

    var totalPembayaran = dppoSubtotal - dppoNominal;
    var showDp = formatRupiah(dppoNominal);

    $("#dppo-box-subtotal").text(formatRupiah(dppoSubtotal))
    $("#dppo-box-dp").text(showDp)
    $("#dppo-box-total").text(formatRupiah(totalPembayaran))
}

function updateInvoiceDppo() {
    let dppoSubtotal = 0;
    let invoiceContent = "";
    let nominalDp = parseFloat($("#dppo-nominal").val().replace(/\./g, '')) || 0;
    var statusDPPO = $("#status-dppo").val();
    var resultKeteranganProduk = (statusDPPO === 'DP') ? 
                                    'Down Payment Produk Baru' : 
                                        ((statusDPPO === 'PO') 
                                            ? 'Pre Order Produk Baru' : '');

    $("#dppo-container tr").each(function() {
        var itemName = $(this).find("[name='dppo_nama_produk[]']").val();
        var dppoPrice = $(this).find("[name='dppo_harga[]']").val();
        var qtyProduct = parseFloat($(this).find("[name='dppo_qty_produk[]']").val());
        var nilai = parseFloat(dppoPrice.replace(/\D/g, ''));
        var totalNilai = nilai * qtyProduct;
        var totalRupiah = formatRupiah(totalNilai);

        dppoSubtotal += totalNilai;

        invoiceContent += `
        <tr class="bg-white dark:bg-gray-800">
            <td class="px-2 py-1">${itemName}</td>
            <td class="px-2 py-1 text-xs">${resultKeteranganProduk}</td>
            <td class="px-2 py-1">${qtyProduct}</td>
            <td class="px-2 py-1">${dppoPrice}</td>
            <td class="px-2 py-1">${totalRupiah}</td>
        </tr>
        `;
    });

    var totalPembayaran = dppoSubtotal - nominalDp;
    var showDp = formatRupiah(nominalDp);
    var statusInvoice = (statusDPPO == 'DP') ? 'Down Payment' : 'Pre Order';

    $("#invoice-title").text(statusInvoice);
    $("#invoice-dppo-subtotal").text(formatRupiah(dppoSubtotal));
    $("#invoice-dppo-dp").text(showDp);
    $("#invoice-dppo-sisa-total").text(formatRupiah(totalPembayaran));
    $("#invoice-dppo-container").html(invoiceContent);
}

$(document).ready(function () {
    const addItemDppo = $('#add-item-dppo');
    const dppoContainer = $('#dppo-container');
    let itemBodyCount = $('#dppo-container tr').length;

    $(document).on('input', '#dppo-nominal', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatAngka(parsedValue));
    });

    $(document).on('change', '#status-dppo', function() {
        if($(this).val() == 'DP') {
            $('#dppo-nominal').attr('required', 'required');
        } else {
            $('#dppo-nominal').removeAttr('required');
        }
    });

    addItemDppo.on('click', function () {
        itemBodyCount++
        let formItem = `
            <tr id="dppo-item-${itemBodyCount}" class="bg-white dark:bg-gray-800">
                <td class="px-4 py-4">
                    <label for="dppo-jenis-transaksi-${itemBodyCount}"></label>
                    <select name="dppo_jenis_transaksi[]" id="dppo-jenis-transaksi-${itemBodyCount}" data-id="${itemBodyCount}" class="jenis_produk bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Jenis Transaksi</option>
                        <option value="drone_baru">Drone Baru</option>
                        <option value="drone_bekas">Drone Bekas</option>
                    </select>
                </td>
                <td class="px-4 py-4">
                    <input type="hidden" name="dppo_id_produk[]" id="dppo-item-id-${itemBodyCount}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
                    <input type="text" name="dppo_nama_produk[]" id="dppo-nama-produk-${itemBodyCount}" data-id="${itemBodyCount}" class="dppo_nama_produk bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item Name" required>
                </td>
                <td class="px-4 py-4">
                    <input type="text" name="dppo_qty_produk[]" id="qty-produk-${itemBodyCount}" data-id="${itemBodyCount}" class="dppo_qty_produk bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Jumlah Produk" required>
                </td>
                <td class="px-4 py-4">
                    <input type="text" name="dppo_harga[]" id="dppo-harga-${itemBodyCount}" data-id="${itemBodyCount}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rp. 0" readonly required>
                </td>
                <td class="px-4 py-4">
                    <button type="button" class="remove-dppo-item" data-id="${itemBodyCount}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </td>
            </tr>
        `;
        dppoContainer.append(formItem);
    })

    $(document).on("click", ".remove-dppo-item", function() {
        let itemNameId = $(this).data("id");
        $("#dppo-item-"+itemNameId).remove();
        itemBodyCount--;
        updateBoxDPPO();
        updateInvoiceDppo()
   });

   $(document).on('focus', '.dppo_nama_produk', function () {
        let produkNameId = $(this).data("id");
        let jenisTransaksi = $('#dppo-jenis-transaksi-'+produkNameId).val();

        $.get(`/kios/kasir/autocomplete/${jenisTransaksi}`, function(data) {
            $("#dppo-nama-produk-"+produkNameId).autocomplete({
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

                    $("#dppo-item-id-"+produkNameId).val(selectedId);
                }
            }).autocomplete("widget").addClass("cursor-pointer px-2 w-64 h-60 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500");

        }).fail(function(error) {
            console.error('Error:', error);
        });

   });

   $(document).on("click", "#dppo-review-invoice", function () {
        var invoiceNamaCus = $('#dppo-invoice-nama-customer');
        var invoiceTlp = $('#dppo-invoice-no-tlp');
        var invoiceJalan = $('#dppo-invoice-jalan');
        var namaCustomer = $('#dppo_nama_customer').val();
        fetch(`/kios/kasir/getCustomer/${namaCustomer}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(customer => {
                var fullName = customer.first_name + ' ' + customer.last_name + ' - ' + customer.id;

                invoiceNamaCus.text(fullName);
                invoiceTlp.text(customer.no_telpon);
                invoiceJalan.text(customer.nama_jalan);
            })
        })
        .catch(error => console.error('Error:', error));
        
        updateInvoiceDppo();
    });

   $(document).on('change', '.dppo_nama_produk', function () {
        let idItem = $(this).data("id");
        var formHarga = $('#dppo-harga-'+idItem);
        var jenisTransaksi = $('#dppo-jenis-transaksi-'+idItem).val();
        var produkId = $('#dppo-item-id-'+idItem).val();

        fetch(`/kios/kasir/getSrpProduk/${jenisTransaksi}/${produkId}`)
        .then(response => response.json())
        .then(data => {
            var harga = formatRupiah(data);
            formHarga.val(harga);

            updateBoxDPPO();
            updateInvoiceDppo()
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
   })

   $(document).on('change', '.dppo_qty_produk', function () {
        updateBoxDPPO();
        updateInvoiceDppo()
    })

   $(document).on('change', '#dppo-nominal', function () {
        updateBoxDPPO();
        updateInvoiceDppo()
   });
})