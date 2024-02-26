<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

Class Empresa
{
	//Implementamos nuestro variable global
	public $id_usr_sesion;

	//Implementamos nuestro constructor
	public function __construct($id_usr_sesion = 0)	{
		$this->id_usr_sesion = $id_usr_sesion;
	}	

	public function mostrar_empresa(){
		$sql="SELECT * FROM nosotros WHERE idnosotros = '1' AND estado = '1' AND estado_delete = '1';";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function actualizar_datos_empresa( $id, $direccion,$nombre,$tipo_documento, $num_documento,$celular,$telefono, $link_grupo_whats,$mapa,$correo,$horario, 
	$rs_facebook,$rs_instagram,$rs_web, $rs_facebook_etiqueta, $rs_instagram_etiqueta, $rs_web_etiqueta) {
		$sql="UPDATE nosotros SET direccion='$direccion', nombre_empresa='$nombre', tipo_documento = '$tipo_documento',	num_documento='$num_documento',	
		celular='$celular',	telefono_fijo='$telefono', link_grupo_whats = '$link_grupo_whats', correo='$correo', horario='$horario',	mapa='$mapa',	 user_updated ='$this->id_usr_sesion',
		rs_facebook='$rs_facebook', rs_instagram='$rs_instagram', rs_web='$rs_web', rs_facebook_etiqueta = '$rs_facebook_etiqueta', rs_instagram_etiqueta = '$rs_instagram_etiqueta',
		rs_web_etiqueta = '$rs_web_etiqueta'
		WHERE idnosotros ='$id'";
		return ejecutarConsulta($sql);

	}
	
}
?>