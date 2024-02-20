<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); }//Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['correo_wordpress'] == 1) {
    
    require_once "../modelos/Landing_disenio.php";

    $landing_disenio  = new Landing_disenio($_SESSION['idusuario']);
    
    date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
    $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
    $scheme_host =  ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://localhost/front_jdl/admin/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/');

    // :::::::::::::::::::::::::::::::::::: D A T O S   D I S E N I O ::::::::::::::::::::::::::::::::::::::
    
    
    switch ($_GET["op"]) {   
      
      // :::::::::::::::::::::::::: S E C C I O N   D I S E N I O   ::::::::::::::::::::::::::
      case 'mostrar':
        $rspta = $landing_disenio->mostrar();
        echo json_encode($rspta);
      break; 
    
      
    
      // :::::::::::::::::::::::::: S E C C I O N   _ _ _ _ _ _  ::::::::::::::::::::::::::
    
     
      

      default: 
        $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
      break;
    }

  } else {
    $retorno = ['status'=>'nopermiso', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
    echo json_encode($retorno);
  }  
}

ob_end_flush();
?>
