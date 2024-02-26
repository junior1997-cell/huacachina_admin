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
    $sql="SELECT * FROM landing_disenio WHERE idlanding_disenio = '$idlanding_disenio'; ";
    return ejecutarConsultaSimpleFila($sql);  
  }

  public function editar($id, $f_titulo,$f_descripcion,$fe_titulo,$fe_descripcion,$f_img_fondo,$f_img_promocion, $fe_img_fondo){
    $sql = "UPDATE landing_disenio SET f_img_fondo = '$f_img_fondo', f_img_promocion = '$f_img_promocion', f_titulo = '$f_titulo', f_descripcion = '$f_descripcion', 
    fe_img_fondo = '$fe_img_fondo', fe_titulo = '$fe_titulo', fe_descripcion = '$fe_descripcion'
    WHERE idlanding_disenio = '$id'";
    return ejecutarConsulta($sql);
  }

  public function insertar($f_titulo,$f_descripcion,$fe_titulo,$fe_descripcion,$f_img_fondo,$f_img_promocion, $fe_img_fondo){
    $sql = "INSERT INTO landing_disenio (f_img_fondo, f_img_promocion, f_titulo, f_descripcion, fe_img_fondo, fe_titulo, fe_descripcion) 
    VALUES ('$f_img_fondo', '$f_img_promocion', '$f_titulo', '$f_descripcion', '$fe_img_fondo', '$fe_titulo', '$fe_descripcion' )";
    return ejecutarConsulta_retornarID($sql);
  }
}
