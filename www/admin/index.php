<?php 
if(!isset($_SESSION))
	session_start();
//$no_validate = true;

$system_prefix = "";
$required_connect = "true";
require_once('../connections/data.php'); ?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">

    <title>Ambiente de aprendizaje (Usuarios)</title>
    <meta name="description" content="">
    <meta name="author" content="">
	
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/ico" />
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />

    <script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery.ui.core.js"></script>
	<script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="../js/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" src="../js/jquery.ui.datepicker-es.js"></script>
    <script type="text/javascript" src="../js/jquery.maskedinput.js"></script>
    
	<script type="text/javascript" src="../js/jquery.validate.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.messages.es.js"></script>
    
    <script type="text/javascript" src="../js/montero.ajaxsetup.js"></script>
 
    
<style type="text/css">
  body {
    padding-top: 60px;
  }
  .container-fluid p{
	  font-size: 10pt;
  }
</style>

</head>

  <body>
    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="./">Ambiente de aprendizaje</a>
          <ul class="nav">
            <?php if(overdriveControlAcceso("inicio", false)){ ?><li><a href="./">Inicio</a></li><?php } ?>
            <?php if(overdriveControlAcceso("foros", false)){ ?><li><a href="./?page=foros">Foros</a></li><?php } ?>
            <?php if(overdriveControlAcceso("usuarios", false)){ ?><li><a href="./?page=usuarios">Usuarios</a></li><?php } ?>
            <?php if(overdriveControlAcceso("grupos", false)){ ?><li><a href="./?page=grupos">Grupos</a></li><?php } ?>
            <?php if(overdriveControlAcceso("objetos", false)){ ?><li><a href="./?page=objetos">Temas</a></li><?php } ?>
            <?php if(overdriveControlAcceso("objetos_ver", false)){ ?><li><a href="./?page=objetos_ver">Objetos didácticos</a></li><?php } ?>
            <?php if(overdriveControlAcceso("mensajes", false)){ ?><li><a href="./?page=mensajes">Mensajes</a></li><?php } ?>
            <?php if(overdriveControlAcceso("cambiarpass", false)){ ?><li><a href="./?page=cambiarpass">Contraseña</a></li><?php } ?>
            
            <li><a href="logout.php">Cerrar sesión</a></li>
          </ul>
          <p class="pull-right" style="color: #999">Logeado como <a href="#"><?php echo $_SESSION['Username'] ?></a></p>
        </div>
      </div>
    </div>

    <div class="container-fluid">
		<?php
		$pagina;
			if(isset($_GET['page'])){
				$ex = explode("_", $_GET['page']);
				$p = $ex[0] . ".php";
				if(file_exists("views/".$p)){
					$pagina = "views/".$p;
				} else {
					$pagina = "views/inicio.php";
				}
			} else {
				$pagina = "views/inicio.php";
			}
			
			//include($pagina); // <---- quitar al usar la BD
			if(isset($_SESSION['Rol']) && !isset($no_validate)){
				//el metodo controlAcceso recibe el rol del usuario y luego el nombre del recurso
				if(overdriveControlAcceso($system_prefix . getView(), false))
					include($pagina);
				else
					include("views/access_denied.php");
				//echo getNameScript($_SERVER['PHP_SELF']);
			}
		
		?>

    </div>
    

</body>
</html>