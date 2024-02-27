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

          <?php if($_SESSION['empresa']==1) { ?>

          <!-- Start::app-content -->
          <div class="main-content app-content">
            <div class="container-fluid">

              <!-- Start::page-header -->
              <div class="d-md-flex d-block align-items-center justify-content-between my-3 page-header-breadcrumb">
                <div>
                  <div class="d-md-flex d-block align-items-center ">
                    <button class="btn-modal-effect btn btn-warning label-btn m-r-10px editar" onclick="activar_editar(1);"><i class="ri-edit-2-fill label-btn-icon me-2"></i> Editar</button>
                    <button class="btn-modal-effect btn btn-primary label-btn m-r-10px actualizar" id="guardar_registro_empresa" style="display: none;"><i class="ri-save-3-line label-btn-icon me-2"></i> Actualizar</button>                    

                    <!-- <button class="btn btn-warning m-r-10px editar" id="edit" onclick="activar_editar(1);">Editar</button>
                    <button class="btn btn-primary m-r-10px actualizar" type="submit" id="actualizar_registro" style="display: none;">Actualizar</button>
                    <button class="btn btn-primary m-r-10px registra_unico" style="display: none;" onclick="registrar_unico();">Guardar</button> -->
                    <div >
                      <p class="fw-semibold fs-18 mb-0"> Empresa</p>
                      <span class="fs-semibold text-muted">Gestiona los datos de tu empresa.</span>
                    </div>
                  </div>
                </div>

                <div class="btn-list mt-md-0 mt-2">
                  <nav>
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="javascript:void(0);">Landing</a></li>
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
                      <div class="row" id="cargando-1-fomulario" style="display: none;">
                        <!-- id -->
                        <input type="hidden" name="idnosotros" id="idnosotros" />
                        
                        
                        <div class="col-lg-6 " >

                          <div class="row">
                            <!-- Grupo -->
                            <div class="col-12 pl-0">
                              <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b>DATOS EMPRESA</b></label></div>
                            </div>
                          </div>

                          <div class="card-body" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 3px rgb(0 0 0 / 60%);">
                            <div class="row ">
                              <!-- RUC -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="tipo_documento">Tipo Doc. <sup class="text-danger">*</sup></label>
                                  <select name="tipo_documento" id="tipo_documento" class="form-control inpur_edit" readonly>
                                    <option value="RUC">RUC</option>
                                  </select>
                                </div>
                              </div>

                              <!-- DOCUMENTO -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="num_documento">N° de documento <sup class="text-danger">*</sup></label>
                                  <div class="input-group">
                                    <input type="number" name="num_documento" class="form-control inpur_edit" id="num_documento" placeholder="N° de documento" readonly />
                                    <span class="input-group-text" style="cursor: pointer;" data-bs-toggle="tooltip"  title="Buscar Reniec/SUNAT" onclick="buscar_sunat_reniec('');">
                                      <i class="fas fa-search text-primary" id="search"></i>
                                      <i class="fa fa-spinner fa-pulse fa-fw fa-lg text-primary" id="charge" style="display: none;"></i>
                                    </span>
                                  </div>
                                </div>
                              </div>

                              <!-- Nombre Empresa -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-12" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="nombre">Nombre <sup class="text-danger">*</sup></label>
                                  <input type="text" name="nombre" class="form-control inpur_edit" id="nombre" readonly />
                                </div>
                              </div>

                              <!-- direccion -->
                              <div class="col-6 col-sm-6 col-md-6 col-lg-12" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="direccion">Dirección <sup class="text-danger">*</sup></label>
                                  <input type="text" name="direccion" class="form-control inpur_edit" id="direccion" readonly />
                                </div>
                              </div>

                              <!-- mapa -->
                              <div class="col-6 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="mapa"><span class="badge rounded-pill bg-outline-info cursor-pointer" data-bs-toggle="tooltip"  title="Previsualizar" onclick="view_mapa();"><i class="las la-eye fa-lg"></i></span> Mapa Link <sup class="text-danger">*</sup></label>
                                  <textarea  class="form-control inpur_edit"  name="mapa" id="mapa" id="" cols="30" rows="2" readonly></textarea>                                  
                                </div>
                              </div>

                              <!-- Horario-->
                              <div class="col-12 col-sm-12 col-md-12 col-lg-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="horario">Horario <sup class="text-danger">*</sup> </label> 
                                  <textarea name="horario" id="horario" class="form-control inpur_edit" rows="2" readonly></textarea>
                                </div>
                              </div>

                            </div>
                          </div>                            
                        </div>                        
                        
                        <div class="col-lg-6 ">

                          <div class="row">
                            <!-- Grupo -->
                            <div class="col-12 pl-0">
                            <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b>CONTACTO</b></label></div>
                            </div>
                          </div>

                          <div class="card-body" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 3px rgb(0 0 0 / 60%);">
                            <div class="row">
                              <!-- Correo -->
                              <div class="col-6 col-sm-6 col-md-6 col-lg-12" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="correo">Correo <sup class="text-danger">*</sup></label>
                                  <input type="text" name="correo" class="form-control inpur_edit" id="correo" readonly />
                                </div>
                              </div>

                              <!-- celular --> 
                              <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="celular">Celular WhatsApp</label>
                                  <div class="input-group">                                          
                                    <span class="input-group-text"><i class="ri-whatsapp-line text-success fa-lg"></i></span>
                                    <input type="tel" name="celular" class="form-control inpur_edit" id="celular" placeholder="Celular" readonly />
                                  </div>
                                </div>
                              </div>

                              <!-- Teléfono -->
                              <div class="col-6 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="telefono">Teléfono Fijo<sup class="text-danger">*</sup></label>
                                  <input type="text" name="telefono" class="form-control inpur_edit" id="telefono" readonly />
                                </div>
                              </div>

                              <!-- Grupo WhatsApp --> 
                              <div class="col-12 col-sm-6 col-md-6 col-lg-12" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="link_grupo_whats">Link Grupo WhatsApp</label>
                                  <div class="input-group">                                          
                                    <span class="input-group-text"><i class="ri-group-line text-success fa-lg"></i></span>
                                    <input type="url" name="link_grupo_whats" id="link_grupo_whats" class="form-control inpur_edit"  placeholder="Celular" readonly />
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>                        

                        <div class="col-lg-12 pt-3">

                          <div class="row">
                            <!-- Grupo -->
                            <div class="col-12 pl-0">
                            <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b>REDES SOCIALES</b></label></div>
                            </div>
                          </div>

                          <div class="card-body" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 3px rgb(0 0 0 / 60%);">
                            <div class="row">
                              <!-- Facebook -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-4" style="margin-bottom: 20px;">
                                <div class="row">
                                  <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                      <label class="form-label" for="rs_facebook_etiqueta">Facebook Etiqueta</label>
                                      <div class="input-group">                                          
                                        <span class="input-group-text"><i class="fa-brands fa-facebook-f text-blue fa-lg"></i></span>
                                        <input type="text" name="rs_facebook_etiqueta" class="form-control inpur_edit" id="rs_facebook_etiqueta" placeholder="Etiqueta social" readonly />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                      <label class="form-label" for="rs_facebook">Facebook Link</label>
                                      <div class="input-group">                                          
                                        <span class="input-group-text"><i class="ti ti-link text-blue fa-lg"></i></span>
                                        <input type="url" name="rs_facebook" class="form-control inpur_edit" id="rs_facebook" placeholder="URL red social" readonly />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                              </div>

                              <!-- Instagram -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-4" style="margin-bottom: 20px;">
                                <div class="row">
                                  <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                      <label class="form-label" for="rs_instagram_etiqueta">Instagram Etiqueta</label>
                                      <div class="input-group">                                          
                                        <span class="input-group-text"><i class="fa-brands fa-instagram text-pink fa-lg"></i></span>
                                        <input type="text" name="rs_instagram_etiqueta" class="form-control inpur_edit" id="rs_instagram_etiqueta" placeholder="Etiqueta red social" readonly />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                      <label class="form-label" for="rs_instagram">Instagram Link</label>
                                      <div class="input-group">                                          
                                        <span class="input-group-text"><i class="ti ti-link text-pink fa-lg"></i></span>
                                        <input type="url" name="rs_instagram" class="form-control inpur_edit" id="rs_instagram" placeholder="URL red social" readonly />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                              </div>

                              <!-- Página Web -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-4" style="margin-bottom: 20px;">
                                <div class="row">
                                  <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                      <label class="form-label" for="rs_web_etiqueta">Página Web Etiqueta</label>
                                      <div class="input-group">
                                          <span class="input-group-text" id="basic-addon1">
                                            <i class="fa-brands las la-globe-americas fa-lg"></i>
                                          </span>
                                        <input type="text" name="rs_web_etiqueta" class="form-control inpur_edit" id="rs_web_etiqueta" placeholder="Etiqueta Pag. web" readonly />
                                      </div>
                                    </div>
                                  </div> <!-- /.col -->
                                  <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                      <label class="form-label" for="rs_web">Página Web Link</label> 
                                      <div class="input-group">
                                          <span class="input-group-text" id="basic-addon1">
                                            <i class="ti ti-link fa-lg"></i>
                                          </span>
                                        <input type="url" name="rs_web" class="form-control inpur_edit" id="rs_web" placeholder="URL Pag. web" readonly />
                                      </div>
                                    </div>
                                  </div> <!-- /.col -->
                                </div> <!-- /.row -->                                
                              </div> <!-- /.col -->  

                            </div>
                          </div>
                        </div>                        

                        <!-- Longuitud -->
                        <div class="col-6 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 20px; display: none;">
                          <div class="form-group">
                            <label for="longuitud">Longuitud <sup class="text-danger">*</sup></label>
                            <input type="text" name="longuitud" class="form-control" id="longuitud" readonly />
                          </div>
                        </div>                        

                      </div>

                      <div class="row" id="cargando-2-fomulario"  >
                        <div class="col-lg-12 text-center">
                          <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                          <h4 class="bx-flashing mt-2" >Cargando...</h4>
                        </div>
                      </div>
                      <button type="submit" style="display: none;" id="submit-form-empresa">Submit</button>
                    </form>
                  </div>
                  <div class="card-footer d-flex justify-content-end">
                    
                  </div>
                </div>
              </section>
              <!-- End::row-1 -->

            </div>
          </div>

          <?php } else { $title_submodulo ='Empresa'; $descripcion ='Empresa del sistema!'; $title_modulo = 'Landing Page'; include("403_error.php"); }?>         

          
          <div class="modal fade modal-effect" id="modal-agregar-mapa" tabindex="-1" aria-labelledby="modal-agregar-usuarioLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-agregar-usuarioLabel1">Previsualizacion del Mapa</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body preview-mapa">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" ><i class="las la-times fs-lg"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div>

          <?php include("template/search_modal.php"); ?>
          <?php include("template/footer.php"); ?>

        </div>

        <?php include("template/scripts.php"); ?>
        <?php include("template/custom_switcherjs.php"); ?>    

        <!-- Api Mapa -->
        <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJZ5VXawUSvX2v-QuV_JwQb6_j-EP7oyk&callback=initMap">	</script>
        <script>  
          function initMap() {console.log('mapa cargado');}
        </script>

        <script src="scripts/empresa.js"></script>

        <script> $(function () { $('[data-bs-toggle="tooltip"]').tooltip(); }); </script>
      
      </body>

    </html>
  <?php  
  }
  ob_end_flush();

?>
