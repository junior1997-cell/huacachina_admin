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

  function reportes_local($anio, $mes)
  { $data_barra_anio = array(); $data_linea_mes = array();
     $total_registros = 0; $porsentaje = 0; $total_reciente = 0;
     $total_este_mes = 0; 

    $sql_1 = "SELECT  COUNT(idlanding_correo) as cantidad	FROM landing_correo  WHERE  estado='1' AND estado_delete='1';";
    $todo = ejecutarConsultaSimpleFila($sql_1);
    if ($todo['status'] == false) {
      return $todo;
    }

    // ----------- TOTAL REGISTROS ---------
    $sql_1 = "SELECT  COUNT(idlanding_correo) as cantidad
    FROM landing_correo  WHERE estado='1' AND estado_delete='1';";
    $total_reg = ejecutarConsultaSimpleFila($sql_1); if ($total_reg['status'] == false) { return $total_reg; }
    $total_registros += (empty($total_reg['data']) ? 0 : (empty($total_reg['data']['cantidad']) ? 0 : floatval($total_reg['data']['cantidad'])));

    // -------------- 24 HORAS --------------
    $sql_2 = "SELECT COUNT(*) AS total FROM landing_correo
    WHERE fecha_envio >= NOW() - INTERVAL 24 HOUR AND estado = '1' AND estado_delete = '1';";
    $mas_reciente = ejecutarConsultaSimpleFila($sql_2); if ($mas_reciente['status'] == false) { return $mas_reciente; }
    $total_reciente += (empty($mas_reciente['data']) ? 0 : (empty($mas_reciente['data']['total']) ? 0 : floatval($mas_reciente['data']['total'])));
    

    // ------------ PORSENTAJE --------------
    $sql_6 = "SELECT  COUNT(idlanding_correo) as cantidad FROM landing_correo
    WHERE YEAR(fecha_envio) = YEAR(CURDATE()) AND MONTH(fecha_envio) = MONTH(CURDATE()) AND estado='1' AND estado_delete='1';";
    $este_mes = ejecutarConsultaSimpleFila($sql_6); if ($este_mes['status'] == false) { return $este_mes; }
    $total_este_mes += (empty($este_mes['data']) ? 0 : (empty($este_mes['data']['cantidad']) ? 0 : floatval($este_mes['data']['cantidad'])));
    $porsentaje = number_format(($total_reciente / $total_este_mes) * 100, 2);


    // ---------------- DIA -----------------
    $data_x_dia = []; $vista_all = [];
    for ($i=0; $i <= 6 ; $i++) { 
      $sql_3 = "SELECT COUNT(idlanding_correo) as cantidad FROM landing_correo
      WHERE WEEKDAY(fecha_envio)='$i' AND YEAR(fecha_envio) = '$anio' AND MONTH(fecha_envio) = '$mes' AND estado='1' AND estado_delete='1';";
      $dia = ejecutarConsultaSimpleFila($sql_3); if ($dia['status'] == false) { return $dia; }
      array_push($data_x_dia, (empty($dia['data']) ? 0 : (empty($dia['data']['cantidad']) ? 0 : floatval($dia['data']['cantidad']) ) ));         
      array_push($vista_all, $dia['data'] );         
    }


    // ---------------- MES -----------------
    $numDias = (new DateTime("{$anio}-{$mes}-01"))->format('t');
    for ($i = 1; $i <= $numDias; $i++){
        $sql_4 = "SELECT COUNT(idlanding_correo) as cantidad FROM landing_correo 
        WHERE YEAR(fecha_envio) = '$anio' AND MONTH(fecha_envio) = '$mes' AND DAY(fecha_envio) = '$i' AND estado = '1' AND estado_delete = '1';";
        $dia_del_mes = ejecutarConsultaSimpleFila($sql_4);
        if ($dia_del_mes['status'] == false) { return $dia_del_mes; }
        array_push($data_linea_mes, (empty($dia_del_mes['data']) ? 0 : (empty($dia_del_mes['data']['cantidad']) ? 0 : floatval($dia_del_mes['data']['cantidad']))));
    }
    $dias_en_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
    $lista_dias_mes = range(1, $dias_en_mes);



    // --------------- ANIO -----------------
    for ($i = 1; $i <= 12; $i++) {
      $sql_5 = "SELECT COUNT(idlanding_correo) as cantidad, monthname(fecha_envio) as mes_name_abreviado, monthname(fecha_envio) as mes_name
                FROM landing_correo 
                WHERE YEAR(fecha_envio) = '$anio' AND MONTH(fecha_envio) = '$i' AND estado = '1' AND estado_delete = '1';";
      $mes_del_anio = ejecutarConsultaSimpleFila($sql_5);
      if ($mes_del_anio['status'] == false) { return $mes_del_anio; }
      array_push($data_barra_anio, (empty($mes_del_anio['data']) ? 0 : (empty($mes_del_anio['data']['cantidad']) ? 0 : floatval($mes_del_anio['data']['cantidad']))));
      
    }


    $results = [
      "status" => true,
      "data" => [
        "total_registros" => $total_registros,
        "chart_rct" => ["reciente" => $total_reciente, "porsentaje"=> $porsentaje],
        "chart_barra" => [ "anio" => $data_barra_anio ],
        "chart_linea" => [ "mes" => $data_linea_mes, "dias" => $lista_dias_mes],
        "chart_numero" => [ 'dia'  => $data_x_dia, 'vista_all'  => $vista_all  ],
        
      ],
      "message" => 'Todo oka'
    ];
    return $results;
  }

  function listar(){
    // ----------- LISTA DE ANIOS ----------
    $data_list_anio = [];
    $sql_3 ="SELECT DISTINCT EXTRACT(YEAR FROM fecha_envio) AS anio
    FROM landing_correo where estado = '1' AND estado_delete = '1' ORDER BY anio DESC;";
    $list_anios = ejecutarConsulta($sql_3); if ($list_anios['status'] == false) { return $list_anios; }
    foreach ($list_anios['data'] as $row) { array_push($data_list_anio, $row['anio']); }
    $grupos = array_chunk($data_list_anio, 5);

    $results = [
      "status" => true,
      "data" => [ "chatr_list" => ["lista" =>$data_list_anio, "grupos" => $grupos], ],
      "message" => 'Todo oka'
    ];
    return $results;

  }

}
?>
