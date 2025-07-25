$(document).ready(function () {
    let number = 0;

    $(document).on("change", "#jenis-produk-split", function () {
        updateSparepart();
    });

    $(document).on("change", "#nama-sparepart", function () {
        const idSparepart = $(this).val();
        const selectIdItem = $("#id-item");
        const skuText = $("#text-sku-split");

        fetch(`/gudang/produk/get-list-id-item/${idSparepart}`)
            .then((response) => response.json())
            .then((data) => {
                selectIdItem.empty();
                skuText.text(data.sku);

                const defaultOption = $("<option>")
                    .text("Pilih ID Item")
                    .val("")
                    .attr("hidden", true)
                    .addClass("bg-white dark:bg-gray-700");
                selectIdItem.append(defaultOption);

                data.listIdItem.forEach((idItem) => {
                    const nameII =
                        "N." +
                        idItem.gudang_belanja_id +
                        "." +
                        idItem.gudang_belanja.gudang_supplier_id +
                        "." +
                        idItem.id;
                    const option = $("<option>").val(idItem.id).text(nameII);
                    selectIdItem.append(option);
                });
            })
            .catch((error) => alert("Error fetching data : " + error));
    });

    $(document).on("change", "#id-item", function () {
        const idItem = $(this).val();
        const tanggalMasuk = $("#tanggal-masuk-split");
        const belanjaId = $("#belanja-id");
        const nilaiAwal = $("#nominal-awal-part-split");
        const nilaiAwalText = $("#text-sisa-nilai");

        fetch(`/gudang/produk/get-db-id-item/${idItem}`)
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                const date = new Date(data.created_at);
                const options = {
                    day: "numeric",
                    month: "short",
                    year: "numeric",
                };
                const formattedDate = date.toLocaleDateString("id-ID", options);

                const nominalPcsRounded = Math.round(data.nominal_pcs);

                tanggalMasuk.text(formattedDate);
                belanjaId.val(data.gudang_belanja_id);
                nilaiAwal.val(nominalPcsRounded);
                nilaiAwalText.text("Rp. " + formatAngka(nominalPcsRounded));
            })
            .catch((error) => alert("Error fetching data : " + error));
    });

    $(document).on("click", "#tambah-split-part", function () {
        var jenisProduk = $("#jenis-produk-split").val();
        if (jenisProduk == "") {
            alert("Pilih jenis produk terlebih dahulu");
            return;
        }
        number++;
        const containerSplit = $("#container-split-part");
        let formSplitPart = `
            <div id="form-list-split-${number}" class="form-list-split grid grid-cols-4 gap-6" style="grid-template-columns: 5fr 3fr 3fr 1fr">
                <div>
                    <label for="sparepart-split-${number}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sparepart :</label>
                    <select name="sparepart_split[]" id="sparepart-split-${number}" data-id="${number}" class="sparepart-split bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Sparepart</option>
                    </select>
                </div>
                <div>
                    <label for="nominal-split-${number}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal / Pcs :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="nominal_split[]" id="nominal-split-${number}" data-id="${number}" class="format-angka-rupiah nominal-split rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </div>
                <div>
                    <label for="qty-split-${number}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                    <input type="text" name="qty_split[]" id="qty-split-${number}" data-id="${number}" class="number-format qty-split bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                </div>
                <div class="flex justify-center mt-10">
                    <button type="button" class="remove-list-split" data-id="${number}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `;
        containerSplit.append(formSplitPart);

        const produkId = $("#jenis-produk-split").val();
        const selectElements = $("#sparepart-split-" + number);

        fetch(`/gudang/purchasing/sparepart-bjenis/${produkId}`)
            .then((response) => response.json())
            .then((data) => {
                selectElements.each(function () {
                    const select = $(this);
                    select.empty();

                    const defaultOption = $("<option>")
                        .text("Pilih Sparepart")
                        .val("")
                        .attr("hidden", true)
                        .addClass("bg-white dark:bg-gray-700");
                    select.append(defaultOption);

                    data.forEach((part) => {
                        const option = $("<option>")
                            .val(part.id)
                            .text(part.nama_internal);
                        select.append(option);
                    });
                });
            })
            .catch((error) => alert("Error fetching data: " + error));
    });

    $(document).on("click", "#tambah-split-optional-part", function () {
        let optionalLength = $(".optional-produk-split").length;
        let lastSelect = $("#produk-optional-split-" + optionalLength);
        if (lastSelect.length && lastSelect.val() === "") {
            alert("Selesaikan optional sebelumnya.");
            return;
        }
        optionalLength++;
        const containerOptional = $("#container-optional-split-part");
        let formOptional = `
            <div id="form-list-optional-split-${optionalLength}" class="form-list-optional-split grid grid-cols-5 gap-6" style="grid-template-columns: 5fr 5fr 3fr 3fr 1fr">
                <div>
                    <label for="produk-optional-split-${optionalLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Drone :</label>
                    <select name="optional_produk[]" id="produk-optional-split-${optionalLength}" data-id="${optionalLength}" class="optional-produk-split bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Produk</option>
                    </select>
                </div>
                <div>
                    <label for="sparepart-optional-split-${optionalLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Sparepart :</label>
                    <select name="sparepart_split[]" id="sparepart-optional-split-${optionalLength}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Sparepart</option>
                    </select>
                </div>
                <div>
                    <label for="nominal-optional-split-${optionalLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nominal / Pcs :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="nominal_split[]" id="nominal-optional-split-${optionalLength}" data-id="${optionalLength}" class="format-angka-rupiah nominal-split-optional rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </div>
                <div>
                    <label for="qty-optional-split-${optionalLength}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity : </label>
                    <input type="text" name="qty_split[]" id="qty-optional-split-${optionalLength}" data-id="${optionalLength}" class="number-format qty-optional-split bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                </div>
                <div class="flex justify-center mt-10">
                    <button type="button" class="remove-list-optional-split" data-id="${optionalLength}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `;
        containerOptional.append(formOptional);

        var optionalJenisDrone = $("#produk-optional-split-" + optionalLength);
        fetch(`/gudang/produk/get-list-jenis-drone`)
            .then((response) => response.json())
            .then((data) => {
                optionalJenisDrone.each(function () {
                    const select = $(this);
                    select.empty();

                    const defaultOption = $("<option>")
                        .text("Pilih Produk")
                        .val("")
                        .attr("hidden", true)
                        .addClass("bg-white dark:bg-gray-700");
                    select.append(defaultOption);

                    data.forEach((drone) => {
                        const option = $("<option>")
                            .val(drone.id)
                            .text(drone.jenis_produk);
                        select.append(option);
                    });
                });
            })
            .catch((error) => alert("Error fetching data: " + error));
    });

    $(document).on("click", ".remove-list-split", function () {
        let idForm = $(this).data("id");
        $("#form-list-split-" + idForm).remove();
        number--;
        updateBoxSplit();
    });

    $(document).on("click", ".remove-list-optional-split", function () {
        let idForm = $(this).data("id");
        $("#form-list-optional-split-" + idForm).remove();
        optionalLength--;
        updateBoxSplit();
    });

    $(document).on("change", ".optional-produk-split", function () {
        let idForm = $(this).data("id");
        getSparepartOptional(idForm);
    });

    $(document).on(
        "change",
        ".qty-split, .nominal-split, .qty-optional-split, .nominal-split-optional",
        function () {
            updateBoxSplit();
        }
    );

    function updateBoxSplit() {
        const button = $("#submit-split");
        let nominalAwal = $("#nominal-awal-part-split").val();
        let totalNominal = 0;

        $("#container-split-part .form-list-split").each(function () {
            let qty = parseFloat($(this).find(".qty-split").val()) || 0;
            let nominal =
                parseFloat(
                    $(this).find(".nominal-split").val().replace(/\./g, "")
                ) || 0;
            let hasilNominal = qty * nominal;
            totalNominal += hasilNominal;
        });

        $("#container-optional-split-part .form-list-optional-split").each(
            function () {
                let qtyOptional =
                    parseFloat(
                        $(this)
                            .find(".qty-optional-split")
                            .val()
                            .replace(/\./g, "")
                    ) || 0;
                let nominalOptional =
                    parseFloat(
                        $(this)
                            .find(".nominal-split-optional")
                            .val()
                            .replace(/\./g, "")
                    ) || 0;
                let hasilNominalOptional = qtyOptional * nominalOptional;
                totalNominal += hasilNominalOptional;
            }
        );

        let sisaNominal = nominalAwal - totalNominal;
        $("#sisa-nominal-split").text("Rp. " + formatAngka(sisaNominal));

        if (sisaNominal == 0) {
            button.removeClass("cursor-not-allowed").prop("disabled", false);
        } else {
            button.addClass("cursor-not-allowed").prop("disabled", true);
        }
    }

    function updateSparepart() {
        const produkId = $("#jenis-produk-split").val();
        const selectElements = $(".sparepart-split");

        fetch(`/gudang/purchasing/sparepart-bjenis/${produkId}`)
            .then((response) => response.json())
            .then((data) => {
                selectElements.each(function () {
                    const select = $(this);
                    select.empty();

                    const defaultOption = $("<option>")
                        .text("Pilih Sparepart")
                        .val("")
                        .attr("hidden", true)
                        .addClass("bg-white dark:bg-gray-700");
                    select.append(defaultOption);

                    data.forEach((part) => {
                        const option = $("<option>")
                            .val(part.id)
                            .text(part.nama_internal);
                        select.append(option);
                    });
                });
            })
            .catch((error) => alert("Error fetching data: " + error));
    }

    function getSparepartOptional(idForm) {
        var jenisDroneId = $("#produk-optional-split-" + idForm).val();
        var formSparepart = $("#sparepart-optional-split-" + idForm);

        fetch(`/gudang/purchasing/sparepart-bjenis/${jenisDroneId}`)
            .then((response) => response.json())
            .then((data) => {
                formSparepart.empty();

                const defaultOption = $("<option>")
                    .text("Pilih Sparepart")
                    .val("")
                    .attr("hidden", true)
                    .addClass("bg-white dark:bg-gray-700");
                formSparepart.append(defaultOption);

                data.forEach((part) => {
                    const option = $("<option>")
                        .val(part.id)
                        .text(part.nama_internal);
                    formSparepart.append(option);
                });
            })
            .catch((error) => alert("Error fetching data:", error));
    }

    function formatAngka(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }
});
