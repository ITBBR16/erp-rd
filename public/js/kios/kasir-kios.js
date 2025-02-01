function formatRupiah(angka) {
    return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
}

function printInvoice() {
    window.print();
}

function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
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

// Alphine.js
document.addEventListener('alpine:init', () => {
    Alpine.store('kasirForm', {
        itemCount: 0,
        items: [],
        invoices: [],
        autocompleteData: {},
        discount: "0",
        ongkir: "0",
        packing: "0",
        asuransi: "0",
        subTotal: 0,

        addItem() {
            this.itemCount++;
            this.items.push({
                id: this.itemCount,
                jenisTransaksi: '',
                itemName: '',
                itemId: '',
                kasirSn: '',
                kasirHarga: '',
                modalGudang: '',
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
            const itemToRemove = this.items.find(item => item.id === id);
            if (itemToRemove) {
                this.removeFromInvoice(itemToRemove);
            }
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

                item.modalGudang = data.nilai.modalGudang;

                if (item.jenisTransaksi == 'part_baru' || item.jenisTransaksi == 'part_bekas') {

                    item.kasirSnOptions = data.data_sn.map(sn => ({
                        label: sn.id_item,
                        value: sn.id
                    }));

                    item.kasirHarga = formatRupiah(data.nilai.hargaGlobal);
                    item.modalGudang = data.nilai.modalGudang;

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

        updateInvoice() {
            const kasirDiscount = parseFloat(this.discount.replace(/\D/g, '')) || 0;
            const kasirOngkir = parseFloat(this.ongkir.replace(/\D/g, '')) || 0;
            const kasirPacking = parseFloat(this.packing.replace(/\D/g, '')) || 0;
            const kasirAsuransi = parseFloat(this.asuransi.replace(/\D/g, '')) || 0;
            this.subTotal = 0;

            this.items.forEach(item => {
                const price = parseFloat(item.kasirHarga.replace(/\D/g, '')) || 0;
                this.subTotal += price;
            });

            const totalPayment = this.subTotal - kasirDiscount + kasirOngkir;
            const totalOngkirInvoice = kasirOngkir + kasirPacking + kasirAsuransi;

            document.getElementById("invoice-subtotal").textContent = formatRupiah(this.subTotal);
            document.getElementById("invoice-discount").textContent = formatRupiah(kasirDiscount);
            document.getElementById("invoice-ongkir").textContent = formatRupiah(totalOngkirInvoice);
            document.getElementById("invoice-total").textContent = formatRupiah(totalPayment);
            document.getElementById("kasir-box-subtotal").textContent = formatRupiah(this.subTotal);
            document.getElementById("kasir-box-discount").textContent = formatRupiah(kasirDiscount);
            document.getElementById("kasir-box-ongkir").textContent = formatRupiah(kasirOngkir);
            document.getElementById("kasir-box-packing").textContent = formatRupiah(kasirPacking);
            document.getElementById("kasir-box-asuransi").textContent = formatRupiah(kasirAsuransi);
            document.getElementById("kasir-box-total").textContent = formatRupiah(totalPayment);
        },
    });
});

$(document).ready(function(){

    $(document).on('click', '#add-metode-pembayaran-lunas', function () {
        let formLength = $('.form-mp-kasir').length;
        const containerMPKasirLunas = $('#container-metode-pembayaran-kasir-kios');

        formLength++;
        let formMP = `
            <div id="form-mp-kasir-${formLength}" class="form-mp-kasir grid grid-cols-4 gap-4 mb-4" style="grid-template-columns: 5fr 5fr 3fr 1fr">
                <div>
                    <label for="kasir-metode-pembayaran-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Metode Pembayaran :</label>
                    <select name="kasir_metode_pembayaran[]" id="kasir-metode-pembayaran-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Select Metode Pembayaran</option>`;
                        daftarAkun.forEach(function(akun) {
                            formMP += `<option value="${akun.id}">${akun.nama_akun}</option>`
                        });
                        formMP +=
                        `
                    </select>
                </div>
                <div>
                    <label for="kasir-nominal-pembayaran-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Nominal Pembayaran :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="kasir_nominal_pembayaran[]" id="kasir-nominal-pembayaran-${formLength}" class="kasir-formated-rupiah rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" oninput="this.value = this.value.replace(/\D/g, '')" required>
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Files Bukti Transaksi :</label>
                    <div class="relative z-0 w-full">
                        <label for="file-bukti-transaksi-${formLength}" id="file-label" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            No file chosen
                        </label>
                        <input type="file" name="file_bukti_transaksi[]" id="file-bukti-transaksi-${formLength}" class="hidden" onchange="updateFileName(this)"required>
                    </div>
                </div>
                <div class="flex justify-center items-end pb-2">
                    <button type="button" class="remove-mp-kasir" data-id="${formLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `
        containerMPKasirLunas.append(formMP);
    });

    $(document).on('click', '.remove-mp-kasir', function () {
        let idForm = $(this).data("id");
        $('#form-mp-kasir-' + idForm).remove();
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
