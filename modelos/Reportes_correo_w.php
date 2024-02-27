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

  function reportes_wordpress($id, $anio, $mes){
    $data_linea_mes = array(); $data_barra_anio = array();
    $total_registros = 0; $porsentaje = 0; $total_reciente = 0;
    $total_este_mes = 0;
    
    // ----------- TOTAL REGISTROS ---------
    $sql_1 = "SELECT  COUNT(form_post_id) as cantidad
    FROM wpb4_wpforms_db  WHERE form_post_id = '$id' ;";
    $total_reg = ejecutarConsultaSimpleFila_W($sql_1); if ($total_reg['status'] == false) { return $total_reg; }
    $total_registros += (empty($total_reg['data']) ? 0 : (empty($total_reg['data']['cantidad']) ? 0 : floatval($total_reg['data']['cantidad'])));


    // -------------- 24 HORAS --------------
    $sql_2 = "SELECT COUNT(*) AS total FROM wpb4_wpforms_db
    WHERE form_date >= NOW() - INTERVAL 24 HOUR AND form_post_id = '$id' ";
    $mas_reciente = ejecutarConsultaSimpleFila_W($sql_2); if ($mas_reciente['status'] == false) { return $mas_reciente; }
    $total_reciente += (empty($mas_reciente['data']) ? 0 : (empty($mas_reciente['data']['total']) ? 0 : floatval($mas_reciente['data']['total'])));
    
    
    // ------------ PORSENTAJE --------------
    $sql_6 = "SELECT COUNT(*) AS cantidad FROM wpb4_wpforms_db
    WHERE YEAR(form_date) = YEAR(CURDATE()) AND MONTH(form_date) = MONTH(CURDATE()) AND form_post_id = '$id' ";
    $mas_reciente = ejecutarConsultaSimpleFila_W($sql_6); if ($mas_reciente['status'] == false) { return $mas_reciente; }
    $total_este_mes += (empty($mas_reciente['data']) ? 0 : (empty($mas_reciente['data']['cantidad']) ? 0 : floatval($mas_reciente['data']['cantidad'])));
    $porsentaje = number_format(($total_reciente / $total_este_mes) * 100, 2);

    // ---------------- DIA -----------------
    $data_x_dia = []; $vista_all = [];
    for ($i=0; $i <= 6 ; $i++) { 
      $sql_3 = "SELECT COUNT(form_post_id) as cantidad FROM wpb4_wpforms_db
      WHERE WEEKDAY(form_date)='$i' AND YEAR(form_date) = '$anio' AND MONTH(form_date) = '$mes' AND form_post_id = '$id';";
      $dia = ejecutarConsultaSimpleFila_W($sql_3); if ($dia['status'] == false) { return $dia; }
      array_push($data_x_dia, (empty($dia['data']) ? 0 : (empty($dia['data']['cantidad']) ? 0 : floatval($dia['data']['cantidad']) ) ));         
      array_push($vista_all, $dia['data'] );         
    }

    // ---------------- MES -----------------
    $numDias = (new DateTime("{$anio}-{$mes}-01"))->format('t');
    for ($i = 1; $i <= $numDias; $i++){
        $sql_4 = "SELECT COUNT(form_post_id) as cantidad FROM wpb4_wpforms_db 
        WHERE YEAR(form_date) = '$anio' AND MONTH(form_date) = '$mes' AND DAY(form_date) = '$i' AND form_post_id = '$id';";
        $dia_del_mes = ejecutarConsultaSimpleFila_W($sql_4);
        if ($dia_del_mes['status'] == false) { return $dia_del_mes; }
        array_push($data_linea_mes, (empty($dia_del_mes['data']) ? 0 : (empty($dia_del_mes['data']['cantidad']) ? 0 : floatval($dia_del_mes['data']['cantidad']))));
    }
    $dias_en_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
    $lista_dias_mes = range(1, $dias_en_mes);

    // --------------- ANIO -----------------
    for ($i = 1; $i <= 12; $i++) {
      $sql_5 = "SELECT COUNT(form_post_id) as cantidad FROM wpb4_wpforms_db 
      WHERE YEAR(form_date) = '$anio' AND MONTH(form_date) = '$i' AND form_post_id = '$id';";
      $mes_del_anio = ejecutarConsultaSimpleFila_W($sql_5);
      if ($mes_del_anio['status'] == false) { return $mes_del_anio; }
      array_push($data_barra_anio, (empty($mes_del_anio['data']) ? 0 : (empty($mes_del_anio['data']['cantidad']) ? 0 : floatval($mes_del_anio['data']['cantidad']))));
      
    }

    $results = [
      "status" => true,
      "data" => [
        "total_registros" => $total_registros,
        "chat_numero" => ["recientew" => $total_reciente, "porsentajew"=> $porsentaje],
        "chart_day" => [ 'dia'  => $data_x_dia ],
        "chart_barra" => [ "anio" => $data_barra_anio ],
        "chart_linea" => [ "mes" => $data_linea_mes, "dias" => $lista_dias_mes],
      ],
      "message" => 'Todo oka'
    ];
    return $results;
  }

  function listar($id){
    // ----------- LISTA DE ANIOS ----------
    $data_list = [];
    $sql ="SELECT DISTINCT EXTRACT(YEAR FROM form_date) AS anio
    FROM wpb4_wpforms_db where form_post_id = '$id' ORDER BY anio DESC;";
    $list_anios = ejecutarConsulta_W($sql); if ($list_anios['status'] == false) { return $list_anios; }
    foreach ($list_anios['data'] as $row) { array_push($data_list, $row['anio']); }

    $results = [
      "status" => true,
      "data" => [ "chart_lista" => ["lista" =>$data_list] ],
      "message" => 'Todo oka'
    ];
    return $results;
  }

}
?>