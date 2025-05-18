<?php require_once('../../connections/data.php'); 
if (isset($_POST['seccion'])){
	switch($_POST['seccion']){
		case "usuarios_control":
			if ((isset($_POST['id'])) && overdriveControlAcceso("usuarios_control-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `usuarios` WHERE `id_usuario` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
		case "grupos_control":
			if ((isset($_POST['id'])) && overdriveControlAcceso("grupos_control-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `grupos` WHERE `IdGrupo` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
		case "grupos_agregarusuarios":
			if ((isset($_POST['id'])) && overdriveControlAcceso("grupos_agregarusuarios-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `usuarios_grupos` WHERE `IdUsuarioGrupo` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
		case "grupos_agregartemas":
			if ((isset($_POST['id'])) && overdriveControlAcceso("grupos_agregartemas-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `grupos_temas` WHERE `IdGrupoTema` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
		case "objetos_subtema":
			if ((isset($_POST['id'])) && overdriveControlAcceso("objetos_subtema-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `subtemas` WHERE `IdSubTema` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
		case "mensajes_bandeja":
			if ((isset($_POST['id'])) && overdriveControlAcceso("mensajes_bandeja-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `mensajes_destinos` WHERE `IdMensajeDestino` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
		case "mensajes_salida":
			if ((isset($_POST['id'])) && overdriveControlAcceso("mensajes_salida-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `mensajes_emisores` WHERE `IdMensajeEmisor` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
		case "foros_tipo":
			if ((isset($_POST['id'])) && overdriveControlAcceso("foros_tipo-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `tipo_foros` WHERE `IdTipoForo` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
		case "objetos_subir":
			if ((isset($_POST['id'])) && overdriveControlAcceso("objetos_subir-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `objetos_didacticos` WHERE `IdObjetoDidactico` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
		case "foros_control":
			if ((isset($_POST['id'])) && overdriveControlAcceso("foros_control-eliminar", false)) {
				
			  $deleteSQL = sprintf("DELETE FROM `foros` WHERE `IdForo` = %s",
								   GetSQLValueString($_POST['id'], "int"));
			
			  mysql_select_db($database_bd_server, $bd_server);
			  $Result1 = mysql_query($deleteSQL, $bd_server);// or die(mysql_error());
			  
			  if($Result1){
				  echo "1";
			  } else {
				  echo "Error al eliminar el registro.";
			  }
			} else {
				echo "Permisos de usuario deniega operación.";
			}
			break;
	}
}
?>
