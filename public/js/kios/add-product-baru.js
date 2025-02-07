$(document).ready(function(){
    let countJenisProduk = 1;
    let kelengkapanCount = 1;
    const jenisSelect = $('#jenis_id');
    const kelengkapanSelect = $('#kelengkapan');
    const tambahForm = $('#add-kelengkapan');
    const formKelengkapan = $('#form-kelengkapan');

    // Create Paket Penjualan
    jenisSelect.on('change', function () {
        const jenisValue = jenisSelect.val();

        if (jenisValue) {
            fetch(`/kios/product/getKelengkapan/${jenisValue}`)
                .then(response => response.json())
                .then(data => {
                    kelengkapanSelect.html('');

                    const defaultOption = $('<option>', {
                        text: '-- Kelengkapan Produk --',
                        hidden: true
                    });
                    kelengkapanSelect.append(defaultOption);

                    data.forEach(produk_kelengkapan => {
                        const option = $('<option>', {
                            value: produk_kelengkapan.id,
                            text: produk_kelengkapan.kelengkapan
                        }).addClass('bg-white dark:bg-gray-700');
                        kelengkapanSelect.append(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        } else {
            kelengkapanSelect.html('');
        }
    });

    let nomorKelengkapan = 1;
    tambahForm.on('click', function () {
        nomorKelengkapan++
        let tambahFormKelengkapan = `
            <div id="form-kelengkapan-dd-${nomorKelengkapan}" class="grid grid-cols-3 gap-4 md:gap-6 mt-5">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="kelengkapan"></label>
                    <select name="kelengkapan[]" id="kelengkapan-${nomorKelengkapan}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <option value="" hidden>-- Kelengkapan Produk --</option>
                    </select>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="quantity[]" id="quantity-${nomorKelengkapan}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                    <label for="quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Barang</label>
                </div>
                <div class="flex justify-center items-center">
                    <button type="button" class="remove-kelengkapan" data-id="${nomorKelengkapan}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </div>
            </div>
        `
        formKelengkapan.append(tambahFormKelengkapan);

        const jenisValue = jenisSelect.val();

        if (jenisValue) {
            fetch(`/kios/product/getKelengkapan/${jenisValue}`)
                .then(response => response.json())
                .then(data => {
                    $('#kelengkapan-' + nomorKelengkapan).html('');

                    const defaultOption = $('<option>', {
                        text: '-- Kelengkapan Produk --',
                        hidden: true
                    });
                    $('#kelengkapan-' + nomorKelengkapan).append(defaultOption);

                    data.forEach(produk_kelengkapan => {
                        const option = $('<option>', {
                            value: produk_kelengkapan.id,
                            text: produk_kelengkapan.kelengkapan
                        }).addClass('bg-white dark:bg-gray-700');
                        $('#kelengkapan-' + nomorKelengkapan).append(option);
                    });
                })
                .catch(error => {
                    alert('Error fetching data:' + error);
                });
        } else {
            $('#kelengkapan-' + nomorKelengkapan).html('');
        }
    });

    $(document).on("click", ".remove-kelengkapan", function() {
        let formId = $(this).data("id");
        $("#form-kelengkapan-dd-"+formId).remove();
        kelengkapanCount--;
    });

    // add & edit kelengkapan
    $("#add-jenis-kelengkapan").on("click", function () {
        kelengkapanCount++
        let addKelengkapanForm = `
            <div id="jenis-kelengkapan-${kelengkapanCount}" class="grid grid-cols-4 gap-4 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="jenis_kelengkapan[]" id="jenis_kelengkapan${kelengkapanCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                    <label for="jenis_kelengkapan${kelengkapanCount}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Kelengkapan</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="produk_jenis${kelengkapanCount}"></label>
                    <select name="produk_jenis[]" id="produk_jenis${kelengkapanCount}" data-id="${kelengkapanCount}" class="produk_jenis block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <option value="" hidden>-- Jenis Produk --</option>`;
                        jenisProduk.forEach(function(item) {
                            addKelengkapanForm += `<option value="${item.id}" class="dark:bg-gray-700">${item.jenis_produk}</option>`;
                        });
                        addKelengkapanForm += `
                    </select>
                </div>
                <div class="col-span-2 grid grid-cols-5" style="grid-template-columns: 5fr 5fr 5fr 5fr 1fr">
                    <div id="box-add-kelengkapan-${kelengkapanCount}" class="col-span-4 flex flex-wrap border rounded-lg items-start w-full h-10 border-gray-300 mb-6 gap-3 p-2 text-sm overflow-y-auto">
                        
                    </div>
                    <div class="flex mb-6 justify-center items-center">
                        <button type="button" class="remove-jenis-kelengkapan" data-id="${kelengkapanCount}">
                            <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

        $("#jenis-kelengkapan").append(addKelengkapanForm);

    });

    $("#add-edit-kelengkapan").on("click", function () {
        kelengkapanCount++
        let editKelengkapanForm = `
            <div id="edit-kelengkapan-form-${kelengkapanCount}" class="grid grid-cols-4 gap-4 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="edit_kelengkapan_produk${kelengkapanCount}"></label>
                    <select name="edit_kelengkapan_produk[]" id="edit_kelengkapan_produk${kelengkapanCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <option value="" hidden>-- Kelengkapan Produk --</option>`;
                        kelengkapanProduk.forEach(function(item) {
                            editKelengkapanForm += `<option value="${item.id}" class="dark:bg-gray-700">${item.kelengkapan}</option>`;
                        });
                        editKelengkapanForm += `
                    </select>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="edit_produk_jenis${kelengkapanCount}"></label>
                    <select name="edit_produk_jenis[]" id="edit_produk_jenis${kelengkapanCount}" data-id="${kelengkapanCount}" class="edit_produk_jenis block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <option value="" hidden>-- Jenis Produk --</option>`;
                        jenisProduk.forEach(function(item) {
                            editKelengkapanForm += `<option value="${item.id}" class="dark:bg-gray-700">${item.jenis_produk}</option>`;
                        });
                        editKelengkapanForm += `
                    </select>
                </div>
                <div class="col-span-2 grid grid-cols-5" style="grid-template-columns: 5fr 5fr 5fr 5fr 1fr">
                    <div id="box-edit-kelengkapan-${kelengkapanCount}" class="col-span-4 flex flex-wrap border rounded-lg items-start w-full h-10 border-gray-300 mb-6 gap-3 p-2 text-sm overflow-y-auto">
                        
                    </div>
                    <div class="flex mb-6 justify-center items-center">
                        <button type="button" class="remove-edit-kelengkapan" data-id="${kelengkapanCount}">
                            <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

        $("#form-edit-kelengkapan").append(editKelengkapanForm);

    });

    $(document).on("click", ".remove-jenis-kelengkapan", function() {
        let formId = $(this).data("id");
        $("#jenis-kelengkapan-"+formId).remove();
        kelengkapanCount--;
    });

    $(document).on("click", ".remove-edit-kelengkapan", function() {
        let dataId = $(this).data("id");
        $("#edit-kelengkapan-form-"+dataId).remove();
        kelengkapanCount--;
    });

    function editJenisProduk(id) {
        countJenisProduk++
        var boxJenisProduk = $('#box-edit-kelengkapan-' + id);
        var valueSelected = $('#edit_produk_jenis' + id + ' option:selected').val();
        var selectedText = $('#edit_produk_jenis' + id + ' option:selected').text();

        let formJenisProduk = `
            <div id="ek-${countJenisProduk}" class="flex items-center text-gray-800 border-gray-300 bg-transparent dark:text-white dark:border-gray-800">
                <div class="text-sm">
                    <input type="hidden" name="ek_jenis_id[]" id="ek-value-${countJenisProduk}" value="${valueSelected}">
                    <input type="hidden" name="ek_text" id="ek-text-${countJenisProduk}" value="${selectedText}">
                    <input type="hidden" id="ek-return-${countJenisProduk}" value="${id}">
                    ${selectedText}
                </div>
                <button type="button" data-id="${countJenisProduk}" class="button-delete-ek ml-auto -mx-1.5 -my-1.5 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-7 w-7 bg-transparent dark:text-gray-400 dark:hover:bg-gray-700" data-dismiss-target="#jp-1" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </button>
            </div>
        `

        boxJenisProduk.append(formJenisProduk);
    }

    function addJenisProduk(id) {
        countJenisProduk++
        var boxAddJenisProduk = $('#box-add-kelengkapan-' + id);
        var valueSelected = $('#produk_jenis' + id + ' option:selected').val();
        var selectedText = $('#produk_jenis' + id + ' option:selected').text();

        let addFormJenisProduk = `
            <div id="aj-${countJenisProduk}" class="flex items-center text-gray-800 border-gray-300 bg-transparent dark:text-white dark:border-gray-800">
                <div class="text-sm">
                    <input type="hidden" name="add_jenis_id[]" id="aj-value-${countJenisProduk}" value="${valueSelected}">
                    <input type="hidden" name="aj_text" id="aj-text-${countJenisProduk}" value="${selectedText}">
                    <input type="hidden" id="aj-return-${countJenisProduk}" value="${id}">
                    ${selectedText}
                </div>
                <button type="button" data-id="${countJenisProduk}" class="button-delete-aj ml-auto -mx-1.5 -my-1.5 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 inline-flex items-center justify-center h-7 w-7 bg-transparent dark:text-gray-400 dark:hover:bg-gray-700" data-dismiss-target="#jp-1" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </button>
            </div>
        `

        boxAddJenisProduk.append(addFormJenisProduk);
    }

    $(document).on("change", ".edit_produk_jenis", function() {
        let editPJId = $(this).data("id");
        editJenisProduk(editPJId);

        $(this).find('option:selected').remove();
    });

    $(document).on("change", ".produk_jenis", function() {
        let addKP = $(this).data("id");
        addJenisProduk(addKP);

        $(this).find('option:selected').remove();
    });

    $(document).on("click", ".button-delete-ek", function() {
        let formId = $(this).data("id");
        let id = $('#ek-return-' + formId).val();
        let selectedValue = $('#ek-value-' + formId).val();
        let selectedText = $('#ek-text-' + formId).val();

        $('#edit_produk_jenis' + id).append($('<option>', {
            value: selectedValue,
            text: selectedText
        }));

        $("#ek-"+formId).remove();
        countJenisProduk--;
    });

    $(document).on("click", ".button-delete-aj", function() {
        let formId = $(this).data("id");
        let id = $('#aj-return-' + formId).val();
        let selectedValue = $('#aj-value-' + formId).val();
        let selectedText = $('#aj-text-' + formId).val();

        $('#produk_jenis' + id).append($('<option>', {
            value: selectedValue,
            text: selectedText
        }));

        $("#aj-"+formId).remove();
        countJenisProduk--;
    });

 });