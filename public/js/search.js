document.addEventListener('DOMContentLoaded', function () {
    $('#table-search').on('input', function () {
        const query = $(this).val();
        const dataNotFound = document.getElementById('dataNotFound');

        if (!query) {
            $('.customer-row').show();
            dataNotFound.style.display = 'none';
        } else {
            $('.customer-row').hide();

            $.ajax({
                url: '/customer/data-customer/search',
                method: 'GET',
                data: { query: query },
                dataType: 'json',
                success: function (response) {
                    if (response.hasOwnProperty('data')) {
                        const data = response.data;

                        if (data.length === 0) {
                            dataNotFound.style.display = 'block';
                        } else {
                            $.each(data, function (key, customer) {
                                $('#customerRow_' + customer.id).show();
                            });

                            dataNotFound.style.display = 'none';
                        }
                    } else {
                        console.error('Invalid response format: missing "data" property');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                }
            });
        }
    });
});
