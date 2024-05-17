document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('table-search');
    const rows = document.querySelectorAll('tbody tr');
    const dataNotFound = document.getElementById('dataNotFound');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let found = false;

        rows.forEach(row => {
            const customerName = row.querySelector('.customer-name').textContent.toLowerCase();
            if (customerName.includes(searchTerm)) {
                row.style.display = '';
                found = true;
            } else {
                row.style.display = 'none';
            }
        });

        if (found) {
            dataNotFound.style.display = 'none';
        } else {
            dataNotFound.style.display = 'block';
        }
    });
});
