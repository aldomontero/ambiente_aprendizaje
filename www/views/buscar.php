<h1 class="title">Búsqueda de ranchos</h1>

<p>Para comenzar introduzca el rancho que deaea buscar y haga clic en Ir.</p>

<?php
// --------------------------------------------------------------------------------
	$show_where = "";

	if (isset($_GET['opcion']) && isset($_GET['search'])) {
		switch($_GET['opcion']){
			case 1:
				if($_GET['municipio'] != "")
					$where = "WHERE ranchos.municipio = '" . $_GET['municipio'] . "' AND ";
				else
					$where = "WHERE ";
					
				$where .= "ranchos.titulo LIKE '%" . $_GET['search'] . "%' ORDER BY ranchos.id DESC";
				$show_where = "Resultados de búsqueda por nombre de rancho";
				break;
			default:
			$where = "ORDER BY ranchos.id DESC LIMIT 0 , 10";
			$show_where = "Mostrando los últimos 10 ranchos";
		}
	} else {
		$where = "ORDER BY ranchos.id DESC LIMIT 0 , 10";
		$show_where = "Mostrando los últimos 10 ranchos";
	}

	mysql_select_db($database_bd_server, $bd_server);
	$query = "SELECT ranchos.id, foto, titulo, descripcion, fecha_publicacion, municipios.municipio FROM ranchos INNER JOIN municipios ON ranchos.municipio = municipios.id " . $where;
	$consulta = mysql_query($query, $bd_server) or die(mysql_error());
	$row = mysql_fetch_assoc($consulta);
	$totalRows = mysql_num_rows($consulta); 
	
	$query = "SELECT ranchos_detalle.id_rancho, ranchos_detalle.cantidad, servicios.titulo FROM ranchos_detalle INNER JOIN servicios ON ranchos_detalle.id_servicio = servicios.id INNER JOIN ranchos ON ranchos_detalle.id_rancho = ranchos.id " . $where;
	$consulta_detail = mysql_query($query, $bd_server) or die(mysql_error());
	$row_detail = mysql_fetch_assoc($consulta_detail);

	$query_bd_data = "SELECT id, municipio FROM municipios ORDER BY municipio ASC";
		$bd_data_municipios = mysql_query($query_bd_data, $bd_server) or die(mysql_error());
// --------------------------------------------------------------------------------
// LISTAR ELEMENTOS
?>

<form action="" class="busqueda" name="registro" id="registro" method="GET">
<fieldset>
    <label for="usuario">Buscar en:&nbsp;&nbsp;</label>
      <input name="page" value="ranchos" type="hidden">
      <select name="municipio" id="municipio" style="width: 120px"><option value="">Todos</option>
		<?php while($row_bd_data_municipios = mysql_fetch_assoc($bd_data_municipios)){ ?>
  		<option value="<?php echo $row_bd_data_municipios['id']?>" <?php if ((strcmp($row_bd_data_municipios['id'], isset($_GET['id']) ? $_GET['id'] : ""  ))) {echo "SELECTED";} else{ if (!(strcmp(strtolower($row_bd_data_municipios['municipio']), isset($_GET['mun']) ? strtolower($_GET['mun']) : ""  ))) {echo "SELECTED"; }} ?>><?php echo $row_bd_data_municipios['municipio']?></option>
		<?php } ?>
      </select> a
      <input type="text" name="search" placeholder="Rancho a buscar" id="search" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
    <input class="btn primary" value="Buscar" type="submit">
    <input name="opcion" value="1" type="hidden">
    
</fieldset>
<input type="hidden" name="MM_insert" value="registro" />
</form>

<?php
  echo "<p style='color:green'>" . $show_where . "</p>";
?>
<table class="bordered-table zebra-striped" style="width: 100%">
  <thead>
    <th></th>
    <th>Rancho</th>
    <!-- <th>Fecha de creación</th> -->
  </thead>
  <tbody>
  <?php 
  if($totalRows === 0){ ?>
  <tr>
  <td colspan="3">Ningún elemento publicado.</td>
  </tr>    
  <?php } else {
  do { ?>
    <tr>
      <td style="width: 100px"><?php
	  if($row['foto'] != NULL){
		$file = "img/logo_ranch/icon" . $row['id'] . "." . $row['foto'];
		if(is_file($file)){ ?>
			<img src="<?php echo $file ?>" width="120" height="100" border="0" />
	  <?php }
	  } ?></td>
      <td><strong><a href="./?page=verrancho&id=<?php echo $row['id']; ?>"><?php echo $row['titulo']; ?></a></strong> en <?php echo $row['municipio']; ?><br />
        
      <?php echo $row['descripcion'] . "<br><br>Estos son los servicios que ofrece:<br /><br /><ul>";
	  
	  $next = true;
	  $count = 0;
	  do {
		  if($row_detail['id_rancho'] === $row['id']){
			echo "<li>".$row_detail['cantidad'] . " " .$row_detail['titulo'] . "</li>";
			$next = true;
			$count++;
		  } else {
			$next = false;
			if($count === 0)
				echo "<li>Rancho sin servicios que ofrecer por el momento.</li>";
			else
				$count = 0;
		  }
	  } while($next && $row_detail = mysql_fetch_assoc($consulta_detail));
	   ?></ul></td>
      <!-- <td style="width: 120px"><?php echo mysqldate_to_stardant(DATE_WITH_LETTERS, $row['fecha_publicacion']); ?></td> -->
      
    </tr>
    <?php } while ($row = mysql_fetch_assoc($consulta));
  }?>
</tbody>
</table>
