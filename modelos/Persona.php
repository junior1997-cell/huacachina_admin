<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Persona
{
	//Implementamos nuestro constructor
  public $id_usr_sesion; public $id_empresa_sesion;
  //Implementamos nuestro constructor
  public function __construct( $id_usr_sesion = 0, $id_empresa_sesion = 0 )
  {
    $this->id_usr_sesion =  isset($_SESSION['idpersona']) ? $_SESSION["idpersona"] : 0;
		$this->id_empresa_sesion = isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;
  }

	//Implementamos un método para insertar registros
	public function insertar($nombres, $tipo_documento, $num_documento, $direccion, $telefono, $email, 
	$cargo, $idtipo_persona, $nacimiento,$edad, $imagen)	{
		// $nombres=$nombre.' '.$apellidos;

	 $sql="INSERT INTO persona(idtipo_persona, idcargo_trabajador, nombres, tipo_documento, numero_documento, 
	 fecha_nacimiento, edad, celular, direccion, correo,foto_perfil) 
	  VALUES ('$idtipo_persona','$cargo','$nombres','$tipo_documento','$num_documento','$nacimiento','$edad','$telefono',
	 '$direccion','$email','$imagen')";

	 return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idpersona, $nombres, $tipo_documento, $num_documento, $direccion,$telefono, $email, 
	$cargo, $idtipo_persona, $nacimiento,$edad, $imagen) {
		// $nombres=$nombre.' '.$apellidos;
		$sql = "UPDATE persona SET 
			idtipo_persona='$idtipo_persona',
			idcargo_trabajador='$cargo',
			nombres='$nombres',
			tipo_documento='$tipo_documento',
			numero_documento='$num_documento',
			fecha_nacimiento='$nacimiento',
			edad='$edad',
			celular='$telefono',
			direccion='$direccion',
			correo='$email',
			foto_perfil='$imagen' 
		WHERE idpersona='$idpersona';";
	
	return ejecutarConsulta($sql);

	}

	//Implementamos un método para desactivar persona
	public function desactivar($idpersona) {
		$sql = "UPDATE persona set estado='0' where idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar persona
	public function delete($idpersona)	{
		$sql = "UPDATE persona set estado_delete='0' where idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idpersona)	{
		$sql = "SELECT * from persona where idpersona='$idpersona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()	{
		$sql = "SELECT p.idpersona, p.idtipo_persona, p.idcargo_trabajador, p.nombres, p.tipo_documento, p.numero_documento, 
		p.fecha_nacimiento, p.edad,p.celular, p.direccion, p.correo, p.foto_perfil, p.estado as condicion ,ct.nombre as cargo 
		FROM persona as p 
		INNER JOIN cargo_trabajador as ct on p.idcargo_trabajador= ct.idcargo_trabajador 
		WHERE p.estado_delete='1'and p.estado='1';";
		return ejecutarConsulta($sql);
	}


	
	public function obtenerImg($idpersona) {
		$sql = "SELECT foto_perfil FROM persona WHERE idpersona='$idpersona'";
		return ejecutarConsultaSimpleFila($sql);
	}




}
