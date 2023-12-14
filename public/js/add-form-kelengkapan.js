$(document).ready(function(){
   let kelengkapanCount = 1;
   
   function updateRmButton() {
        if(kelengkapanCount === 1){
            $(".remove-kelengkapan").hide()
        } else{
            $(".remove-kelengkapan").show()
        }
   }

   $("#add-kelengkapan").on("click", function () {
        kelengkapanCount++
        let kelengkapanForm = `
            <div id="form-kelengkapan-${kelengkapanCount}" class="grid grid-cols-3 gap-4 md:gap-6 w-10/12 mt-3">
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="kelengkapan[]" id="kelengkapan${kelengkapanCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                    <label for="kelengkapan${kelengkapanCount}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Kelengkapan</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="quantity[]" id="quantity${kelengkapanCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                    <label for="quantity${kelengkapanCount}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jumlah Barang</label>
                </div>
                <div class="flex justify-center items-center">
                    <button type="button" class="remove-kelengkapan" data-id="${kelengkapanCount}">
                        <span class="material-symbols-outlined text-red-600 hover:text-red-500">cancel</span>
                    </button>
                </div>
            </div>
        `;
        $("#form-kelengkapan").append(kelengkapanForm);
        updateRmButton();
   });

   $(document).on("click", ".remove-kelengkapan", function() {
        let formId = $(this).data("id");
        $("#form-kelengkapan-"+formId).remove();
        kelengkapanCount--;
        updateRmButton();
   });

   updateRmButton();

});