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

    <?php $title_page = "Inicio";
    include("template/head.php"); ?>

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
                <button class="btn-modal-effect btn btn-primary label-btn m-r-10px" onclick="limpiar_form();" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" data-bs-target="#modal-agregar-usuario"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                <div>
                  <p class="fw-semibold fs-18 mb-0">Lista de usuarios del sistema!</p>
                  <span class="fs-semibold text-muted">Administra de manera eficiente tus usuarios.</span>
                </div>
              </div>
            </div>

            <div class="btn-list mt-md-0 mt-2">
              <nav>
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javascript:void(0);">Usuario</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Administracion</li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- End::page-header -->

          <!-- Start::row-1 -->
          <div class="row">
            <div class="col-xxl-12 col-xl-12">
              <div class="">
                <div class="card custom-card">
                  <div class="card-body table-responsive">

                    <table id="tabla-usuario" class="table table-bordered w-100" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Opciones</th>
                          <th>Nombre</th>
                          <th>Usuario</th>
                          <th>Cargo</th>
                          <th>Teléfono</th>
                          <th>Email</th>
                          <th>Estado</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Opciones</th>
                          <th>Nombre</th>
                          <th>Usuario</th>
                          <th>Cargo</th>
                          <th>Teléfono</th>
                          <th>Email</th>
                          <th>Estado</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <!-- End::row-1 -->

        </div>
      </div>
      <!-- End::app-content -->

      <div class="modal fade modal-effect" id="modal-agregar-usuario" tabindex="-1" aria-labelledby="modal-agregar-usuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="modal-agregar-usuarioLabel1">Modal title</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form name="form-agregar-usuario" id="form-agregar-usuario" method="POST" class="row g-3 needs-validation" novalidate>
                <div class="tab-content">
                  <div class="tab-pane fade show active text-muted" id="dato-usuario-pane" role="tabpanel" tabindex="0">
                    <div class="row gy-2" id="cargando-1-fomulario">
                      <!-- id usuario -->
                      <b class="trabajador-name"></b>
                      <input type="hidden" class="" id="idusuario" name="idusuario">
                      <!-- Cargo -->
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="id_persona" class="form-label">Nombre:</label>
                          <select class="form-control select2" name="id_persona" id="id_persona" onchange="capt_cargo();"> </select>
                          <input type="hidden" name="persona_old" id="persona_old">
                        </div>
                      </div>

                      <!-- Cargo -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="cargo" class="form-label">Cargo:</label>
                          <input type="text" class=" form-control cargo_persona" readonly style="display: none;">
                          <input type="text" class=" form-control cargo_persona_edit" readonly >
                        </div>
                      </div>
                      <!-- Usuario -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="login" class="form-label">Usuario:</label>
                          <input type="text" class="form-control" name="login" id="login" required>
                        </div>
                      </div>
                      <!--  Contraseña -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="clave" class="form-label">Contraseña:</label>
                          <div class="input-group mb-3">
                            <input type="password" class="form-control" name="clave" id="clave" required placeholder="Contraseña" aria-describedby="icon-view-password">
                            <button class="btn btn-primary" type="button" onclick="ver_password(this);" id="icon-view-password"><i class="fa-solid fa-eye"></i></button>
                            <input type="hidden" name="password-old"   id="password-old"  >
                          </div>
                        </div>
                      </div>
                      <!-- permisos -->
                      <div class="col-xl-12">
                        <div class="mail-notification-settings">
                          <p class="fs-14 mb-1 fw-semibold text-primary">Roles de Módulo</p>
                          <p class="fs-12 mb-0 text-muted">Escoje los módulos correspondientes al menú</p>
                        </div>
                        <div id="permisos"> </div>
                      </div>

                    </div>
                    <div class="row" id="cargando-2-fomulario" style="display: none;">
                      <div class="col-lg-12 text-center">
                        <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                        <h4 class="bx-flashing">Cargando...</h4>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Chargue  -->
                <div class="p-l-25px col-lg-12" id="barra_progress_usuario_div" style="display: none;">
                  <div class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div id="barra_progress_usuario" class="progress-bar" style="width: 0%">
                      <div class="progress-bar-value">0%</div>
                    </div>
                  </div>
                </div>
                <!-- Submit -->
                <button type="submit" style="display: none;" id="submit-form-usuario">Submit</button>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limpiar_form();"><i class="las la-times fs-lg"></i> Close</button>
              <button type="button" class="btn btn-primary" id="guardar_registro_usuario"><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>

      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>

    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>

    <!-- Select2 Cdn -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="scripts/usuario.js"></script>
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