<h2>Consultar temas<small></small></h2>
<p>Para ver los temas y los subtemas.</p>

<?php

$id = -1;
$window = "lista";
$isInsert = true;

$section_name = "objetos_tema";
$insertar_msj = "Nuevo tema";
$actualizar_msj = "Actualizar datos del tema";

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
    <a class="btn" href="./?page=<?php echo $section_name?>&opt=nuevo"><?php echo $insertar_msj ?></a><br />
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
        <tr id="row-<?php echo $row['IdTema']; ?>" <?php if( $row['IdTema'] == '0') echo "style='background-color: gray'"; else echo "style='background-color: silver; left: 10px'"; ?>>
          <td><?php echo $row['Tema']; ?></td>
          <td><?php echo $row['FechaAlta']?></td>
          <td><?php echo $row['Visibilidad'] ?></td>
          <td>
          <?php /*
		   if(overdriveControlAcceso($section_name."-eliminar", false)){ ?>
		  <a class="btn" href="#" rel="delete" name="<?php echo $row['IdTema']; ?>">X</a>
           <?php } */?></td>
        </tr>
        <?php } while ($row = mysql_fetch_assoc($consulta));
	  }?>
    </tbody>
    </table>

<!-- FIN CONTENIDO -->
  
<?php
	mysql_free_result($consulta);

?>