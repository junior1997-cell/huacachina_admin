<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

Class Landing_correo
{
	//Implementamos nuestro variable global
	public $id_usr_sesion;

	//Implementamos nuestro constructor
	public function __construct($id_usr_sesion = 0)	{
		$this->id_usr_sesion = $id_usr_sesion;
	}

	//Implementar un método para listar los registros
	public function tbla_principal(  )	{
		$sql="SELECT idlanding_correo, nombres, celular, fecha_envio, DATE_FORMAT(fecha_envio, '%d/%m/%Y %h:%i %p') as fecha_12h, 
		day_name, month_name, year_name, estado, estado_delete
		FROM landing_correo 
		WHERE estado = '1' and estado_delete = '1' ORDER BY fecha_envio DESC";
		return ejecutarConsultaArray($sql);		
	}	

	//Implementamos un método para activar registros
	public function papelera($id) {
		$sql="UPDATE landing_correo SET estado='0', user_trash= '$this->id_usr_sesion' WHERE idlanding_correo='$id'";
		$papelera =  ejecutarConsulta($sql, 'T'); if ( $papelera['status'] == false) {return $papelera; }  

		//add registro en nuestra bitacora
		$sql_d = $id;
		$sql_bit = "INSERT INTO bitacora_bd(idcodigo, nombre_tabla, id_tabla, sql_d, id_user) VALUES (2,'landing_correo','$id','$sql_d','$this->id_usr_sesion')";
		$bitacora = ejecutarConsulta($sql_bit); if ( $bitacora['status'] == false) {return $bitacora; }  
	
		return $papelera;
	}    

	//Implementamos un método para activar registros
	public function eliminar($id) {
		$sql="UPDATE landing_correo SET estado_delete='0', user_delete= '$this->id_usr_sesion' WHERE idlanding_correo='$id'";
		$eliminar =  ejecutarConsulta($sql, 'D'); if ( $eliminar['status'] == false) {return $eliminar; }  

		//add registro en nuestra bitacora
		$sql_d = $id;
		$sql_bit = "INSERT INTO bitacora_bd(idcodigo, nombre_tabla, id_tabla, sql_d, id_user) VALUES (4,'landing_correo','$id','$sql_d','$this->id_usr_sesion')";
		$bitacora = ejecutarConsulta($sql_bit); if ( $bitacora['status'] == false) {return $bitacora; }  
	
		return $eliminar;
	}   
	
	// :::::::::::::::::::::::::: S E C C I O N   R E P O R T E S  ::::::::::::::::::::::::::

	//visitas a la pagina web
  function reporte_correo(){
    $data_barra = Array(); $data_radar = Array();
    $total_barra = 0;    

		$sql_1 = "SELECT  COUNT(idlanding_correo) as cantidad	FROM landing_correo  WHERE  estado='1' AND estado_delete='1';";
		$todo = ejecutarConsultaSimpleFila($sql_1); if ($todo['status'] == false) { return $todo; }

    for ($i=1; $i <= 12 ; $i++) { 
      $sql_2 = "SELECT  COUNT(idlanding_correo) as cantidad, month_name as mes_name_abreviado, month_name as mes_name, fecha_envio 
      FROM landing_correo  WHERE MONTH(fecha_envio)='$i'  AND estado='1' AND estado_delete='1';";
      $mes = ejecutarConsultaSimpleFila($sql_2); if ($mes['status'] == false) { return $mes; }
      array_push($data_barra, (empty($mes['data']) ? 0 : (empty($mes['data']['cantidad']) ? 0 : floatval($mes['data']['cantidad']) ) )); 
      $total_barra += (empty($mes['data']) ? 0 : (empty($mes['data']['cantidad']) ? 0 : floatval($mes['data']['cantidad']) ) );
    }
    
		$data_x_dia = []; $vista_all = [];
		for ($i=0; $i <= 6 ; $i++) { 
			$sql_3 = "SELECT COUNT(idlanding_correo) as cantidad, day_name, month_name, year_name
			FROM landing_correo  WHERE WEEKDAY(fecha_envio)='$i'  AND estado='1' AND estado_delete='1' GROUP BY  day_name;";
			$dia = ejecutarConsultaSimpleFila($sql_3); if ($dia['status'] == false) { return $dia; }
			array_push($data_x_dia, (empty($dia['data']) ? 0 : (empty($dia['data']['cantidad']) ? 0 : floatval($dia['data']['cantidad']) ) ));         
			array_push($vista_all, $dia['data'] );         
		}
		$data_radar = [ 'total'  =>$todo['data']['cantidad'], 'dia'  => $data_x_dia, 'vista_all'  => $vista_all  ];
    
    $results = [
      "status" => true,
      "data" => [
        "chart_radar" =>   $data_radar ,
        "chart_linea" => ["total" => $total_barra, "mes" => $data_barra,  ] ,        
      ],
      "message"=> 'Todo oka'
    ];
    return $results;
  }
	
}
?>