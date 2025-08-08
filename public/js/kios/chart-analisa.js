document.addEventListener("DOMContentLoaded", function () {
    const options = {
        xaxis: {
            show: true,
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass:
                        "text-xs font-normal fill-gray-500 dark:fill-gray-400",
                },
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: true,
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass:
                        "text-xs font-normal fill-gray-500 dark:fill-gray-400",
                },
                formatter: function (value) {
                    return (
                        "Rp. " +
                        value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    );
                },
            },
        },
        series: [
            {
                name: "Profit bulan ini",
                data: [],
                color: "#7ABA78",
            },
            {
                name: "Periode sebelumnya",
                data: [],
                color: "#75A47F",
            },
        ],
        chart: {
            sparkline: {
                enabled: false,
            },
            height: "100%",
            width: "100%",
            type: "area",
            fontFamily: "Inter, sans-serif",
            dropShadow: {
                enabled: false,
            },
            toolbar: {
                show: false,
            },
        },
        tooltip: {
            enabled: true,
            x: {
                show: false,
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                opacityFrom: 0.55,
                opacityTo: 0,
                shade: "#7ABA78",
                gradientToColors: ["#7ABA78"],
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 6,
        },
        legend: {
            show: true,
        },
        grid: {
            show: true,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: -26,
            },
        },
    };

    if (
        document.getElementById("analisa-profit-chart") &&
        typeof ApexCharts !== "undefined"
    ) {
        const today = new Date();
        const daysInMonth = new Date(
            today.getFullYear(),
            today.getMonth() + 1,
            0
        ).getDate();
        const dateOptions = { day: "2-digit", month: "short" };
        const categories = [];
        for (let i = 1; i <= daysInMonth; i++) {
            const date = new Date(today.getFullYear(), today.getMonth(), i);
            const dateString = date
                .toLocaleDateString("en-GB", dateOptions)
                .replace(/ /g, "\n");
            categories.push(dateString);
        }
        options.xaxis.categories = categories;

        fetch("/kios/analisa/analisa-chart")
            .then((response) => response.json())
            .then((data) => {
                options.series[0].data = data.bulan_ini;
                options.series[1].data = data.periode_sebelumnya;

                const chart = new ApexCharts(
                    document.getElementById("analisa-profit-chart"),
                    options
                );
                chart.render();
            })
            .catch((error) => console.error("Error:", error));
    }
});
