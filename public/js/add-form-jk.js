$(document).ready(function(){
    let kelengkapanCount = 1;
    
    function updateRmButton() {
         if(kelengkapanCount === 1){
             $(".remove-jenis-kelengkapan").hide()
         } else{
             $(".remove-jenis-kelengkapan").show()
         }
    }
 
    $("#add-jenis-kelengkapan").on("click", function () {
         kelengkapanCount++
         let kelengkapanForm = `
         <div id="jenis-kelengkapan-${kelengkapanCount}" class="grid grid-cols-2 gap-4 md:gap-6" style="grid-template-columns: 5fr 1fr">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="jenis_kelengkapan[]" id="jenis_kelengkapan${kelengkapanCount}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" required>
                <label for="jenis_kelengkapan${kelengkapanCount}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Kelengkapan</label>
            </div>
            <div class="flex justify-center items-center">
                <button type="button" class="remove-jenis-kelengkapan" data-id="${kelengkapanCount}">
                    <span class="material-symbols-outlined text-red-600 hover:text-red-500">delete</span>
                </button>
            </div>
        </div>
         `;
         $("#jenis-kelengkapan").append(kelengkapanForm);
         updateRmButton();
    });
 
    $(document).on("click", ".remove-jenis-kelengkapan", function() {
         let formId = $(this).data("id");
         $("#jenis-kelengkapan-"+formId).remove();
         kelengkapanCount--;
         updateRmButton();
    });
 
    updateRmButton();
 
 });