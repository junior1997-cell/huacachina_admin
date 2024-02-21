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
    $idlanding_disenio       = isset($_POST["idlanding_disenio"]) ? limpiarCadena($_POST["idlanding_disenio"]) : "";

    $titulo       = isset($_POST["titulo"]) ? limpiarCadena($_POST["titulo"]) : "";
    $descripcion  = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
    $imagen       = isset($_POST["doc1"]) ? limpiarCadena($_POST["doc1"]) : "";
    
    
    switch ($_GET["op"]) {   
      
      // :::::::::::::::::::::::::: S E C C I O N   D I S E N I O   ::::::::::::::::::::::::::
      case 'mostrar':
        $rspta = $landing_disenio->mostrar();
        echo json_encode($rspta);
      break; 

      case 'actualizar':
        if (!file_exists($_FILES['doc1']['tmp_name']) || !is_uploaded_file($_FILES['doc1']['tmp_name'])) {
          $imagen = $_POST["doc_old_1"];
          $flat_img1 = false;
        } else {
          //guardar imagen
          $ext1 = explode(".", $_FILES["doc1"]["name"]);
          $flat_img1 = true;
          $imagen = $date_now . '__' . random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext1);
          move_uploaded_file($_FILES["doc1"]["tmp_name"], "../assets/images/landing_disenio/" . $imagen);
        }

        if ($flat_img1 == true) {
          $datos_f1 = $landing_disenio->obtenerImg($idlanding_disenio);
          $img1_ant = $datos_f1['data']['img_fondo'];
          if (!empty($img1_ant)) { unlink("../assets/images/landing_disenio/" . $img1_ant); }
        }

        $rspta = $landing_disenio->editar($idlanding_disenio,$titulo,$descripcion,$imagen);
        echo json_encode($rspta, true);
        
      
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
