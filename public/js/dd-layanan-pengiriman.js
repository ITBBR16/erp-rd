$(document).ready(function(){
    const ekspedisiSelect = $('#ekspedisi');
    const layananSelect = $('#layanan');
    
    ekspedisiSelect.on('change', function () {
        const ekspedisiValue = ekspedisiSelect.val();

        if (ekspedisiValue) {
            fetch(`/kios/getLayanan/${ekspedisiValue}`)
                .then(response => response.json())
                .then(data => {
                    layananSelect.empty();

                    const defaultOption = $('<option>').text('-- Jenis Pengiriman --').attr('hidden', true);
                    layananSelect.append(defaultOption);

                    $.each(data, function(index, jenis_layanan) {
                        const option = $('<option>').val(jenis_layanan.id).text(jenis_layanan.nama_layanan).addClass('dark:bg-gray-700');
                        layananSelect.append(option);
                    });
                });
        } else {
            layananSelect.empty();
        }
    });
});
