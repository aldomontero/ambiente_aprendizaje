<div class="sidebar">
<div class="well">
  <h5>Tareas en temas</h5>
  <ul><!-- objeto_tema, objeto_tema_altas, objeto_tema_modificacion, objeto_tema_bajas
objeto_subtema, objeto_subtema_altas, objeto_subtema_modificacion, objeto_subtema_bajas
 -->

    <?php if(overdriveControlAcceso("objetos_tema", false)){ ?><li><a href="./?page=objetos_tema">Temas</a></li><?php } ?>
     <?php if(overdriveControlAcceso("objetos_tema-nuevo", false)){ ?><li><a href="./?page=objetos_tema&opt=nuevo">Nuevo tema</a></li><?php } ?>
     <?php if(overdriveControlAcceso("objetos_subir", false)){ ?><li><a href="./?page=objetos_subir">Subir objetos didácticos</a></li><?php } ?>
     <?php if(overdriveControlAcceso("objetos_ver", false)){ ?><li><a href="./?page=objetos_ver">Ver objetos didácticos</a></li><?php } ?>
  </ul>
  <h5>Tareas en subtemas</h5>
  <ul><!-- usuarios, usuarios_altas, usuarios_modificacion, usuarios_bajas
 -->

    <?php if(overdriveControlAcceso("objetos_subtema", false)){ ?><li><a href="./?page=objetos_subtema">Nuevos subtemas</a></li><?php } ?>
     <?php /*if(overdriveControlAcceso("objetos_subtema-nuevo", false)){ ?><li><a href="./?page=objetos_tema">Nuevo subtnema</a></li><?php }*/ ?>
  </ul>
  <h5>Consultas</h5>
  <ul>
    <?php if(overdriveControlAcceso("objetos_consulta", false)){ ?><li><a href="./?page=objetos_consulta">Consultar temas y subtemas</a></li><?php } ?>
  </ul>
</div>
</div>
<div class="content">
<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
  <?php
	$extension_p = "inicio";
	
		if(isset($_GET['page']) && $_GET['page'] != "objetos"){
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
  <h1>Temas</h1>
  <p>...</p>
  <p><a class="btn primary large">Listado &raquo;</a></p>
<?php } ?>

</div>

</div>

