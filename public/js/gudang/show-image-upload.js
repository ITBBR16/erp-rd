$(document).ready(function(){

    $('.file-upload').on('change', function() {
        let idForm = $(this).data("id");
        var files = $(this)[0].files;
    
        $('#selected-files-' + idForm).html('');
        $('#image-' + idForm).hide();
        $('#selected-files-' + idForm).show();
    
        if(files.length === 0){
            $('#image-' + idForm).show();
        } else {
            for(var i = 0; i < files.length; i++){
                var file = files[i];
                if(file.type.match('image.*')){
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('#selected-files-' + idForm).append('<img class="w-full h-32 m-2" src="'+e.target.result+'">');
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    });

});