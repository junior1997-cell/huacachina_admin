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
    $idlanding_disenio = isset($_POST["idlanding_disenio"]) ? limpiarCadena($_POST["idlanding_disenio"]) : "";

    $f_titulo         = isset($_POST["f_titulo"]) ? limpiarCadena($_POST["f_titulo"]) : "";
    $f_descripcion    = isset($_POST["f_descripcion"]) ? limpiarCadena($_POST["f_descripcion"]) : "";
    $f_img_fondo      = isset($_POST["doc_old_1"]) ? limpiarCadena($_POST["doc_old_1"]) : "";
    $f_img_promocion  = isset($_POST["doc_old_2"]) ? limpiarCadena($_POST["doc_old_2"]) : "";

    $fe_titulo        = isset($_POST["fe_titulo"]) ? limpiarCadena($_POST["fe_titulo"]) : "";
    $fe_descripcion   = isset($_POST["fe_descripcion"]) ? limpiarCadena($_POST["fe_descripcion"]) : "";
    $fe_img_fondo     = isset($_POST["doc_old_3"]) ? limpiarCadena($_POST["doc_old_3"]) : "";
    
    
    switch ($_GET["op"]) {   
      
      // :::::::::::::::::::::::::: S E C C I O N   D I S E N I O   ::::::::::::::::::::::::::
      case 'mostrar':
        $rspta = $landing_disenio->mostrar();
        echo json_encode($rspta);
      break; 

      case 'guardar_y_editar':
        
        //guardar f_img_fondo fondo
        if ( !file_exists($_FILES['doc1']['tmp_name']) || !is_uploaded_file($_FILES['doc1']['tmp_name']) ) {
          $f_img_fondo = $_POST["doc_old_1"];
          $flat_img1 = false; 
        } else {          
          $ext1 = explode(".", $_FILES["doc1"]["name"]);
          $flat_img1 = true;
          $f_img_fondo = $date_now . '__' . random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext1);
          move_uploaded_file($_FILES["doc1"]["tmp_name"], "../assets/modulo/landing_disenio/" . $f_img_fondo);          
        }

        //guardar f_img_promocion bono
        if ( !file_exists($_FILES['doc2']['tmp_name']) || !is_uploaded_file($_FILES['doc2']['tmp_name']) ) {
          $f_img_promocion = $_POST["doc_old_2"];
          $flat_img2 = false;
        } else {           
          $ext2 = explode(".", $_FILES["doc2"]["name"]);
          $flat_img2 = true;
          $f_img_promocion = $date_now . '__' . random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext2);
          move_uploaded_file($_FILES["doc2"]["tmp_name"], "../assets/modulo/landing_disenio/" . $f_img_promocion);
        }

        //guardar fe_img_fondo fondo
        if ( !file_exists($_FILES['doc3']['tmp_name']) || !is_uploaded_file($_FILES['doc3']['tmp_name']) ) {
          $fe_img_fondo = $_POST["doc_old_3"];
          $flat_img1 = false; 
        } else {          
          $ext1 = explode(".", $_FILES["doc3"]["name"]);
          $flat_img1 = true;
          $fe_img_fondo = $date_now . '__' . random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext1);
          move_uploaded_file($_FILES["doc3"]["tmp_name"], "../assets/modulo/landing_disenio/" . $fe_img_fondo);          
        }

        if ( empty($idlanding_disenio) ) { #Creamos el registro

          $rspta = $landing_disenio->insertar($f_titulo,$f_descripcion,$fe_titulo,$fe_descripcion,$f_img_fondo,$f_img_promocion, $fe_img_fondo);
          echo json_encode($rspta, true);

        } else { # Editamos el registro

          if ($flat_img1 == true || empty($f_img_fondo)) {
            $datos_f1 = $landing_disenio->obtenerImg($idlanding_disenio);
            $img1_ant = $datos_f1['data']['f_img_fondo'];
            if (!empty($img1_ant)) { unlink("../assets/modulo/landing_disenio/" . $img1_ant); }         
          }
  
          if ( $flat_img2 == true || empty($f_img_promocion)) { 
            $datos_f2 = $landing_disenio->obtenerImg($idlanding_disenio);
            $img2_ant = $datos_f2['data']['f_img_promocion'];
            if (!empty($img2_ant)) { unlink("../assets/modulo/landing_disenio/" . $img2_ant); }
          }

          if ( $flat_img2 == true || empty($fe_img_fondo)) { 
            $datos_f2 = $landing_disenio->obtenerImg($idlanding_disenio);
            $img3_ant = $datos_f2['data']['fe_img_fondo'];
            if (!empty($img3_ant)) { unlink("../assets/modulo/landing_disenio/" . $img3_ant); }
          }
  
          $rspta = $landing_disenio->editar($idlanding_disenio,$f_titulo,$f_descripcion,$fe_titulo,$fe_descripcion,$f_img_fondo,$f_img_promocion, $fe_img_fondo);
          echo json_encode($rspta, true);
        }        

        
      break;      
    
    
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
