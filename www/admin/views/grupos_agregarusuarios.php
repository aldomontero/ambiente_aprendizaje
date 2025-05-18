<h2>Usuarios y grupos<small></small></h2>
<p>Para gestionar la relación entre usuarios y grupos.</p>

<?php

$id = -1;
$window = "lista";
$isInsert = true;

$section_name = "grupos_agregarusuarios";
$insertar_msj = "Nueva asignacion de grupos";
$actualizar_msj = "Nueva asignacion de grupos";

if(isset($_GET['opt'])){
	$window = $_GET['opt'];
}

if($window === 'nuevo' || $window === 'modi'){
	if(isset($_GET['id'])){
		$isInsert = false;
		$id = $_GET['id'];
	}
	
	if($isInsert)
		overdriveControlAcceso($section_name."-nuevo"); //modificar
	else
		overdriveControlAcceso($section_name."-nuevo");
}

if ((isset($_POST["MM_form"])) && ($_POST["MM_form"] == "form1")) {
	if(strlen(trim($_POST['id'], " ")) === 0 ){
		$SQL = " INSERT INTO `usuarios_grupos` (IdUsuario,IdGrupo) VALUES (%s, %s)";
		$isInsert = true;
	} else {
		$SQL = "INSERT INTO `usuarios_grupos` (IdUsuario,IdGrupo) VALUES (%s, %s)";
		$isInsert = false;
	}
	
	$updateSQL = sprintf($SQL,
				   GetSQLValueString($_POST['Usuario'], "text"),
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
		$mensaje = "Registado exitosamente.";
	}
  } else {
	$mensaje = "No se pudo realizar la operación, verfique sus datos.";
  }
}

if($window === 'nuevo' || $window === 'modi'){
	
	mysql_select_db($database_bd_server, $bd_server);
	$query_bd_data = sprintf("SELECT * FROM grupos WHERE idGrupo = %s", GetSQLValueString($id, "int"));
	$bd_data = mysql_query($query_bd_data, $bd_server) or die(mysql_error());
	$row_bd_data = mysql_fetch_assoc($bd_data);
// --------------------------------------------------------------------------------
// AGREGAR Y MODIFICAR ELEMENTOS	
?>

<p><a class="btn" href="./?page=<?php echo $section_name?>">Regresar al listado</a>
<!--
<a class="btn" href="./?page=<?php echo $section_name?>&opt=nuevo"><?php echo $insertar_msj ?></a></p>
-->

<h3 style="text-align:center">
<?php if (!$isInsert) {
		echo $actualizar_msj;
	} else {
		echo $insertar_msj;
	}
?>
</h3>

    <?php
	  if(isset($mensaje))
		echo '<div class="alert-message bottom">' . $mensaje . '</div>';
	?>
    
<form method="post" name="registro" id="registro"  action="index.php?page=<?php echo $section_name?>&opt=modi&id=<?php echo $id ?>">
  <table align="center" class="noborder" style="width: 70%; margin-left: auto; margin-right: auto">
    <tr valign="baseline">
      <td nowrap align="right" width="30%">Grupo:</td>
      <td><input class="span7" type="text" name="Usuario" value="<?php echo $row_bd_data ? $row_bd_data['Grupo'] : ''; ?>" size="32" disabled="disabled"></td>
    </tr>
    <tr valign="baseline">
      <?php 
		$query = "SELECT ug.*, u.* FROM usuarios_grupos AS ug INNER JOIN Usuarios AS u ON ug.IdUsuario = u.id_usuario WHERE idGrupo = " . $id;
		$consulta_usuario = mysql_query($query, $bd_server) or die(mysql_error());
		$row_usuario = mysql_fetch_assoc($consulta_usuario);
		$totalRows_usuario = mysql_num_rows($consulta_usuario); ?>
        
        <table class="bordered-table zebra-striped" style="width: 100%; margin-left: auto; margin-right: auto">
          <thead>
            <th>Nombre</th>
            <th>Usuario</th>
            <th></th>
          </thead>
          <tbody>
          <?php 
          if($totalRows_usuario === 0){ ?>
          <tr>
          <td colspan="4">Ningún usuario asignado.</td>
          </tr>      
          <?php } else {
          do { ?>
            <tr id="row-<?php echo $row_usuario['IdUsuarioGrupo']; ?>">
              <td><?php echo $row_usuario['NombreUsuario']?></td>
              <td><?php echo $row_usuario['Usuario']; ?></td>
              <td>
              <?php if(overdriveControlAcceso($section_name."-eliminar", false)){ ?>
		  <a class="btn" href="#" rel="delete" name="<?php echo $row_usuario['IdUsuarioGrupo']; ?>">X</a></td>
           <?php } ?>
            </tr>
            <?php } while ($row_usuario = mysql_fetch_assoc($consulta_usuario));
          }?>
        </tbody>
        </table>
      <?php 
	  $query_sql = "SELECT * FROM usuarios";
	  $query = mysql_query($query_sql, $bd_server) or die(mysql_error());
	  ?>
      <td nowrap align="right" valign="top">Usuario:</td>
      <td><select name="Usuario">
      	<option value="">Seleccione</option>
        <?php  while ($row = mysql_fetch_assoc($query)) { ?>
        <option value="<?php echo $row['id_usuario']?>"><?php echo $row['Usuario'] . " : " . $row['NombreUsuario'];?></option>
        <?php
		}
		mysql_free_result($query);
		?>
      </select></td>
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
				$where = "WHERE Grupo LIKE '%" . $_POST['search'] . "%'" ;
				$show_where = "Resultados de búsqueda por nombre y apellido";
				break;
			default:
			$where = "ORDER BY Grupo ASC LIMIT 0 , 20";
			$show_where = "Mostrando los primeros 20";
		}
	} else {
		$where = "ORDER BY Grupo ASC LIMIT 0 , 20";
		$show_where = "Mostrando los primeros 20";
	}

	mysql_select_db($database_bd_server, $bd_server);
	$query = "SELECT IdGrupo, Grupo, IdUsuario FROM grupos " . $where;
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
        <option value="1"<?php if(isset($_POST['opcion']) && $_POST['opcion'] == 1) echo ' selected="selected"'; ?>>Nombres</option>
      </select>
      <input type="text" name="search" placeholder="Texto a buscar" id="search" value="<?php if(isset($_POST['search'])) echo $_POST['search']; ?>">
    <input class="btn primary" value="Ir" type="submit">
    <!--
    <a class="btn" href="./?page=<?php echo $section_name?>&opt=nuevo"><?php echo $insertar_msj ?></a>
    -->
</fieldset>
<input type="hidden" name="MM_insert" value="registro" />
</form>

    <table class="bordered-table zebra-striped" style="width: 700px; margin-left: auto; margin-right: auto">
      <thead>
      	<th>Nombre</th>
        <th>Usuario</th>
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
        <tr id="row-<?php echo $row['IdGrupo']; ?>">
          <td><?php echo $row['Grupo']; ?></td>
          <td><?php echo $row['IdUsuario']?></td>
          <td>
          <?php if(overdriveControlAcceso($section_name."-nuevo", false)){ ?>
          <a class="btn" href="./?page=<?php echo $section_name?>&opt=modi&id=<?php echo $row['IdGrupo']; ?>">Asignar usuarios</a> 
          <?php }?>
        </tr>
        <?php } while ($row = mysql_fetch_assoc($consulta));
	  }?>
    </tbody>
    </table>

<!-- FIN CONTENIDO -->
  
<?php
	mysql_free_result($consulta);
}
?>