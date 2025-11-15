// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Status Pendaftaran Chart Example
var ctx = document.getElementById("statusPendaftaranChart");
if (ctx) {
  var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["Menunggu Verifikasi", "Berkas Diterima", "Berkas Ditolak", "Sudah Bayar", "Lulus Seleksi"],
      datasets: [{
        data: [156, 892, 89, 756, 623],
        backgroundColor: [
          '#f6c23e', // Kuning - Menunggu Verifikasi
          '#1cc88a', // Hijau - Berkas Diterima
          '#e74a3b', // Merah - Berkas Ditolak
          '#36b9cc', // Biru Muda - Sudah Bayar
          '#4e73df'  // Biru - Lulus Seleksi
        ],
        hoverBackgroundColor: [
          '#f4b619',
          '#17a673',
          '#d52a1e',
          '#2c9faf',
          '#2e59d9'
        ],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            var label = chart.data.labels[tooltipItem.index];
            var value = chart.data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
            var total = chart.data.datasets[tooltipItem.datasetIndex].data.reduce((a, b) => a + b, 0);
            var percentage = Math.round((value / total) * 100);
            
            return label + ': ' + number_format(value) + ' (' + percentage + '%)';
          }
        }
      },
      legend: {
        display: true,
        position: 'bottom',
        labels: {
          padding: 20,
          usePointStyle: true,
          fontColor: '#858796'
        }
      },
      cutoutPercentage: 60,
    },
  });
}