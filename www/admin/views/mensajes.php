<div class="sidebar">
<div class="well">
  <h5>Tareas en mensajes</h5>
  <ul><!-- mensajes, mensajes_altas, mensajes_modificacion, mensajes_bajas

 -->

    <?php if(overdriveControlAcceso("mensajes_salida-nuevo", false)){ ?><li><a href="./?page=mensajes_salida&opt=nuevo">Nuevo mensaje</a></li><?php } ?>
     <?php if(overdriveControlAcceso("mensajes_bandeja", false)){ ?><li><a href="./?page=mensajes_bandeja">Bandeja de entrada</a></li><?php } ?>
     <?php if(overdriveControlAcceso("mensajes_salida", false)){ ?><li><a href="./?page=mensajes_salida">Mensajes de salida</a></li><?php } ?>
  </ul>
</div>
</div>
<div class="content">
<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
<?php
	$extension_p = "inicio";
	
		if(isset($_GET['page']) && $_GET['page'] != "mensajes"){
			$extension_p = $_GET['page'] . ".php";
			if(file_exists("views/".$extension_p)){
				$extension_p = "views/".$extension_p;
			}
		}
		
		//include($pagina); // <---- quitar al usar la BD
		if(isset($_SESSION['Rol']) && !isset($no_validate) && $extension_p != 'inicio'){
			//el metodo controlAcceso recibe el rol del usuario y luego el nombre del recurso
			if(overdriveControlAcceso($system_prefix . getView(), false))
				include($extension_p);
			else
				include("views/access_denied.php");
			//echo getNameScript($_SERVER['PHP_SELF']);
		}
	if($extension_p == 'inicio'){
		?>
  <h1>Bandeja de mensajes</h1>
  <p>...</p>
  <p><a class="btn primary large">Listado &raquo;</a></p>
  <?php } ?>
</div>

</div>

