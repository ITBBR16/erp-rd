function formatRupiah(angka) {
    return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
}

function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

// Alphine.js
document.addEventListener("alpine:init", () => {
    Alpine.store("kasirForm", {
        itemCount: 0,
        items: [],
        invoices: [],
        autocompleteData: {},
        discount: "0",
        ongkir: "0",
        packing: "0",
        asuransi: "0",
        kerugian: "0",
        subTotal: 0,
        asuransiChecked: false,

        addItem() {
            this.itemCount++;
            this.items.push({
                id: this.itemCount,
                jenisTransaksi: "",
                itemName: "",
                itemId: "",
                kasirSn: "",
                kasirHarga: "",
                garansiSecond: "",
                modalGudang: "",
                kasirModalPart: "",
                checkboxTax: false,
                itemOptions: [],
                filteredItems: [],
                searchQuery: "",
                kasirSnOptions: [],
                showDropdown: false,
            });
        },

        toggleAsuransi() {
            let netTotal = this.subTotal - this.discount;

            if (this.asuransiChecked) {
                if (netTotal >= 20000001) {
                    this.asuransi = Math.round(netTotal * 0.0027);
                } else if (netTotal >= 10000001) {
                    this.asuransi = 38000;
                } else if (netTotal >= 5000001) {
                    this.asuransi = 19000;
                } else if (netTotal >= 3000001) {
                    this.asuransi = 8550;
                } else if (netTotal >= 1000001) {
                    this.asuransi = 4750;
                } else {
                    this.asuransi = 950;
                }
            } else {
                this.asuransi = 0;
            }

            this.updateInvoice();
        },

        removeItem(id) {
            const itemToRemove = this.items.find((item) => item.id === id);
            if (itemToRemove) {
                this.removeFromInvoice(itemToRemove);
            }
            this.items = this.items.filter((item) => item.id !== id);
        },

        async fetchItemOptions(item) {
            if (!item.jenisTransaksi) {
                alert("Silahkan pilih jenis transaksi terlebih dahulu.");
                return;
            }

            if (!this.autocompleteData[item.jenisTransaksi]) {
                try {
                    let response = await fetch(
                        `/kios/kasir/autocomplete/${item.jenisTransaksi}`
                    );
                    let data = await response.json();
                    this.autocompleteData[item.jenisTransaksi] = data;
                } catch (error) {
                    alert("Terjadi kesalahan saat mengambil data.");
                    return;
                }
            }

            if (
                item.jenisTransaksi == "part_baru" ||
                item.jenisTransaksi == "part_bekas"
            ) {
                item.itemOptions = this.autocompleteData[
                    item.jenisTransaksi
                ].map((part) => ({
                    label: part.nama_part,
                    value: part.id,
                }));
            } else {
                item.itemOptions = this.autocompleteData[
                    item.jenisTransaksi
                ].map((drone) => ({
                    label: drone.subjenis.paket_penjualan,
                    value: drone.subjenis.id,
                }));
            }

            item.filteredItems = item.itemOptions;
        },

        searchItems(item) {
            if (!item.searchQuery) {
                item.filteredItems = item.itemOptions;
            } else {
                item.filteredItems = item.itemOptions.filter((option) =>
                    option.label
                        .toLowerCase()
                        .includes(item.searchQuery.toLowerCase())
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
                alert("Silahkan pilih item terlebih dahulu.");
                return;
            }

            try {
                let response = await fetch(
                    `/kios/kasir/getSerialNumber/${item.jenisTransaksi}/${item.itemId}`
                );
                let data = await response.json();

                if (!data || !data.data_sn) {
                    alert("Tidak ada serial number yang tersedia.");
                    return;
                }

                item.modalGudang = data.nilai.modalGudang;

                if (
                    item.jenisTransaksi == "part_baru" ||
                    item.jenisTransaksi == "part_bekas"
                ) {
                    item.kasirSnOptions = data.data_sn.map((sn) => ({
                        label: sn.id_item,
                        value: sn.id,
                    }));

                    item.kasirHarga = formatRupiah(data.nilai.hargaGlobal);
                    item.modalGudang = data.nilai.modalGudang;
                } else if (item.jenisTransaksi == "drone_baru") {
                    item.kasirSnOptions = data.data_sn.map((sn) => ({
                        label: sn.serial_number,
                        value: sn.id,
                    }));

                    item.kasirHarga = formatRupiah(data.nilai);
                } else if (item.jenisTransaksi == "drone_bekas") {
                    item.kasirSnOptions = data.data_sn.map((sn) => ({
                        label: sn.serial_number,
                        value: sn.id,
                    }));
                } else if (item.jenisTransaksi == "drone_bnob") {
                    item.kasirSnOptions = data.data_sn.map((sn) => ({
                        label: sn.serial_number,
                        value: sn.id,
                    }));
                }
            } catch (error) {
                alert(
                    "Terjadi kesalahan saat mengambil data serial number. Error : " +
                        error
                );
            }
        },

        updateNilaiDroneBekas(item, option) {
            return new Promise((resolve, reject) => {
                if (item.jenisTransaksi === "drone_bekas" && option !== "") {
                    fetch(`/kios/kasir/getNilaiDroneSecond/${option}`)
                        .then((response) => response.json())
                        .then((data) => {
                            item.kasirHarga = formatRupiah(data.nilai);
                            item.garansiSecond = data.garansi;
                            resolve();
                        })
                        .catch((error) => {
                            console.error("Error fetching data:", error);
                            reject(error);
                        });
                } else if (
                    item.jenisTransaksi === "drone_bnob" &&
                    option !== ""
                ) {
                    fetch(`/kios/kasir/get-nilai-bnob/${option}`)
                        .then((response) => response.json())
                        .then((data) => {
                            item.kasirHarga = formatRupiah(data.nilai);
                            resolve();
                        })
                        .catch((error) => {
                            console.error("Error fetching data:", error);
                            reject(error);
                        });
                } else {
                    resolve();
                }
            });
        },

        addToInvoice(item) {
            var selectedSnLabel =
                item.kasirSnOptions.find((sn) => sn.value == item.kasirSn)
                    ?.label || item.kasirSn;
            var deskripsi =
                item.jenisTransaksi == "drone_bekas"
                    ? "Unit Second, Garansi " +
                      item.garansiSecond +
                      " Bulan Serial Number " +
                      selectedSnLabel
                    : item.jenisTransaksi == "drone_baru"
                    ? "Unit Baru, Garansi 1 Tahun Serial Number " +
                      selectedSnLabel
                    : "-";

            if (
                item.jenisTransaksi === "part_baru" ||
                item.jenisTransaksi === "part_bekas"
            ) {
                const existingInvoiceItem = this.invoices.find(
                    (invItem) =>
                        invItem.productName === item.itemName &&
                        invItem.description === deskripsi
                );

                if (existingInvoiceItem) {
                    existingInvoiceItem.qty += 1;
                    existingInvoiceItem.totalPrice = formatRupiah(
                        existingInvoiceItem.qty *
                            (parseFloat(item.kasirHarga.replace(/\D/g, "")) ||
                                0)
                    );
                } else {
                    const invoiceItem = {
                        productName: item.itemName,
                        description: deskripsi,
                        qty: 1,
                        itemPrice: item.kasirHarga || 0,
                        totalPrice: item.kasirHarga || 0,
                    };
                    this.invoices.push(invoiceItem);
                }
            } else {
                const invoiceItem = {
                    productName: item.itemName,
                    description: deskripsi,
                    qty: 1,
                    itemPrice: item.kasirHarga || 0,
                    totalPrice: item.kasirHarga || 0,
                };
                this.invoices.push(invoiceItem);
            }
        },

        removeFromInvoice(item) {
            const existingInvoiceItem = this.invoices.find(
                (invItem) =>
                    invItem.productName === item.itemName &&
                    (item.jenisTransaksi === "part_baru" ||
                        item.jenisTransaksi === "part_bekas")
            );

            if (existingInvoiceItem && existingInvoiceItem.qty > 1) {
                existingInvoiceItem.qty -= 1;
                existingInvoiceItem.totalPrice = formatRupiah(
                    existingInvoiceItem.qty *
                        (parseFloat(item.kasirHarga.replace(/\D/g, "")) || 0)
                );
            } else {
                this.invoices = this.invoices.filter(
                    (invItem) => invItem.productName !== item.itemName
                );
            }
        },

        updateInvoice() {
            let kasirDiscount =
                parseFloat(this.discount.replace(/\D/g, "")) || 0;
            let kasirOngkir = parseFloat(this.ongkir.replace(/\D/g, "")) || 0;
            let kasirPacking = parseFloat(this.packing.replace(/\D/g, "")) || 0;
            let kasirAsuransi = this.asuransi || 0;
            let kasirKerugian =
                parseFloat(this.kerugian.replace(/\D/g, "")) || 0;
            this.subTotal = 0;

            this.items.forEach((item) => {
                let price = parseFloat(item.kasirHarga.replace(/\D/g, "")) || 0;
                this.subTotal += price;
            });

            let totalOngkirInvoice = kasirOngkir + kasirPacking + kasirAsuransi;
            let totalPayment =
                this.subTotal -
                kasirDiscount -
                kasirKerugian +
                totalOngkirInvoice;

            document.getElementById("kasir-asuransi").value = kasirAsuransi;
            document.getElementById("input-invoice-subtotal").value =
                formatRupiah(this.subTotal);
            document.getElementById("input-invoice-discount").value =
                formatRupiah(kasirDiscount);
            document.getElementById("input-invoice-ongkir").value =
                formatRupiah(totalOngkirInvoice);
            document.getElementById("input-invoice-total").value =
                formatRupiah(totalPayment);
            document.getElementById("invoice-subtotal").textContent =
                formatRupiah(this.subTotal);
            document.getElementById("invoice-discount").textContent =
                formatRupiah(kasirDiscount);
            document.getElementById("invoice-ongkir").textContent =
                formatRupiah(totalOngkirInvoice);
            document.getElementById("invoice-total").textContent =
                formatRupiah(totalPayment);
            document.getElementById("kasir-box-subtotal").textContent =
                formatRupiah(this.subTotal);
            document.getElementById("kasir-box-discount").textContent =
                formatRupiah(kasirDiscount);
            document.getElementById("kasir-box-kerugian").textContent =
                formatRupiah(kasirKerugian);
            document.getElementById("kasir-box-ongkir").textContent =
                formatRupiah(kasirOngkir);
            document.getElementById("kasir-box-packing").textContent =
                formatRupiah(kasirPacking);
            document.getElementById("kasir-box-asuransi").textContent =
                formatRupiah(kasirAsuransi);
            document.getElementById("kasir-box-total").textContent =
                formatRupiah(totalPayment);
        },
    });
});

$(document).ready(function () {
    $(document).on("click", "#add-metode-pembayaran-lunas", function () {
        let formLength = $(".form-mp-kasir").length;
        const containerMPKasirLunas = $(
            "#container-metode-pembayaran-kasir-kios"
        );

        formLength++;
        let formMP = `
            <div id="form-mp-kasir-${formLength}" class="form-mp-kasir grid grid-cols-4 gap-4 mb-4" style="grid-template-columns: 5fr 5fr 3fr 1fr">
                <div>
                    <label for="kasir-metode-pembayaran-${formLength}" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Pilih Metode Pembayaran :</label>
                    <select name="kasir_metode_pembayaran[]" id="kasir-metode-pembayaran-${formLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Select Metode Pembayaran</option>`;
        daftarAkun.forEach(function (akun) {
            formMP += `<option value="${akun.id}">${akun.nama_akun}</option>`;
        });
        formMP += `
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
        `;
        containerMPKasirLunas.append(formMP);
    });

    $(document).on("click", ".remove-mp-kasir", function () {
        let idForm = $(this).data("id");
        $("#form-mp-kasir-" + idForm).remove();
    });

    $(document).on("click", ".review-invoice", function () {
        var invoiceNamaCus = $("#invoice-nama-customer");
        var invoiceTlp = $("#invoice-no-tlp");
        var invoiceJalan = $("#invoice-jalan");
        var namaCustomer = $("#kasir-nama-customer").val();
        fetch(`/kios/kasir/getCustomer/${namaCustomer}`)
            .then((response) => response.json())
            .then((data) => {
                data.forEach((customer) => {
                    var fullName =
                        customer.first_name +
                        (customer.last_name ? " " + customer.last_name : "");

                    invoiceNamaCus.val(fullName);
                    invoiceTlp.val(customer.no_telpon);
                    invoiceJalan.val(customer.nama_jalan);
                });
            })
            .catch((error) => console.error("Error:", error));

        checkPembayaranKasirLunas();
    });

    $(document).on(
        "change",
        "#kasir-discount, #kasir-kerugian, #kasir-ongkir, #kasir-packing, #checkbox-asuransi, #kasir-dikembalikan, #kasir-pll, #kasir-sc, .kasir_sn, .kasir-nominal-pembayaran",
        function () {
            checkPembayaranKasirLunas();
        }
    );

    $(document).on("input", ".kasir-formated-rupiah", function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, "");
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatAngka(parsedValue));
    });

    $(document).on("click", "#button-print-invoice", function (e) {
        e.preventDefault();
        window.print();
    });

    // Update Customer
    $(document).on("click", ".done-update-data-customer", function () {
        var idCustomer = $("#kasir-nama-customer").val();
        var firstName = $("#update-first-name").val();
        var lastName = $("#update-last-name").val();
        var provinsiId = $("#update-kasir-provinsi").val();
        var kotaId = $("#update-kasir-kota").val();
        var kecamatanId = $("#update-kasir-kecamatan").val();
        var kelurahanId = $("#update-kasir-kelurahan").val();
        var kodePos = $("#update-kasir-kodepos").val();
        var alamat = $("#update-kasir-alamat").val();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/kios/kasir/updateDataCustomer",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                id_customer: idCustomer,
                first_name: firstName,
                last_name: lastName,
                provinsi_customer: provinsiId,
                kota_customer: kotaId,
                kecamatan_customer: kecamatanId,
                kelurahan_customer: kelurahanId,
                kode_pos_customer: kodePos,
                alamat_customer: alamat,
            },
            success: function (response) {
                // console.log(response);
            },
            error: function (xhr, status, error) {
                aler(xhr.responseText);
            },
        });
    });

    $(document).on("click", ".update-alamat-kasir", function () {
        var idCustomer = $("#kasir-nama-customer").val();
        var containerFirstName = $("#update-first-name");
        var containerLastName = $("#update-last-name");
        var containerKodePos = $("#update-kasir-kodepos");
        var containerAlamat = $("#update-kasir-alamat");

        if (idCustomer == "") {
            alert("Silahkan pilih customer terlebih dahulu.");
            return;
        }

        fetch(`/kios/kasir/getCustomer/${idCustomer}`)
            .then((response) => response.json())
            .then((data) => {
                let provinsiId = data[0].provinsi_id;
                let kotaId = data[0].kota_kabupaten_id;
                let kecamatanId = data[0].kecamatan_id;
                let kelurahanId = data[0].kelurahan_id;

                containerFirstName.val(data[0].first_name);
                containerLastName.val(data[0].last_name);

                getProvinsi(provinsiId);

                if (provinsiId) {
                    getDataKota(provinsiId, kotaId);

                    if (kotaId) {
                        getDataKecamatan(kotaId, kecamatanId);

                        if (kecamatanId) {
                            getDataKelurahan(kecamatanId, kelurahanId);
                        }
                    }
                }

                containerKodePos.val(data[0].kode_pos);
                containerAlamat.val(data[0].nama_jalan);
            })
            .catch((error) => console.error("Error:", error));
    });

    $(document).on("change", "#update-kasir-provinsi", function () {
        getDataKota();
    });

    $(document).on("change", "#update-kasir-kota", function () {
        getDataKecamatan();
    });

    $(document).on("change", "#update-kasir-kecamatan", function () {
        getDataKelurahan();
    });

    function checkPembayaranKasirLunas() {
        let totalTagihan = 0;
        let totalPembayaran = 0;
        let nominalDiscount =
            parseFloat($("#kasir-discount").val().replace(/\./g, "")) || 0;
        let nominalKerugian =
            parseFloat($("#kasir-kerugian").val().replace(/\./g, "")) || 0;
        let nominalOngkir =
            parseFloat($("#kasir-ongkir").val().replace(/\./g, "")) || 0;
        let nominalPacking =
            parseFloat($("#kasir-packing").val().replace(/\./g, "")) || 0;
        let nominalAsuransi =
            parseFloat($("#kasir-asuransi").val().replace(/\D/g, "")) || 0;
        let nominalDikembalikan =
            parseFloat($("#kasir-dikembalikan").val().replace(/\./g, "")) || 0;
        let nominalPll =
            parseFloat($("#kasir-pll").val().replace(/\./g, "")) || 0;
        let nominalSaveSaldoCustomer =
            parseFloat($("#kasir-sc").val().replace(/\./g, "")) || 0;
        let statusBox = $("#status-box-lunas");

        $("input[name='kasir_harga[]']").each(function () {
            let harga = parseFloat($(this).val().replace(/\D/g, "")) || 0;
            totalTagihan += harga;
        });

        $("input[name='kasir_nominal_pembayaran[]']").each(function () {
            let pembayaran = parseFloat($(this).val().replace(/\D/g, "")) || 0;
            totalPembayaran += pembayaran;
        });

        let totalTagihanCustomer =
            totalTagihan +
            nominalOngkir +
            nominalPacking +
            nominalAsuransi +
            nominalDikembalikan +
            nominalPll +
            nominalSaveSaldoCustomer;
        let totalPembayaranCustomer =
            totalPembayaran + nominalDiscount + nominalKerugian;

        console.log("nominalAsuransi : " + nominalAsuransi);
        console.log("Total Tagihan Customer : " + totalTagihanCustomer);
        console.log("Total Pembayaran Customer : " + totalPembayaranCustomer);

        if (totalTagihanCustomer == totalPembayaranCustomer) {
            statusBox
                .text("Pass")
                .removeClass(
                    "bg-rose-100 text-rose-700 dark:bg-rose-800 dark:text-rose-300 bg-orange-100 text-orange-700 dark:bg-orange-800 dark:text-orange-300"
                )
                .addClass(
                    "bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-300"
                );

            $("#btn-kasir-lunas")
                .removeClass("cursor-not-allowed")
                .removeAttr("disabled");

            if (
                (!nominalDikembalikan && nominalDikembalikan !== 0) ||
                (!nominalPll && nominalPll !== 0) ||
                (!nominalSaveSaldoCustomer && nominalSaveSaldoCustomer !== 0)
            ) {
                $("#form-kelebihan").hide();
                $("#kasir-dikembalikan").val(0);
                $("#kasir-pll").val(0);
                $("#kasir-sc").val(0);
            }
        } else if (totalTagihanCustomer < totalPembayaranCustomer) {
            statusBox
                .text("Overpay")
                .removeClass(
                    "bg-rose-100 text-rose-700 dark:bg-rose-800 dark:text-rose-300 bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-300"
                )
                .addClass(
                    "bg-orange-100 text-orange-700 dark:bg-orange-800 dark:text-orange-300"
                );
            $("#form-kelebihan").show();
            $("#btn-kasir-lunas")
                .addClass("cursor-not-allowed")
                .prop("disabled", true);
        } else {
            statusBox
                .text("Not Pass")
                .removeClass(
                    "bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-300 bg-orange-100 text-orange-700 dark:bg-orange-800 dark:text-orange-300"
                )
                .addClass(
                    "bg-rose-100 text-rose-700 dark:bg-rose-800 dark:text-rose-300"
                );
            $("#form-kelebihan").hide();
            $("#kasir-dikembalikan").val(0);
            $("#kasir-pll").val(0);
            $("#kasir-sc").val(0);
            $("#btn-kasir-lunas")
                .addClass("cursor-not-allowed")
                .prop("disabled", true);
        }
    }

    function getProvinsi(provinsiId) {
        const containerProvinsi = $("#update-kasir-provinsi");
        const containerKota = $("#update-kasir-kota");
        const containerKecamatan = $("#update-kasir-kecamatan");
        const containerKelurahan = $("#update-kasir-kelurahan");

        containerKota.html("");
        containerKecamatan.html("");
        containerKelurahan.html("");

        fetch("/getProvinsi")
            .then((response) => response.json())
            .then((data) => {
                containerProvinsi.html("");
                if (data.length > 0) {
                    const defaultOption = $("<option>")
                        .text("Pilih Provinsi")
                        .val("")
                        .attr("hidden", true);
                    containerProvinsi.append(defaultOption);

                    data.forEach((provinsi) => {
                        const option = $("<option>")
                            .val(provinsi.id)
                            .text(provinsi.name)
                            .addClass("bg-white dark:bg-gray-700");

                        if (provinsiId && provinsi.id == provinsiId) {
                            option.attr("selected", true);
                        }

                        containerProvinsi.append(option);
                    });
                }
            })
            .catch((error) => console.error("Error fetching data:", error));
    }

    function getDataKota(provinsiId, kotaId) {
        const selectedProvinsi =
            provinsiId != null ? provinsiId : $("#update-kasir-provinsi").val();
        const containerKota = $("#update-kasir-kota");
        const containerKecamatan = $("#update-kasir-kecamatan");
        const containerKelurahan = $("#update-kasir-kelurahan");

        containerKecamatan.html("");
        containerKelurahan.html("");

        if (selectedProvinsi) {
            fetch(`/getKota/${selectedProvinsi}`)
                .then((response) => response.json())
                .then((data) => {
                    containerKota.html("");
                    if (data.length > 0) {
                        const defaultOption = $("<option>")
                            .text("Pilih Kota / Kabupaten")
                            .val("")
                            .attr("hidden", true);
                        containerKota.append(defaultOption);

                        data.forEach((kota) => {
                            const option = $("<option>")
                                .val(kota.id)
                                .text(kota.name)
                                .addClass("bg-white dark:bg-gray-700");

                            if (kotaId && kota.id == kotaId) {
                                option.attr("selected", true);
                            }
                            containerKota.append(option);
                        });
                    }
                })
                .catch((error) => console.error("Error fetching data:", error));
        }
    }

    function getDataKecamatan(kotaId, kecamatanId) {
        const selectedKota =
            kotaId != null ? kotaId : $("#update-kasir-kota").val();
        const containerKecamatan = $("#update-kasir-kecamatan");
        const containerKelurahan = $("#update-kasir-kelurahan");

        containerKelurahan.html("");

        if (selectedKota) {
            fetch(`/getKecamatan/${selectedKota}`)
                .then((response) => response.json())
                .then((data) => {
                    containerKecamatan.html("");
                    if (data.length > 0) {
                        const defaultOption = $("<option>")
                            .text("Pilih Kecamatan")
                            .val("")
                            .attr("hidden", true);
                        containerKecamatan.append(defaultOption);

                        data.forEach((kecamatan) => {
                            const option = $("<option>")
                                .val(kecamatan.id)
                                .text(kecamatan.name)
                                .addClass("bg-white dark:bg-gray-700");

                            if (kecamatanId && kecamatan.id == kecamatanId) {
                                option.attr("selected", true);
                            }
                            containerKecamatan.append(option);
                        });
                    }
                })
                .catch((error) => console.error("Error fetching data:", error));
        }
    }

    function getDataKelurahan(kecamatanId, kelurahanId) {
        const selectedKecamatan =
            kecamatanId != null
                ? kecamatanId
                : $("#update-kasir-kecamatan").val();
        const containerKelurahan = $("#update-kasir-kelurahan");

        if (selectedKecamatan) {
            fetch(`/getKelurahan/${selectedKecamatan}`)
                .then((response) => response.json())
                .then((data) => {
                    containerKelurahan.empty();
                    if (data.length > 0) {
                        const defaultOption = $("<option>")
                            .text("Pilih Kelurahan")
                            .val("")
                            .attr("hidden", true)
                            .addClass("bg-white dark:bg-gray-700");
                        containerKelurahan.append(defaultOption);

                        let isOptionSelected = false;

                        data.forEach((kelurahan) => {
                            const option = $("<option>")
                                .val(kelurahan.id)
                                .text(kelurahan.name);

                            if (kelurahanId && kelurahan.id == kelurahanId) {
                                option.attr("selected", true);
                                isOptionSelected = true;
                            }
                            containerKelurahan.append(option);
                        });
                    }
                })
                .catch((error) => console.error("Error fetching data:", error));
        }
    }
});
