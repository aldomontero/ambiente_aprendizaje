<div class="sidebar">
<div class="well">
  <h5>Tareas en grupos</h5>
  <ul><!-- grupos_altas, grupos_modificacion, grupos_bajas, grupos, grupos_agregar_usuarios, grupos_agregar_temas, grupos_quitar_usuarios, grupos_quitar_temas

 -->

    <?php if(overdriveControlAcceso("grupos", false)){ ?><li><a href="./?page=grupos_control">Grupos</a></li><?php } ?>
     <?php if(overdriveControlAcceso("grupos_control-nuevo", false)){ ?><li><a href="./?page=grupos_control&opt=nuevo">Nuevo grupo</a></li><?php } ?>
  </ul>
  <h5>Asignaciones a grupos</h5>
  <ul><!-- usuarios, usuarios_altas, usuarios_modificacion, usuarios_bajas
 -->

    <?php if(overdriveControlAcceso("grupos_agregartemas", false)){ ?><li><a href="./?page=grupos_agregartemas">Agregar temas a grupos</a></li><?php } ?>
     <?php if(overdriveControlAcceso("grupos_agregarusuarios", false)){ ?><li><a href="./?page=grupos_agregarusuarios">Agregar usuarios a un grupo</a></li><?php } ?>
  </ul>
</div>
</div>
<div class="content">
<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
  <?php
	$extension_p = "inicio";
	
		if(isset($_GET['page']) && $_GET['page'] != "grupos"){
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
  <h1>Grupos</h1>
  <p>...</p>
  <p><a class="btn primary large">Listado &raquo;</a></p>
  
<?php } ?>
</div>

</div>

