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
}
