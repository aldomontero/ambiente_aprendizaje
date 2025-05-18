<div class="sidebar">
<div class="well">
  <h5>Tareas en usuarios</h5>
  <ul><!-- usuarios, usuarios_altas, usuarios_modificacion, usuarios_bajas
 -->

    <?php if(overdriveControlAcceso("usuarios_control", false)){ ?><li><a href="./?page=usuarios_control">Usuarios</a></li><?php } ?>
     <?php if(overdriveControlAcceso("usuarios_control-nuevo", false)){ ?><li><a href="./?page=usuarios_control&opt=nuevo">Nuevo usuario</a></li><?php } ?>
  </ul>
</div>
</div>
<div class="content">
<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
  <?php
	$extension_p = "inicio";
	
		if(isset($_GET['page']) && $_GET['page'] != "usuarios"){
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
  <h1>Usuarios</h1>
  <p>...</p>
  <p><a class="btn primary large">Listado &raquo;</a></p>

<?php } ?>
</div>

</div>

