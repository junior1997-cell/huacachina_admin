<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); }//Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['correo_wordpress'] == 1) {
    
    require_once "../modelos/Correo_wordpress.php";

    $correo_wordpress  = new Correo_wordpress($_SESSION['idusuario']);
    
    date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
    $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
    $scheme_host =  ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://localhost/front_jdl/admin/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/');

    // :::::::::::::::::::::::::::::::::::: D A T O S   C O M P R A ::::::::::::::::::::::::::::::::::::::
    $idcompra_producto  = isset($_POST["idcompra_producto"]) ? limpiarCadena($_POST["idcompra_producto"]) : "";
    $idproveedor        = isset($_POST["idproveedor"]) ? limpiarCadena($_POST["idproveedor"]) : "";
    $num_doc            = isset($_POST["num_doc"]) ? limpiarCadena($_POST["num_doc"]) : "";  

    switch ($_GET["op"]) {   

      
      // :::::::::::::::::::::::::: S E C C I O N   C O R R E O   ::::::::::::::::::::::::::

      case 'mostrar_productos':
    
        // $rspta = $correo_wordpress->mostrar($idproducto_pro);
        // echo json_encode($rspta, true);
    
      break; 
    
      case 'tbla_principal':
        $rspta = $correo_wordpress->tbla_principal( '1568' );
        
        //Vamos a declarar un array
        $data = []; $cont = 1;
        
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $reg) {

            $array_datos = unserialize($reg['form_value']);

            $data[] = [
              "0" => $cont,
              "1" => $reg['fecha_12h'],
              "2" => '<span class="text-primary font-weight-bold" >' . $array_datos['Nombres'] . '</span>',              
              "3" => $array_datos['Telefono'],
              "4" => $array_datos['Correo'],
              "5" => '<textarea cols="30" rows="1" class="textarea_datatable" readonly="">' . $array_datos['Horario'] . '</textarea>',
              "6" => $array_datos['Modalidad de informacion'],
              "7" => $array_datos['Monto inicial con el que cuenta'],
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
