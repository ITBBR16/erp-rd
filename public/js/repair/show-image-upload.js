$(document).ready(function(){

    $('.file-upload').on('change', function() {
        let idForm = $(this).data("id");
        var files = $(this)[0].files;
    
        $('#selected-files-ts-' + idForm).html('');
        $('#image-ts-' + idForm).hide();
        $('#selected-files-ts-' + idForm).show();
    
        if(files.length === 0){
            $('#image-ts-' + idForm).show();
        } else {
            for(var i = 0; i < files.length; i++){
                var file = files[i];
                if(file.type.match('image.*')){
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('#selected-files-ts-' + idForm).append('<img class="w-12 h-12 m-2" src="'+e.target.result+'">');
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    });

    $('#file-upload-kasir').on('change', function(){
        var files = $(this)[0].files;

        $('#selected-files-bukti-transaksi').html('');
        $('#image-transaksi').hide();
        $('#selected-files-bukti-transaksi').show();

        for(var i = 0; i < files.length; i++){
            var file = files[i];
            if(file.type.match('image.*')){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#selected-files-bukti-transaksi').append('<img class="w-full h-32" src="'+e.target.result+'">');
                };
                reader.readAsDataURL(file);
            }
        }
    });

});