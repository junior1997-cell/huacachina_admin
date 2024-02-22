<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Usuario
{
	//Implementamos nuestro constructor
	public $id_usr_sesion;
	public $id_empresa_sesion;
	//Implementamos nuestro constructor
	public function __construct($id_usr_sesion = 0)
	{
		$this->id_usr_sesion =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
	}

	//Implementamos un método para insertar registros
	public function insertar($id_persona, $login, $clavehash, $permisos)
	{

		// var_dump($permisos); die();
		$sql = "INSERT INTO usuario(idpersona, login, password) VALUES ('$id_persona','$login','$clavehash')";

		$idusuarionew = ejecutarConsulta_retornarID($sql);

		if ($idusuarionew['status'] == false) {
			return $idusuarionew;
		}

		$num_elementos = 0;
		$sw = true;

		if (!empty($permisos)) {

			while ($num_elementos < count($permisos)) {

				$iduser_new = $idusuarionew['data'];

				$sql_detalle = "INSERT into usuario_permiso(idusuario, idpermiso) values ('$iduser_new', '$permisos[$num_elementos]')";

				$sw = ejecutarConsulta($sql_detalle);
				if ($sw['status'] == false) {
					return $sw;
				}

				$num_elementos = $num_elementos + 1;
			}

			return $sw;
		} else {

			return $idusuarionew;
		}
	}

	//Implementamos un método para editar registros
	public function editar($idusuario, $id_persona, $persona_old, $login, $clavehash, $permisos)
	{
		$trab = "";
		if (empty($trabajador)) {
			$trab = $persona_old;
		} else {
			$trab = $id_persona;
		}

		$sql = "UPDATE usuario SET idpersona='$trab',login='$login', password='$clavehash' WHERE idusuario='$idusuario'";
		$edit_user = ejecutarConsulta($sql);

		if ($edit_user['status'] == false) {
			return $edit_user;
		}

		//Eliminar todos los permisos asignados para volverlos a registrar
		$sqldel = "DELETE from usuario_permiso where 	idusuario='$idusuario'";
		$del_user_permiso = ejecutarConsulta($sqldel);

		if ($del_user_permiso['status'] == false) {
			return $del_user_permiso;
		}

		$ii = 0;
		$sw = true;

		if ($permisos != "") {

			while ($ii < count($permisos)) {

				$sql_detalle = "INSERT into usuario_permiso(idusuario, idpermiso) values ('$idusuario', '$permisos[$ii]')";

				$sw = ejecutarConsulta($sql_detalle);

				if ($sw['status'] == false) {
					return $sw;
				}

				$ii = $ii + 1;
			}
			return $sw;
		} else {
			return $edit_user;
		}
	}

	//Implementamos un método para desactivar usuario
	public function desactivar($idusuario)
	{
		$sql = "UPDATE usuario set estado='0' where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar usuario
	public function delete($idusuario)
	{
		$sql = "UPDATE usuario set estado_delete='0' where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql = "SELECT u.idusuario, u.idpersona, u.login, u.password, u.estado, p.nombres , ct.nombre as cargo
		FROM usuario AS u
		inner join  persona AS p  on u.idpersona = p.idpersona
		inner join cargo_trabajador as ct on p.idcargo_trabajador= ct.idcargo_trabajador
		WHERE u.idusuario='$idusuario';";

		return ejecutarConsultaSimpleFila($sql);
	}

	// null, david
	public function validar_usuario($idusuario, $user)
	{
		$validar_user = empty($idusuario) ? "" : "AND u.idusuario != '$idusuario'";
		$sql = "SELECT u.idusuario FROM usuario AS u WHERE u.login = '$user' $validar_user;";
		$buscando =  ejecutarConsultaArray($sql);
		if ($buscando['status'] == false) {
			return $buscando;
		}

		if (empty($buscando['data'])) {
			return true;
		} else {
			return false;
		}
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT u.idusuario, p.nombres as nombre_usuario, p.tipo_documento, p.numero_documento as num_documento, 
		p.celular as telefono, p.correo as email, ct.nombre as cargo, p.foto_perfil as imagen, u.login , u.estado as condicion
		from usuario u 
		INNER JOIN persona p on p.idpersona=u.idpersona 
		INNER JOIN cargo_trabajador ct on p.idcargo_trabajador=ct.idcargo_trabajador 
		where u.estado='1' and u.estado_delete='1'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql = "SELECT * from usuario where condicion=1";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select_persona()
	{
		$sql = "SELECT p.idpersona, p.nombres, p.numero_documento,p.foto_perfil, ct.nombre as cargo 
		FROM persona p 
		LEFT JOIN usuario u ON p.idpersona = u.idpersona 
		INNER JOIN cargo_trabajador ct ON p.idcargo_trabajador = ct.idcargo_trabajador
		WHERE p.estado = '1' AND p.estado_delete = '1' AND u.idpersona IS NULL;";
		return ejecutarConsultaArray($sql);
	}

	//Implementar un metodo para listar los permisos marcados
	public function listarmarcados($idusuario)
	{
		$sql = "SELECT * from usuario_permiso where idusuario='$idusuario'";
		return ejecutarConsultaArray($sql);
	}

	public function listar_grupo_marcados($idusuario)
	{
		$sql = "SELECT up.idusuario, p.idpermiso, p.estado, p.modulo, count(p.modulo) 
		from usuario_permiso AS up 
		INNER JOIN permiso as p ON up.idpermiso = p.idpermiso 
		where idusuario='$idusuario'
		GROUP BY p.modulo ORDER BY count(p.modulo) DESC; ";
		return ejecutarConsultaArray($sql);
	}

	public function listarmarcadosEmpresa($idusuario)
	{
		$sql = "SELECT * from usuario_empresa where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	public function listarmarcadosEmpresaTodos()
	{
		$sql = "SELECT * from usuario_empresa ";
		return ejecutarConsulta($sql);
	}

	public function listarmarcadosNumeracion($idusuario)
	{
		$sql = "SELECT * from detalle_usuario_numeracion where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Funcion para verificar el acceso al sistema
	public function verificar($login, $clave)
	{

		// var_dump($login.'  ---- '.$clave);die();

		$sql = "SELECT u.idusuario, p.nombres as nombre_usuario, p.tipo_documento, p.numero_documento as num_documento, 
		p.celular as telefono, p.correo as email, ct.nombre as cargo, p.foto_perfil as imagen, u.login 
		from usuario u 
		INNER JOIN persona p on p.idpersona=u.idpersona 
		INNER JOIN cargo_trabajador ct on p.idcargo_trabajador=ct.idcargo_trabajador 
		where u.login='$login' and u.password='$clave' and u.estado='1';";

		return ejecutarConsultaSimpleFila($sql);
		// $info =  ejecutarConsultaSimpleFila($sql); 
		// var_dump($info);die();

	}

	// public function onoffTempo($st)	{
	// 	$sql = "UPDATE temporizador set estado='$st' where id='1' ";
	// 	return ejecutarConsulta($sql);
	// }

	// public function consultatemporizador()	{
	// 	$sql = "SELECT id as idtempo, tiempo, estado from temporizador where id='1' ";
	// 	return ejecutarConsultaSimpleFila($sql);
	// }

	// public function savedetalsesion($idusuario)	{
	// 	$sql = "INSERT into detalle_usuario_sesion (idusuario, tcomprobante, idcomprobante, fechahora) 
	//   values ('$idusuario', '','', now())";
	// 	return ejecutarConsulta($sql);
	// }
}
