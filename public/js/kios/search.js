document.addEventListener('DOMContentLoaded', function () {
    $('#customer-search').on('input', function () {
        const query = $(this).val();
        const dataNotFound = document.getElementById('dataNotFound');

        if (!query) {
            $('.customer-row').show();
            dataNotFound.style.display = 'none';
        } else {
            $('.customer-row').hide();

            fetch('/kios/customer/list-customer/search?query=' + encodeURIComponent(query), {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.hasOwnProperty('data')) {
                    const customers = data.data;

                    if (customers.length === 0) {
                        dataNotFound.style.display = 'block';
                    } else {
                        customers.forEach(customer => {
                            $('#customerRow_' + customer.id).show();
                        });

                        dataNotFound.style.display = 'none';
                    }
                } else {
                    console.error('Invalid response format: missing "data" property');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        }
    });
});
