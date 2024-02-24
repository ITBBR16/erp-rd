$(document).ready(function() {
    const jenisSelect = $('#jenis_id');
    const kelengkapanSelect = $('#kelengkapan');
    const tambahForm = $('#add-kelengkapan');
    const formKelengkapan = $('#form-kelengkapan');

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
                        }).addClass('dark:bg-gray-700');
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
                    <select name="kelengkapan[]" id="kelengkapan-${nomorKelengkapan}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                        <option value="" hidden>-- Kelengkapan Produk --</option>
                    </select>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="quantity[]" id="quantity-${nomorKelengkapan}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
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
                        }).addClass('dark:bg-gray-700');
                        $('#kelengkapan-' + nomorKelengkapan).append(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
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

});
