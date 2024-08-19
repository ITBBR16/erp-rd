$(document).ready(function(){

    $('#file_paket_produk').on('change', function(){
        var files = $(this)[0].files;

        $('#selected_images_paket').html('');
        $('#image_paket').hide();
        $('#selected_images_paket').show();

        for(var i = 0; i < files.length; i++){
            var file = files[i];
            if(file.type.match('image.*')){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#selected_images_paket').append('<img class="w-full h-32" src="'+e.target.result+'">');
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $('#file_kelengkapan_produk').on('change', function(){
        var files = $(this)[0].files;

        $('#selected_images_kelengkapan').html('');
        $('#image_kelengkapan').hide();
        $('#selected_images_kelengkapan').show();

        for(var i = 0; i < files.length; i++){
            var file = files[i];
            if(file.type.match('image.*')){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#selected_images_kelengkapan').append('<img class="w-12 h-12 m-2" src="'+e.target.result+'">');
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $('#file_paket_produk_second').on('change', function(){
        var files = $(this)[0].files;

        $('#selected_images_paket_second').html('');
        $('#image_paket_second').hide();
        $('#selected_images_paket_second').show();

        for(var i = 0; i < files.length; i++){
            var file = files[i];
            if(file.type.match('image.*')){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#selected_images_paket_second').append('<img class="w-full h-32" src="'+e.target.result+'">');
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $('#file_kelengkapan_produk_second').on('change', function(){
        var files = $(this)[0].files;

        $('#selected_images_kelengkapan_second').html('');
        $('#image_kelengkapan_second').hide();
        $('#selected_images_kelengkapan_second').show();

        for(var i = 0; i < files.length; i++){
            var file = files[i];
            if(file.type.match('image.*')){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#selected_images_kelengkapan_second').append('<img class="w-12 h-12 m-2" src="'+e.target.result+'">');
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $('.files-paket-penjualan').on('change', function(){
        var idForm = $(this).data("id");
        var files = $(this)[0].files;

        $('#selected-img-paktet-' + idForm).html('');
        $('#default-img-edit-paket-' + idForm).hide();
        $('#selected-img-paktet-' + idForm).show();

        for(var i = 0; i < files.length; i++){
            var file = files[i];
            if(file.type.match('image.*')){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#selected-img-paktet-' + idForm).append('<img class="w-full h-32" src="'+e.target.result+'">');
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $('.files-kelengkapan-produk').on('change', function(){
        var idForm = $(this).data("id");
        var files = $(this)[0].files;

        $('#selected-img-kelengkapan-' + idForm).html('');
        $('#default-img-edit-kelengkapan-' + idForm).hide();
        $('#selected-img-kelengkapan-' + idForm).show();

        for(var i = 0; i < files.length; i++){
            var file = files[i];
            if(file.type.match('image.*')){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#selected-img-kelengkapan-' + idForm).append('<img class="w-12 h-12 m-2" src="'+e.target.result+'">');
                };
                reader.readAsDataURL(file);
            }
        }
    });
});