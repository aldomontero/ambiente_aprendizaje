<h2>Administrar tipo de foros<small></small></h2>
<p>Para gestionar los tipos de foros en los que se clasificaran los foros.</p>

<?php

$id = -1;
$window = "lista";
$isInsert = true;

$section_name = "foros_tipo";
$insertar_msj = "Nuevo tipo de foro";
$actualizar_msj = "Actualizar datos del tipo de foro";

if(isset($_GET['opt'])){
	$window = $_GET['opt'];
}

if($window === 'nuevo' || $window === 'modi'){
	if(isset($_GET['id'])){
		$isInsert = false;
		$id = $_GET['id'];
	}
	
	if($isInsert)
		overdriveControlAcceso($section_name."-nuevo");
	else
		overdriveControlAcceso($section_name."-modificar");
}

if ((isset($_POST["MM_form"])) && ($_POST["MM_form"] == "form1")) {
	if(strlen(trim($_POST['id'], " ")) === 0 ){
		$SQL = " INSERT INTO `tipo_foros` (TipoForo) VALUES (
%s)";
		$isInsert = true;
	} else {
		$SQL = "UPDATE `tipo_foros` SET TipoForo=%s WHERE `IdTipoForo` = %s;";
		$isInsert = false;
	}
	
	$updateSQL = sprintf($SQL,
				   GetSQLValueString($_POST['TipoForo'], "text"),
				   GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_bd_server, $bd_server);
  $Result = mysql_query($updateSQL, $bd_server);// or die(mysql_error());

  if($Result){
  	/*if($isInsert && overdriveControlAcceso("admin-avisos_editar", false)){
	  header ("Location: index.php?page=avisos&opt=modi&id= " . mysql_insert_id($bd_server));
  	}*/
	if($isInsert){
		$mensaje = "Registado exitosamente.";
	} else {
		$mensaje = "Actualizado exitosamente.";
	}
  } else {
	$mensaje = "No se pudo realizar la operación, verfique sus datos.";
  }
}

if($window === 'nuevo' || $window === 'modi'){
	
	mysql_select_db($database_bd_server, $bd_server);
	$query_bd_data = sprintf("SELECT * FROM tipo_foros WHERE IdTipoForo = %s", GetSQLValueString($id, "int"));
	$bd_data = mysql_query($query_bd_data, $bd_server) or die(mysql_error());
	$row_bd_data = mysql_fetch_assoc($bd_data);
// --------------------------------------------------------------------------------
// AGREGAR Y MODIFICAR ELEMENTOS	
?>

<p><a class="btn" href="./?page=<?php echo $section_name?>">Regresar al listado</a> 
<a class="btn" href="./?page=<?php echo $section_name?>&opt=nuevo"><?php echo $insertar_msj ?></a></p>


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
      <td nowrap align="right" width="30%">Tipo de foro:</td>
      <td><input class="span7" type="text" name="TipoForo" value="<?php echo $row_bd_data ? $row_bd_data['TipoForo'] : ""; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input class="btn primary" type="submit" value="Continuar">
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
				$where = "WHERE TipoForo LIKE '%" . $_POST['search'] . "%'" ;
				$show_where = "Resultados de búsqueda por nombre de grupo";
				break;
			default:
			$where = "ORDER BY TipoForo ASC LIMIT 0 , 20";
			$show_where = "Mostrando los primeros 20";
		}
	} else {
		$where = "ORDER BY TipoForo ASC LIMIT 0 , 20";
		$show_where = "Mostrando los primeros 20";
	}

	mysql_select_db($database_bd_server, $bd_server);
	$query = "SELECT * FROM tipo_foros " . $where;
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
        <option value="1"<?php if(isset($_POST['opcion']) && $_POST['opcion'] == 1) echo ' selected="selected"'; ?>>Nombre del tipo de foro</option>
      </select>
      <input type="text" name="search" placeholder="Texto a buscar" id="search" value="<?php if(isset($_POST['search'])) echo $_POST['search']; ?>">
    <input class="btn primary" value="Ir" type="submit">
    <a class="btn" href="./?page=<?php echo $section_name?>&opt=nuevo"><?php echo $insertar_msj ?></a>
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
      	<th>Tipo de foro</th>
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
        <tr id="row-<?php echo $row['IdTipoForo']; ?>">
          <td><?php echo $row['TipoForo']; ?></td>
          <td>
          <?php if(overdriveControlAcceso($section_name."-modificar", false)){ ?>
          <a class="btn" href="./?page=<?php echo $section_name?>&opt=modi&id=<?php echo $row['IdTipoForo']; ?>">Editar</a> 
          <?php }
		   if(overdriveControlAcceso($section_name."-eliminar", false)){ ?>
		  <a class="btn" href="#" rel="delete" name="<?php echo $row['IdTipoForo']; ?>">X</a></td>
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