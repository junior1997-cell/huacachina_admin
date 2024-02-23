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

  </head>

  <!-- <body idusuario="<?php //echo $_SESSION["idempresa"];
                        ?>" reporte="<?php //echo $_SESSION["reporte"];
                                                                          ?>" > -->

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
                <p class="fw-semibold fs-18 mb-0">Reportes del correo Landing Page</p>
                <span class="fs-semibold text-muted">semanal - mensual - anual</span>
              </div>

              <div class="col-xxl-3 col-xl-5 col-lg-6 col-md-12 col-sm-12">

                <!-- ----------- REPORTE SEMANAL ---------------- -->
                <div class="row">
                  <div class="card custom-card crm-highlight-card">
                    <!-- ------- titulo ------- -->
                    <div class="card-header justify-content-between flex-wrap">
                      <span class="avatar avatar-md avatar-rounded bg-green text-gray-200">
                        <i class="ti ti-calendar fs-20"></i>
                      </span>
                      <div class="flex-fill fw-semibold fs-18 text-fixed-white mb-2"> Reporte Semanal </div>
                    </div>
                    <!-- ----------- grafica -------- -->
                    <div class="card-body p-2">
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
                      <div class="row m-sm-3">
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

                <!-- ------------------- REPORTE 24 HORAS --------------- -->
                <div class="row">
                  <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                      <div class="d-flex align-items-top justify-content-between">
                        <div>
                          <span class="avatar avatar-md avatar-rounded bg-primary">
                            <i class="ti ti-users fs-16"></i>
                          </span>
                        </div>
                        <div class="flex-fill ms-3">
                          <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div>
                              <p class="text-muted mb-0">Últimas 24 Horas</p>
                              <h4 class="fw-semibold mt-1" id="recientes"> <!-- Datos 24H --> </h4>
                            </div>
                            <div id="crm-total-customers"></div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mt-1">
                            <div>
                              <!-- <a class="text-primary" href="javascript:void(0);">View All<i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a> -->
                            </div>
                            <div class="text-end">
                              <p class="mb-0 text-success fw-semibold" id="porsentaje"></p>
                              <span class="text-muted op-7 fs-11">este mes</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                  
              </div>
              

              <!-- ----------- REPORTE MENSUAL ---------------- -->
              <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="card custom-card">
                  <!-- ------- titulo ------- -->
                  <div class="card-header justify-content-between flex-wrap">
                    <div class="card-title"> Reporte Mensual </div>
                  </div>
                  <!-- ----------- grafica -------- -->
                  <div class="card-body p-0">
                    <div id="nft-statistics2" class="p-3 text-center">
                      <div class="spinner-border w-50px h-50px" role="status"> </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ----------- REPORTE ANUAL ---------------- -->
              <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="card custom-card">
                  <div class="card-header justify-content-between flex-wrap">
                    <div class="card-title">Reporte Anual</div>  
                  </div>
                  <div class="card-body py-0">
                    <div class="p-3 text-center" id="crm-profits-earned"></div>
                  </div>
                </div>
              </div>

            </div>
          </section>
          <!-- End::Selection Correo-1 -->


          <!-- Start::Section Correo-2-->
          <section id="correo-2">
            <div class="row">
              <!-- ------------ Emcabezado ------------------- -->
              <div class=" my-4">
                <p class="fw-semibold fs-18 mb-0">Reportes de Correo WordPress</p>
                <span class="fs-semibold text-muted">semana - mensual - anual</span>
              </div>

              <!-- ----------- REPORTE SEMANAL ---------------- -->
              <div class="col-xxl-3 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="row">
                  <div class="card custom-card crm-highlight-card">
                    <!-- ------- titulo ------- -->
                    <div class="card-header justify-content-between flex-wrap">
                      <span class="avatar avatar-md avatar-rounded bg-green text-gray-200">
                        <i class="ti ti-calendar fs-20"></i>
                      </span>
                      <div class="flex-fill fw-semibold fs-18 text-fixed-white mb-2"> Reporte Semanal </div>
                    </div>
                    <!-- ----------- grafica -------- -->
                    <div class="card-body p-2">
                      <div class="row">
                        <div class="d-flex flex-wrap justify-content-evenly flex-fill">
                          <div class="m-sm-0 m-2">
                            <span><b>Domingo</b></span> <div class="fw-semibold text-danger correo2-dia-semana-7"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Lunes</b></span> <div class="fw-semibold mb-0 text-danger correo2-dia-semana-1"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Martes</b></span><div class="fe-semibold mb-0 text-danger correo2-dia-semana-2 "><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Miércoles</b></span> <div class="fw-semibold mb-0 text-danger correo2-dia-semana-3"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                        </div>
                      </div>
                      <div class="row m-sm-3">
                        <div class="d-flex flex-wrap justify-content-evenly flex-fill">
                          <div class="m-sm-0 m-2">
                            <span><b>Jueves</b></span> <div class="fw-semibold mb-0 text-danger correo2-dia-semana-4"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Viernes</b></span> <div class="fw-semibold mb-0 text-danger correo2-dia-semana-5"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                          <div class="m-sm-0 m-2">
                            <span><b>Sábado</b></span> <div class="fw-semibold mb-0 text-danger correo2-dia-semana-6"><div class="spinner-border w-20px h-20px" role="status"> </div></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ----------- Reporte Mensual ---------------- -->
              <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="card custom-card">
                  <!-- ------- titulo ------- -->
                  <div class="card-header justify-content-between flex-wrap">
                    <div class="card-title"> Reporte Mensual </div>
                  </div>
                  <!-- ----------- grafica -------- -->
                  <div class="card-body p-0">
                    <div id="nft-statistics5" class="p-3 text-center">
                      <div class="spinner-border w-50px h-50px" role="status"> </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ----------- Reporte Anual ---------------- -->
              <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="card custom-card">
                  <!-- ------- titulo ------- -->
                  <div class="card-header justify-content-between flex-wrap">
                    <div class="card-title"> Reporte Anual </div>
                  </div>
                  <!-- ----------- grafica -------- -->
                  <div class="card-body p-0">
                    <div id="nft-statistics6" class="p-3 text-center">
                      <div class="spinner-border w-50px h-50px" role="status"> </div>
                    </div>
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