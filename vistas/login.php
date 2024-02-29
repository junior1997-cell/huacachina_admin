<!DOCTYPE html>
<html lang="es" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Login | Admin Landing </title>
  <meta name="Description" content="Responsive Admin Web Dashboard">
  <meta name="Author" content=" Technologies Private Limited">
  <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

  <!-- Favicon -->
  <link rel="icon" href="../assets/modulo/login/icon.png" type="image/x-icon">
  <!-- Main Theme Js -->
  <script src="../assets/js/authentication-main.js"></script>
  <!-- Bootstrap Css -->
  <link id="style" href="../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Style Css -->
  <link href="../assets/css/styles.min.css" rel="stylesheet">
  <!-- Icons Css -->
  <link href="../assets/css/icons.min.css" rel="stylesheet">
  <!-- swiper -->
  <link rel="stylesheet" href="../assets/libs/swiper/swiper-bundle.min.css">
  <!-- Prism CSS -->
  <link rel="stylesheet" href="../assets/libs/prismjs/themes/prism-coy.min.css">
  <!-- Sweetalerts CSS -->
  <link rel="stylesheet" href="../assets/libs/sweetalert2/sweetalert2.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../assets/libs/toastr/toastr.min.css">
  <!-- My Stylo -->
  <link href="../assets/css/style_new.css" rel="stylesheet">
</head>

<body class="bg-white">

  <!-- Start Switcher -->
  <?php include("template/switcher.php"); ?>
  
  <!-- End Switcher -->

  <div class="row authentication mx-0">

    <div class="col-xxl-7 col-xl-7 col-lg-12" style=" background-image: url('../assets/modulo/login/fondo_huacachina.webp'); background-size: cover; background-position: center center;" >
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-xxl-6 col-xl-7 col-lg-7 col-md-7 col-sm-8 col-12"  >
          <!--  #333333b5 -->
          <div class="p-5" style="background-color:#132f11b5; border-radius: 10px;">
            <div class="mb-3" style="text-align: center;">
              <a href="index.php" style="display: flex; justify-content: center; align-items: center;" >
                <img src="../assets/modulo/login/Logo.png" alt="" class="authentication-brand desktop-logo" style="height: 30%;">
                <img src="../assets/modulo/login/Logo.png" alt="" class="authentication-brand desktop-dark" style="height: 30%;">
              </a>
            </div>
            <p class="h3 fw-semibold mb-2" style="text-align: center; color: #f6f0b3;">Ingresar al sistema</p>
            <p class="mb-3 op-7 fw-normal" style="text-align: center;  color: #ffff; font-size: 15px;">Bienvenido de nuevo!</p>
            <!-- <div class="btn-list">
              <button class="btn btn-light"><svg class="google-svg" xmlns="http://www.w3.org/2000/svg" width="2443" height="2500" preserveAspectRatio="xMidYMid" viewBox="0 0 256 262">
                  <path fill="#4285F4" d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" />
                  <path fill="#34A853" d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" />
                  <path fill="#FBBC05" d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" />
                  <path fill="#EB4335" d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" />
                </svg>Sign In with google</button>
              <button class="btn btn-icon btn-light"><i class="ri-facebook-fill"></i></button>
              <button class="btn btn-icon btn-light"><i class="ri-twitter-fill"></i></button>
            </div>
            <div class="text-center my-5 authentication-barrier">
              <span>OR</span>
            </div> -->
            <form name="frmAcceso" id="frmAcceso" method="post">
              <div class="row gy-3">
                <div class="col-xl-12 mt-0">
                  <label for="logina" class="form-label text-white" >Usuario</label>
                  <input type="text" class="form-control form-control-lg" id="logina" placeholder="user name" required>
                </div>
                <div class="col-xl-12 mb-3">
                  <label for="clavea" class="form-label text-white d-block" >Contraseña<a href="https://wa.link/oetgkf" target="_blank" class="float-end" style="color: #f6f0b3;" >Olvidaste tu contraseña ?</a></label>
                  <div class="input-group">
                    <input type="password" class="form-control form-control-lg" id="clavea" placeholder="password" required>
                    <button class="btn btn-light" type="button" onclick="createpassword('clavea',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                  </div>
                  <div class="mt-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                      <label class="form-check-label fw-normal" for="defaultCheck1" style="color: #f6f0b3;">
                        Recordar contraseña ?
                      </label>
                    </div>
                  </div>
                </div>
                <div class="col-xl-12 d-grid mt-2">
                  <button type="submit" class="btn btn-lg btn-primary login-btn ">Iniciar sesión</button>
                </div>
              </div>
            </form>
            <div class="text-center">
              <p class="fs-12 text-muted mt-4 " style="color: #f6f0b3;" >¿No tienes una cuenta? <a href="https://wa.link/oetgkf" target="_blank" class="text-primary">Inscribirse</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xxl-5 col-xl-5 col-lg-5 d-xl-block d-none px-0">
      <div class="authentication-cover">
        <div class="aunthentication-cover-content rounded">
          <div class="swiper keyboard-control">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                  <div>
                    <div class="mb-5">
                      <img src="../assets/modulo/login/img_portal_login_1.png" class="authentication-image" alt="">
                    </div>
                    <h6 class="fw-semibold text-fixed-white">¿Listo para continuar?</h6>
                    <p class="fw-normal fs-14 op-7">
                    ¡Saludos! Nos alegra verte de nuevo por aquí. Para continuar donde lo dejaste y acceder a todas 
                    las increíbles funciones que ofrecemos, por favor, ingresa tu usuario y contraseña a continuación. 
                    ¡Gracias por elegirnos!

                    </p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                  <div>
                    <div class="mb-5">
                      <img src="../assets/modulo/login/img_portal_login_2.png" class="authentication-image" alt="">
                    </div>
                    <h6 class="fw-semibold text-fixed-white">¡Estamos emocionados de verte de nuevo!</h6>
                    <p class="fw-normal fs-14 op-7"> Esperamos que tu última visita haya sido memorable. Para continuar explorando y descubriendo todo lo que tenemos para ofrecer, por favor, inicia sesión.
                    </p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                  <div>
                    <div class="mb-5">
                      <img src="../assets/modulo/login/img_portal_login_3.png" class="authentication-image" alt="">
                    </div>
                    <h6 class="fw-semibold text-fixed-white">¡Estamos listos para continuar juntos!</h6>
                    <p class="fw-normal fs-14 op-7">Por favor, proporciona tus credenciales de inicio de sesión para acceder a tu cuenta y continuar tu viaje con nosotros.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- :::::::::::::::::::::::::::: Toast :::::::::::::::::::::::::::: -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
      <div id="user-incorrecto" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header text-default">
          <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/logo-short.png" alt="...">
          <strong class="me-auto">Usuario y/o Password incorrectos</strong>
          <small>1 seg</small>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bg-white"> Ingrese sus credenciales correctamente, o pida al administrador de sistema restablecer sus credenciales. </div>
      </div>

      <div id="error-servidor" class="toast colored-toast bg-danger text-fixed-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-fixed-white">
          <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/logo-short.png" alt="...">
          <strong class="me-auto">JDL anuncia</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bg-white text-black"> Error de conexion, si esto perciste contactar al ing de sistemas <b><a class="" href="https://wa.link/oetgkf" target="_blank">click aqui</a></b>. </div>
      </div>

      <div id="dangerToast" class="toast colored-toast bg-danger-transparent" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-fixed-white">
          <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/logo-short.png" alt="...">
          <strong class="me-auto">Ynex</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"> Your,toast message here. </div>
      </div>
    </div>
    <!-- /.toast-container -->
  </div>
  <!-- /.row -->

  <!-- jQuery 3.6.0 -->
  <script src="../assets/libs/jquery/jquery.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Swiper JS -->
  <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>
  <!-- Internal Sing-Up JS -->
  <script src="../assets/js/authentication.js"></script>
  <!-- Show Password JS -->
  <script src="../assets/js/show-password.js"></script>
  <!-- Prism JS -->
  <script src="../assets/libs/prismjs/prism.js"></script>
  <script src="../assets/js/prism-custom.js"></script>
  <!-- Sweetalerts JS -->
  <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
  <!-- <script src="../assets/js/sweet-alerts.js"></script> -->

  <!-- Toastr -->
  <script src="../assets/libs/toastr/toastr.min.js"></script>
  <script src="scripts/login.js"></script>

</body>

</html>