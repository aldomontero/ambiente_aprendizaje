<div class="sidebar">
<div class="well">
  <h5>Tareas en foros</h5>
  <ul><!-- foros, foros _altas, foros_modificacion, foros_bajas, foros_agregar_comentarios, foros_eliminar_comentarios -->

    <?php if(overdriveControlAcceso("foros", false)){ ?><li><a href="./?page=foros_control">Foros</a></li><?php } ?>
    <?php if(overdriveControlAcceso("foros_control-nuevo", false)){ ?><li><a href="./?page=foros_control&opt=nuevo">Nuevo foro</a></li><?php } ?>
    <?php if(overdriveControlAcceso("foros_comentarios", false)){ ?><li><a href="./?page=foros_comentarios">Explorar comentarios</a></li><?php } ?>
  </ul>
  
  <h5>Tipo de foros</h5>
  <ul><!-- foros, foros _altas, foros_modificacion, foros_bajas, foros_agregar_comentarios, foros_eliminar_comentarios -->

    <?php if(overdriveControlAcceso("foros_tipo", false)){ ?><li><a href="./?page=foros_tipo">Tipo de foros</a></li><?php } ?>
    <?php if(overdriveControlAcceso("foros_tipo-nuevo", false)){ ?><li><a href="./?page=foros_tipo&opt=nuevo">Nuevo tipo de foro</a></li><?php } ?>
  </ul>
</div>
</div>
<div class="content">
<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
<?php
	$extension_p = "inicio";
	
		if(isset($_GET['page']) && $_GET['page'] != "foros"){
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
  <h1>Foros</h1>
  <p>...</p>
  <p><a class="btn primary large">Listado &raquo;</a></p>
  
    <?php } ?>
</div>


</div>

