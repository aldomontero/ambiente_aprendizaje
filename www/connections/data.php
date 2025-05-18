<?php
include_once 'mysql_legacy_support.php';

if (!isset($_SESSION)) {
  session_start();
}

date_default_timezone_set("America/Mexico_City");
define("DATE_WITH_LETTERS", 1);
define("TIMESTAMP_WITH_LETTERS", 3);
define("NORMAL_DATE", 2);

define("ZEND_PATH", $_SERVER['DOCUMENT_ROOT'] . "/Ambiente de aprendizaje/www/Zend/");
define("APPLICATION_PATH", $_SERVER['DOCUMENT_ROOT'] . "/Ambiente de aprendizaje/www/");

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"$acceso->controlAcceso($_SESSION['Rol']
# HTTP="true"
$hostname_bd_server = "localhost";
$database_bd_server = "aldom_com_ambiente";
$username_bd_server = "root";
$password_bd_server = "";

if(!isset($required_connect) or (isset($required_connect) && $required_connect)){
	$bd_server = mysql_pconnect($hostname_bd_server, $username_bd_server, $password_bd_server) or trigger_error(mysql_error(),E_USER_ERROR);
	mysql_query("SET NAMES 'utf8'");
}

if (isset($_POST['login_usuario'])) {
	
  $loginUsername=$_POST['login_usuario'];
  $password=$_POST['contrasena'];
  mysql_select_db($database_bd_server, $bd_server);
  //var_dump(md5(mysql_escape_string($password))); exit;

  $LoginRS__query=sprintf("SELECT id_usuario, nombreusuario, usuario, tipousuario FROM usuarios INNER JOIN tipo_usuario ON usuarios.idtipousuario = tipo_usuario.idtipousuario WHERE usuario='%s' AND password='%s'", mysql_escape_string($loginUsername), md5(mysql_escape_string($password)));

  $LoginRS = mysql_query($LoginRS__query, $bd_server) or ($LoginRS = false);//  or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $data_user = mysql_fetch_assoc($LoginRS);
  
  if ($loginFoundUser) {
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
	$_SESSION['Rol'] = strtolower($data_user['tipousuario']);
    $_SESSION['Username'] = $loginUsername;
	$_SESSION['IdUsuario'] =  $data_user['id_usuario'];
	$_SESSION['Nombre'] = $data_user['nombreusuario'];
	
    header("Location: index.php");
  }
  else {
    header("Location: ../?page=error" );
  }
} else {
	if(!isset($no_validate))
		if(!isset($_SESSION['Username']))
			header("Location: ../?page=login");
}

function overdriveControlAcceso($resource_name, $redirect_page = true){
	require_once ZEND_PATH . 'Acl_Config.php';
	$acceso = new Acl_Config();
	return $acceso->controlAcceso($_SESSION['Rol'], $resource_name, $redirect_page);
}

function getView(){
	if(isset($_GET['page']) && strlen($_GET['page'])){
		$name_pagina = str_replace("-", "_", $_GET['page']);
		return $name_pagina;
	} else {
		return getNameResource($_SERVER['PHP_SELF']);
	}
}

function getNameResource($dir){
	$remove_folder = explode("/", $dir);
	$file_name = $remove_folder[count($remove_folder) - 1];
	$script_name = substr($file_name, 0 , strlen($file_name) - 4);
	return $script_name;
}

function getPageFile($dir){
	$remove_folder = explode("/", $dir);
	$file_name = $remove_folder[count($remove_folder) - 1];
	return $file_name;
}

function filterVars($query, $delete_vars){
	$out_vars = "";
	
	if(strlen($query) > 0){
		$vars = explode('&', $query);
		for($n = 0; $n < count($vars); $n++){
			$delete = false;
			for($m = 0; $m < count($delete_vars); $m++){
				if(substr($vars[$n], 0, strlen($delete_vars[$m])) == $delete_vars[$m])
					$delete = true;
			}
			if(!$delete){
				$out_vars .= "&" . $vars[$n];
			}
		}
	}
	return $out_vars;
}

function gd($fecha, $tiempo){
	switch($tiempo){
		case "dia":
			return substr($fecha, 8, 2);
		break;
		case "mes":
			return substr($fecha, 5, 2);
		break;
		case "año":
		default:
			return substr($fecha, 0,4);
		break;
	}
}

function ordering($column, $name, $page, $o_default, $o_type ){
	$query = filterVars($_SERVER['QUERY_STRING'], array('orderby','ordertype'));
	if($o_default == $column){
		return '<a href="'.$page.'?orderby='. $column . '&ordertype=' . ($o_type == "ASC" ? "DESC" : "ASC") . $query . '">' .
				($o_type == "ASC" ? "&or;" : "&and;") . $name . '</a>';
	} else {
		return '<a href="'.$page.'?orderby='. $column . '&ordertype=' . $o_type . $query . '">' . 
				$name .'</a>';
	}

}


function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
	case "calificacion":
      $theValue = ($theValue != "") ? doubleval($theValue) : "0";
      break;
	case "fecha_requerida":
      $theValue = ($theValue != "" or $theValue != NULL) ? "'" . normal_to_mysqldate($theValue) . "'" : "'" . date("Y-m-d"). "'" ;
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . normal_to_mysqldate($theValue) . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

// COversion de fecha
function mysqldate_to_stardant($format_result, $mysql_date){
	if($mysql_date === NULL ||  $mysql_date === NULL)
		return "";
		
	switch($format_result){
		case DATE_WITH_LETTERS:
			if(strlen($mysql_date) === 10){
				$mes = Array('Ene', 'Feb','Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
				return substr($mysql_date, 8, 2) . ' ' . $mes[intval(substr($mysql_date, 5, 2)) - 1] . ', ' . substr($mysql_date, 0, 4);
			} else {
				return "Error";
			}
		break;
		case NORMAL_DATE:
			if(strlen($mysql_date) === 10){
				return substr($mysql_date, 8, 2) . '-' . substr($mysql_date, 5, 2) . '-' . substr($mysql_date, 0, 4);
			} else {
				return "Error";
			}
		break; 
		case TIMESTAMP_WITH_LETTERS:
			if(strlen($mysql_date) === 19){
				$mes = Array('00','Ene', 'Feb','Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
				$hora = explode(":", substr($mysql_date, 11, 5));
				$tiempo;
				if(intval($hora[0]) > 12){
					$ampm = intval($hora[0]) - 12;
					$tiempo = ($ampm < 10 ? "0" . $ampm : $ampm ) . ":" . $hora[1] . " p.m.";
				} else {
					$tiempo = $hora[0] . ":" . $hora[1] . ($hora[0] === '12' ? " p.m." : " a.m.");
				}
				return substr($mysql_date, 8, 2) . ' ' . $mes[intval(substr($mysql_date, 5, 2))] . ', ' . substr($mysql_date, 0, 4) . " " . $tiempo;
			} else {
				return "Error";
			}
		break;
		default:
			return NULL;
	}
}

function normal_to_mysqldate($date){
	if($date === NULL ||  $date === NULL)
		return "";
		
	$reg = explode("-", $date);
	if(count($reg) === 3)
		return $reg[2] . '-' . $reg[1] . '-' . $reg[0];
	else
		return "";
}

function obtener_extension($file){
	if($file != NULL){
		$explore = explode('.', $file);
		if(count($explore) > 1){
			return $explore[count($explore) - 1];	
		}
	}
}
?>