<?php
//Activamos el almacenamiento en el buffer
ob_start();

session_start();
if (!isset($_SESSION["user_nombre"])) {
  header("Location: index.php?file=" . basename($_SERVER['PHP_SELF']));
} else {
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

  <head>

    <?php $title_page = "Inicio";
    include("template/head.php"); ?>
    <link rel="stylesheet" href="../assets/libs/jsvectormap/css/jsvectormap.min.css">
    <link rel="stylesheet" href="../assets/libs/swiper/swiper-bundle.min.css">

    <style>
      .scale-up-horizontal-left{animation:scale-up-horizontal-left 0.5s } @keyframes scale-up-horizontal-left{0%{transform:scaleX(.4);transform-origin:left center}100%{transform:scaleX(1);transform-origin:left center}}
      .scale-up-vertical-top1{animation:scale-up-vertical-top 0.4s linear} @keyframes scale-up-vertical-top{0%{transform:scaleY(.4);transform-origin:center top}100%{transform:scaleY(1);transform-origin:center top}}
      .scale-up-vertical-top2{animation:scale-up-vertical-bottom 0.4s linear} @keyframes scale-up-vertical-bottom{0%{transform:scaleY(.4);transform-origin:center bottom}100%{transform:scaleY(1);transform-origin:center bottom}}
    </style>
  </head>

  <!-- <body idusuario="<?php //echo $_SESSION["idempresa"]; ?>" reporte="<?php //echo $_SESSION["reporte"]; ?>" > -->

  <body>
    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>

      <!-- Start::app-content -->
      <div class="main-content app-content">
        <div class="container-fluid">

          <!-- Start::page-header -->

          <!-- End::page-header -->
          

          <!-- Start::Section Correo-1-->
          <section id="correo-1">
            <div class="row">
              <!-- ------------ Emcabezado ------------------- -->
                <div class="my-4">
                  <div class="row">
                    <div class="col-md-6">
                      <p class="fw-semibold fs-18 mb-0">Reportes del correo Landing Page</p>
                      <span class="fs-semibold text-muted">semana - mes - año</span>
                    </div>
                    <div class="col-md-6 text-end">
                      <div class="d-inline-block me-2">
                        <select name="anios" id="anios" class="form-select"> <!-- lista de años --> </select>
                      </div>
                      <div class="d-inline-block me-2">
                        <select name="meses" id="meses" class="form-select"> <!-- lista de meses --> </select>
                      </div>
                      <div class="d-inline-block">
                        <button type="button" class="btn btn-primary btn-wave" id="filtroBtn">
                          <i class="ri-filter-3-fill me-2 align-middle d-inline-block"></i>Filtrar
                        </button>
                      </div>
                    </div>
                  </div>
                  
                </div>

              <div class="col-xxl-3 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <!-- ----------- REPORTE SEMANAL ---------------- -->
                <div class="row scale-up-vertical-top1">
                  <div class="card custom-card crm-highlight-card">
                    <!-- ------- titulo ------- -->
                    <div class="card-header justify-content-left flex-wrap">
                      <span class="avatar avatar-md avatar-rounded bg-green text-gray-200">
                        <i class="ti ti-calendar fs-20"></i>
                      </span>
                      <div>
                        <div class="flex-fill fw-semibold fs-18 text-fixed-white"> Reporte Semanal</div>
                        <a href="#" class=" fs-12" id="mes_seleccionado"></a>
                      </div>
                    </div>
                    <!-- ----------- grafica -------- -->
                    <div class="card-body">
                      <div class="row">
                        <div class="d-flex flex-wrap justify-content-evenly flex-fill">
                          <div class="m-sm-0 m-2">
                            <span><b>Domingo</b></span> <div class="fw-semibold text-danger dia-semana-7"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Lunes</b></span> <div class="fw-semibold mb-0 text-danger dia-semana-1"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Martes</b></span><div class="fe-semibold mb-0 text-danger dia-semana-2 "><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Miércoles</b></span> <div class="fw-semibold mb-0 text-danger dia-semana-3"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                        </div>
                      </div>
                      <div class="row m-sm-2">
                        <div class="d-flex flex-wrap justify-content-evenly flex-fill">
                          <div class="m-sm-0 m-2">
                            <span><b>Jueves</b></span> <div class="fw-semibold mb-0 text-danger dia-semana-4"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Viernes</b></span> <div class="fw-semibold mb-0 text-danger dia-semana-5"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Sábado</b></span> <div class="fw-semibold mb-0 text-danger dia-semana-6"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ----------- REPORTE 24 HORAS --------------- -->
                <div class="row scale-up-vertical-top2">
                  <div class="card custom-card overflow-hidden" >
                    <div class="card-body">
                      <div class="d-flex align-items-top justify-content-between">
                        <div>
                          <span class="avatar avatar-md avatar-rounded bg-primary">
                            <i class="ti ti-users fs-16"></i>
                          </span>
                        </div>
                        <div class="flex-fill ms-3" >
                          <p class="text-muted mb-0">Últimas 24 Horas</p>
                          <h4 class="fw-semibold mt-1" id="recientes"> <!-- Datos 24H --> </h4>
                        </div>    
                        <div class="col-4 text-end" >
                          <div class="mb-0" id="porsentaje" style="color: black;"></div>
                          <span class="mt-0">este mes</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ------------- REPORTE MENSUAL ---------------- -->
              <div class="col-xxl-9 col-xl-5 col-lg-6 col-md-12 col-sm-12 scale-up-horizontal-left">
                <div class="card custom-card">
                  <!-- ------- titulo ------- -->
                  <div class="card-header justify-content-between flex-wrap">
                    <div class="card-title"> Reporte Mensual </div>
                    <a href="#" class="p-2 fs-12 text-muted" id="mesSeleccionado"></a>
                  </div>
                  <!-- ----------- grafica -------- -->
                  <div class="card-body p-0">
                    <div id="graf_linea_mes_landing" class="p-3 text-center">
                      <div class="spinner-border w-50px h-50px" role="status"> </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ------------- REPORTE ANUAL ------------------ -->
              <div class="col-xxl-12 col-xl-5 col-lg-6 col-md-12 col-sm-12 scale-up-horizontal-left">
                <div class="card custom-card">
                  <div class="card-header justify-content-between flex-wrap">
                    <div class="card-title">Reporte Anual</div> 
                    <a class="p-2 fs-12 text-muted" id="anioSeleccionado"></a>
                  </div>
                  <div class="card-body py-0">
                    <div class="p-3 text-center" id="graf_barra_anio_landing"></div>
                  </div>
                </div>
              </div>

            </div>
          </section>
          <!-- End::Selection Correo-1 -->


          <!-- Start::Section Correo-2-->
          <section id="correo-2">
            <div class="row">
              <!-- --------------- Emcabezado ------------------- -->
              <div class="my-4">
                <div class="row">
                  <div class="col-md-6">
                    <p class="fw-semibold fs-18 mb-0">Reportes de Correo WordPress</p>
                    <span class="fs-semibold text-muted">semana - mes - año</span>
                  </div>
                  <div class="col-md-6 text-end">
                    <div class="d-inline-block me-2">
                      <select name="anios2" id="anios2" class="form-select"> <!-- lista de años --> </select>
                    </div>
                    <div class="d-inline-block me-2">
                      <select name="meses2" id="meses2" class="form-select"> <!-- lista de meses --> </select>
                    </div>
                    <div class="d-inline-block">
                      <button type="button" class="btn btn-purple btn-wave" id="filtroBtn2">
                        <i class="ri-filter-3-fill me-2 align-middle d-inline-block"></i>Filtrar
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xxl-3 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <!-- ------------ REPORTE SEMANAL --------------- -->
                <div class="row scale-up-vertical-top1">
                  <div class="card custom-card" style="background-color: #6f42c1;">
                    <!-- ------- titulo ------- -->
                    <div class="card-header justify-content-left flex-wrap">
                      <span class="avatar avatar-md avatar-rounded" style="background-color: #AB5FE3;">
                        <i class="ti ti-calendar fs-20"></i>
                      </span>
                      <div>
                        <div class="flex-fill fw-semibold fs-18 text-fixed-white"> Reporte Semanal</div>
                        <a class=" fs-12" id="mes_seleccionado2"></a>
                      </div>
                    </div>
                    <!-- ----------- grafica -------- -->
                    <div class="card-body">
                      <div class="row">
                        <div class="d-flex flex-wrap justify-content-evenly flex-fill">
                          <div class="m-sm-0 m-2">
                            <span><b>Domingo</b></span> <div class="fw-semibold text-danger dia2-semana-7"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Lunes</b></span> <div class="fw-semibold mb-0 text-danger dia2-semana-1"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Martes</b></span><div class="fe-semibold mb-0 text-danger dia2-semana-2 "><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Miércoles</b></span> <div class="fw-semibold mb-0 text-danger dia2-semana-3"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                        </div>
                      </div>
                      <div class="row m-sm-3">
                        <div class="d-flex flex-wrap justify-content-evenly flex-fill">
                          <div class="m-sm-0 m-2">
                            <span><b>Jueves</b></span> <div class="fw-semibold mb-0 text-danger dia2-semana-4"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Viernes</b></span> <div class="fw-semibold mb-0 text-danger dia2-semana-5"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Sábado</b></span> <div class="fw-semibold mb-0 text-danger dia2-semana-6"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ------------ REPORTE 24 HORAS -------------- -->
                <div class="row scale-up-vertical-top2">
                  <div class="card custom-card overflow-hidden" >
                    <div class="card-body">
                      <div class="d-flex align-items-top justify-content-between">
                        <div>
                          <span class="avatar avatar-md avatar-rounded bg-purple">
                            <i class="ti ti-users fs-16"></i>
                          </span>
                        </div>
                        <div class="flex-fill ms-3" >
                          <p class="text-muted mb-0">Últimas 24 Horas</p>
                          <h4 class="fw-semibold mt-1" id="recientes_w"> <!-- Datos 24H --> </h4>
                        </div>    
                        <div class="col-4 text-end" >
                          <div class="mb-0" id="porsentaje_w" style="color: black;"></div>
                          <span class="mt-0">este mes</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ------------- REPORTE MENSUAL ---------------- -->
              <div class="col-xxl-9 col-xl-5 col-lg-6 col-md-12 col-sm-12 scale-up-horizontal-left">
                <div class="card custom-card">
                  <!-- ------- titulo ------- -->
                  <div class="card-header justify-content-between flex-wrap">
                    <div class="card-title"> Reporte Mensual </div>
                    <a href="#" class="p-2 fs-12 text-muted" id="mesSeleccionado2"></a>
                  </div>
                  <!-- ----------- grafica -------- -->
                  <div class="card-body p-0">
                    <div id="graf_linea_mes_wordpress" class="p-3 text-center">
                      <div class="spinner-border w-50px h-50px" role="status"> </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ------------- REPORTE ANUAL ------------------ -->
              <div class="col-xxl-12 col-xl-5 col-lg-6 col-md-12 col-sm-12 scale-up-horizontal-left">
                <div class="card custom-card">
                  <div class="card-header justify-content-between flex-wrap">
                    <div class="card-title">Reporte Anual</div> 
                    <a class="p-2 fs-12 text-muted" id="anioSeleccionado2"></a>
                  </div>
                  <div class="card-body py-0">
                    <div class="p-3 text-center" id="graf_barra_anio_wordpress"></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- End::Selection Correo-2 -->

        </div>
      </div>
      <!-- End::app-content -->

      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>

    </div>

    <?php include("template/scripts.php"); ?>


    <!-- JSVector Maps JS -->
    <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>

    <!-- JSVector Maps MapsJS -->
    <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

    <!-- Apex Charts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

    <script src="scripts/reportes_correo.js"></script>

    <?php include("template/custom_switcherjs.php"); ?>

  </body>

  </html>
<?php
}
ob_end_flush();
?>