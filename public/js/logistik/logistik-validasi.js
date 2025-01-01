$(document).ready(function(){
    $(document).on('change', '#validasi_resi', function() {
        const dataOrderList = $(this).val();
        const listOrder = $('#list_order');
        
        if(dataOrderList){
            fetch(`/kios/product/getOrderList/${dataOrderList}`)
                .then(response => response.json())
                .then(data => {
                    listOrder.empty();
                    
                    const defaultOption = $('<option>', {
                        text: 'Pilih Paket Penjualan',
                        value: '',
                        hidden: true
                    });
                    listOrder.append(defaultOption);
                    
                    data.orderData.forEach(function (result) {
                        
                        const option = $('<option>', {
                            value: result.id,
                            text: result.paket.paket_penjualan
                        })
                        .addClass('bg-white dark:bg-gray-700');
                        listOrder.append(option);
                        
                    });
                })
                .catch(error => console.error('Error:', error));
        } else {
            listOrder.empty();
        }
    });

    $(document).on('change', '#list_order', function() {
        const orderListId = $(this).val();
        const inputSN = $('#input-serial-number');
        
        if(orderListId){
            fetch(`/kios/product/getQtyOrderList/${orderListId}`)
                .then(response => response.json())
                .then(data => {
                    inputSN.empty();

                    data.forEach(data => {
                        const newRow = $('<div class="w-full grid grid-cols-3 gap-6"></div>');
                        const validasiQty = document.getElementById('validasi-qty');
                        const paketId = document.getElementById('paket_id');
                        const ordertId = document.getElementById('order_id');
                        ordertId.value = data.order_id;
                        paketId.value = data.sub_jenis_id;
                        validasiQty.value = data.quantity;
                        let angka = 1;
                        
                        for (let i = 0; i < data.quantity; i++) {
                            const nomor = angka + i;
                            const newInputSn = $(`
                                <div class="relative">
                                    <input type="text" name="validasi-sn[]" id="validasi-sn-${nomor}" class="block px-2.5 pb-2.5 pt-2 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Serial Number ${nomor}">
                                </div>
                                `);
                                    // <label for="validasi-sn-${nomor}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Serial Number ${nomor}</label>

                            newRow.append(newInputSn);

                            if ((i + 1) % 3 === 0 || (i === data.quantity - 1)) {
                                inputSN.append(newRow);
                            }
                        }
                    });
                })
                .catch(error => alert('Error:' + error));
        } else {
            inputSN.empty();
        }
    });

});
