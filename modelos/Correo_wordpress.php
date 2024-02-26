<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_W.php";

Class Correo_wordpress
{
	//Implementamos nuestro variable global
	public $id_usr_sesion;

	//Implementamos nuestro constructor
	public function __construct($id_usr_sesion = 0)	{
		$this->id_usr_sesion = $id_usr_sesion;
	}

	//Implementar un método para listar los registros
	public function tbla_principal( $id )	{
		$sql="SELECT form_id, form_post_id, form_value, form_date, DATE_FORMAT(form_date, '%d/%m/%Y %h:%i %p') as fecha_12h 
    FROM wpb4_wpforms_db WHERE form_post_id = '$id' ORDER BY form_date DESC";
		return ejecutarConsultaArray_W($sql);		
	}	
	
}
?>