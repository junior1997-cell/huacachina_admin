<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); }//Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['empresa'] == 1) {
    
    require_once "../modelos/Empresa.php";

    $empresa = new Empresa();
    
    date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
    $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
    $scheme_host =  ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://localhost/front_jdl/admin/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/');

    // :::::::::::::::::::::::::::::::::::: D A T O S   E M P R E S A ::::::::::::::::::::::::::::::::::::::
    $id             = isset($_POST["idnosotros"])? limpiarCadena($_POST["idnosotros"]):"";
    $direccion      = isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
    $nombre         = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $tipo_documento = isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
    $num_documento  = isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
    $mapa           = isset($_POST["mapa"])? limpiarCadena($_POST["mapa"]):"";    
    $horario        = isset($_POST["horario"])? limpiarCadena($_POST["horario"]):"";

    $correo           = isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
    $celular          = isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
    $telefono         = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
    $link_grupo_whats = isset($_POST["link_grupo_whats"])? limpiarCadena($_POST["link_grupo_whats"]):"";  

    $rs_facebook            = isset($_POST["rs_facebook"])? limpiarCadena($_POST["rs_facebook"]):"";
    $rs_instagram           = isset($_POST["rs_instagram"])? limpiarCadena($_POST["rs_instagram"]):"";
    $rs_web                 = isset($_POST["rs_web"])? limpiarCadena($_POST["rs_web"]):"";
    $rs_facebook_etiqueta   = isset($_POST["rs_facebook_etiqueta"])? limpiarCadena($_POST["rs_facebook_etiqueta"]):"";
    $rs_instagram_etiqueta  = isset($_POST["rs_instagram_etiqueta"])? limpiarCadena($_POST["rs_instagram_etiqueta"]):"";
    $rs_web_etiqueta        = isset($_POST["rs_web_etiqueta"])? limpiarCadena($_POST["rs_web_etiqueta"]):"";

    switch ($_GET["op"]) {   

      
      // :::::::::::::::::::::::::: S E C C I O N   E M P R E S A   ::::::::::::::::::::::::::

      case 'mostrar_empresa':
        $rspta = $empresa->mostrar_empresa();
        echo json_encode($rspta);
      break;
      
      case 'actualizar_datos_empresa':
        if (empty($id)){
          $rspta = ['status'=> 'error_personalizado', 'user'=>$_SESSION["nombre"], 'message'=>"No no modifique el codigo por favor", 'data'=>[]];
          json_encode( $rspta, true) ;
        }else {
          // editamos un documento existente
          $rspta=$empresa->actualizar_datos_empresa( $id, $direccion,$nombre,$tipo_documento, $num_documento,$celular,$telefono, $link_grupo_whats,$mapa,$correo,$horario, 
          $rs_facebook,$rs_instagram,$rs_web, $rs_facebook_etiqueta, $rs_instagram_etiqueta, $rs_web_etiqueta);          
          echo json_encode( $rspta, true) ;
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
