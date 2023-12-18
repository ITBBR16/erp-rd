document.addEventListener('DOMContentLoaded', function(){
    const addFormBelanja = document.getElementById('add-new-belanja');
    const formNewBelanja = document.getElementById('form-new-belanja');

    addFormBelanja.addEventListener('click', function () {
        const jumlahForm = document.querySelectorAll('.dd-new-belanja');
        const newBelanajaForm = formNewBelanja.lastElementChild.cloneNode(true);

        const uniqueId = new Date().getTime(); 

        newBelanajaForm.id = 'dd-new-belanja-' + uniqueId;

        newBelanajaForm.querySelectorAll('select, input').forEach(function (element) {
            const currentId = element.id;
            if (currentId) {
                element.id = currentId + '-' + uniqueId;
            }
        });
    
        formNewBelanja.appendChild(newBelanajaForm);
    
        const removeKelengkapanButton = newBelanajaForm.querySelector('.remove-form-pembelian');
    
        if (jumlahForm.length > 1) {
            removeKelengkapanButton.style.display = 'block';
        }
    
        removeKelengkapanButton.style.display = 'inline-block';
        removeKelengkapanButton.addEventListener('click', function () {
            formNewBelanja.removeChild(newBelanajaForm);
        });
    });
    

});



// document.addEventListener('DOMContentLoaded', function () {

//     fetch("{{ route('product.index') }}")
//         .then(response => response.json())
//         .then(data => {
//             populateDropdown('#jenis_produk', data);
//         });
//         .catch(error => console.error('Error fetching produk data:', error));

//     document.getElementById('jenis_produk').addEventListener('change', function () {
//         var jenisDroneId = this.value;

//         fetch(`/kios/get-paket-penjualan/${jenisDroneId}`)
//             .then(response => response.json())
//             .then(data => {
//                 populateDropdown('#paket_penjualan', data);
//             })
//             .catch(error => console.error('Error fetching paket penjualan data:', error));
//     });

//     document.getElementById('add-new-belanja').addEventListener('click', function () {
//         var form = '<div class="grid md:w-full md:grid-cols-4 md:gap-4"><div><label for="jenis_produk" class="sr-only"></label><select name="jenis_produk[]" id="jenis_produk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer"><option hidden>Series Drone</option>@foreach($jenisProduk as $jp)<option value="{{ $jp->id }}" class="dark:bg-gray-700">{{ $jp->jenis_produk }}</option>@endforeach</select></div><div class="form-group"><label for="paket_penjualan" class="sr-only"></label><select name="paket_penjualan[]" id="paket_penjualan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-0 focus:border-gray-200 peer"><option hidden>-- Paket Penjualan --</option></select></div><div class="relative z-0 w-full mb-4 group"><input type="text" name="quantity" id="quantity" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required><label for="quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Item</label></div><div class="flex justify-center items-center"><button type="button" class="remove-form-pembelian"><span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span></button></div></div>';

//         document.querySelector('#form-new-belanja').insertAdjacentHTML('beforeend', form);
//     });

//     document.querySelector('#form-new-belanja').addEventListener('click', function (event) {
//         if (event.target.classList.contains('remove-form-pembelian')) {
//             event.target.parentElement.parentElement.remove();
//         }
//     });

//     function populateDropdown(selector, data) {
//         var dropdown = document.querySelector(selector);
//         dropdown.innerHTML = '<option value="" hidden>-- Paket Penjualan --</option>';

//         data.forEach(function (entry) {
//             var option = document.createElement('option');
//             option.value = entry.id;
//             option.text = entry.nama;
//             dropdown.appendChild(option);
//         });
//     }
// });
