var selectAnios;
function init() {
  reporte_correo_L();
  reporte_correo_W();
  lista_meses_anios();
}

function reporte_correo_L() {
  var anioSelect = $("#anios").val(); if (!anioSelect){anioSelect = new Date().getFullYear();}
  var mesSelect = $("#meses").val(); if (!mesSelect){mesSelect = new Date().getMonth()+1;}
  ver_subtitulo_L();
  $.post("../ajax/reportes_correo.php?op=reporte_correo_1", {anio: anioSelect, mes: mesSelect}, function (e, textStatus, jqXHR) {
    e = JSON.parse(e); var chart; var chart1; var chart2;

    if (e.status) {
      // :::::::::::::::: ULTIMAS 24 HORAS :::::::::::::::
      $("#recientes").html(e.data.chart_rct.reciente);

      // ::::::::::::::: PORCENTAJE DIARIO :::::::::::::::
      var options = {
        chart: {
            height: 127,
            width: 100,
            type: "radialBar",
        },

        series: [e.data.chart_rct.porsentaje],
        colors: ["rgba(144,238,144,1)"],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    padding: 0,
                    size: "55%",
                    background: "#90EE90"
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: "#90EE90",
                        fontSize: ".525rem",
                        show: false
                    },
                    value: {
                        offsetY: 5,
                        color: "#90EE90",
                        fontSize: ".875rem",
                        show: true,
                        fontWeight: 600
                    }
                }
            }
        },
        stroke: {
            lineCap: "round"
        },
        labels: ["Status"]
      };
      document.querySelector("#porsentaje").innerHTML = ""
      var chart = new ApexCharts(document.querySelector("#porsentaje"), options);
      chart.render();

      // ::::::::::::::::: REPORTE X DIA :::::::::::::::::
      e.data.chart_numero.dia.forEach((val, key) => {
        if (val == 0) {
          $(`.dia-semana-${key + 1}`).html(val).removeClass('text-white').addClass('text-danger text-center');
        } else {
          $(`.dia-semana-${key + 1}`).html(val).removeClass('text-danger').addClass('text-white text-center');
        }
      });

      // :::::::::::::::: REPOERTE X MES :::::::::::::::::
      var options1 = {
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
          categories: e.data.chart_linea.dias,
          axisBorder: { show: true, color: 'rgba(119, 119, 142, 0.05)', offsetX: 0, offsetY: 0, },
          axisTicks: { show: true, borderType: 'solid', color: 'rgba(119, 119, 142, 0.05)', width: 6, offsetX: 0, offsetY: 0 },
          labels: { rotate: -90 }
        }
      };
      document.getElementById('graf_linea_mes_landing').innerHTML = ''
      chart1 = new ApexCharts(document.querySelector("#graf_linea_mes_landing"), options1);
      chart1.render();
      chart1.updateOptions({ colors: [`rgb(${myVarVal})", "rgba(${myVarVal}, 0.3)`], });

      // :::::::::::::::: REPORTE X ANIO :::::::::::::::::
      var options2 = {
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
          categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
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
      document.getElementById('graf_barra_anio_landing').innerHTML = '';
      var chart2 = new ApexCharts(document.querySelector("#graf_barra_anio_landing"), options2);
      chart2.render();
      chart2.updateOptions({ colors: [`rgb(${myVarVal})", "rgba(${myVarVal}, 0.3)`], });

    } else {
      console.error("Error al obtener datos del servidor:", e.message);
    }
  });
  
}

function reporte_correo_W(){
  var anioSelect_w = $("#anios2").val(); if (!anioSelect_w){anioSelect_w = new Date().getFullYear();}
  var mesSelect_w = $("#meses2").val(); if (!mesSelect_w){mesSelect_w = new Date().getMonth()+1;}
  ver_subtitulo_W();
  $.post("../ajax/reportes_correo_w.php?op=reporte_correo_w", {anio: anioSelect_w, mes: mesSelect_w}, function (e, textStatus, jqXHR) {
    e = JSON.parse(e); var chart; var chart1; var chart2;
    if (e.status) {

      // :::::::::::::::: ULTIMAS 24 HORAS :::::::::::::::
      $("#recientes_w").html(e.data.chat_numero.recientew);

      // ::::::::::::::: PORCENTAJE DIARIO :::::::::::::::
      var options = {
        chart: {
            height: 127,
            width: 100,
            type: "radialBar",
        },

        series: [e.data.chat_numero.porsentajew],
        colors: ["rgba(144,144,238,1)"],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    padding: 0,
                    size: "55%",
                    background: "#9C8EFA"
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: "#9C8EFA",
                        fontSize: ".525rem",
                        show: false
                    },
                    value: {
                        offsetY: 5,
                        color: "#9C8EFA",
                        fontSize: ".875rem",
                        show: true,
                        fontWeight: 600
                    }
                }
            }
        },
        stroke: {
            lineCap: "round"
        },
        labels: ["Status"]
      };
      document.querySelector("#porsentaje_w").innerHTML = ""
      var chart = new ApexCharts(document.querySelector("#porsentaje_w"), options);
      chart.render();

      // ::::::::::::::::: REPORTE X DIA :::::::::::::::::
      e.data.chart_day.dia.forEach((val, key) => {
        if (val == 0) {
          $(`.dia2-semana-${key + 1}`).html(val).removeClass('text-white').addClass('text-danger text-center');
        } else {
          $(`.dia2-semana-${key + 1}`).html(val).removeClass('text-danger').addClass('text-white text-center');
        }
      });


      // :::::::::::::::: REPOERTE X MES :::::::::::::::::
      var options1 = {
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
          categories: e.data.chart_linea.dias,
          axisBorder: { show: true, color: 'rgba(119, 119, 142, 0.05)', offsetX: 0, offsetY: 0, },
          axisTicks: { show: true, borderType: 'solid', color: 'rgba(119, 119, 142, 0.05)', width: 6, offsetX: 0, offsetY: 0 },
          labels: { rotate: -90 }
        }
      };
      document.getElementById('graf_linea_mes_wordpress').innerHTML = ''
      chart1 = new ApexCharts(document.querySelector("#graf_linea_mes_wordpress"), options1);
      chart1.render();

      // :::::::::::::::: REPORTE X ANIO :::::::::::::::::
      var options2 = {
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
          categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
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
      document.getElementById('graf_barra_anio_wordpress').innerHTML = '';
      var chart2 = new ApexCharts(document.querySelector("#graf_barra_anio_wordpress"), options2);
      chart2.render();

    } else {
      console.error("Error al obtener datos del servidor:", e.message);
    }

  });
}

function lista_meses_anios() {

  // ----------- LANDING ------------------------
  var selectMeses = $("#meses"); selectMeses.empty();
  var meses = [
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
  ];
  var mesActual = new Date().getMonth();
  for (var i = 0; i < meses.length; i++) {
    var mes = meses[i];
    var option = $("<option>").text(mes).val(i + 1);
    if (i == mesActual) { option.attr("selected", true); }
    selectMeses.append(option);
  }
  $.post("../ajax/reportes_correo.php?op=list_anios", {}, function (e, textStatus, jqXHR) {
    e = JSON.parse(e); var chart; var chart1;

    if (e.status) {
      var selectAnios = $("#anios"); selectAnios.empty();
      for (var i = 0; i < e.data.chatr_list.lista.length; i++) {
        var anio = e.data.chatr_list.lista[i];
        var option = $("<option>").text(anio).val(anio);
        selectAnios.append(option);
      }
    } else {
      console.error("Error al obtener datos del servidor:", e.message);
    }
  });

  // -------------- WORDPRESS --------------
  var selectMeses2 = $("#meses2"); selectMeses2.empty();
  for (var i = 0; i < meses.length; i++) {
    var mes2 = meses[i];
    var option2 = $("<option>").text(mes2).val(i + 1);
    if (i == mesActual) { option2.attr("selected", true); }
    selectMeses2.append(option2);
  }
  $.post("../ajax/reportes_correo_w.php?op=list_anios_w", {}, function (e, textStatus, jqXHR) {
    e = JSON.parse(e);

    if (e.status) {
      var selectAnios2 = $("#anios2"); selectAnios2.empty();
      for (var i = 0; i < e.data.chart_lista.lista.length; i++) {
        var anio2 = e.data.chart_lista.lista[i];
        var option2 = $("<option>").text(anio2).val(anio2);
        selectAnios2.append(option2);
      }
    } else {
      console.error("Error al obtener datos del servidor:", e.message);
    }
  });


}

function ver_subtitulo_L (){ //no encontré otra forma más eficiente de listar esta vaina XD
  var anioSelect = $("#anios").val();
  if (!anioSelect) {anioSelect = new Date().getFullYear();}
  var mesSelect = $("#meses").val();
  if (!mesSelect) {mesSelect = new Date().getMonth() + 1;}
  var nombresMeses = [
      "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
      "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
  ];
  $("#anioSeleccionado").text(anioSelect);
  $("#mesSeleccionado").text(nombresMeses[mesSelect - 1]); 
  $("#mes_seleccionado").text(nombresMeses[mesSelect - 1]); 
}

function ver_subtitulo_W (){ //no encontré otra forma más eficiente de listar esta vaina XD
  var anioSelect = $("#anios2").val();
  if (!anioSelect) {anioSelect = new Date().getFullYear();}
  var mesSelect = $("#meses2").val();
  if (!mesSelect) {mesSelect = new Date().getMonth() + 1;}
  var nombresMeses = [
      "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
      "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
  ];
  $("#anioSeleccionado2").text(anioSelect);
  $("#mesSeleccionado2").text(nombresMeses[mesSelect - 1]); 
  $("#mes_seleccionado2").text(nombresMeses[mesSelect - 1]); 
}



$("#filtroBtn").on("click", function() {
  reporte_correo_L();
});

$("#filtroBtn2").on("click", function() {
  reporte_correo_W();
});



init();













function reporte_correo_W_respaldo(){
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