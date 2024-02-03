$(document).ready(function(){
    const jenisDroneSecond = $('#jenis_drone_second');
    const container = $('#kelengkapan-second');
    const biayaPengambilan = $('#biaya_pengambilan');
    const comeFrom = $('#come_from');
    const customer = $('#customerContainer');
    const marketplace = $('#marketplaceContainer');
    const biayaSatuan = $('.biaya_satuan');
    
    jenisDroneSecond.on('change', function() {
        const subJenisId = jenisDroneSecond.val();
        
        if(subJenisId){
            fetch(`/kios/get-kelengkapan-second/${subJenisId}`)
            .then(response => response.json())
            .then(data => {
                container.html('');

                data.kelengkapans.forEach(function (kelengkapan) {
                    container.append(`
                        <div class="grid md:grid-cols-3 md:gap-6">
                            <div class="flex items-center mb-6">
                                <input name="kelengkapan_second[]" id="kelengkapan_second${kelengkapan.id}" type="checkbox" value="${kelengkapan.id}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="kelengkapan_second${kelengkapan.id}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">${kelengkapan.kelengkapan}</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="number" name="quantity_second[]" id="quantity_second${kelengkapan.id}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="">
                                <label for="quantity_second${kelengkapan.id}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Quantity</label>
                            </div>
                        </div>
                    `);
                });
            })
            .catch(error => console.error('Error:', error));
        } else {
            container.html('');
        }
    });
    
    function formatRupiah(angka) {
        return accounting.formatMoney(angka, "", 0, ".", ",");
    }
    
    biayaPengambilan.on('input', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

    biayaSatuan.on('input', function () {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/[^\d]/g, '');
        var parsedValue = parseInt(inputValue, 10);
        $(this).val(formatRupiah(parsedValue));
    });

    comeFrom.on('change', function () {
        const valAsal = comeFrom.val();

        $('#customer').val('');
        $('#marketplace').val('');
        
        if( valAsal == 'Customer' ) {
            customer.show();
            customer.prop('required', true);
            marketplace.hide();
            marketplace.prop('required', false);
        } else {
            customer.hide();
            customer.prop('required', false);
            marketplace.show();
            marketplace.prop('required', true);
        }
        
    });

    // Cek nilai pada halaman qc second
    function cekNilai() {
        var nilaiSatuanInputs = document.getElementsByName('harga_satuan[]');
        var totalHargaSatuan = 0;
    
        for (var i = 0; i < nilaiSatuanInputs.length; i++) {
            var nilaiSatuan = parseFloat(nilaiSatuanInputs[i].value.replace(/\./g, ''));
            totalHargaSatuan += nilaiSatuan;
        }
    
        var nilaiTotalInput = parseFloat(document.getElementById('biaya_pengambilan').value.replace(/\./g, ''));

        if (!isNaN(nilaiTotalInput) && !isNaN(totalHargaSatuan) && nilaiTotalInput.toFixed(2) === totalHargaSatuan.toFixed(2)) {
            document.getElementById('submit_qc_second').removeAttribute('disabled');
            document.getElementById('submit_qc_second').classList.remove('cursor-not-allowed');
            // console.log("Nilai satuan sama dengan nilai total.");
        } else {
            // console.log("Nilai satuan tidak sama dengan nilai total.");
        }
    }

    var hargaSatuanInputs = document.querySelectorAll('input[name="harga_satuan[]"]');
    hargaSatuanInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            cekNilai();
        });
    });

});
