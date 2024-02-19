<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); }//Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['correo_landing'] == 1) {
    
    require_once "../modelos/Landing_correo.php";

    $landing_correo  = new Landing_correo($_SESSION['idusuario']);
    
    date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
    $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
    $scheme_host =  ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://localhost/front_jdl/admin/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/');

    // :::::::::::::::::::::::::::::::::::: D A T O S   C O M P R A ::::::::::::::::::::::::::::::::::::::
    $idcompra_producto  = isset($_POST["idcompra_producto"]) ? limpiarCadena($_POST["idcompra_producto"]) : "";
    $idproveedor        = isset($_POST["idproveedor"]) ? limpiarCadena($_POST["idproveedor"]) : "";
    $num_doc            = isset($_POST["num_doc"]) ? limpiarCadena($_POST["num_doc"]) : "";  

    switch ($_GET["op"]) {   

      
      // :::::::::::::::::::::::::: S E C C I O N   C O R R E O   ::::::::::::::::::::::::::

      case 'papelera':    
        $rspta = $landing_correo->papelera($_GET["id_tabla"]);
        echo json_encode($rspta, true);    
      break; 

      case 'eliminar':    
        $rspta = $landing_correo->eliminar($_GET["id_tabla"]);
        echo json_encode($rspta, true);    
      break; 
    
      case 'tbla_principal':
        $rspta = $landing_correo->tbla_principal( );
        
        //Vamos a declarar un array
        $data = []; $cont = 1;
        
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $reg) {           

            $data[] = [
              "0" => $cont,
              "1" => '<div class="hstack gap-2 fs-15">' .                
              '<button  class="btn btn-icon btn-sm btn-danger-light product-btn" onclick="eliminar_correo(' . $reg['idlanding_correo']. ',\''. $reg['nombres'] . '\')" data-bs-toggle="tooltip" title="Eliminar o papelera"><i class="ri-delete-bin-line"></i></button>'.               
              '</div>',
              "2" => $reg['fecha_12h'],
              "3" => $reg['day_name'],
              "4" => '<span class="text-primary font-weight-bold" >' . $reg['nombres'] . '</span>',              
              "5" => '<a href="tel:+51'. $reg['celular'].'">'. $reg['celular'].'</a>',               
            ];
            $cont++;
          }
          $results = [
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "data" => $data,
          ];
          echo json_encode($results, true);
        } else {
          echo $rspta['code_error'] .' - '. $rspta['message'] .' '. $rspta['data'];
        }
    
      break;
    
      // :::::::::::::::::::::::::: S E C C I O N   R E P O R T E S  ::::::::::::::::::::::::::
    
      case 'reporte':    
        $rspta = $landing_correo->reporte_correo();
        echo json_encode($rspta, true);    
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
