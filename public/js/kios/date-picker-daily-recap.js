document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("export-form-daily-recap");

    form.addEventListener("submit", function (e) {
        const startDate = document.getElementById("start-date").value;
        const endDate = document.getElementById("end-date").value;

        if (!startDate || !endDate) {
            e.preventDefault();
            alert("Silakan pilih tanggal awal dan akhir terlebih dahulu.");
        }
    });

    const formatDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const day = String(date.getDate()).padStart(2, "0");
        return `${year}-${month}-${day}`;
    };

    // Event listener untuk update input saat tanggal dipilih
    document
        .getElementById("start-datepicker")
        .addEventListener("changeDate", function (e) {
            document.getElementById("start-date").value = formatDate(
                e.detail.date
            );
        });

    document
        .getElementById("end-datepicker")
        .addEventListener("changeDate", function (e) {
            document.getElementById("end-date").value = formatDate(
                e.detail.date
            );
        });
});
