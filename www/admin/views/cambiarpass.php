<?php

if ((isset($_POST["MM_form"])) && ($_POST["MM_form"] == "form1")) {
	
	mysql_select_db($database_bd_server, $bd_server);
	$query_bd_data = sprintf("SELECT * FROM usuarios WHERE Usuario = %s AND Password = %s", GetSQLValueString($_SESSION['Username'], "text"), GetSQLValueString(md5($_POST['pass']), "text"));
	$bd_data = mysql_query($query_bd_data, $bd_server) or die(mysql_error());
	$row_bd_data = mysql_num_rows($bd_data);
	
	
	if($row_bd_data > 0 && strcmp($_POST['newpass'], $_POST['cnewpass']) == 0){
		$SQL = "UPDATE `usuarios` SET Password = %s WHERE Usuario = %s AND Password = %s;";
		$isInsert = false;
	
	
		$updateSQL = sprintf($SQL,
				   GetSQLValueString(md5($_POST['newpass']), "text"),
				   GetSQLValueString($_SESSION['Username'], "text"), 
				   GetSQLValueString(md5($_POST['pass']), "text"));

	  mysql_select_db($database_bd_server, $bd_server);
	  $Result = mysql_query($updateSQL, $bd_server);// or die(mysql_error());
	
	  if($Result){
		/*if($isInsert && overdriveControlAcceso("admin-avisos_editar", false)){
		  header ("Location: index.php?page=avisos&opt=modi&id= " . mysql_insert_id($bd_server));
		}*/
		$mensaje = "Actualizado exitosamente.";
	  } else {
		$mensaje = "Verifique su contraseña, vuelva a intentarlo.";
	  }
	} else {
		$mensaje = "Error al cambiar contraseña.";
	}
}

?>

<div class="content">
<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
  <h1>Cambiar contraseña</h1>
  <p>Si deseas cambiar tu contraseña por favor rellena la información solicitada.</p>
  <?php
	  if(isset($mensaje))
		echo '<div class="alert-message bottom">' . $mensaje . '</div>';
	?>
  <form method="post" name="registro" id="registro"  action="index.php?page=cambiarpass">
  <table align="center" class="noborder" style="width: 70%; margin-left: auto; margin-right: auto">
    <tr valign="baseline">
      <td nowrap align="right" width="30%">Contraseña anterior:</td>
      <td><input class="span7" type="password" name="pass" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Nueva contraseña:</td>
      <td><input class="span7" type="password" name="newpass" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Repetir contraseña:</td>
      <td><input class="span7" type="password" name="cnewpass" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input class="btn primary" type="submit" value="Continuar">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_form" value="form1">
</form>

</div>

</div>

