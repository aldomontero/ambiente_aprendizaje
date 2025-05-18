<h2>Mensajes en bandeja<small></small></h2>
<p>Para ver mensajes recibidos a mi buzón.</p>

<?php

$id = -1;
$window = "lista";
$isInsert = true;

$section_name = "mensajes_bandeja";
$insertar_msj = "Ver mensaje";
$actualizar_msj = "Ver mensaje";

if(isset($_GET['opt'])){
	$window = $_GET['opt'];
}

if($window === 'nuevo' || $window === 'modi'){
	if(isset($_GET['id'])){
		$isInsert = false;
		$id = $_GET['id'];
	}
	
	if($isInsert)
		overdriveControlAcceso($section_name."-ver");
	else
		overdriveControlAcceso($section_name."-ver");
}
/*
if ((isset($_POST["MM_form"])) && ($_POST["MM_form"] == "form1")) {
	if(strlen(trim($_POST['id'], " ")) === 0 ){
		$SQL = " INSERT INTO `mensajes_emisores` (IdUsuario,MensajeEmisor) VALUES (%s, %s)";
		
		$SQL2 = " INSERT INTO `mensajes_destinos` (IdUsuario,IdMensajeEmisor,MensajeRecibido) VALUES (%s, %s, %s)";
		$isInsert = true;
	} else {
		$SQL = "SELECT 1 AS T";
		$SQL2 = "SELECT 1 AS T";
		$isInsert = false;
	}
	
	$updateSQL = sprintf($SQL,
				   GetSQLValueString($_SESSION['IdUsuario'], "text"),
				   GetSQLValueString($_POST['MensajeEmisor'], "text"));

  mysql_select_db($database_bd_server, $bd_server);
  $Result = mysql_query($updateSQL, $bd_server) or die(mysql_error());
  
  $updateSQL2 = sprintf($SQL2,
				   GetSQLValueString($_POST['Usuario'], "text"),
				   GetSQLValueString(mysql_insert_id($bd_server), "text"),
				   "0");
				   
  $Result += mysql_query($updateSQL2, $bd_server) or die(mysql_error());
  
  if($Result > 1){
  	/*if($isInsert && overdriveControlAcceso("admin-avisos_editar", false)){
	  header ("Location: index.php?page=avisos&opt=modi&id= " . mysql_insert_id($bd_server));
  	}
	if($isInsert){
		$mensaje = "Registado exitosamente.";
	} else {
		$mensaje = "Actualizado exitosamente.";
	}
  } else {
	$mensaje = "No se pudo realizar la operación, verfique sus datos.";
  }
}*/

if($window === 'nuevo' || $window === 'modi'){
	
	mysql_select_db($database_bd_server, $bd_server);
	$query_bd_data = sprintf("SELECT e.IdMensajeEmisor AS id, e.MensajeEmisorFechaHora AS fecha_hora, e.IdUsuario AS receptor, d.MensajeRecibido, e.MensajeEmisor FROM mensajes_emisores AS e INNER JOIN mensajes_destinos AS d ON e.IdMensajeEmisor = d.IdMensajeEmisor WHERE d.IdMensajeDestino = %s", GetSQLValueString($id, "int"));
	$bd_data = mysql_query($query_bd_data, $bd_server) or die(mysql_error());
	$row_bd_data = mysql_fetch_assoc($bd_data);
// --------------------------------------------------------------------------------
// AGREGAR Y MODIFICAR ELEMENTOS	
?>

<p><a class="btn" href="./?page=<?php echo $section_name?>">Regresar al listado</a> 
<!-- <a class="btn" href="./?page=<?php echo $section_name?>&opt=nuevo"><?php echo $insertar_msj ?></a></p>
-->

<h3 style="text-align:center">
<?php if (!$isInsert) {
		echo $actualizar_msj;
	} else {
		echo $insertar_msj;
	}
?>
</h3>

<form method="post" name="registro" id="registro"  action="index.php?page=<?php echo $section_name?>">
  <table align="center" class="noborder" style="width: 70%; margin-left: auto; margin-right: auto">
    <tr valign="baseline">
      <?php 
	  $query_sql = "SELECT * FROM usuarios";
	  $query = mysql_query($query_sql, $bd_server) or die(mysql_error());
	  ?>
      <td nowrap align="right" valign="top">Recibido de:</td>
      <td><select name="Usuario" <?php if($window === 'modi') echo 'disabled=disabled' ?>>
      	<option value="">Seleccione</option>
        <?php  while ($row = mysql_fetch_assoc($query)) { ?>
        <option value="<?php echo $row['id_usuario']?>" <?php if (!(strcmp($row['id_usuario'], $row_bd_data ? $row_bd_data['receptor'] : ''))) {echo "SELECTED";} ?>><?php echo $row['NombreUsuario'];?></option>
        <?php
		}
		mysql_free_result($query);
		?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Mensaje:</td>
      <td><input class="span7" type="text" name="MensajeEmisor" <?php if($window === 'modi') echo 'disabled=disabled' ?> value="<?php echo $row_bd_data ? $row_bd_data['MensajeEmisor'] : ''; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input class="btn primary" type="submit" value="Continuar" <?php if($window === 'modi') echo 'disabled=disabled' ?>>
      <input class="btn" value="Regresar" type="button" onclick="window.location.href='./?page=<?php echo $section_name?>'" name="regresar"/></td>
    </tr>
  </table>
  <input type="hidden" name="id" value="<?php echo $id == -1 ? "" : $id ?>">
  <input type="hidden" name="MM_form" value="form1">
</form>

<script>
	
$("#registro").validate({
	rules: {
		/*usuario: { required: true, minlength: 2 },
		nombre: { required: true, minlength: 2 },
		apellidos: { required: true },
		correo: { email: true, required: true },
		telefono: { number: true, minlength: 5 },
		password: { minlength: 4, required: true },
		rpassword: { equalTo: "input[name=password]", minlength: 4 },
		puesto: { minlength: 2 },
		rol: { required: true }*/
	},
	messages: {
		rpassword: {
			equalTo: "La contraseña no coincide"
		}
	}
});

</script>

<?php
// --------------------------------------------------------------------------------
} else {
	
	$show_where = "";

	if (isset($_POST['opcion']) && isset($_POST['search'])) {
		switch($_POST['opcion']){
			case 1:
				$where = "AND usuarios.nombreUsuario LIKE '%" . $_POST['search'] . "%'" ;
				$show_where = "Resultados de búsqueda por nombre y apellido";
				break;
			default:
			$where = "ORDER BY mensajes_emisores.MensajeEmisorFechaHora DESC LIMIT 0 , 20";
			$show_where = "Mostrando los primeros 20";
		}
	} else {
		$where = "ORDER BY mensajes_emisores.MensajeEmisorFechaHora DESC LIMIT 0 , 20";
		$show_where = "Mostrando los primeros 20";
	}

	mysql_select_db($database_bd_server, $bd_server);
	$query = "SELECT mensajes_destinos.IdMensajeDestino, mensajes_emisores.MensajeEmisorFechaHora, usuarios.nombreUsuario FROM mensajes_emisores
			  INNER JOIN mensajes_destinos ON mensajes_emisores.IdMensajeEmisor = mensajes_destinos.IdMensajeEmisor
			  INNER JOIN usuarios ON  mensajes_emisores.IdUsuario = usuarios.id_usuario WHERE mensajes_destinos.IdUsuario = " . $_SESSION['IdUsuario'] . " " . $where;
	$consulta = mysql_query($query, $bd_server) or die(mysql_error());
	$row = mysql_fetch_assoc($consulta);
	$totalRows = mysql_num_rows($consulta); 
// --------------------------------------------------------------------------------
// LISTAR ELEMENTOS
?>

<!--  CONTENIDO -->

<form action="" class="busqueda" name="registro" id="registro" method="POST">
<fieldset>
    <label for="usuario">Buscar en:&nbsp;&nbsp;</label>
      <select name="opcion" id="opcion">
        <option value="1"<?php if(isset($_POST['opcion']) && $_POST['opcion'] == 1) echo ' selected="selected"'; ?>>Nombre destinatario</option>
      </select>
      <input type="text" name="search" placeholder="Texto a buscar" id="search" value="<?php if(isset($_POST['search'])) echo $_POST['search']; ?>">
    <input class="btn primary" value="Ir" type="submit">
    <!--
    <a class="btn" href="./?page=<?php echo $section_name?>&opt=nuevo"><?php echo $insertar_msj ?></a> -->
</fieldset>
<input type="hidden" name="MM_insert" value="registro" />
</form>

    <?php
	  if(isset($mensaje))
		echo '<div class="alert-message bottom">' . $mensaje . '</div>';
	  echo "<p style='color:green'>" . $show_where . "</p>";
	?>
    <table class="bordered-table zebra-striped" style="width: 700px; margin-left: auto; margin-right: auto">
      <thead>
        <th>Recibido de</th>
        <th>Fecha envio</th>
        <th></th>
      </thead>
      <tbody>
      <?php 
	  if($totalRows === 0){ ?>
      <tr>
      <td colspan="4">Ningún elemento encontrado.</td>
      </tr>      
      <?php } else {
	  do { ?>
        <tr id="row-<?php echo $row['IdMensajeDestino']; ?>">
          <td><?php echo $row['nombreUsuario']?></td>
          <td><?php echo $row['MensajeEmisorFechaHora'] ?></td>
          <td>
          <?php if(overdriveControlAcceso($section_name."-ver", false)){ ?>
          <a class="btn" href="./?page=<?php echo $section_name?>&opt=modi&id=<?php echo $row['IdMensajeDestino']; ?>">Ver</a> 
          <?php }
		   if(overdriveControlAcceso($section_name."-eliminar", false)){ ?>
		  <a class="btn" href="#" rel="delete" name="<?php echo $row['IdMensajeDestino']; ?>">X</a></td>
           <?php } ?>
        </tr>
        <?php } while ($row = mysql_fetch_assoc($consulta));
	  }?>
    </tbody>
    </table>

<script>

	setup('POST','ajax/deletes.php');
	
	$('a[rel=delete]').click(function(){
		if(confirm("Esta seguro de eliminar el registro?")){
			var id = $(this).attr("name");
			$.ajax({
				data: "id="+id+"&seccion=<?php echo $section_name?>",
				success: function(response) {
					if(response == 1)
						$('#row-' + id).attr("style", "display: none");
					else 
						alert("Ocurrio un error al eliminar el registro");

				}
			});
		}
	});
</script>

<!-- FIN CONTENIDO -->
  
<?php
	mysql_free_result($consulta);
}
?>