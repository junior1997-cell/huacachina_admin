<?php
  //Activamos el almacenamiento en el buffer
  ob_start();

  session_start();
  if (!isset($_SESSION["user_nombre"])){
    header("Location: index.php?file=".basename($_SERVER['PHP_SELF']));
  }else{
    ?>
    <!DOCTYPE html>
    <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close">

      <head>
        
        <?php $title_page = "Empresa"; include("template/head.php"); ?>    

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
                      <p class="fw-semibold fs-18 mb-0">Datos Generales de la EMPRESA</p>
                  </div>
                </div>
                
                <div class="btn-list mt-md-0 mt-2">              
                  <nav>
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="javascript:void(0);">Usuario</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Empresa</li>
                    </ol>
                  </nav>
                </div>
              </div>          
              <!-- End::page-header -->

              <!-- Start::row-1 -->
              <section id="cuerpo-empresa">
                <div class="card custom-card">
                  <div class="card-body">
                    <form name="form-empresa" id="form-empresa" method="POST">
                      <div class="row" id="cargando-1-fomulario">
                        <!-- id -->
                        <input type="hidden" name="idnosotros" id="idnosotros" />
                        <!-- RUC -->
                        <div class="col-12 col-sm-6 col-md-6 col-lg-2" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="tipo_documento">Tipo Doc. <sup class="text-danger">*</sup></label>
                            <select name="tipo_documento" id="tipo_documento" class="form-control" readonly>
                              <option value="RUC">RUC</option>
                            </select>
                          </div>
                        </div>

                        <!-- DOCUMENTO -->
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="num_documento">N° de documento <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                              <input type="number" name="num_documento" class="form-control" id="num_documento" placeholder="N° de documento" readonly />
                              <span class="input-group-text" style="cursor: pointer;" data-toggle="tooltip" data-original-title="Buscar Reniec/SUNAT" onclick="buscar_sunat_reniec('');">
                                <i class="fas fa-search text-primary" id="search"></i>
                                <i class="fa fa-spinner fa-pulse fa-fw fa-lg text-primary" id="charge" style="display: none;"></i>
                              </span>
                            </div>
                          </div>
                        </div>

                        <!-- nombre -->
                        <div class="col-12 col-sm-6 col-md-6 col-lg-7" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="nombre">Nombre <sup class="text-danger">*</sup></label>
                            <input type="text" name="nombre" class="form-control" id="nombre" readonly />
                          </div>
                        </div>

                        <!-- direccion -->
                        <div class="col-6 col-sm-6 col-md-6 col-lg-8" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="direccion">Dirección <sup class="text-danger">*</sup></label>
                            <input type="text" name="direccion" class="form-control" id="direccion" readonly />
                          </div>
                        </div>

                        <!-- Correo -->
                        <div class="col-6 col-sm-6 col-md-6 col-lg-4" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="correo">Correo <sup class="text-danger">*</sup></label>
                            <input type="text" name="correo" class="form-control" id="correo" readonly />
                          </div>
                        </div>

                        <!-- celular -->
                        <div class="col-6 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="celular">Celular <sup class="text-danger">*</sup></label>
                            <input type="text" name="celular" class="form-control" id="celular" readonly />
                          </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-6 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="telefono">Teléfono <sup class="text-danger">*</sup></label>
                            <input type="text" name="telefono" class="form-control" id="telefono" readonly />
                          </div>
                        </div>
                        
                        <!-- mapa -->
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="mapa">Mapa Link <sup class="text-danger">*</sup></label>
                            <textarea  class="form-control"  name="mapa" id="mapa" id="" cols="30" rows="1" readonly></textarea>
                            
                          </div>
                        </div>

                        <!-- Longuitud -->
                        <div class="col-6 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 20px; display: none;">
                          <div class="form-group">
                            <label for="longuitud">Longuitud <sup class="text-danger">*</sup></label>
                            <input type="text" name="longuitud" class="form-control" id="longuitud" readonly />
                          </div>
                        </div>

                        <!-- Facebook -->
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="rs_facebook">Facebook</label>
                            <div class="input-group">                                          
                              <span class="input-group-text"><i class="fa-brands fa-facebook-f text-primary fa-lg"></i></span>
                              <input type="url" name="rs_facebook" class="form-control" id="rs_facebook" placeholder="URL red social" readonly />
                            </div>
                          </div>
                        </div>

                        <!-- Instagram -->
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="rs_instagram">Instagram</label>
                            <div class="input-group">                                          
                              <span class="input-group-text"><i class="fa-brands fa-instagram text-pink fa-lg"></i></span>
                              <input type="url" name="rs_instagram" class="form-control" id="rs_instagram" placeholder="URL red social" readonly />
                            </div>
                          </div>
                        </div>

                        <!-- TikTok -->
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="rs_web">Página Web</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                  <i class="fa-brands las la-globe-americas fa-lg"></i>
                                </span>
                              <input type="url" name="rs_web" class="form-control" id="rs_web" placeholder="URL Pag. web" readonly />
                            </div>
                          </div>
                        </div>


                        <!-- Horario-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 20px;">
                          <div class="form-group">
                            <label for="horario">Horario <sup class="text-danger">*</sup> </label> 
                            <textarea name="horario" id="horario" class="form-control" rows="3" readonly></textarea>
                          </div>
                        </div>

                      </div>

                      <div class="row" id="cargando-2-fomulario" style="display: none;" >
                        <div class="col-lg-12 text-center">
                          <i class="fas fa-spinner fa-pulse fa-6x"></i><br><br>
                          <h4>Cargando...</h4>
                        </div>
                      </div>
                      <button type="submit" style="display: none;" id="submit-form-actualizar-registro">Submit</button>
                    </form>
                  </div>
                  <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-warning editar"  onclick="activar_editar(1);">Editar</button>
                    <button type="submit" class="btn btn-success actualizar" id="actualizar_registro" style="display: none;">Actualizar</button>
                  </div>
                </div>
              </section>
              <!-- End::row-1 -->

            </div>
          </div>
                  

          <?php include("template/search_modal.php"); ?>
          <?php include("template/footer.php"); ?>

        </div>

        <?php include("template/scripts.php"); ?>
        <?php include("template/custom_switcherjs.php"); ?>    

        <script src="scripts/empresa.js"></script>

        <script> $(function () { $('[data-toggle="tooltip"]').tooltip(); }); </script>
      
      </body>

    </html>
  <?php  
  }
  ob_end_flush();

?>
