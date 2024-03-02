$(document).ready(function(){
    const contaienrQcSecond = $('#additional-kelengkapan-qc-second');
    const ContaienrExcludeBarangQcSecomd = $('#barang-exclude-qc-second');
    const tambahAdditionalQc = $('#add-second-additional-qc');
    const tambahExcludeBarangQcSecond = $('#add-second-exclude-kelengkapan-qc')
    const jenisProdukQcSecond = $('#jenis-qc-id');
    let uniqueCount = 20;

    tambahAdditionalQc.on('click', function () {
        uniqueCount++
        const jenisId = jenisProdukQcSecond.val();

        let addAdditonalForm = `
            <tr id="additionalKelengkapanQC-${uniqueCount}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <label for="kelengkapan_qc_additional${uniqueCount}" class="sr-only">Jenis Paket Produk</label>
                    <select name="kelengkapan_qc_additional[]" id="kelengkapan_qc_additional${uniqueCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                        <option value="" hidden>-- Kelengkapan --</option>
                    </select>
                </th>
                <td class="px-6 py-4">
                    <input type="text" name="kondisi[]" id="kondisi-${uniqueCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" required>
                </td>
                <td class="px-6 py-4">
                    <input type="text" name="serial_number[]" id="serial_number-${uniqueCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600">
                </td>
                <td class="px-6 py-4 text-right">
                    <input type="text" name="keterangan[]" id="keterangan-${uniqueCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600">
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-center items-center col-span-1">
                        <button type="button" class="remove-second-qc" data-id="${uniqueCount}">
                            <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                        </button>
                    </div>
                </td>
            </tr>
        `;

        contaienrQcSecond.append(addAdditonalForm);

        if(jenisId){
            const ddQcKelengkapan = $('#kelengkapan_qc_additional' + uniqueCount);
            fetch(`/kios/product/getAdditionalKelengkapan/${jenisId}`)
            .then(response => response.json())
            .then(data => {
                ddQcKelengkapan.empty();

                const defaultOption = $('<option>', {
                    text: '-- Tambahan Kelengkapan --',
                    value: '',
                    hidden: true
                });
                ddQcKelengkapan.append(defaultOption);

                data.forEach(kelengkapan => {
                    const option = $('<option>', {
                        value: kelengkapan.id,
                        text: kelengkapan.kelengkapan
                    })
                    .addClass('dark:bg-gray-700');
                    ddQcKelengkapan.append(option);
                });
            })
            .catch(error => console.error('Error:', error));
        } else {
            ddQcKelengkapan.html('');
        }
    });

    tambahExcludeBarangQcSecond.on('click', function () {
        uniqueCount++
        const jenisId = jenisProdukQcSecond.val();

        let addAdditonalForm = `
        <div id="exclude-barang-qc-${uniqueCount}" class="mt-4 grid md:grid-cols-5 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="kelengkapan_qc_additional[]" id="exclude_kelengkapan_qc_additional${uniqueCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                <label for="exclude_kelengkapan_qc_additional${uniqueCount}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kelengkapan</label>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="kondisi[]" id="exclude-kondisi${uniqueCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                <label for="exclude-kondisi${uniqueCount}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kondisi</label>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="serial_number[]" id="exclude-serial_number${uniqueCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                <label for="exclude-serial_number${uniqueCount}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Serial Number</label>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="keterangan[]" id="exclude-keterangan${uniqueCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                <label for="exclude-keterangan${uniqueCount}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan</label>
            </div>
            <div class="flex justify-center items-center col-span-1">
                <button type="button" class="remove-exclude-kelengkapan-qc" data-id="${uniqueCount}">
                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                </button>
            </div>
        </div>
        `;

        ContaienrExcludeBarangQcSecomd.append(addAdditonalForm);
    });

    $(document).on("click", ".remove-exclude-kelengkapan-qc", function() {
        let itemNameId = $(this).data("id");
        $("#exclude-barang-qc-"+itemNameId).remove();
        uniqueCount--;
    });

    $(document).on("click", ".remove-second-qc", function() {
        let itemNameId = $(this).data("id");
        $("#additionalKelengkapanQC-"+itemNameId).remove();
        uniqueCount--;
    });

});
