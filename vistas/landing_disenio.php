<?php
//Activamos el almacenamiento en el buffer
ob_start();

session_start();
if (!isset($_SESSION["user_nombre"])) {
  header("Location: index.php?file=" . basename($_SERVER['PHP_SELF']));
} else {
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close">

  <head>

    <?php $title_page = "Correo WordPress";
    include("template/head.php"); ?>

    <style>
      .custom-icon { font-size: 40px; color: #36E04B; }
      .border-top { 
        border-top: 2px solid !important; 
        
      }

    </style>

  </head>

  <body id="body-usuario">

    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>

      <!-- Start::app-content -->
      <div class="main-content app-content">
        <div class="container-fluid">

          <!-- Start::page-header -->
          <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
              <div class="d-md-flex d-block align-items-center ">
                <i class="bi bi-flower3 custom-icon"></i>
                <div>
                  <p class="fw-semibold fs-18 mb-0"> Diseño Landing</p>
                  <span class="fs-semibold text-muted">Gestiona tu deseño.</span>
                </div>
              </div>
            </div>

            <div class="btn-list mt-md-0 mt-2">
              <nav>
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javascript:void(0);">Usuario</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Diseño Landing</li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- End::page-header -->

          <!-- Start::row-1 -->
          <section id="cuerpo-disenio-landing">
            <div class="card custom-card">
              <div class="card-body">
                <form name="form-disenio" id="form-disenio" method="POST">
                  <div class="row" id="cargando-1-fomulario">
                    <!-- ------------- INFORMACION --------- -->
                    <div class="col-md-6 p-3">
                      <h5 class="card-title text-center">INFO</h5>
                      
                      <div class="col-md-12 border-top p-3">
                        <div class="row">
                          <div class="mb-3 col-lg-12">
                            <div class="form-group">
                              <label class="form-label">Título</label>
                              <input type="text" class="form-control" name="titulo" id="titulo"/>

                            </div>
                          </div>

                          <div class="mb-3 col-lg-12">
                            <div class="form-group">
                              <label class="form-label">Descripción</label>
                              <input type="text" class="form-control" name="descripcion" id="descripcion"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- ----------------- IMAGEN --------------- -->
                    <div class="col-md-6 p-3">
                      <h5 class="card-title text-center">IMAGEN</h5>
                      <div class="col-md-12 border-top p-3">
                        <div class="row">
                          <!-- imagen -->
                        </div> 
                      </div>
                    </div>

                  </div>

                  <div class="row" id="cargando-2-fomulario" style="display: none;">
                    <div class="col-lg-12 text-center">
                      <i class="fas fa-spinner fa-pulse fa-6x"></i><br><br>
                      <h4>Cargando...</h4>
                    </div>
                  </div>
                  <button type="submit" style="display: none;" id="submit-form-actualizar-registro">Submit</button>

                </form>
              </div>
              <div class="card-footer d-flex justify-content-end">
                <button class="btn btn-warning editar" onclick="activar_editar(1);">Editar</button>
                <button type="submit" class="btn btn-success actualizar" id="actualizar_registro" style="display: none;">Actualizar</button>
              </div>
            </div>
          </section>
          <!-- End::row-1 -->

        </div>
      </div>
      <!-- End::app-content -->

      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>

    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>

    <script src="scripts/landing_disenio.js"></script>

    <script>
      $(function() {
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>

  </body>

  </html>
<?php
}
ob_end_flush();

?>