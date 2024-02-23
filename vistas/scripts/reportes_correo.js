
function init() {

  reporte_correo_L();
  reporte_correo_W();
}

function reporte_correo_L() {
  $.post("../ajax/reportes_correo.php?op=reporte_correo_1", {}, function (e, textStatus, jqXHR) {
    e = JSON.parse(e); var chart;

    if (e.status) {
      // ::::::::::::: LISTAR ANIOS ::::::::::
      $("#grupos_anios").empty();

      e.data.lista_anios.grupos.forEach(function (grupo) {
        var primero = grupo[0];
        var ultimo = grupo[grupo.length - 1];

        var liElement = $("<li>").append(
          $("<a>").addClass("dropdown-item").attr("href", "#").text(primero + " - " + ultimo)
        );
        $("#grupos_anios").append(liElement);

      });
    

      // :::::::::::::::: ULTIMAS 24 HORAS :::::::::::::::
      $("#recientes").html(e.data.chat_rct.reciente);
      $("#porsentaje").html(e.data.chat_rct.porsentaje + "%");

      // ::::::::::::::::: REPORTE X DIA :::::::::::::::::
      e.data.chart_radar.dia.forEach((val, key) => {
        if (val == 0) {
          $(`.dia-semana-${key + 1}`).html(val).removeClass('text-white').addClass('text-danger text-center');
        } else {
          $(`.dia-semana-${key + 1}`).html(val).removeClass('text-danger').addClass('text-white text-center');
        }
      });

      // ::::::::::::::::: REPORTE X MES  :::::::::::::::::
      var options = {
        series: [{
          name: "Cantidad",
          data: e.data.chart_linea.mes
        }],
        chart: {
          height: 300,
          type: 'line',
          zoom: { enabled: false },
          dropShadow: { enabled: true, enabledOnSeries: undefined, top: 5, left: 0, blur: 3, color: '#000', opacity: 0.1 },
        },
        dataLabels: { enabled: false },
        legend: { position: "top", horizontalAlign: "center", offsetX: -15, fontWeight: "bold", },
        stroke: { curve: 'smooth', width: '3', dashArray: [0, 5], },
        grid: { borderColor: '#f2f6f7', },
        colors: ["rgb(132, 90, 223)", "rgba(132, 90, 223, 0.3)"],
        yaxis: {
          title: {
            text: 'Cantidad de envios',
            style: { color: '#adb5be', fontSize: '14px', fontFamily: 'poppins, sans-serif', fontWeight: 600, cssClass: 'apexcharts-yaxis-label', },
          },
        },
        xaxis: {
          type: 'month',
          categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
          axisBorder: { show: true, color: 'rgba(119, 119, 142, 0.05)', offsetX: 0, offsetY: 0, },
          axisTicks: { show: true, borderType: 'solid', color: 'rgba(119, 119, 142, 0.05)', width: 6, offsetX: 0, offsetY: 0 },
          labels: { rotate: -90 }
        }
      };
      document.getElementById('nft-statistics2').innerHTML = ''
      chart = new ApexCharts(document.querySelector("#nft-statistics2"), options);
      chart.render();
      chart.updateOptions({ colors: [`rgb(${myVarVal})", "rgba(${myVarVal}, 0.3)`], });

      // ::::::::::::::::::::: REPORTE X ANIO :::::::::::::::::::
      var options1 = {
        series: [{
          name: 'Cantidad',
          data: e.data.chart_barra.anio
        }],
        chart: {
          type: 'bar',
          height: 300,
          toolbar: {
            show: false,
          }
        },
        grid: {
          borderColor: '#f2f6f7',
          strokeDashArray: 3
        },
        colors: ["rgb(132, 90, 223)", "rgba(132, 90, 223, 0.3)"],
        plotOptions: {
          bar: {
            colors: {
              ranges: [{
                from: -100,
                to: -46,
                color: '#ebeff5'
              }, {
                from: -45,
                to: 0,
                color: '#ebeff5'
              }]
            },
            columnWidth: '60%',
            borderRadius: 5,
          }
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: undefined,
        },
        legend: {
          show: false,
          position: 'top',
        },
        yaxis: {
          title: {
            style: {
              color: '#adb5be',
              fontSize: '13px',
              fontFamily: 'poppins, sans-serif',
              fontWeight: 600,
              cssClass: 'apexcharts-yaxis-label',
            },
          },
          labels: {
            formatter: function (y) {
              return y.toFixed(0) + "";
            }
          }
        },
        xaxis: {
          type: 'week',
          categories: ['2020', '2021', '2022', '2023', '2024'],
          axisBorder: {
            show: true,
            color: 'rgba(119, 119, 142, 0.05)',
            offsetX: 0,
            offsetY: 0,
          },
          axisTicks: {
            show: true,
            borderType: 'solid',
            color: 'rgba(119, 119, 142, 0.05)',
            width: 6,
            offsetX: 0,
            offsetY: 0
          },
          labels: {
            rotate: -90
          }
        }
      };
      document.getElementById('crm-profits-earned').innerHTML = '';
      var chart1 = new ApexCharts(document.querySelector("#crm-profits-earned"), options1);
      chart1.render();
      chart1.updateOptions({ colors: [`rgb(${myVarVal})", "rgba(${myVarVal}, 0.3)`], });
    } else {
      console.error("Error al obtener datos del servidor:", e.message);
    }
  });
}



function reporte_correo_W(){
  $.post("../ajax/reportes_correo_w.php?op=reporte_correo_w", {}, function (e, textStatus, jqXHR) {
    e = JSON.parse(e); var chart;

    // :::::::::::::::: ULTIMAS 24 HORAS :::::::::::::::
    $("#recientesW").html(e.data.chat_numero.reciente);
    $("#porsentajeW").html(e.data.chat_numero.porsentaje + "%");

    // ::::::::::::::::: REPORTE X DIA :::::::::::::::::
    e.data.chart_radar.dia2.forEach((val, key) => {
      if (val == 0) {
        $(`.correo2-dia-semana-${key + 1}`).html(val).removeClass('text-white').addClass('text-danger text-center');
      } else {
        $(`.correo2-dia-semana-${key + 1}`).html(val).removeClass('text-danger').addClass('text-white text-center');
      }
    });

    // ::::::::::::::::: REPORTE X MES  :::::::::::::::::
    var options = {
      series: [{
        name: "Cantidad",
        data: e.data.chart_linea.mes
      }],
      chart: {
        height: 300,
        type: 'line',
        zoom: { enabled: false },
        dropShadow: { enabled: true, enabledOnSeries: undefined, top: 5, left: 0, blur: 3, color: '#000', opacity: 0.1 },
      },
      dataLabels: { enabled: false },
      legend: { position: "top", horizontalAlign: "center", offsetX: -15, fontWeight: "bold", },
      stroke: { curve: 'smooth', width: '3', dashArray: [0, 5], },
      grid: { borderColor: '#f2f6f7', },
      colors: ["rgb(132, 90, 223)", "rgba(132, 90, 223, 0.3)"],
      yaxis: {
        title: {
          text: 'Cantidad de envios',
          style: { color: '#adb5be', fontSize: '14px', fontFamily: 'poppins, sans-serif', fontWeight: 600, cssClass: 'apexcharts-yaxis-label', },
        },
      },
      xaxis: {
        type: 'month',
        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
        axisBorder: { show: true, color: 'rgba(119, 119, 142, 0.05)', offsetX: 0, offsetY: 0, },
        axisTicks: { show: true, borderType: 'solid', color: 'rgba(119, 119, 142, 0.05)', width: 6, offsetX: 0, offsetY: 0 },
        labels: { rotate: -90 }
      }
    };
    document.getElementById('nft-statistics3').innerHTML = ''
    chart = new ApexCharts(document.querySelector("#nft-statistics3"), options);
    chart.render();

    // ::::::::::::::::::::: REPORTE X ANIO :::::::::::::::::::
    var options1 = {
      series: [{
        name: 'Cantidad',
        data: e.data.chart_barra.anio
      }],
      chart: {
        type: 'bar',
        height: 300,
        toolbar: {
          show: false,
        }
      },
      grid: {
        borderColor: '#f2f6f7',
        strokeDashArray: 3
      },
      colors: ["rgb(132, 90, 223)", "rgba(132, 90, 223, 0.3)"],
      plotOptions: {
        bar: {
          colors: {
            ranges: [{
              from: -100,
              to: -46,
              color: '#ebeff5'
            }, {
              from: -45,
              to: 0,
              color: '#ebeff5'
            }]
          },
          columnWidth: '60%',
          borderRadius: 5,
        }
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        show: true,
        width: 2,
        colors: undefined,
      },
      legend: {
        show: false,
        position: 'top',
      },
      yaxis: {
        title: {
          style: {
            color: '#adb5be',
            fontSize: '13px',
            fontFamily: 'poppins, sans-serif',
            fontWeight: 600,
            cssClass: 'apexcharts-yaxis-label',
          },
        },
        labels: {
          formatter: function (y) {
            return y.toFixed(0) + "";
          }
        }
      },
      xaxis: {
        type: 'week',
        categories: ['2020', '2021', '2022', '2023', '2024'],
        axisBorder: {
          show: true,
          color: 'rgba(119, 119, 142, 0.05)',
          offsetX: 0,
          offsetY: 0,
        },
        axisTicks: {
          show: true,
          borderType: 'solid',
          color: 'rgba(119, 119, 142, 0.05)',
          width: 6,
          offsetX: 0,
          offsetY: 0
        },
        labels: {
          rotate: -90
        }
      }
    };
    document.getElementById('crm-profits-earned2').innerHTML = '';
    var chart1 = new ApexCharts(document.querySelector("#crm-profits-earned2"), options1);
    chart1.render();

  });
}


init();