$(document).ready(function () {
    const containerAddRecap = $("#container-input-dr");

    $(document).on('change', '#keperluan_recap', function () {
        var keperluanRecap = $(this).find("option:selected").text();

        $("#input-ts, #input-wtb, #input-wts").remove();
        $("#button-new-dr").addClass('cursor-not-allowed').prop('disabled', true);

        switch (keperluanRecap) {
            case 'Technical Support':
                inputTs(containerAddRecap, jenisProduk, jenisPermasalahan);
                break;
            case 'Want to Buy':
                inputWtb(containerAddRecap);
                break;
            case 'Want to Sell':
                inputWts(containerAddRecap, jenisProduk);
                break;
            default:
                alert('Fitur Tidak Tersedia.');
                break;
        }
    });
    // Keperluan WTB
    $(document).on('change', '#kondisi_produk', function () {
        var kondisiProduk = $("#kondisi_produk").val();
        var jenisProduk = $("#jenis_produk");

        if(kondisiProduk == 'Part Baru' || kondisiProduk == 'Part Bekas') {
            alert('Fitur belum tersedia.');
            jenisProduk.empty();
            $("#kondisi_produk").val("");
        } else {
            fetch(`/kios/customer/getJenisProduk/${kondisiProduk}`)
            .then(response => response.json())
            .then(data => {
                jenisProduk.empty();
                const addedProductIds = new Set(); // Menyimpan id produk yang sudah di tambahkan
                const fragment = $(document.createDocumentFragment()); // Menampung semua elemen option yang di tambahkan

                const defaultOption = $('<option>', {
                    text: 'Hayooo',
                    hidden: true
                });
                jenisProduk.append(defaultOption);

                data.forEach(jenis => {
                    jenis.subjenis.produkjenis.forEach(produk => {
                        if (!addedProductIds.has(produk.id)) {
                            addedProductIds.add(produk.id);
                
                            const option = $('<option>', {
                                value: produk.id,
                                text: produk.jenis_produk
                            }).addClass('dark:bg-gray-700');
                            
                            fragment.append(option);
                        }
                    });
                });
                jenisProduk.append(fragment);
            })
            .catch(error => {
                alert('Error Fetching Data : ', error);
            });
        }
    });

    $(document).on('change', '#jenis_produk', function () {
        var jenisProdukId = $(this).val();
        var kondisiProduk = $("#kondisi_produk").val();
        var paketPenjualan = $("#paket_penjualan");
        var listProdukTersedia = $('#list-produk-tersedia');
        var statusPaketPenjualan = $('#status-paket-penjualan');

        if(kondisiProduk == 'Part Baru' || kondisiProduk == 'Part Bekas') {
            alert('Fitur belum tersedia.');
        } else {
            fetch(`/kios/customer/getSubJenisProduk/${kondisiProduk}/${jenisProdukId}`)
            .then(response => response.json())
            .then(data => {
                paketPenjualan.empty();
                (listProdukTersedia) ? listProdukTersedia.remove() : '';
                (statusPaketPenjualan) ? statusPaketPenjualan.remove() : '';
                const addedProductIds = new Set(); // Menyimpan id produk yang sudah di tambahkan
                const fragment = $(document.createDocumentFragment()); // Menampung semua elemen option yang di tambahkan

                const defaultOption = $('<option>', {
                    text: 'Hayooo',
                    hidden: true
                });
                paketPenjualan.append(defaultOption);

                data.forEach(jenis => {
                    jenis
                    const option = $('<option>', {
                        value: jenis.id,
                        text: jenis.paket_penjualan
                    })
                    .addClass('dark:bg-gray-700');
                    paketPenjualan.append(option);
                });
            })
            .catch(error => {
                alert('Error Fetching Data : ' + error);
            });
        }
    });

    $(document).on('change', '#paket_penjualan', function () {
        var containerStatusId = $('#container-produk-status');
        var statusProduk = $('#status-produk');
        var listProduk = $('#list-produk-dr');
        var listProdukTersedia = $('#list-produk-tersedia');
        var statusPaketPenjualan = $('#status-paket-penjualan');
        var jenisProdukId = $("#jenis_produk").val();
        var kondisiProduk = $("#kondisi_produk").val();
        var paketPenjualan = $("#paket_penjualan").val();

        fetch(`/kios/customer/getSubJenisProduk/${kondisiProduk}/${jenisProdukId}`)
            .then(response => response.json())
            .then(data => {
                listProdukTersedia.remove();
                statusPaketPenjualan.remove();
                data.forEach(jenis => {
                    jenis.kiosproduk.forEach(item => {
                        let dataStatus = ``;
                        let namaStatus = ``;
                        if (paketPenjualan == jenis.id) {
                            if (item.status == 'Ready' || item.status == 'Promo') {
                                dataStatus += `
                                    <span id="status-paket-penjualan" class="my-2 bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Ready</span>
                                `
                                namaStatus += item.status
                            } else {
                                dataStatus += `
                                    <span id="status-paket-penjualan" class="my-2 bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Sold</span>
                                `
                                namaStatus += item.status
                            }
                            containerStatusId.append(dataStatus);
                            statusProduk.val(namaStatus);
                        }
                    })
                    const dataList = `
                    <li id="list-produk-tersedia" class="flex items-center">
                        <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        ${jenis.paket_penjualan}
                    </li>
                    `;
                    listProduk.append(dataList);
                });
            })
            .catch(error => {
                alert('Error Fetching Data : ', error);
            });
    });

    // Keperluan WTS
    $(document).on('change', '#jenis-produk-sell', function () {
        var jenisId = $(this).val();
        var paketPenjualan = $('#paket-penjualan-sell');
        var statusSell = $('#status-sell');

        fetch(`/kios/customer/getPaketPenjualan/${jenisId}`)
            .then(response => response.json())
            .then(data => {
                paketPenjualan.empty();
                statusSell.remove();

                const defaultOption = $('<option>', {
                    text: 'Hayooo',
                    hidden: true
                });
                paketPenjualan.append(defaultOption);

                data.forEach(jenis => {
                    const option = $('<option>', {
                        value: jenis.id,
                        text: jenis.paket_penjualan
                    })
                    .addClass('dark:bg-gray-700');
                    paketPenjualan.append(option);
                });
            })
            .catch(error => {
                alert('Error Fetching Data : ', error);
            });
    })

    $(document).on('change', '#paket-penjualan-sell', function () {
        var paketPenjualanSell = $(this).val()
        var containerStatusSell = $('#container-status-wts');
        var statusSell = $('#status-sell');
        statusSell.remove();

        const statusItem = `
            <span id="status-sell" class="my-2 bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Need</span>
        `
        containerStatusSell.append(statusItem);

    });

    // Keperluan TS
    $(document).on('change', '#permasalahan', function () {
        var idPermasalahan = $(this).val();
        var permasalahan = $(this).find("option:selected").text();
        var keterangan = $('#keterangan');
        var deskripsiTs = $('#deskripsi-ts');

        if(permasalahan == 'Belum Terdata') {
            keterangan.removeAttr('readonly', true);
        } else {
            keterangan.attr("readonly", "readonly");
        }

        fetch(`/kios/customer/getDeskripsiPermasalahan/${idPermasalahan}`)
        .then(response => response.json())
        .then(data => {
            deskripsiTs.empty();
            deskripsiTs.append(data.deskripsi)
        })
        .catch(error => {
            alert('Error Fetching Data : ', error);
        });

    })

    $(document).on('change', '#kategori_permasalahan', function () {
        var kategoriPermasalahanId = $(this).val();
        var jenisId = $('#jenis-produk-ts').val();
        var permasalahan = $('#permasalahan');
        var deskripsiTs = $('#deskripsi-ts');

        fetch(`/kios/customer/getPermasalahan/${jenisId}/${kategoriPermasalahanId}`)
        .then(response => response.json())
        .then(data => {
            permasalahan.empty();
            deskripsiTs.empty();

            const defaultOption = [
                {value: '', text: 'Permasalahan', hidden: true},
                {value: 1, text: 'Belum Terdata'},
            ];

            defaultOption.forEach(option => {
                const newDefaultOption = $('<option>', {
                    value: option.value,
                    text: option.text,
                    hidden : option.hidden
                });
                permasalahan.append(newDefaultOption);
            })

            data.forEach(pml => {
                const option = $('<option>', {
                    value: pml.id,
                    text: pml.nama
                });
                permasalahan.append(option);
            });

        })
        .catch(error => {
            alert('Error Fetching Data : ', error);
        });

    });

    function inputTs(container, jenisProduk, jenisPermasalahan) {
        let itemForm = `
            <div id="input-ts">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="jenis_produk"></label>
                        <select name="jenis_produk" id="jenis-produk-ts" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Jenis Produk</option>`;
                            jenisProduk.forEach(function (item) {
                                itemForm += `<option value="${item.id}">${item.jenis_produk}</option>`
                            });
                            itemForm += `
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="kategori_permasalahan"></label>
                        <select name="kategori_permasalahan" id="kategori_permasalahan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Jenis Permasalahan</option>`;
                            jenisPermasalahan.forEach(function (jp) {
                                itemForm += `<option value="${jp.id}">${jp.nama}</option>`
                            });
                            itemForm += `
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="permasalahan"></label>
                        <select name="permasalahan" id="permasalahan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Permasalahan</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="keterangan" id="keterangan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly required>
                        <label for="keterangan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
                    </div>
                </div>
                <label for="deskripsi-ts" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your message</label>
                <textarea id="deskripsi-ts" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Deskripsi Permasalahan . . ." readonly></textarea>
            </div>`

        $("#button-new-dr").removeClass('cursor-not-allowed').removeAttr('disabled', true);
        container.append(itemForm)

    }

    function inputWtb(contaienr) {
        var itemWtb = `
            <div id="input-wtb">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="kondisi_produk"></label>
                        <select name="kondisi_produk" id="kondisi_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Kondisi Produk</option>
                            <option value="Drone Baru">Drone Baru</option>
                            <option value="Drone Bekas">Drone Bekas</option>
                            <option value="Part Baru">Part Baru</option>
                            <option value="Part Bekas">Part Bekas</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="jenis_produk"></label>
                        <select name="jenis_produk" id="jenis_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Jenis Produk</option>
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="paket_penjualan"></label>
                        <select name="paket_penjualan" id="paket_penjualan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Paket Penjualan</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="hidden" name="status_produk" id="status-produk" value="">
                        <input type="text" name="keterangan" id="keterangan-wtb" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                        <label for="keterangan-wtb" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
                    </div>
                </div>
                <div id="container-produk-status" class="gap-4 flex items-center">
                    <h2 class="my-2 text-lg font-semibold text-gray-900 dark:text-white">List Produk Tersedia :</h2>
                </div>
                <ul id="list-produk-dr" class="max-w-full space-y-1 text-gray-500 list-inside dark:text-gray-400">
                    
                </ul>
            </div>
        `

        $("#button-new-dr").removeClass('cursor-not-allowed').removeAttr('disabled', true);
        contaienr.append(itemWtb)
    }

    function inputWts(container, jenisProduk) {
        var itemWts = `
            <div id="input-wts">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="jenis-produk-sell"></label>
                        <select name="jenis_produk" id="jenis-produk-sell" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Jenis Produk</option>`;
                            jenisProduk.forEach(function (item) {
                                itemWts += `<option value="${item.id}">${item.jenis_produk}</option>`
                            });
                            itemWts += `
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="paket-penjualan-sell"></label>
                        <select name="paket_penjualan" id="paket-penjualan-sell" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Paket Penjualan</option>
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="produk_worth"></label>
                        <select name="produk_worth" id="produk_worth" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                            <option value="" hidden>Worth Produk</option>
                            <option value="Ya">Ya</option>
                            <option value="Mungkin">Mungkin</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="hidden" name="status_produk" id="status-produk-wts" value="">
                        <input type="text" name="keterangan" id="keterangan-wtb" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                        <label for="keterangan-wtb" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
                    </div>
                </div>
                <div id="container-status-wts" class="gap-4 flex items-center">
                    <h2 class="my-2 text-lg font-semibold text-gray-900 dark:text-white">Status Produk Dibutuhkan :</h2>
                </div>
                <div id="container-status-sell" class="flex items-center mb-6">
                    <input type="hidden" name="status_produk" id="status-produk-sell" value="">
                </div>
            </div>
        `

        $("#button-new-dr").removeClass('cursor-not-allowed').removeAttr('disabled', true);
        container.append(itemWts)
    }

});