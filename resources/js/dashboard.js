
document.addEventListener("DOMContentLoaded", function () {
  const labels = JSON.parse(document.getElementById("expenseChart").dataset.labels).map(function(x){ return x.toUpperCase(); });
  const data = JSON.parse(document.getElementById("expenseChart").dataset.data);
  const color = JSON.parse(document.getElementById("expenseChart").dataset.color);

  var options = {
    chart: {
        type: 'pie',
        height: 'auto', // Let it adjust based on the container
        width: '100%' // Ensures it takes full width
    },
    stroke: { show: false} ,
    series: data,
    labels: labels,
    plotOptions: {
        pie: {
            customScale: 1, // Try values between 0.8 - 1.2 for better scaling
        }
    },
    legend: {
        position: 'top', // Move legend to the top on small screens
        fontSize: '12px',
        itemMargin: {
            horizontal: 5,
            vertical: 5
        }
    },
    dataLabels:{
      enabled: true,
      style: {
        fontSize: '20px',
      }
    },
    colors: color,
    responsive: [
        {
            breakpoint: 500, // Adjust when the screen is smaller than 600px
            options: {
                chart: {
                    height: 250 // Reduce chart size for smaller screens
                },
                legend: {
                    position: 'top',
                    fontSize: '8px'
                },
                dataLabels:{
                  style: {
                    fontSize: '10px',
                  }
                },
            }
        }
    ]
  };

    var chart = new ApexCharts(document.querySelector("#expenseChart"), options);
    chart.render();
});
