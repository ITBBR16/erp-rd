// Mencari data customer on repair
$(document).ready(function(){
    $('#repair-customer-search').on('input', function () {
        const query = $(this).val();
        const dataNotFound = document.getElementById('dataCRNotFound');

        if (!query) {
            $('.repair-customer-row').show();
            dataNotFound.style.display = 'none';
        } else {
            $('.repair-customer-row').hide();

            fetch('/repair/customer/list-customer-repair/search?query=' + encodeURIComponent(query), {
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
                            $('#resultCustomerRepair' + customer.id).show();
                        });

                        dataNotFound.style.display = 'none';
                    }
                } else {
                    console.log('Invalid response format: missing "data" property');
                }
            })
            .catch(error => {
                console.log('Fetch error: ' + error);
            });
        }
    });
});
