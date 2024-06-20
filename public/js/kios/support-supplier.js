$(document).ready(function () {
    let itemTrCount = $('#ss-container tr').length;

    $("#add-ss-form").on("click", function () {
        itemTrCount++
        let addSSForm = `
            <tr id="form-ss-${itemTrCount}" class="bg-white dark:bg-gray-800">
                <td class="px-4 py-4">
                    <select name="nama_produk[]" id="nama-produk-${itemTrCount}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Select Produk</option>`;
                        products.forEach(function(item) {
                            addSSForm += `<option value="${item.id}">${item.subjenis.produkjenis.jenis_produk} ${item.subjenis.paket_penjualan}</option>`
                        });
                        addSSForm += `
                    </select>
                </td>
                <td class="px-4 py-4">
                    <div date-rangepicker class="flex items-center">
                        <div class="relative">
                            <input name="start_promo[]" id="start-promo-${itemTrCount}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Start Date" required>
                        </div>
                        <span class="mx-4 text-gray-500">to</span>
                        <div class="relative">
                            <input name="end_promo[]" id="end-promo-${itemTrCount}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="End Date" required>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="nominal_promo[]" id="nominal-promo-${itemTrCount}" class="nominal_ss rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="nominal_support[]" id="nominal-support-${itemTrCount}" class="nominal_ss rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                    </div>
                </td>
                <td class="px-4 py-4">
                    <button type="button" class="remove-form-ss" data-id="${itemTrCount}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </td>
            </tr>
        `

        $('#ss-container').append(addSSForm);
    });

    $(document).on("click", ".remove-form-ss", function () {
        let formId = $(this).data("id");
        $("#form-ss-"+formId).remove();
        itemTrCount--;
    });

    $(document).on('input', '.nominal_ss', function () {
        var value = $(this).val();
        value = value.replace(/[^\d]/g, '');
        var parsedValue = parseInt(value, 10);
        $(this).val(formatAngka(parsedValue));
    });

});