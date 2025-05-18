<h2>Ver objetos didácticos<small></small></h2>
<p>Para ver ojetos didácticos a temas y a los subtemas.</p>

<?php

$tipo = 'tema';
$id = -1;
$window = "lista";
$isInsert = true;

$section_name = "objetos_ver";
$insertar_msj = "Ver archivos";
$actualizar_msj = "Ver archivos";

if(isset($_GET['opt'])){
	$window = $_GET['opt'];
}

if($window === 'nuevo' || $window === 'modi'){
	if(isset($_GET['id'])){
		$isInsert = true;
		$id = $_GET['id'];
		$tipo = $_GET['tipo'];
	}
}

if($window === 'nuevo' || $window === 'modi'){
	
	if($tipo == 'tema'){
		$query_bd_data = sprintf("SELECT temas.Tema, '' As SubTema FROM temas WHERE IdTema = %s", GetSQLValueString($id, "int"));
	} else {
		$query_bd_data = sprintf("SELECT subtemas.SubTema, temas.Tema FROM subtemas INNER JOIN temas ON subtemas.IdTema = temas.IdTema WHERE IdSubTema = %s", GetSQLValueString($id, "int"));
	}
	mysql_select_db($database_bd_server, $bd_server);
	$bd_data = mysql_query($query_bd_data, $bd_server) or die(mysql_error());
	$row_bd_data = mysql_fetch_assoc($bd_data);
// --------------------------------------------------------------------------------
// AGREGAR Y MODIFICAR ELEMENTOS	
?>

<p><a class="btn" href="./?page=<?php echo $section_name?>">Regresar al listado</a></p>


<h3 style="text-align:center">
<?php if (!$isInsert) {
		echo $actualizar_msj;
	} else {
		echo $insertar_msj;
	}
?>
</h3>
  <table align="center" class="noborder" style="width: 70%; margin-left: auto; margin-right: auto">
    <tr valign="baseline">
      <td nowrap align="right" width="30%">Tema:</td>
      <td><input class="span7" type="text" name="Tema" value="<?php echo $row_bd_data ? $row_bd_data['Tema'] : ''; ?>" size="32" disabled="disabled"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" width="30%">SubTema:</td>
      <td><input class="span7" type="text" name="Tema" value="<?php echo $row_bd_data ? $row_bd_data['SubTema'] : ''; ?>" size="32" disabled="disabled"></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2">
      <?php 
		$query = "SELECT * FROM objetos_didacticos WHERE IdObjeto = " . $id . " AND ObjetoDidacticoTema = " . ($_GET['tipo'] == 'tema' ? 1 : 0);
		$consulta_tema = mysql_query($query, $bd_server) or die(mysql_error());
		$row_tema = mysql_fetch_assoc($consulta_tema);
		$totalRows_tema = mysql_num_rows($consulta_tema); ?>
        
        <table class="bordered-table zebra-striped" style="width: 100%; margin-left: auto; margin-right: auto">
          <thead>
            <th>Titulo</th>
            <th>Archivo</th>
            <th>Tamaño (Kb)</th>
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
            <tr id="row-<?php echo $row_tema['IdObjetoDidactico']; ?>">
              <td><?php echo $row_tema['TituloObjetoDidactico']?></td>
              <td><?php echo $row_tema['ArchivoObjetoDidactico']; ?></td>
              <td><?php echo $row_tema['TamañoKBytes']; ?></td>
              <td>
           <a class="btn" href="./?page=objetos_ver&opt=archivo&name=file<?php echo $row_tema['IdObjetoDidactico'] . "." . obtener_extension($row_tema['ArchivoObjetoDidactico']); ?>" target="_blank">Ver archivo</a> 
           	</td>
            </tr>
            <?php } while ($row_tema = mysql_fetch_assoc($consulta_tema));
          }?>
        </tbody>
        </table>
      </td>
      </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td>
      <input class="btn" value="Regresar" type="button" onclick="window.location.href='./?page=<?php echo $section_name?>'" name="regresar"/></td>
    </tr>
  </table>


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
} else if($window === 'archivo'){
	echo "<iframe src='objetos/" . $_GET['name'] . "' width='100%' height='500' border='0'></iframe>";
} else {
	
	$show_where = "";

	if (isset($_POST['opcion']) && isset($_POST['search'])) {
		switch($_POST['opcion']){
			case 1:
				$where = "WHERE " . (isset($_POST['vis']) ? " Visibilidad = 0 AND" : " Visibilidad = 1 AND" ). " Tema LIKE '%" . $_POST['search'] . "%'" ;
				$show_where = "Resultados de búsqueda por tema";
				break;
			default:
			$where = (isset($_POST['vis']) ? " WHERE Visibilidad = 0 " : " WHERE Visibilidad = 1 " );
			$show_where = "Mostrando los primeros 20";
		}
	} else {
		$where = (isset($_POST['vis']) ? " WHERE Visibilidad = 0 " : " WHERE Visibilidad = 1 " );
		$show_where = "Mostrando los primeros 20";
	}

	mysql_select_db($database_bd_server, $bd_server);
	$query = "SELECT *
				FROM (
				SELECT 0 AS IdTema, IdTema AS Padre, Tema, Visibilidad, FechaAlta, 't' AS TIPO
				FROM TEMAS
				UNION ALL
				SELECT IdSubTema, TEMAS.IdTema AS Padre, SubTema, TEMAS.Visibilidad, SUBTEMAS.FechaAlta, 's' AS TIPO
				FROM SUBTEMAS
				INNER JOIN TEMAS ON SUBTEMAS.IDTEMA = TEMAS.IDTEMA
				) AS T
  	" . $where . " ORDER BY Padre, IdTema ASC";
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
    <br />
    <label><input type="checkbox" value="1" name="vis" <?php 
	if(isset($_POST['vis'])){
		echo ' checked="checked"';
	}?> /> No es visible</label><br />
</fieldset>
<input type="hidden" name="MM_insert" value="registro" />
</form>

    <?php
	  if(isset($mensaje))
		echo '<div class="alert-message bottom">' . $mensaje . '</div>';
	  echo "<p style='color:green'>" . $show_where . "</p>";
	?>
    <table class="bordered-table" style="width: 700px; margin-left: auto; margin-right: auto">
      <thead>
        <th>Tema</th>
        <th>Fecha alta</th>
        <th>Visibilidad</th>
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
        <tr id="row-<?php echo $row['IdTema']. $row['Padre']; ?>" <?php if( $row['IdTema'] == '0') echo "style='background-color: gray'"; else echo "style='background-color: silver; left: 10px'"; ?>>
          <td><?php echo $row['Tema']; ?></td>
          <td><?php echo $row['FechaAlta']?></td>
          <td><?php echo $row['Visibilidad'] ?></td>
          <td>
          <?php if(overdriveControlAcceso($section_name, false)){ ?>
          <a class="btn" href="./?page=<?php echo $section_name?>&opt=nuevo&id=<?php echo $row['Padre']; ?>&tipo=<?php if( $row['IdTema'] == '0') echo 'tema'; else echo 'subtema'; ?>">Explorar archivos</a> 
           <?php } ?>
           </td>
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