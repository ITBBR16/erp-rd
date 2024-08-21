function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

$(document).ready(function () {
    let countForm = 1;

    $('#add-item-estimasi').on('click', function () {
        countForm++;
        const containerEstimasi = $('#container-input-estimasi');
        const containerGudang = $('#container-data-gudang');
        let itemForm = `
            <tr id="input-estimasi-${countForm}" class="bg-white dark:bg-gray-800">
                <td class="px-2 py-4">
                    <select name="jenis_transaksi[]" id="estimasi-jt-${countForm}" data-id="${countForm}" class="estimasi-jt bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Transaksi</option>
                    </select>
                </td>
                <td class="px-2 py-4">
                    <select name="jenis_part[]" id="estimasi-jp-${countForm}" data-id="${countForm}" class="estimasi-jp bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Jenis Produk</option>
                    </select>
                </td>
                <td class="px-2 py-4">
                    <select name="nama_part[]" id="estimasi-part-${countForm}" data-id="${countForm}" class="estimasi-part bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" hidden>Pilih Part</option>
                    </select>
                </td>
                <td class="px-2 py-4">
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-base font-semibold text-gray-900 bg-gray-200 border rounded-r border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">Rp</span>
                        <input type="text" name="harga_customer[]" id="harga-customer-${countForm}" class="format-angka-estimasi rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0">
                    </div>
                </td>
                <td class="px-2 py-4 text-center">
                    <button type="button" data-id="${countForm}" class="remove-form-estimasi">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                    </button>
                </td>
            </tr>
        `

        let itemFG = `
            <tr id="data-gudang-${countForm}" class="bg-white dark:bg-gray-800">
                <td class="px-2 py-4">
                    <div class="relative z-0 w-full">
                        <input name="stok_part[]" id="stok-part-${countForm}" type="text" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly>
                    </div>
                </td>
                <td class="px-2 py-4">
                    <div class="relative z-0 w-full group flex items-center">
                        <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                        <input name="harga_promo_part[]" id="harga-promo-part-${countForm}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                    </div>
                </td>
                <td class="px-2 py-4">
                    <div class="relative z-0 w-full group flex items-center">
                        <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                        <input name="harga_repair[]" id="harga-repair-${countForm}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">
                    </div>
                </td>
                <td class="px-2 py-4">
                    <div class="relative z-0 w-full group flex items-center">
                        <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                        <input name="harga_gudang[]" id="harga-gudang-${countForm}" type="text" class="format-angka-estimasi block py-2.5 ps-6 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " readonly>
                    </div>
                </td>
            </tr>
        `

        containerEstimasi.append(itemForm);
        containerGudang.append(itemFG);
    });

    $(document).on('click', '.remove-form-estimasi', function () {
        let idForm = $(this).data("id");
        $('#input-estimasi-' + idForm).remove();
        $('#data-gudang-' + idForm).remove();
        countForm--;
    });

    $(document).on('input', '.format-angka-estimasi', function () {
        var inputActive = $(this).val();
        inputActive = inputActive.replace(/[^\d]/g, '');
        var parsedNumber = parseInt(inputActive, 10);
        $(this).val(formatAngka(parsedNumber));
    });

    $('.estimasi-jt').on('change', function () {
        let formId = $(this).data("id");
        
    });

});