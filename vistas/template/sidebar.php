<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

  <!-- Start::main-sidebar-header -->
  <div class="main-sidebar-header">
    <a href="index.php" class="header-logo">
      <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
      <img src="../assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
      <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
      <img src="../assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
      <img src="../assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
      <img src="../assets/images/brand-logos/toggle-white.png" alt="logo" class="toggle-white">
    </a>
  </div>
  <!-- End::main-sidebar-header -->

  <!-- Start::main-sidebar -->
  <div class="main-sidebar" id="sidebar-scroll">

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open">
      <div class="slide-left" id="slide-left">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
          <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
        </svg>
      </div>
      <ul class="main-menu">
        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">I N I C I O</span></li>
        <!-- End::slide__category -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['dashboard'] == '1') { ?>
        <li class="slide">
          <a href="escritorio.php" class="side-menu__item">
            <i class="bx bx-home side-menu__icon"></i><span class="side-menu__label"> Dashboards</span>
          </a>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name"> L A N D I N G </span></li>
        <!-- End::slide__category -->
        
        <!-- Start::slide -->
        <?php  if ($_SESSION['landing_page'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class="bx bx-home side-menu__icon"></i>
            <span class="side-menu__label">Landing Page<span class="badge bg-warning-transparent ms-2">3</span></span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"> <a href="javascript:void(0)">Landing Page</a>  </li>
            <?php  if ($_SESSION['landing'] == '1') { ?>
            <li class="slide"> <a href="landing_disenio.php" class="side-menu__item">Diseño landing</a> </li>
            <?php } ?>
            <?php  if ($_SESSION['empresa'] == '1') { ?>
            <li class="slide"> <a href="empresa.php" class="side-menu__item">Empresa</a> </li>
            <?php } ?>
            <?php  if ($_SESSION['correo_landing'] == '1') { ?>
            <li class="slide"> <a href="landing_correo.php" class="side-menu__item">Correo</a> </li>         
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name"> W O R D P R E S S </span></li>
        <!-- End::slide__category -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['correo_inicio'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class="bx bx-file-blank side-menu__icon"></i>
            <span class="side-menu__label">Wordpress<span class="badge bg-secondary-transparent ms-2">New</span></span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"> <a href="javascript:void(0)">Wordpress</a> </li>
            <?php  if ($_SESSION['correo_wordpress'] == '1') { ?>
            <li class="slide"> <a href="correo_wordpress.php" class="side-menu__item">Correo Wordpress</a></li> 
            <?php } ?>                        
          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">S E G U R I D A D</span></li>
        <!-- End::slide__category -->

        <!-- Start::slide -->
        <?php  if ($_SESSION['administracion'] == '1') { ?>
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class="bx bx-medal side-menu__icon"></i>
            <span class="side-menu__label">Administracion</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>
          <ul class="slide-menu child1">
            <li class="slide side-menu__label1"><a href="javascript:void(0)">Administracion</a></li>
            <?php  if ($_SESSION['usuario'] == '1') { ?>
            <li class="slide"><a href="usuario.php" class="side-menu__item">Usuarios</a></li>     
            <?php } ?>       
            <?php  if ($_SESSION['usuario'] == '1') { ?>
            <li class="slide"><a href="persona.php" class="side-menu__item">Persona</a></li>     
            <?php } ?>  
            <?php  if ($_SESSION['cargos'] == '1') { ?>
            <li class="slide"><a href="usuario.php" class="side-menu__item">Cargos</a></li>     
            <?php } ?>  
            <?php  if ($_SESSION['tipo_persona'] == '1') { ?>
            <li class="slide"><a href="usuario.php" class="side-menu__item">Tipo Persona</a></li>     
            <?php } ?>  

          </ul>
        </li>
        <?php } ?>
        <!-- End::slide -->

        <!-- Start::slide__category -->
        <li class="slide__category"><span class="category-name">S O P O R T E</span></li>
        <!-- End::slide__category --> 

        <!-- Start::slide -->
        <li class="slide">
          <a href="https://wa.link/oetgkf" class="side-menu__item" target="_blank">
            <i class="bx bx-home side-menu__icon"></i><span class="side-menu__label"> Soporte Técnico</span>
          </a>
        </li>
        <!-- End::slide -->

        
      </ul>
      <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
          height="24" viewBox="0 0 24 24">
          <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
        </svg></div>
    </nav>
    <!-- End::nav -->

  </div>
  <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->