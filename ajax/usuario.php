<?php
ob_start();

if (strlen(session_id()) < 1) {
  session_start();
} //Validamos si existe o no la sesión

require_once "../modelos/Usuario.php";
$usuario = new Usuario();

date_default_timezone_set('America/Lima');
$date_now = date("d_m_Y__h_i_s_A");
$imagen_error = "this.src='../dist/svg/404-v2.svg'";
$toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';

$id_persona = isset($_POST["id_persona"]) ? limpiarCadena($_POST["id_persona"]) : "";
$persona_old = isset($_POST["persona_old"]) ? limpiarCadena($_POST["persona_old"]) : "";
$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$login      = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave      = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
// $clave_old      = isset($_POST["password-old"]) ? limpiarCadena($_POST["password-old"]) : "";
$permiso          = isset($_POST['permiso']) ? $_POST['permiso'] : "";

$imagen            = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
  case 'guardaryeditar':

    if (empty($clave)) {
      // Si la variable $clave está vacía, se obtiene la clave actual del usuario y se usa para actualizar el registro
      $usuario_actual = $usuario->mostrar($idusuario);
      $clavehash = $usuario_actual['data']['password'];
    } else {
      // Si la variable $clave tiene un valor, se usa ese valor para actualizar el registro
      $clavehash = hash("SHA256", $clave);
    }

    if (empty($idusuario)) {
      $rspta = $usuario->insertar($id_persona, $login, $clavehash, $permiso);
      echo json_encode($rspta, true);
    } else {
      $rspta = $usuario->editar($idusuario, $id_persona,$persona_old, $login, $clavehash, $permiso);
      echo json_encode($rspta, true);
    }
    break;

  case 'desactivar':
    $rspta = $usuario->desactivar($_GET["id_tabla"]);
    echo json_encode($rspta, true);
    break;


  case 'delete':
    $rspta = $usuario->delete($_GET["id_tabla"]);
    echo json_encode($rspta, true);
    break;


  case 'mostrar':
    $rspta = $usuario->mostrar($idusuario);
    echo json_encode($rspta, true);
  break;

  case 'validar_usuario':
    $rspta = $usuario->validar_usuario($_GET["idusuario"], $_GET["login"]);
    //Codificar el resultado utilizando json
    echo json_encode($rspta, true);
    break;


  case 'listar':
    $rspta = $usuario->listar();
    //Vamos a declarar un array
    // echo json_encode($rspta);
    $data = array();

    foreach ($rspta['data'] as $key => $reg) {

      $img = empty($reg['imagen']) ? 'no-perfil.jpg' : $reg['imagen'];

      $data[] = array(
        "0" => '<div class="hstack gap-2 fs-15">' .
          '<button class="btn btn-icon btn-sm btn-warning-light" onclick="mostrar(' . $reg['idusuario'] . ')" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>' .
          ' <button  class="btn btn-icon btn-sm btn-danger-light product-btn" onclick="eliminar(' . $reg['idusuario'] . ', \'' . encodeCadenaHtml($reg['nombre_usuario']) . '\')" data-bs-toggle="tooltip" title="Eliminar"><i class="ri-delete-bin-line"></i></button>' .
          '</div>',
        "1" => '<div class="d-flex flex-fill align-items-center">
          <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen"><span class="avatar"> <img src="../assets/modulo/persona/' . $img . '" alt=""> </span></div>
          <div>
            <span class="d-block fw-semibold text-primary">' . $reg['nombre_usuario'] . ' </span>
            <span class="text-muted">' . $reg['tipo_documento'] . ' ' . $reg['num_documento'] . '</span>
          </div>
        </div>',
        "2" => $reg['login'],
        "3" => $reg['cargo'],
        "4" => $reg['telefono'],
        "5" => $reg['email'],
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


  case 'select2persona':

    $rspta = $usuario->select_persona();
    $data = "";

    if ($rspta['status']) {

      foreach ($rspta['data'] as $key => $value) {
        $data  .= '<option value=' . $value['idpersona'] . ' title="' . $value['foto_perfil'] . '" cargo="' . $value['cargo'] . '">' . $value['nombres'] . ' - ' . $value['numero_documento'] . '</option>';
      }

      $retorno = array(
        'status' => true,
        'message' => 'Salió todo ok',
        'data' => $data,
      );

      echo json_encode($retorno, true);
    } else {
      echo json_encode($rspta, true);
    }
    break;

  case 'permisos':
    //Obtenemos todos los permisos de la tabla permisos
    require_once "../modelos/Permiso.php";
    $permiso = new Permiso();
    $rspta = $permiso->listar_todos_permisos();

    $id = $_GET['id'];
    $marcados = $usuario->listarmarcados($id); # Obtener los permisos asignados al usuario

    $valores = array(); # Declaramos el array para almacenar todos los permisos marcados

    foreach ($marcados['data'] as $key => $val) {
      array_push($valores, $val['idpermiso']);
    } # Almacenar los permisos asignados al usuario en el array

    //Mostramos la lista de permisos en la vista y si están o no marcados
    echo '<div class="row gy-2" >';
    foreach ($rspta['data']['agrupado'] as $key => $val1) {
      echo '<div class="col-lg-3" >';
      echo '<span>' . $val1['modulo'] . '</span>';
      foreach ($val1['submodulo'] as $key => $val2) {
        $sw = in_array($val2['idpermiso'], $valores) ? 'checked' : '';
        echo '<div class="custom-toggle-switch d-flex align-items-center mb-1">
          <input id="permiso_' . $val2['idpermiso'] . '" name="permiso[]" type="checkbox" ' . $sw . ' value="' . $val2['idpermiso'] . '">
          <label for="permiso_' . $val2['idpermiso'] . '" class="label-primary"></label><span class="ms-3">' . $val2['submodulo'] . '</span>
        </div>';
      }
      echo '</div>';
    }
    echo '</div>';
    break;

  case 'verificar':

    $logina   = $_POST['logina'];
    $clavea   = $_POST['clavea'];
    $st       = $_POST['st'];

    //Hash SHA256 en la contraseña
    //$clavehash=$clavea;
    $clavehash = hash("SHA256", $clavea);

    $rspta  = $usuario->verificar($logina, $clavehash);

    if (!empty($rspta['data'])) {
      // echo json_encode($rspta, true);
      // Mapear el valor numérico a su respectiva descripción
      $cargo = '';
      switch ($rspta['data']['cargo']) {
        case 0:
          $cargo = "Administrador";
          break;
        case 1:
          $cargo = "Ventas";
          break;
        case 2:
          $cargo = "Logistica";
          break;
        case 3:
          $cargo = "Contabilidad";
          break;
      }
      //Declaramos las variables de sesión
      $_SESSION['idusuario']      = $rspta['data']['idusuario'];
      $_SESSION['user_nombre']    = $rspta['data']['nombre_usuario'];
      $_SESSION['user_apellido']  = 'Requejo';
      $_SESSION['user_tipo_doc']  = $rspta['data']['tipo_documento'];
      $_SESSION['user_num_doc']   = $rspta['data']['num_documento'];
      $_SESSION['user_cargo']     = $cargo;
      $_SESSION['user_imagen']    = $rspta['data']['imagen'];
      $_SESSION['user_login']     = $rspta['data']['login'];


      $marcados = $usuario->listarmarcados($rspta['data']['idusuario']);         # Obtenemos los permisos del usuario
      $grupo    = $usuario->listar_grupo_marcados($rspta['data']['idusuario']);  # Obtenemos los permisos del usuario
      // $usuario->savedetalsesion($rspta['data']['idusuario']);                    # Guardamos los datos del usuario al iniciar sesion.

      $valores = array();           # Declaramos el array para almacenar todos los permisos marcados
      $valores_agrupado = array();  # Declaramos el array para almacenar todos los permisos marcados

      foreach ($marcados['data'] as $key => $val) {
        array_push($valores, $val['idpermiso']);
      } # Almacenamos los permisos marcados en el array      

      foreach ($grupo['data'] as $key => $val) {
        array_push($valores_agrupado, $val['modulo']);
      }  # Almacenamos los permisos marcados en el array

      //modulos
      in_array('Landing Page', $valores_agrupado)           ? $_SESSION['landing_page'] = 1            : $_SESSION['landing_page']       = 0;
      in_array('Correo Inicio', $valores_agrupado)          ? $_SESSION['correo_inicio'] = 1           : $_SESSION['correo_inicio']      = 0;
      in_array('Adminstracion', $valores_agrupado)          ? $_SESSION['administracion'] = 1           : $_SESSION['administracion']      = 0;

      // Inicio
      in_array(1, $valores) ? $_SESSION['dashboard']           = 1 : $_SESSION['dashboard'] = 0;
      // Landing Page
      in_array(2, $valores) ? $_SESSION['landing']             = 1 : $_SESSION['landing'] = 0;
      in_array(3, $valores) ? $_SESSION['empresa']             = 1 : $_SESSION['empresa'] = 0;
      in_array(4, $valores) ? $_SESSION['correo_landing']      = 1 : $_SESSION['correo_landing'] = 0;
      // Correo Inicio
      in_array(5, $valores) ? $_SESSION['correo_wordpress']    = 1 : $_SESSION['correo_wordpress'] = 0;
      // Adminstracion
      in_array(6, $valores) ? $_SESSION['usuario']             = 1 : $_SESSION['usuario'] = 0;
      in_array(7, $valores) ? $_SESSION['permisos']            = 1 : $_SESSION['permisos'] = 0;
      in_array(8, $valores) ? $_SESSION['cargos']              = 1 : $_SESSION['cargos'] = 0;
      in_array(9, $valores) ? $_SESSION['tipo_persona']        = 1 : $_SESSION['tipo_persona'] = 0;

      $data = ['status' => true, 'message' => 'todo okey', 'data' => $rspta['data']];
      echo json_encode($data, true);
    } else {
      $data = ['status' => true, 'message' => 'todo okey', 'data' => []];
      echo json_encode($data, true);
    }

    break;

  case 'salir':
    session_unset();  //Limpiamos las variables de sesión  
    session_destroy(); //Destruìmos la sesión
    header("Location: ../index.php"); //Redireccionamos al login
    break;
}

ob_end_flush();
