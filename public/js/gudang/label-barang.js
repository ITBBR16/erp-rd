$(document).ready(function () {
    $(document).on('nama-sparepart-label', (e) => {
        const sparepart = e.originalEvent.detail.id;
        const selectIdPembelanjaan = $('#label-id-belanja');

        fetch(`/gudang/receive/get-id-pembelanjaan/${sparepart}`)
        .then(response => response.json())
        .then(data => {
            selectIdPembelanjaan.empty();

            const defaultOption = $('<option>')
                            .text('Pilih ID Pembelanjaan')
                            .val('')
                            .attr('hidden', true)
                            .addClass('bg-white dark:bg-gray-700');
            selectIdPembelanjaan.append(defaultOption);

            data.forEach(idBelanja => {
                const options = $('<option>')
                                .val(idBelanja.id)
                                .text(idBelanja.display);
                selectIdPembelanjaan.append(options);
            });
        })
        .catch(error => alert('Error fetching data : ' + error));
    });

    $(document).on('change', '#label-id-belanja', function () {
        const idBelanja = $(this).val();
        const containerTable = $('#container-table-label');

        fetch(`/gudang/receive/get-data-pembelanjaan/${idBelanja}`)
        .then(response => response.json())
        .then(data => {
            containerTable.empty();

            let formTable = `
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <th class="px-6 py-2">${data.orderId}</th>
                    <td class="px-6 py-2">${data.sku}</td>
                    <td class="px-6 py-2">${data.namaProduk}</td>
                    <td class="px-6 py-2">${data.quantity}</td>
                    <td class="px-6 py-2">
                        <a href="/gudang/receive/print-label/${data.detailId}/${data.idProduk}" target="_blank" class="flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-black dark:hover:text-gray-300">
                            <i class="material-symbols-outlined text-xl mr-3">label</i>
                            <span class="whitespace-nowrap">Print Label</span>
                        </a>
                    </td>
                </tr>
            `

            containerTable.append(formTable);
        })
    });
});