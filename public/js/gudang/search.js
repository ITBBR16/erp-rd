$(document).ready(function () {
    $('#search-list-produk-gudang').on('keyup', function(){
        let query = $(this).val();
        $.ajax({
            url: "/gudang/produk/list-produk/search",
            type: 'GET',
            data: {query: query},
            success: function(response){
                $('#produk-table').html(response.html);
            }
        });
    });

    $(document).on('click', '#produk-table .pagination a', function(event){
        event.preventDefault();
        let url = $(this).attr('href');
        fetch_data(url);
    });

    function fetch_data(url) {
        $.ajax({
            url: url,
            success: function(response) {
                $('#produk-table').html(response.html);
            }
        });
    }
});