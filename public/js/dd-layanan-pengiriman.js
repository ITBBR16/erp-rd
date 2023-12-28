$(document).ready(function(){
    const ekspedisiSelect = $('#ekspedisi');
    const layananSelect = $('#layanan');
    
    ekspedisiSelect.on('change', function () {
        const ekspedisiValue = ekspedisiSelect.value;

        if (ekspedisiValue) {
            fetch(`/kios/getLayanan/${ekspedisiValue}`)
                .then(response => response.json())
                .then(data => {
                    layananSelect.innerHTML = '';

                    const defaultOption = document.createElement('option');
                    defaultOption.textContent = '-- Jenis Pengiriman --';
                    defaultOption.setAttribute('hidden', true);
                    layananSelect.appendChild(defaultOption);

                    data.forEach(jenis_layanan => {
                        const option = document.createElement('option');
                        option.value = jenis_layanan.id;
                        option.textContent = jenis_layanan.nama_layanan;
                        option.classList.add('dark:bg-gray-700');
                        layananSelect.appendChild(option);
                    });
                });
        } else {
            layananSelect.innerHTML = '';
        }
    });
});
