<h2>Explorar foros<small></small></h2>
<p>Para visualizar los foros de la página.</p>

<?php

$id = -1;
$window = "lista";
$isInsert = true;

$section_name = "foros_comentarios";
$insertar_msj = "Ver foro";
$actualizar_msj = "Ver foro";

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
		$SQL = " INSERT INTO `comentarios_foros` (ComentarioForo, IdUsuario, IdForo) VALUES (%s, %s, %s)";
		$isInsert = true;
	} else {
		$SQL = "INSERT INTO `comentarios_foros` (ComentarioForo, IdUsuario, IdForo) VALUES (%s, %s, %s)";
		$isInsert = false;
	}
	
	$updateSQL = sprintf($SQL,
				   GetSQLValueString($_POST['ComentarioForo'], "text"),
				   GetSQLValueString($_SESSION['IdUsuario'], "text"),
				   GetSQLValueString($id, "text"));

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
	$query_bd_data = sprintf("SELECT * FROM foros WHERE IdForo = %s", GetSQLValueString($id, "int"));
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
      <td nowrap align="right" width="30%">Foro:</td>
      <td><input class="span7" type="text" name="Foro" value="<?php echo $row_bd_data ? $row_bd_data['Foro'] : ''; ?>" disabled="disabled" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Fecha Vigencia:</td>
      <td><input class="span7" type="text" name="FechaVigencia" disabled="disabled" value="<?php echo $row_bd_data ? $row_bd_data['FechaVigencia'] : ''; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2">
      <?php 
		$query = "SELECT * FROM  comentarios_foros WHERE IdForo = " . $id;
		$consulta_tema = mysql_query($query, $bd_server) or die(mysql_error());
		$row_tema = mysql_fetch_assoc($consulta_tema);
		$totalRows_tema = mysql_num_rows($consulta_tema); ?>
        
        <table class="bordered-table zebra-striped" style="width: 100%; margin-left: auto; margin-right: auto">
          <thead>
            <th>Comentario del Foro</th>
            <th>Id Usuario</th>
            <th>Fecha de Comentario</th>
            <th></th>
          </thead>
          <tbody>
          <?php 
          if($totalRows_tema === 0){ ?>
          <tr>
          <td colspan="4">Ningún tema asignado.</td>
          </tr>      
          <?php } else {
          do { ?>
            <tr id="row-<?php echo $row_tema['IdComentarioForo']; ?>">
              <td><?php echo $row_tema['ComentarioForo']?></td>
              <td><?php echo $row_tema['IdUsuario']; ?></td>
              <td><?php echo $row_tema['FechaComentario']; ?></td>
              <td>
              <?php if(overdriveControlAcceso($section_name."-eliminar", false)){ ?>
		  <a class="btn" href="#" rel="delete" name="<?php echo $row_tema['IdComentarioForo']; ?>">X</a></td>
           <?php } ?>
            </tr>
            <?php } while ($row_tema = mysql_fetch_assoc($consulta_tema));
          }?>
        </tbody>
        </table>
      </td>
      </tr>
      <tr>
      <td nowrap align="right" valign="top" colspan="2">
      	  <table align="center" class="noborder" style="width: 70%; margin-left: auto; margin-right: auto">
            <tr valign="baseline">
              <td nowrap align="right" width="30%">Tu Comentario:</td>
              <td><input class="span7" type="text" name="ComentarioForo" value="" size="32"></td>
            </tr>
          </table>
      </td>
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
				$where = "WHERE Foro LIKE '%" . $_POST['search'] . "%'" ;
				$show_where = "Resultados de búsqueda por nombre y apellido";
				break;
			case 2:
				$where = "WHERE FechaVigencia LIKE '%" . $_POST['search'] . "%'";
				$show_where = "Resultados de búsqueda por correo electrónico";
				break;
			default:
			$where = "ORDER BY Foro ASC LIMIT 0 , 20";
			$show_where = "Mostrando los primeros 20";
		}
	} else {
		$where = "ORDER BY Foro ASC LIMIT 0 , 20";
		$show_where = "Mostrando los primeros 20";
	}

	mysql_select_db($database_bd_server, $bd_server);
	$query = "SELECT IdForo, Foro, FechaAlta, FechaVigencia FROM foros " . $where;
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
        <option value="1"<?php if(isset($_POST['opcion']) && $_POST['opcion'] == 1) echo ' selected="selected"'; ?>>Nombre foro</option>
        <option value="2"<?php if(isset($_POST['opcion']) && $_POST['opcion'] == 2) echo ' selected="selected"'; ?>>Fecha vigencia</option>
      </select>
      <input type="text" name="search" placeholder="Texto a buscar" id="search" value="<?php if(isset($_POST['search'])) echo $_POST['search']; ?>">
    <input class="btn primary" value="Ir" type="submit">
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
        <th>Foro</th>
        <th>Fecha vigencia</th>
        <th>Fecha alta</th>
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
        <tr id="row-<?php echo $row['IdForo']; ?>">
          <td><?php echo $row['Foro']; ?></td>
          <td><?php echo $row['FechaVigencia']?></td>
          <td><?php echo $row['FechaAlta'] ?></td>
          <td>
          <?php if(overdriveControlAcceso($section_name."-nuevo", false)){ ?>
          <a class="btn" href="./?page=<?php echo $section_name?>&opt=modi&id=<?php echo $row['IdForo']; ?>">Ver foro</a> 
			</td>
           <?php } ?>
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