<?php
require "../config/Conexion_v2.php";

class Landing_disenio
{
  //Implementamos nuestro variable global
  public $id_usr_sesion;

  //Implementamos nuestro constructor
  public function __construct($id_usr_sesion = 0)
  {
    $this->id_usr_sesion = $id_usr_sesion;
  }

  public function mostrar(){
		$sql="SELECT * FROM landing_disenio WHERE idlanding_disenio = '1' AND estado = '1' AND estado_delete = '1';";
		return ejecutarConsultaSimpleFila($sql);
	}

  public function obtenerImg($idlanding_disenio){
    $sql="SELECT img_fondo FROM landing_disenio WHERE idlanding_disenio = '$idlanding_disenio'; ";
    return ejecutarConsultaSimpleFila($sql);  
  }

  public function editar($id, $titulo, $descripcion, $imagen){
    $sql = "UPDATE landing_disenio SET titulo = '$titulo', descripcion = '$descripcion', img_fondo = '$imagen' WHERE idlanding_disenio = '$id'";
    return ejecutarConsulta($sql);
  }
}
