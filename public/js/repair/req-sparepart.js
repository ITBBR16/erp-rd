function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

$(document).ready(function () {
    let uniqueCount = 1;

    // Req. Part Estimasi
    $(document).on('click', '.add-req-part-estimasi', function () {
        uniqueCount++;
        let dataId = $(this).data("id");
        var parentReqCsr = $('#parent-req-part-estimasi-' + dataId);
        var formId = `req-jenis-produk-estimasi-${dataId}-${uniqueCount}`;

        let itemFormReq = `
            <div id="container-req-part-estimasi-${dataId}-${uniqueCount}" class="container-req-part-estimasi grid grid-cols-7 mb-4 gap-4" style="grid-template-columns: 5fr 5fr 5fr 5fr 5fr 5fr 1fr">
                <div>
                    <label for="req-jenis-produk-estimasi-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Produk :</label>
                    <select name="jenis_produk[]" id="req-jenis-produk-estimasi-${dataId}-${uniqueCount}" data-id="${dataId}" data-number="${uniqueCount}" class="req-jenis-produk-estimasi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Produk</option>
                    </select>
                </div>
                <div>
                    <label for="req-part-estimasi-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Part :</label>
                    <select name="sku_part[]" id="req-part-estimasi-${dataId}-${uniqueCount}" data-id="${dataId}" data-number="${uniqueCount}" class="req-part-estimasi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Part</option>
                    </select>
                </div>
                <div>
                    <label for="nama-alias-estimasi-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Alias :</label>
                    <input type="text" name="nama_alias[]" id="nama-alias-estimasi-${dataId}-${uniqueCount}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Alias">
                </div>
                <div>
                    <label for="harga-customer-estimasi-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Harga Customer :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="harga_customer[]" id="harga-customer-estimasi-${dataId}-${uniqueCount}" class="format-angka-req-part rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </div>
                <div>s
                    <label for="harga-repair-estimasi-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Harga Repair :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="harga_repair[]" id="harga-repair-estimasi-${dataId}-${uniqueCount}" class="format-angka-req-part rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly required>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="modal_gudang[]" id="modal-gudang-req-part-estimasi-${dataId}-${uniqueCount}">
                    <input type="hidden" name="promo_gudang[]" id="promo-gudang-req-part-estimasi-${dataId}-${uniqueCount}">
                    <label for="harga-gudang-estimasi-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Harga Global :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="harga_gudang[]" id="harga-gudang-estimasi-${dataId}-${uniqueCount}" class="format-angka-req-part rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly required>
                    </div>
                </div>
                <div class="flex justify-center items-center mt-10">
                    <button type="button" data-id="${dataId}" data-number="${uniqueCount}" class="remove-req-estimasi">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `;

        parentReqCsr.append(itemFormReq);
        getJenisDroneReqPart(formId);
        buttonCheckCsr(dataId);
    });

    $(document).on('change', '.req-jenis-produk-estimasi', function () {
        let dataId = $(this).data("id");
        let number = $(this).data("number");
        var jenisDrone = $('#req-jenis-produk-estimasi-' + dataId + '-' + number).val();
        var formId = 'req-part-estimasi-' + dataId + '-' + number;

        getRequestPartGudang(jenisDrone, formId);
    });

    $(document).on('change', '.req-part-estimasi', function () {
        let dataId = $(this).data("id");
        let number = $(this).data("number");
        var id = $(this).val();
        let formId = 'estimasi-' + dataId + '-' + number;

        getDetailPart(formId, id);
    });

    // Req. Part CSR
    $(document).on('click', '.add-req-part-csr', function () {
        uniqueCount++;
        let dataId = $(this).data("id");
        var parentReqCsr = $('#parent-req-part-csr-' + dataId);
        var jenisTransaksi = 'P.Baru';
        var formId = 'req-jenis-produk-' + dataId + '-' + uniqueCount;

        let itemFormReq = `
            <div id="container-req-part-csr-${dataId}-${uniqueCount}" class="container-req-part-csr grid grid-cols-7 mb-4 gap-4" style="grid-template-columns: 5fr 5fr 5fr 5fr 5fr 5fr 1fr">
                <div>
                    <label for="req-jenis-produk-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Produk :</label>
                    <select name="jenis_produk[]" id="req-jenis-produk-${dataId}-${uniqueCount}" data-id="${dataId}" data-number="${uniqueCount}" class="req-jenis-produk-csr bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Produk</option>
                    </select>
                </div>
                <div>
                    <input type="hidden" name="nama_part[]" id="req-nama-part-csr-${dataId}-${uniqueCount}">
                    <label for="req-part-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Part :</label>
                    <select name="sku_part[]" id="req-part-${dataId}-${uniqueCount}" data-id="${dataId}" data-number="${uniqueCount}" class="req-part-csr bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Part</option>
                    </select>
                </div>
                <div>
                    <label for="nama-alias-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Nama Alias :</label>
                    <input type="text" name="nama_alias[]" id="nama-alias-${dataId}-${uniqueCount}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Alias">
                </div>
                <div>
                    <label for="harga-customer-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Harga Customer :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="harga_customer[]" id="harga-customer-${dataId}-${uniqueCount}" class="format-angka-req-part rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </div>
                <div>
                    <label for="harga-repair-csr-estimasi-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Harga Repair :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="harga_repair[]" id="harga-repair-csr-estimasi-${dataId}-${uniqueCount}" class="format-angka-req-part rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly required>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="modal_gudang[]" id="modal-gudang-req-part-estimasi-${dataId}-${uniqueCount}">
                    <input type="hidden" name="promo_gudang[]" id="promo-gudang-req-part-estimasi-${dataId}-${uniqueCount}">
                    <label for="harga-gudang-csr-estimasi-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Harga Global :</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="harga_gudang[]" id="harga-gudang-csr-estimasi-${dataId}-${uniqueCount}" class="format-angka-req-part rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly required>
                    </div>
                </div>
                <div class="flex justify-center items-center mt-10">
                    <button type="button" data-id="${dataId}" data-number="${uniqueCount}" class="remove-req-csr">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `;

        parentReqCsr.append(itemFormReq);
        buttonCheckCsr(dataId);
    });

    $(document).on('change', '.req-jenis-produk-csr', function () {
        let dataId = $(this).data("id");
        let number = $(this).data("number");
        var jenisDrone = $('#req-jenis-produk-' + dataId + '-' + number).val();
        var formId = 'req-part-' + dataId + '-' + number;

        getRequestPartGudang(jenisDrone, formId);
    });

    $(document).on('change', '.req-part-csr', function () {
        let dataId = $(this).data("id");
        let number = $(this).data("number");
        let formId = dataId + '-' + number;

        var jenisTransaksi = 'P.Baru';
        var textPart = $('#req-part-' + formId + ' option:selected').text();
        var sku = $(this).val();
        var namaPart = $('#req-nama-part-csr-' + formId);
        namaPart.val(textPart);

        getDetailPart(jenisTransaksi, formId, sku)
    });

    $(document).on('input', '.format-angka-req-part', function () {
        var inputActive = $(this).val();
        inputActive = inputActive.replace(/[^\d]/g, '');
        var parsedNumber = parseInt(inputActive, 10);
        $(this).val(formatAngka(parsedNumber));
    })

    $(document).on('click', '.remove-req-csr', function () {
        let dataId = $(this).data("id");
        let number = $(this).data("number");
        $('#container-req-part-csr-' + dataId + '-' + number).remove();
        uniqueCount--;
        buttonCheckCsr(dataId);
    });

    // Req Teknisi

    // $(document).on('click', '.add-req-part-teknisi', function () {
    //     uniqueCount++;
    //     let dataId = $(this).data("id");
    //     var parentReqTeknisi = $('#parent-req-part-teknisi-' + dataId);
    //     var jenisTransaksi = 'P.Baru';
    //     var formId = 'req-jenis-produk-' + dataId + '-' + uniqueCount;

    //     let itemFormReq = `
    //         <div id="container-req-part-teknisi-${dataId}-${uniqueCount}" class="container-req-part-teknisi grid grid-cols-4 mb-4 gap-4" style="grid-template-columns: 5fr 5fr 2fr 1fr">
    //             <div>
    //                 <label for="req-jenis-produk-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Produk :</label>
    //                 <select name="jenis_produk[]" id="req-jenis-produk-${dataId}-${uniqueCount}" data-id="${dataId}" data-number="${uniqueCount}" class="req-jenis-produk-teknisi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
    //                     <option value="" hidden>Pilih Jenis Produk</option>
    //                 </select>
    //             </div>
    //             <div>
    //                 <input type="hidden" name="nama_part[]" id="req-nama-part-teknisi-${dataId}-${uniqueCount}">
    //                 <label for="req-part-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Part :</label>
    //                 <select name="sku_part[]" id="req-part-${dataId}-${uniqueCount}" data-id="${dataId}" data-number="${uniqueCount}" class="req-part-teknisi bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
    //                     <option value="" hidden>Pilih Part</option>
    //                 </select>
    //             </div>
    //             <div>
    //                 <label for="req-qty-part-${dataId}-${uniqueCount}" class="block py-2 text-sm font-medium text-gray-900 dark:text-white">Quantity :</label>
    //                 <input name="qty_req[]" type="text" id="req-qty-part-${dataId}-${uniqueCount}" class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
    //             </div>
    //             <div class="flex justify-center items-center mt-10">
    //                 <button type="button" data-id="${dataId}" data-number="${uniqueCount}" class="remove-req-teknisi">
    //                     <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
    //                 </button>
    //             </div>
    //         </div>
    //     `;

    //     parentReqTeknisi.append(itemFormReq);
    //     buttonCheckTeknisi(dataId);

    //     // if (cacheJDG[jenisTransaksi]) {
    //     //     getCacheJDG(cacheJDG[jenisTransaksi], formId);
    //     // } else {
    //     // }
    //     // getJenisDroneGudang(formId);
    // });

    // $(document).on('change', '.req-jenis-produk-teknisi', function () {
    //     let dataId = $(this).data("id");
    //     let number = $(this).data("number");
    //     var jenisTransaksi = 'P.Baru';
    //     var jenisDrone = $('#req-jenis-produk-' + dataId + '-' + number).val();
    //     var formId = 'req-part-' + dataId + '-' + number;

    //     if (cachePart[jenisTransaksi] && cachePart[jenisTransaksi][jenisDrone]) {
    //         getCachePart(cachePart[jenisTransaksi][jenisDrone], formId);
    //     } else {
    //         getRequestPartGudang(jenisTransaksi, formId);
    //     }
    // });

    // $(document).on('change', '.req-part-teknisi', function () {
    //     let dataId = $(this).data("id");
    //     let number = $(this).data("number");
    //     var textPart = $('#req-part-' + dataId + '-' + number + ' option:selected').text();
    //     var namaPart = $('#req-nama-part-teknisi-' + dataId + '-' + number);
    //     namaPart.val(textPart);
    // });

    // $(document).on('click', '.remove-req-teknisi', function () {
    //     let dataId = $(this).data("id");
    //     let number = $(this).data("number");
    //     $('#container-req-part-teknisi-' + dataId + '-' + number).remove();
    //     uniqueCount--;
    //     buttonCheckTeknisi(dataId);
    // });

    // All function combine req sparepart
    function getJenisDroneReqPart(formId) {
        var inputJP = $('#' + formId);
        fetch(`/repair/estimasi/jenisDrone`)
        .then(response => response.json())
        .then(data => {
            inputJP.empty();

            const defaultOption = $('<option>', {
                text: 'Pilih Jenis Produk',
                value: '',
                hidden: true
            });
            inputJP.append(defaultOption);

            data.forEach(produk => {
                const option = $('<option>', {
                    value: produk.id,
                    text: produk.jenis_produk
                })
                .addClass('dark:bg-gray-700')
                inputJP.append(option)
            });

        });
    }

    function getRequestPartGudang(jenisTransaksi, formId) {
        var partFormSelect = $('#' + formId);
        fetch(`/repair/estimasi/getPartGudang/${jenisTransaksi}`)
        .then(response => response.json())
        .then(data => {
            partFormSelect.empty();

            const defaultOption = $('<option>', {
                text: 'Pilih Part',
                value: '',
                hidden: true
            });
            partFormSelect.append(defaultOption);

            data.forEach(part => {
                const option = $('<option>', {
                    value: part.id,
                    text: part.nama_internal
                })
                .addClass('dark:bg-gray-700');
                partFormSelect.append(option)
            });
        });
    }

    function getDetailPart(formId, sku) {
        var hargaRepair = $('#harga-repair-' + formId);
        var hargaGlobal = $('#harga-gudang-' + formId);
        var modalGudang = $('#modal-gudang-req-part-' + formId);
        var promoGudang = $('#promo-gudang-req-part-' + formId);
        
        fetch(`/repair/estimasi/getDetailGudang/${sku}`)
        .then(response => response.json())
        .then(data => {

            hargaRepair.val(formatAngka(data.srpRepair));
            hargaGlobal.val(formatAngka(data.srpGudang));
            modalGudang.val(data.modal);
            promoGudang.val(0);

        });
    }

    function buttonCheckCsr(dataId) {
        let containerExists = $(`#parent-req-part-csr-${dataId} .container-req-part-csr`).length > 0;
        let button = $('.button-req-part-csr');
    
        if (!containerExists) {
            button.addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            button.removeClass('cursor-not-allowed').prop('disabled', false);
        }
    }

    function buttonCheckTeknisi(dataId) {
        let containerExists = $(`#parent-req-part-teknisi-${dataId} .container-req-part-teknisi`).length > 0;
        let button = $('.button-req-part-teknisi');
    
        if (!containerExists) {
            button.addClass('cursor-not-allowed').prop('disabled', true);
        } else {
            button.removeClass('cursor-not-allowed').prop('disabled', false);
        }
    }
});
