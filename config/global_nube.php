<?php 

// ════════════════════════ BASE DE DATOS OFICIAL ⚠️ C U I D A D O ⚠️ AL USARLO ═════════════════════

define("DB_HOST","162.241.203.240");                # Ip de la pc servidor de base de datos

// ════════ BD ADMIN ════════
define("DB_NAME", "jdlpe_test_sunat");              # Nombre de la base de datos
define("DB_USERNAME", "jdlpe_test_sunat");          # Usuario de la base de datos
define("DB_PASSWORD", "jdlpe_test_sunat");          # Contraseña del usuario de la base de datos

// ════════ BD ADMIN ════════
define("DB_NAME_W", "huacachi_wp787");              # Nombre de la base de datos
define("DB_USERNAME_W", "huacachi_wp787");          # Usuario de la base de datos
define("DB_PASSWORD_W", "S@131[W5p5");          # Contraseña del usuario de la base de datos

define("DB_ENCODE","utf8");                         # definimos la codificación de los caracteres

define("PRO_NOMBRE","SISTEMA DE FACTURACION JDL");  # Definimos una constante como nombre del proyecto

// $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
// $config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
// $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
// $server = $_SERVER['HTTP_HOST']; var_dump($server); 
// var_dump($config['base_url']); die;
?>