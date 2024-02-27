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

    <?php $title_page = "Diseño Landing";
    include("template/head.php"); ?>

    <style>
      .custom-icon { font-size: 40px; color: #36E04B; }

      .border-top { border-top: 2px solid !important; }

      .vertical-line { border-left: 1px solid #000; height: 30px; margin-right: 0 auto; }

    </style>

  </head>

  <body id="body-usuario">

    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>

      <?php if($_SESSION['landing']==1) { ?>

      <!-- Start::app-content -->
      <div class="main-content app-content">
        <div class="container-fluid">

          <!-- Start::page-header -->
          <div class="d-md-flex d-block align-items-center justify-content-between my-3 page-header-breadcrumb">
            <div>
              <div class="d-md-flex d-block align-items-center ">
                <button class="btn-modal-effect btn btn-warning label-btn m-r-10px editar" onclick="activar_editar(1);"><i class="ri-edit-2-fill label-btn-icon me-2"></i> Editar</button>
                <button class="btn-modal-effect btn btn-primary label-btn m-r-10px actualizar" id="guardar_registro_disenio" style="display: none;"><i class="ri-save-3-line label-btn-icon me-2"></i> Actualizar</button>
                <button class="btn-modal-effect btn btn-primary label-btn m-r-10px registra_unico" onclick="registrar_unico();" style="display: none;"><i class="ri-save-3-line label-btn-icon me-2"></i> Guardar</button>

                <!-- <button class="btn btn-warning m-r-10px editar" id="edit" onclick="activar_editar(1);">Editar</button>
                <button class="btn btn-primary m-r-10px actualizar" type="submit" id="actualizar_registro" style="display: none;">Actualizar</button>
                <button class="btn btn-primary m-r-10px registra_unico" style="display: none;" onclick="registrar_unico();">Guardar</button> -->
                <div >
                  <p class="fw-semibold fs-18 mb-0"> Diseño Landing</p>
                  <span class="fs-semibold text-muted">Gestiona tu deseño.</span>
                </div>
              </div>
            </div>

            <div class="btn-list mt-md-0 mt-2">
              <nav>
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javascript:void(0);">Landing</a></li>
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
                <div class="card-title p-2 unico bg-success text-center" style="display: none;">No hay datos disponibles. <b>!Registrar única vez!</b></div>
                <form name="formulario-agregar-disenio" id="formulario-agregar-disenio" method="POST">
                  <div class="row" id="cargando-1-fomulario" style="display: none;">
                    <!-- ID -->
                    <input type="hidden" name="idlanding_disenio" id="idlanding_disenio" value="1" />

                    <div class="col-lg-6">
                      <div class="row">
                        <!-- ------------- INFORMACION --------- -->
                        <div class="col-md-12 p-3">
                          <h5 class="card-title text-center">INFO DE FORMULARIO</h5>
                          <div class="col-md-12 border-top p-3">
                            <div class="row">
                              <div class="mb-3 col-lg-12">
                                <div class="form-group">
                                  <label for="f_titulo" class="form-label">Título</label>
                                  <input type="text" class="form-control" name="f_titulo" id="f_titulo" onkeyup="mayus(this);" readonly />
                                </div>
                              </div>

                              <div class="mb-3 col-lg-12">
                                <div class="form-group">
                                  <label for="f_descripcion" class="form-label">Descripción</label>
                                  <textarea class="form-control" name="f_descripcion" id="f_descripcion" rows="3" readonly></textarea>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>

                        <!-- ----------------- IMAGEN FONDO --------------- -->
                        <div class="col-md-6 p-3">
                          <h5 class="card-title text-center">IMAGEN DE FONDO</h5>
                          <div class="col-md-12 border-top p-3">

                            <div class="my-2 text-center">
                              <div class="btn-group edit_img" style="display: none;">
                                <button type="button" class="btn btn-primary py-1" id="doc1_i"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</button>
                                <input type="hidden" id="doc_old_1" name="doc_old_1" />
                                <input style="display: none;" id="doc1" type="file" name="doc1" accept="application/pdf, image/*" class="docpdf" />
                                <button type="button" class="btn btn-info py-1" onclick="re_visualizacion(1, 'assets/modulo/landing_disenio/', '100%'); reload_zoom();"><i class='bx bx-refresh bx-spin fs-5'></i>Refrescar</button>
                              </div>
                            </div>

                            <!-- imagen -->
                            <div id="doc1_ver" class="text-center ">
                              <img id="img_fondo" src="../assets/images/default/img_defecto2.png" alt="" width="78%" />
                            </div>
                            <div class="text-center" id="doc1_nombre" ><!-- aqui va el nombre del pdf --></div>
                          </div>
                        </div>

                        <!-- ----------------- IMAGEN BONO --------------- -->
                        <div class="col-md-6 p-3">
                          <h5 class="card-title text-center">IMAGEN DE BONO</h5>
                          <div class="col-md-12 border-top p-3">

                            <div class="my-2 text-center">
                              <div class="btn-group edit_img" style="display: none;">
                                <button type="button" class="btn btn-primary py-1" id="doc2_i"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</button>
                                <input type="hidden" id="doc_old_2" name="doc_old_2" />
                                <input style="display: none;" id="doc2" type="file" name="doc2" accept="application/pdf, image/*" class="docpdf" />
                                <button type="button" class="btn btn-info py-1" onclick="re_visualizacion(1, 'assets/modulo/landing_disenio/', '100%'); reload_zoom();"><i class='bx bx-refresh bx-spin fs-5'></i>Refrescar</button>
                              </div>
                            </div>

                            <!-- imagen -->
                            <div id="doc2_ver" class="text-center ">
                              <img id="img_bono" src="../assets/images/default/img_defecto2.png" alt="" width="78%" />
                            </div>
                            <div class="text-center" id="doc2_nombre" ><!-- aqui va el nombre del pdf --></div>
                          </div>
                        </div>

                      </div> <!-- /.row -->
                    </div> <!-- /.col-lg-6 -->

                    <div class="col-lg-6">
                      <div class="row">
                        <!-- ------------- INFORMACION --------- -->
                        <div class="col-md-12 p-3">
                          <h5 class="card-title text-center">INFO DE FORMULARIO ENVIADO</h5>
                          <div class="col-md-12 border-top p-3">
                            <div class="row">
                              <div class="mb-3 col-lg-12">
                                <div class="form-group">
                                  <label for="fe_titulo" class="form-label">Título</label>
                                  <input type="text" class="form-control" name="fe_titulo" id="fe_titulo" onkeyup="mayus(this);" readonly />
                                </div>
                              </div>

                              <div class="mb-3 col-lg-12">
                                <div class="form-group">
                                  <label for="fe_descripcion" class="form-label">Descripción</label>
                                  <textarea class="form-control" name="fe_descripcion" id="fe_descripcion" rows="3" readonly></textarea>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>

                        <!-- ----------------- IMAGEN FONDO --------------- -->
                        <div class="col-md-6 p-3">
                          <h5 class="card-title text-center">IMAGEN DE FONDO</h5>
                          <div class="col-md-12 border-top p-3">

                            <div class="my-2 text-center">
                              <div class="btn-group edit_img" style="display: none;">
                                <button type="button" class="btn btn-primary py-1" id="doc3_i"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</button>
                                <input type="hidden" id="doc_old_3" name="doc_old_3" />
                                <input style="display: none;" id="doc3" type="file" name="doc3" accept="application/pdf, image/*" class="docpdf" />
                                <button type="button" class="btn btn-info py-1" onclick="re_visualizacion(3, 'assets/modulo/landing_disenio/', '100%'); reload_zoom();"><i class='bx bx-refresh bx-spin fs-5'></i>Refrescar</button>
                              </div>
                            </div>

                            <!-- imagen -->
                            <div id="doc3_ver" class="text-center ">
                              <img  src="../assets/images/default/img_defecto2.png" alt="" width="78%" />
                            </div>
                            <div class="text-center" id="doc3_nombre" ><!-- aqui va el nombre del pdf --></div>
                          </div>
                        </div>
                        
                      </div> <!-- /.row -->
                    </div> <!-- /.col-lg-6 -->

                    <!-- Chargue  -->
                    <div class="p-l-25px col-lg-12" id="barra_progress_disenio_div" style="display: none;">
                      <div class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <div id="barra_progress_disenio" class="progress-bar" style="width: 0%">
                          <div class="progress-bar-value">0%</div>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="row" id="cargando-2-fomulario" >
                    <div class="col-lg-12 text-center">
                      <i class="fas fa-spinner fa-pulse fa-6x"></i><br><br>
                      <h4>Cargando...</h4>
                    </div>
                  </div>
                  <button type="submit" style="display: none;" id="submit-form-disenio">Submit</button>
                </form>
                <div class="card-footer d-flex justify-content-end">
                  
                </div>
              </div>
            </div>
          </section>
          <!-- End::row-1 -->


        </div>
      </div>
      <!-- End::app-content -->

      <?php } else { $title_submodulo ='Diseño Landing'; $descripcion ='Diseño Landing del sistema!'; $title_modulo = 'Landing Page'; include("403_error.php"); }?>         


      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>

    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>

    <script src="scripts/landing_disenio.js"></script>

    <script>
      $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
      });
    </script>

  </body>

  </html>
<?php
}
ob_end_flush();

?>