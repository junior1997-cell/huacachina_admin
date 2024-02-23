<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_W.php";


class Reportes_correo_w
{
  //Implementamos nuestro variable global
  public $id_usr_sesion;

  //Implementamos nuestro constructor
  public function __construct($id_usr_sesion = 0)
  {
    $this->id_usr_sesion = $id_usr_sesion;
  }

  function reportes_wordpress($id){
    $data_barra_mes = array(); $data_barra_anio = array();
     $total_registros = 0; $porsentaje = 0; $total_reciente = 0;
    
    // ----------- TOTAL REGISTROS ---------
    $sql_2 = "SELECT  COUNT(form_post_id) as cantidad
    FROM wpb4_wpforms_db  WHERE form_post_id = '$id' ;";
    $total_reg = ejecutarConsultaSimpleFila_W($sql_2); if ($total_reg['status'] == false) { return $total_reg; }
    $total_registros += (empty($total_reg['data']) ? 0 : (empty($total_reg['data']['cantidad']) ? 0 : floatval($total_reg['data']['cantidad'])));


    // -------------- 24 HORAS --------------
    $sql_3 = "SELECT COUNT(*) AS total FROM wpb4_wpforms_db
    WHERE form_date >= NOW() - INTERVAL 24 HOUR AND form_post_id = '$id' ";
    $mas_reciente = ejecutarConsultaSimpleFila_W($sql_3); if ($mas_reciente['status'] == false) { return $mas_reciente; }
    $total_reciente += (empty($mas_reciente['data']) ? 0 : (empty($mas_reciente['data']['total']) ? 0 : floatval($mas_reciente['data']['total'])));
    $porsentaje = number_format(($total_reciente / $total_registros) * 100, 2);


    // ::::::::::::::::: DIA :::::::::::::::::
    $data_x_dia2 = []; $vista_all2 = [];
		for ($i=0; $i <= 6 ; $i++) { 
			$sql = "SELECT COUNT(form_post_id) as cantidad 
			FROM wpb4_wpforms_db  WHERE WEEKDAY(form_date)='$i' AND form_post_id = '$id' ";
			$dia2 = ejecutarConsultaSimpleFila_W($sql); if ($dia2['status'] == false) { return $dia2; }
			array_push($data_x_dia2, (empty($dia2['data']) ? 0 : (empty($dia2['data']['cantidad']) ? 0 : floatval($dia2['data']['cantidad']) ) ));         
			array_push($vista_all2, $dia2['data'] );         
		}

    // -------------- SEMANA -------------
    for ($i=1; $i <= 12 ; $i++) { 
      $sql_5 = "SELECT COUNT(form_post_id) as cantidad, form_date 
      FROM wpb4_wpforms_db  WHERE MONTH(form_date)='$i' AND form_post_id = '$id';";
      $mes = ejecutarConsultaSimpleFila_W($sql_5); if ($mes['status'] == false) { return $mes; }
      array_push($data_barra_mes, (empty($mes['data']) ? 0 : (empty($mes['data']['cantidad']) ? 0 : floatval($mes['data']['cantidad'])))); 
    }

    // -------------- ANIO ---------------
    $currentYear = date("Y");
    for ($i = 0; $i < 5; $i++) {
        $year = $currentYear - $i;
        $sql_6 = "SELECT COUNT(form_post_id) as cantidad, YEAR(form_date) as anio_name_abreviado, YEAR(form_date) as anio_name
        FROM wpb4_wpforms_db WHERE YEAR(form_date)='$year' AND form_post_id = '$id';";
        $anio = ejecutarConsultaSimpleFila_W($sql_6); if ($anio['status'] == false) { return $anio; }
        array_unshift($data_barra_anio, (empty($anio['data']) ? 0 : (empty($anio['data']['cantidad']) ? 0 : floatval($anio['data']['cantidad'])))); 
    }
    
    $results = [
      "status" => true,
      "data" => [
        "total_registros" => $total_registros,
        "chat_numero" => ["reciente" => $total_reciente, "porsentaje"=> $porsentaje],
        "chart_radar" => [ 'dia2'  => $data_x_dia2, 'vista_all'  => $vista_all2  ],
        "chart_linea" => [ "mes" => $data_barra_mes ],
        "chart_barra" => [ "anio" => $data_barra_anio ],
      ],
      "message" => 'Todo oka'
    ];
    return $results;
  }

}
?>