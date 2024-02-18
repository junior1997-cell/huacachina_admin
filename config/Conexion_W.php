<?php
require_once "global_nube.php";
//require_once "global_nube.php";
require "../config/funcion_general.php";

$conexion_w = new mysqli(DB_HOST, DB_USERNAME_W, DB_PASSWORD_W, DB_NAME_W);

$id_usr_sesion 			=  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
$id_empresa_sesion 	= isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;

mysqli_query($conexion_w, 'SET NAMES "' . DB_ENCODE . '"');         # Para el tipo de datos, ejemlo: UTF8
mysqli_query($conexion_w, "SET @id_usr_sesion ='$id_usr_sesion' "); # Para saber quien hizo el CRUD
mysqli_query($conexion_w, "SET time_zone = 'America/Lima';");       # Cambia el horario local: America/Lima
mysqli_query($conexion_w, "SET lc_time_names = 'es_ES';");          # Cambia el idioma a español en fechas

//Si tenemos un posible error en la conexión lo mostramos
if (mysqli_connect_errno()) {
  printf("Falló conexión a la base de datos: %s\n", mysqli_connect_error());
  exit();
}

if (!function_exists('ejecutarConsulta_W')) {

  function ejecutarConsulta_W($sql, $crud = 'R' ) {
    global $conexion_w; mysqli_query($conexion_w, "SET @crud ='$crud' ");
    $query = $conexion_w->query($sql);
    if ($conexion_w->error) {
      try {
        throw new Exception("MySQL error <b> $conexion_w->error </b> Query:<br> $query", $conexion_w->errno);
      } catch (Exception $e) {
        //echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >"; echo nl2br($e->getTraceAsString());
        return array( 
          'status'      => false, 
          'code_error'  => $e->getCode(), 
          'message'     => $e->getMessage(), 
          'data'        => '<br><b>Rutas de errores:</b> <br>'.nl2br($e->getTraceAsString()),
        );          
      }
    } else {
      return array( 
        'status'        => true, 
        'code_error'    => $conexion_w->errno, 
        'message'       => 'Salió todo ok, en ejecutarConsulta_W()', 
        'data'          => $query, 
        'id_tabla'      => $conexion_w->insert_id,
        'affected_rows' => $conexion_w->affected_rows,
        'sqlstate'      => $conexion_w->sqlstate,
        'field_count'   => $conexion_w->field_count,
        'warning_count' => $conexion_w->warning_count, 
      );
    }
  }

  function ejecutarConsultaSimpleFila_W($sql) {
    global $conexion_w;
    $query = $conexion_w->query($sql);
    if ($conexion_w->error) {
      try {
        throw new Exception("MySQL error <b> $conexion_w->error </b> Query:<br> $query", $conexion_w->errno);
      } catch (Exception $e) {
        //echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >"; echo nl2br($e->getTraceAsString());
        $data_errores = array( 
          'status'      => false, 
          'code_error'  => $e->getCode(), 
          'message'     => $e->getMessage(), 
          'data'        => '<br><b>Rutas de errores:</b> <br>'.nl2br($e->getTraceAsString()),
        );
        return $data_errores;
      }

    } else {
      $row = $query->fetch_assoc();
      return array( 
        'status'        => true, 
        'code_error'    => $conexion_w->errno, 
        'message'       => 'Salió todo ok, en ejecutarConsultaSimpleFila_W()', 
        'data'          => $row, 
        'id_tabla'      => '',
        'affected_rows' => $conexion_w->affected_rows,
        'sqlstate'      => $conexion_w->sqlstate,
        'field_count'   => $conexion_w->field_count,
        'warning_count' => $conexion_w->warning_count, 
      );
    }
  }

  function ejecutarConsultaArray_W($sql) {
    global $conexion_w;  //$data= Array();	$i = 0;

    $query = $conexion_w->query($sql);

    if ($conexion_w->error) {
      try {
        throw new Exception("MySQL error <b> $conexion_w->error </b> Query:<br> $query", $conexion_w->errno);
      } catch (Exception $e) {
        //echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >"; echo nl2br($e->getTraceAsString());
        return array( 
          'status' => false, 
          'code_error'  => $e->getCode(), 
          'message'     => $e->getMessage(), 
          'data'        => '<br><b>Rutas de errores:</b> <br>'.nl2br($e->getTraceAsString()),
        );          
      }
    } else {
      for ($data = []; ($row = $query->fetch_assoc()); $data[] = $row);
      return  array( 
        'status'        => true, 
        'code_error'    => $conexion_w->errno, 
        'message'       => 'Salió todo ok, en ejecutarConsultaArray_W()', 
        'data'          => $data, 
        'id_tabla'      => '',
        'affected_rows' => $conexion_w->affected_rows,
        'sqlstate'      => $conexion_w->sqlstate,
        'field_count'   => $conexion_w->field_count,
        'warning_count' => $conexion_w->warning_count, 
      );
    }
  }

  function ejecutarConsulta_retornarID_W($sql, $crud = 'R') {
    global $conexion_w; mysqli_query($conexion_w, "SET @crud ='$crud' ");
    $query = $conexion_w->query($sql);
    if ($conexion_w->error) {
      try {
        throw new Exception("MySQL error <b> $conexion_w->error </b> Query:<br> $query", $conexion_w->errno);
      } catch (Exception $e) {
        //echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >"; echo nl2br($e->getTraceAsString());
        return array( 
          'status' => false, 
          'code_error'  => $e->getCode(), 
          'message'     => $e->getMessage(), 
          'data'        => '<br><b>Rutas de errores:</b> <br>'.nl2br($e->getTraceAsString()),
        );          
      }
    } else {
      return  array( 
        'status' => true, 
        'code_error'    => $conexion_w->errno, 
        'message'       => 'Salió todo ok, en ejecutarConsulta_retornarID_W()', 
        'data'          => $conexion_w->insert_id, 
        'id_tabla'      => $conexion_w->insert_id,
        'affected_rows' => $conexion_w->affected_rows,
        'sqlstate'      => $conexion_w->sqlstate,
        'field_count'   => $conexion_w->field_count,
        'warning_count' => $conexion_w->warning_count, 
      );
    }
  }

  function limpiarCadena_W($str) {
    // htmlspecialchars($str);
    global $conexion_w;
    $str = mysqli_real_escape_string($conexion_w, trim($str));
    return $str;
  }

  function encodeCadenaHtml_W($str) {
    // htmlspecialchars($str);
    global $conexion_w;
    $encod = "UTF-8";
    $str = mysqli_real_escape_string($conexion_w, trim($str));
    return htmlspecialchars($str, ENT_QUOTES);
  }

  function decodeCadenaHtml_W($str) {
    $encod = "UTF-8";
    return htmlspecialchars_decode($str, ENT_QUOTES);
  }
}

?>
