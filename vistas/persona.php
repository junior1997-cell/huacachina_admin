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
        
        <?php $title_page = "Inicio"; include("template/head.php"); ?>    

      </head> 

      <body id="body-persona" class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">

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
                    <button class="btn-modal-effect btn btn-primary label-btn m-r-10px" onclick="limpiar_form();" data-bs-effect="effect-super-scaled" data-bs-toggle="modal"  data-bs-target="#modal-agregar-persona"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                    <div>
                      <p class="fw-semibold fs-18 mb-0">Lista de Personas del sistema!</p>
                      <span class="fs-semibold text-muted">Administra de manera eficiente el registro de personas.</span>
                    </div>                
                  </div>
                </div>
                
                <div class="btn-list mt-md-0 mt-2">              
                  <nav>
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="javascript:void(0);">Pesona</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Administración</li>
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
                        
                        <table id="tabla-persona" class="table table-bordered w-100" style="width: 100%;">
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

          <div class="modal fade modal-effect" id="modal-agregar-persona" tabindex="-1" aria-labelledby="modal-agregar-personaLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-agregar-personaLabel1">Agregar Persona</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form name="form-agregar-persona" id="form-agregar-persona" method="POST" class="row g-3 needs-validation" novalidate>

                    <div class="tab-content" >
                      <div class="tab-pane fade show active text-muted" id="dato-persona-pane" role="tabpanel" tabindex="0">
                        <div class="row gy-2" id="cargando-1-fomulario">
                          <!-- id persona -->
                          <input type="hidden" name="idpersona" id="idpersona" />
                          <input type="hidden" name="idtipo_persona" id="idtipo_persona" value="1" />

                          <!-- Imgen -->
                          <div class="col-md-4 col-lg-4">
                            <div class="mb-4 d-sm-flex align-items-center">
                              <div class="mb-0 me-5">
                                <span class="avatar avatar-xxl avatar-rounded">
                                  <img src="../assets/images/faces/9.jpg" alt="" id="imagenmuestra" onerror="this.src='../assets/modulo/usuario/perfil/no-perfil.jpg';">
                                  <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge">
                                    <input type="file" class="position-absolute w-100 h-100 op-0" name="imagen" id="imagen">
                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                    <i class="fe fe-camera"></i>
                                  </a>
                                </span>
                              </div>
                              <div class="btn-group">
                                <a class="btn btn-primary" onclick="cambiarImagen()"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</a>
                                <a class="btn btn-light" onclick="removerImagen()"><i class="bi bi-trash fs-6"></i> Remover</a>
                              </div>
                            </div>
                          </div>                      

                          <!-- Tipo doc -->
                          <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                              <label for="tipo_documento" class="form-label">Tipo documento(*):</label>
                              <select class="form-control"  name="tipo_documento" id="tipo_documento">
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                                <option value="CEDULA">CEDULA</option>
                              </select>
                            </div>                        
                          </div>
                          <!--  Nro Doc -->
                          <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                              <label for="num_documento" class="form-label">Número(*):</label>
                              
                              <div class="input-group mb-3">                            
                                <input type="text" class="form-control" name="num_documento" id="num_documento" required>
                                <button class="btn btn-primary" type="button" onclick="consultaDniSunat();" id="icon-search-sr"><i class='bx bx-search-alt fs-5'></i></button>
                              </div>
                            </div>                                         
                          </div>
                          <!-- Nombre -->
                          <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                              <label for="nombres" class="form-label">Nombres(*):</label>
                              <input type="text" class="form-control" name="nombres" id="nombres" required>
                            </div>                                         
                          </div>

                          <!-- Apellidos
                          <div class="col-md-5 col-lg-5">
                            <div class="form-group">
                              <label for="apellidos" class="form-label">Apellidos(*):</label>
                              <input type="text" class="form-control" name="apellidos" id="apellidos" required>       
                            </div>                                  
                          </div> -->

                          <!-- fecha nacimiento -->
                          <div class="col-md-2 col-lg-3">
                            <div class="form-group">
                              <label for="nacimiento" class="form-label">Fecha Nacimiento (*) :</label>
                              <input type="date" class="form-control" name="nacimiento" id="nacimiento" 
                              onchange="calcular_edad('#nacimiento', '#edad', '.edad');"
                              required>
                              <input type="hidden" name="edad" id="edad" />
                            </div>                                            
                          </div>
                          <!-- Edad -->
                          <div class="col-md-1 col-lg-1">
                            <div class="form-group">
                              <label for="edad" class="form-label">Edad :</label>
                              <p class="edad" style="border: 1px solid #ced4da; border-radius: 4px; padding: 5px;">0 años.</p>
                            </div>                                            
                          </div>
                        
                          <!-- Direccion -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="direccion" class="form-label">Dirección :</label>
                              <input type="text" class="form-control" name="direccion" id="direccion" required>
                            </div>                                            
                          </div>
                          <!-- Correo -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="email" class="form-label">Correo :</label>
                              <input type="email" class="form-control" name="email" id="email" required>  
                            </div>                                       
                          </div>
                          <!-- Celular -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="telefono" class="form-label">Celular:</label>
                              <input type="text" class="form-control" name="telefono" id="telefono"  required> 
                            </div>                        
                          </div>
                        
                          <!-- Cargo -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cargo" class="form-label">Cargo:</label>
                              <select class="form-control" name="cargo" id="cargo">                                
                                <option value="1">Ninguno</option>
                                <option value="2">Administrador</option>
                                <option value="3">Secretaria</option>
                              </select>
                            </div>                                            
                          </div>

                        </div>
                        <div class="row" id="cargando-2-fomulario" style="display: none;" >
                          <div class="col-lg-12 text-center">                         
                            <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                            <h4 class="bx-flashing">Cargando...</h4>
                          </div>
                        </div>
                      </div>              
                    </div>   
                  <!-- Chargue -->
                    <div class="p-l-25px col-lg-12" id="barra_progress_persona_div" style="display: none;" >
                      <div  class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> 
                        <div id="barra_progress_persona" class="progress-bar" style="width: 0%"> <div class="progress-bar-value">0%</div> </div> 
                      </div>
                    </div>
                    <!-- Submit -->
                    <button type="submit" style="display: none;" id="submit-form-persona">Submit</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limpiar_form();"><i class="las la-times fs-lg"></i> Close</button>
                  <button type="button" class="btn btn-primary" id="guardar_registro_persona" ><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
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

        <script src="scripts/persona.js"></script>
        <script> $(function () { $('[data-toggle="tooltip"]').tooltip(); }); </script>

      
      </body>

    </html>
  <?php  
  }
  ob_end_flush();

?>
