<?php
ob_start();

if (strlen(session_id()) < 1) {
  session_start();
} //Validamos si existe o no la sesión

require_once "../modelos/Persona.php";
$persona = new Persona();

date_default_timezone_set('America/Lima');
$date_now = date("d_m_Y__h_i_s_A");
$imagen_error = "this.src='../dist/svg/404-v2.svg'";
$toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';

$idpersona         = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$nombres           = isset($_POST["nombres"]) ? limpiarCadena($_POST["nombres"]) : "";
$apellidos         = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$tipo_documento    = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento     = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion         = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono          = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email             = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cargo             = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$idtipo_persona    = isset($_POST["idtipo_persona"]) ? limpiarCadena($_POST["idtipo_persona"]) : "";
$nacimiento        = isset($_POST["nacimiento"]) ? limpiarCadena($_POST["nacimiento"]) : "";
$edad              = isset($_POST["edad"]) ? limpiarCadena($_POST["edad"]) : "";
$imagen            = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
// $imagen1 ='';
switch ($_GET["op"]) {

  case 'guardaryeditar':
    
    if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {

      $imagen = $_POST["imagenactual"]; $flat_img1 = false;

    } else {

      $ext = explode(".", $_FILES["imagen"]["name"]); $flat_img1 = true;

      if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {

        $imagen = $date_now . '__' . random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext);

        move_uploaded_file($_FILES["imagen"]["tmp_name"], "../assets/modulo/persona/" . $imagen);
        
      }
    }
     
    if (empty($idpersona)) {

      $rspta = $persona->insertar($nombres, $tipo_documento, $num_documento, $direccion, $telefono, $email, 
      $cargo, $idtipo_persona, $nacimiento,$edad, $imagen);
      echo json_encode($rspta, true);

    } else {

      // validamos si existe LA IMG para eliminarlo
      if ($flat_img1 == true || empty($imagen)) {
        
        $datos_f1 = $persona->obtenerImg($idpersona);
        $img1_ant = $datos_f1['data']['foto_perfil'];
        
        if ( !empty($img1_ant) ) { unlink("../assets/modulo/persona/" . $img1_ant);  }

      }            
      
      $rspta = $persona->editar($idpersona, $nombres, $tipo_documento, $num_documento, $direccion,$telefono, $email, 
      $cargo, $idtipo_persona, $nacimiento,$edad, $imagen);
      echo json_encode($rspta, true);
      
    }
  break;

  case 'desactivar':
    $rspta = $persona->desactivar($_GET["id_tabla"]);
    echo json_encode( $rspta, true) ;
  break;

  case 'delete':
    $rspta = $persona->delete($_GET["id_tabla"]);
    echo json_encode( $rspta, true) ;
  break;

  case 'mostrar':
    $rspta = $persona->mostrar($idpersona);
    echo json_encode($rspta, true);
  break;

  case 'listar':
    $rspta = $persona->listar();

    $data = array();

    foreach ($rspta['data'] as $key => $reg) {

      $img = empty($reg['foto_perfil']) ? 'no-perfil.jpg' : $reg['foto_perfil'];

      $data[] = array(
        "0" => '<div class="hstack gap-2 fs-15">' .
          '<button class="btn btn-icon btn-sm btn-warning-light" onclick="mostrar(' . $reg['idpersona'] . ')" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>' .
          ' <button  class="btn btn-icon btn-sm btn-danger-light product-btn" onclick="eliminar(' . $reg['idpersona'] . ', \''.encodeCadenaHtml($reg['nombres']).'\')" data-bs-toggle="tooltip" title="Eliminar"><i class="ri-delete-bin-line"></i></button>'.
          '</div>',
        "1" => '<div class="d-flex flex-fill align-items-center">
          <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen"><span class="avatar"> <img src="../assets/modulo/persona/' . $img . '" alt=""> </span></div>
          <div>
            <span class="d-block fw-semibold text-primary">' . $reg['nombres'] . ' </span>
            <span class="text-muted">' . $reg['tipo_documento'] . ' ' . $reg['numero_documento'] . '</span><br>
            <span class="text-muted">' . $reg['direccion'] . '</span>
          </div>
        </div>',
        "2" => $reg['fecha_nacimiento']. '  -  ' .$reg['edad'] ,
        "3" =>$reg['cargo'],
        "4" => $reg['celular'],
        "5" => $reg['correo'],
        "6" => ($reg['condicion']) ? '<span class="badge bg-success-transparent">Activado</span>' : '<span class="badge bg-danger-transparent">Inhabilitado</span>'
      );
    }
    $results = array(
      "sEcho" => 1, //Información para el datatables
      "iTotalRecords" => count($data),  //enviamos el total registros al datatable
      "iTotalDisplayRecords" => count($data),  //enviamos el total registros a visualizar
      "aaData" => $data
    );
    echo json_encode($results);

  break;

  case 'salir':
    session_unset();  //Limpiamos las variables de sesión  
    session_destroy(); //Destruìmos la sesión
    header("Location: ../index.php"); //Redireccionamos al login
  break;
}

ob_end_flush();

