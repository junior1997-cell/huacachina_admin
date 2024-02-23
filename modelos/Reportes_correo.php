<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Reportes_correo
{
  //Implementamos nuestro variable global
  public $id_usr_sesion;

  //Implementamos nuestro constructor
  public function __construct($id_usr_sesion = 0)
  {
    $this->id_usr_sesion = $id_usr_sesion;
  }

  function reportes_local()
  {
     $data_barra_mes = array(); $data_barra_anio = array();
     $total_registros = 0; $porsentaje = 0; $total_reciente = 0; 

    $sql_1 = "SELECT  COUNT(idlanding_correo) as cantidad	FROM landing_correo  WHERE  estado='1' AND estado_delete='1';";
    $todo = ejecutarConsultaSimpleFila($sql_1);
    if ($todo['status'] == false) {
      return $todo;
    }

    // ----------- TOTAL REGISTROS ---------
    $sql_2 = "SELECT  COUNT(idlanding_correo) as cantidad
    FROM landing_correo  WHERE estado='1' AND estado_delete='1';";
    $total_reg = ejecutarConsultaSimpleFila($sql_2); if ($total_reg['status'] == false) { return $total_reg; }
    $total_registros += (empty($total_reg['data']) ? 0 : (empty($total_reg['data']['cantidad']) ? 0 : floatval($total_reg['data']['cantidad'])));

    // -------------- 24 HORAS --------------
    $sql_3 = "SELECT COUNT(*) AS total FROM landing_correo
    WHERE fecha_envio >= NOW() - INTERVAL 24 HOUR AND estado = '1' AND estado_delete = '1';";
    $mas_reciente = ejecutarConsultaSimpleFila($sql_3); if ($mas_reciente['status'] == false) { return $mas_reciente; }
    $total_reciente += (empty($mas_reciente['data']) ? 0 : (empty($mas_reciente['data']['total']) ? 0 : floatval($mas_reciente['data']['total'])));
    $porsentaje = number_format(($total_reciente / $total_registros) * 100, 2);

    // ----------------- DIA ----------------
    $data_x_dia = []; $vista_all = [];
		for ($i=0; $i <= 6 ; $i++) { 
			$sql_4 = "SELECT COUNT(idlanding_correo) as cantidad, day_name, month_name, year_name
			FROM landing_correo  WHERE WEEKDAY(fecha_envio)='$i'  AND estado='1' AND estado_delete='1' GROUP BY  day_name;";
			$dia = ejecutarConsultaSimpleFila($sql_4); if ($dia['status'] == false) { return $dia; }
			array_push($data_x_dia, (empty($dia['data']) ? 0 : (empty($dia['data']['cantidad']) ? 0 : floatval($dia['data']['cantidad']) ) ));         
			array_push($vista_all, $dia['data'] );         
		}
		// $data_radar = [ 'dia'  => $data_x_dia, 'vista_all'  => $vista_all  ];

    // -------------- SEMANA -------------
    for ($i=1; $i <= 12 ; $i++) { 
      $sql_5 = "SELECT COUNT(idlanding_correo) as cantidad, month_name as mes_name_abreviado, month_name as mes_name, fecha_envio 
      FROM landing_correo  WHERE MONTH(fecha_envio)='$i'  AND estado='1' AND estado_delete='1';";
      $mes = ejecutarConsultaSimpleFila($sql_5); if ($mes['status'] == false) { return $mes; }
      array_push($data_barra_mes, (empty($mes['data']) ? 0 : (empty($mes['data']['cantidad']) ? 0 : floatval($mes['data']['cantidad'])))); 
      
    }

    // -------------- ANIO ---------------
    $currentYear = date("Y");
    for ($i = 0; $i < 5; $i++) {
        $year = $currentYear - $i;
        $sql_6 = "SELECT COUNT(idlanding_correo) as cantidad, YEAR(fecha_envio) as anio_name_abreviado, YEAR(fecha_envio) as anio_name
        FROM landing_correo WHERE YEAR(fecha_envio)='$year' AND estado='1' AND estado_delete='1';";
        $anio = ejecutarConsultaSimpleFila($sql_6); if ($anio['status'] == false) { return $anio; }
        array_unshift($data_barra_anio, (empty($anio['data']) ? 0 : (empty($anio['data']['cantidad']) ? 0 : floatval($anio['data']['cantidad'])))); 
    }


    // ---------- Lista de años ----------
    $data_list_anio = [];
    $sql_7 ="SELECT DISTINCT EXTRACT(YEAR FROM fecha_envio) AS anio
    FROM landing_correo where estado = '1' AND estado_delete = '1';";
    $list_anios = ejecutarConsulta($sql_7); if ($list_anios['status'] == false) { return $list_anios; }
    foreach ($list_anios['data'] as $row) { array_push($data_list_anio, $row['anio']); }
    $grupos = array_chunk($data_list_anio, 5);

    $results = [
      "status" => true,
      "data" => [
        "lista_anios" => ["lista" =>$data_list_anio, "grupos" => $grupos],
        "total_registros" => $total_registros,
        "chat_rct" => ["reciente" => $total_reciente, "porsentaje"=> $porsentaje],
        "chart_radar" => [ 'dia'  => $data_x_dia, 'vista_all'  => $vista_all  ],
        "chart_linea" => [ "mes" => $data_barra_mes ],
        "chart_barra" => [ "anio" => $data_barra_anio ],
      ],
      "message" => 'Todo oka'
    ];
    return $results;
  }

  



}
?>
