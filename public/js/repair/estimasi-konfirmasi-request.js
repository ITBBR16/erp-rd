function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

$(document).ready(function () {
    $(document).on('change', '#select-customer-konfirmasi-rp', function () {
        var caseId = $(this).val();
        var containerReqPart = $('#container-konf-req-part');

        fetch(`/repair/estimasi/getDataRequestPart/${caseId}`)
        .then(response =>response.json())
        .then(data => {
            containerReqPart.empty();
            data.forEach(dataReq => {
                let formDataReq = `
                    <tr>
                        <td class="px-6 py-3">
                            <input type="hidden" name="req_part_id[]" value="${dataReq.id}">
                            <input type="hidden" name="status_request[]" value="${dataReq.status_proses_id}">
                            <input type="hidden" name="jenis_drone[]" value="${dataReq.jenis_produk}">
                            ${dataReq.jenis_produk}
                        </td>
                        <td class="px-6 py-3">
                            <input type="hidden" name="sku_part[]" value="${dataReq.sku}">
                            <input type="hidden" name="nama_part[]" value="${dataReq.nama_produk}">
                            ${dataReq.nama_produk}
                        </td>
                        <td class="px-6 py-3">
                            <input type="hidden" name="modal_gudang[]" value="${dataReq.modal_gudang}">
                            <input type="hidden" name="harga_gudang[]" value="${dataReq.harga_gudang}">
                            <input type="hidden" name="harga_repair[]" value="${dataReq.harga_repair}">
                            Rp. ${formatAngka(dataReq.harga_repair)}
                        </td>
                        <td class="px-6 py-3">
                            <div class="relative z-0 w-full group flex items-center">
                                <span class="absolute start-0 font-bold text-gray-500 dark:text-gray-400">RP</span>
                                <input type="text" name="harga_customer[]" id="harga-customer-${dataReq.id}" class="konf-req-harga-customer block py-2.5 ps-8 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required>
                            </div>
                        </td>
                    </tr>
                `
                containerReqPart.append(formDataReq);
            });
        })
        .catch(error => {
            alert('Error fetching data:' + error);
        });
    });

    $(document).on('change', '#status-konfirmasi', function () {
        var status = $(this).val();
        if (status == 'Estimasi') {
            $('.konf-req-harga-customer').prop('required', true);
        } else {
            $('.konf-req-harga-customer').removeAttr('required', true);
        }
    })
});