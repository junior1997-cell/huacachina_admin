<?php
ob_start();
if (strlen(session_id()) < 1) {
  session_start();
} //Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status' => 'login', 'message' => 'Tu sesion a terminado pe, inicia nuevamente', 'data' => []];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['dashboard'] == 1) {

    require_once "../modelos/Reportes_correo_w.php";

    $reportes_w  = new Reportes_correo_w($_SESSION['idusuario']);

    date_default_timezone_set('America/Lima');
    $date_now = date("d_m_Y__h_i_s_A");
    $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
    $scheme_host =  ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://localhost/front_jdl/admin/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/');

    switch ($_GET["op"]) {

      case 'reporte_correo_w':
        $id = '1568';
        $anio = isset($_POST['anio']) ? $_POST['anio'] : null;
        $mes = isset($_POST['mes']) ? $_POST['mes'] : null;
        $rspta = $reportes_w->reportes_wordpress($id, $anio, $mes);
        echo json_encode($rspta, true);    
      break; 

      case 'list_anios_w':
        $rspta = $reportes_w->listar('1568');
        echo json_encode($rspta, true);
        break;

      default:
        $rspta = ['status' => 'error_code', 'message' => 'Te has confundido en escribir en el <b>swich.</b>', 'data' => []];
        echo json_encode($rspta, true);
        break;
    }


  } else {
    $retorno = ['status' => 'nopermiso', 'message' => 'Tu sesion a terminado pe, inicia nuevamente', 'data' => []];
    echo json_encode($retorno);
  }
}

ob_end_flush();
?>
