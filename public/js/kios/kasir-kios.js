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
                id: part.id
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

// Alphine.js
document.addEventListener('alpine:init', () => {
    Alpine.store('kasirForm', {
        itemCount: 0,
        items: [],
        invoices: [],
        autocompleteData: {},

        addItem() {
            this.itemCount++;
            this.items.push({
                id: this.itemCount,
                jenisTransaksi: '',
                itemName: '',
                itemId: '',
                kasirSn: '',
                kasirHarga: '',
                kasirModalPart: '',
                checkboxTax: false,
                itemOptions: [],
                filteredItems: [],
                searchQuery: '',
                kasirSnOptions: [],
                showDropdown: false,
            });
        },

        removeItem(id) {
            this.items = this.items.filter(item => item.id !== id);
        },

        async fetchItemOptions(item) {
            if (!item.jenisTransaksi) {
                alert('Silahkan pilih jenis transaksi terlebih dahulu.');
                return;
            }

            if (!this.autocompleteData[item.jenisTransaksi]) {
                try {
                    let response = await fetch(`/kios/kasir/autocomplete/${item.jenisTransaksi}`);
                    let data = await response.json();
                    this.autocompleteData[item.jenisTransaksi] = data;
                } catch (error) {
                    alert('Terjadi kesalahan saat mengambil data.');
                    return;
                }
            }

            if (item.jenisTransaksi == 'part_baru' || item.jenisTransaksi == 'part_bekas') {
                
                item.itemOptions = this.autocompleteData[item.jenisTransaksi].map(part => ({
                    label: part.nama_part,
                    value: part.id
                }));

            } else {

                item.itemOptions = this.autocompleteData[item.jenisTransaksi].map(drone => ({
                    label: drone.subjenis.paket_penjualan,
                    value: drone.subjenis.id
                }));

            }

            item.filteredItems = item.itemOptions;
        },

        searchItems(item) {
            if (!item.searchQuery) {
                item.filteredItems = item.itemOptions;
            } else {
                item.filteredItems = item.itemOptions.filter(option =>
                    option.label.toLowerCase().includes(item.searchQuery.toLowerCase())
                );
            }
            item.showDropdown = true;
        },

        selectItem(item, selectedItem) {
            this.removeFromInvoice(item);

            item.itemId = selectedItem.value;
            item.itemName = selectedItem.label;
            item.showDropdown = false;
            item.searchQuery = selectedItem.label;

            this.fetchKasirSnOptions(item);
        },

        async fetchKasirSnOptions(item) {
            if (!item.itemId) {
                alert('Silahkan pilih item terlebih dahulu.');
                return;
            }

            try {
                let response = await fetch(`/kios/kasir/getSerialNumber/${item.jenisTransaksi}/${item.itemId}`);
                let data = await response.json();

                if (!data || !data.data_sn) {
                    alert('Tidak ada serial number yang tersedia.');
                    return;
                }

                if (item.jenisTransaksi == 'part_baru' || item.jenisTransaksi == 'part_bekas') {

                    item.kasirSnOptions = data.data_sn.map(sn => ({
                        label: sn.id_item,
                        value: sn.id
                    }));

                    item.kasirHarga = formatRupiah(data.nilai.hargaGlobal);

                } else {

                    item.kasirSnOptions = data.data_sn.map(sn => ({
                        label: sn.serial_number,
                        value: sn.id
                    }));

                    item.kasirHarga = formatRupiah(data.nilai);

                }

                this.addToInvoice(item);

            } catch (error) {
                alert('Terjadi kesalahan saat mengambil data serial number. Error : ' + error);
            }
        }, 

        addToInvoice(item) {
            var deskripsi = item.jenisTransaksi == 'drone_baru'
                ? 'Unit Baru, Garansi 1 Tahun'
                : item.jenisTransaksi == 'drone_bekas'
                    ? 'Unit Second, Garansi 1'
                    : '-';

            const invoiceItem = {
                productName: item.itemName,
                description: deskripsi,
                qty: 1,
                itemPrice: item.kasirHarga || 0,
                totalPrice: item.kasirHarga || 0,
            };

            this.invoices.push(invoiceItem);
        },

        removeFromInvoice(item) {
            this.invoices = this.invoices.filter(invItem => invItem.productName !== item.itemName);
        },
    });
});

$(document).ready(function(){
    const kasirContainer = $("#kasir-container");
    let itemCount = $("#kasir-container tr").length;

    $(document).on('change', '.checkbox-tax', function() {
        updateInvoice();
        updateSubtotalBox();
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
