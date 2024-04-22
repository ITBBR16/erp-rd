const options = {
  xaxis: {
      show: true,
      labels: {
          show: true,
          style: {
              fontFamily: "Inter, sans-serif",
              cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
          }
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
              cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
          },
          formatter: function (value) {
              return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
          }
      }
  },
  series: [
      {
          name: "This Week",
          data: [],
          color: "#1A56DB",
      },
      {
          name: "Last Week",
          data: [],
          color: "#7E3BF2",
      },
  ],
  chart: {
      sparkline: {
          enabled: false
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
          shade: "#1C64F2",
          gradientToColors: ["#1C64F2"],
      },
  },
  dataLabels: {
      enabled: false,
  },
  stroke: {
      width: 6,
  },
  legend: {
      show: true
  },
  grid: {
      show: true,
      strokeDashArray: 4,
      padding: {
          left: 2,
          right: 2,
          top: -26
      },
  },
}

window.onload = function() {
  if (document.getElementById("sales-chart") && typeof ApexCharts !== 'undefined') {
      const today = new Date();
      const sevenDaysAgo = new Date(today.getTime() - 6 * 24 * 60 * 60 * 1000);
      const dateOptions = { day: '2-digit', month: 'short' };
      const categories = [];
      for (let i = 0; i < 7; i++) {
          const date = new Date(sevenDaysAgo.getTime() + i * 24 * 60 * 60 * 1000);
          const dateString = date.toLocaleDateString('en-GB', dateOptions).replace(/ /g, '\n');
          categories.push(dateString);
      }
      options.xaxis.categories = categories;

      fetch('/kios/product/weekly-sales-data')
          .then(response => response.json())
          .then(data => {
              options.series[0].data = data.this_week;
              options.series[1].data = data.last_week;

              const chart = new ApexCharts(document.getElementById("sales-chart"), options);
              chart.render();
          })
          .catch(error => console.error('Error:', error));
  }
}
