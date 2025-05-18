<?php session_start(); 
$no_validate = true;
$required_connect = true;
require_once('connections/data.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php
$footer = "<p>&copy; ITVH 2013</p>";
$pagina;
$name_pagina = "inicio";
$from_bd = false;

	if(isset($_GET['page'])){
		$name_pagina = str_replace("-", "-", $_GET['page']);
		$p = $name_pagina . ".php";
		if(file_exists("views/".$p)){
			$pagina = "views/".$p;
		} else {
			mysql_select_db($database_bd_server, $bd_server);
			$query_bd_server = sprintf("SELECT * FROM contenidos WHERE alias = '%s'", $name_pagina);
			$bd_data = mysql_query($query_bd_server, $bd_server) or die(mysql_error());
			if(mysql_num_rows($bd_data) > 0 ){
				$page = mysql_fetch_assoc($bd_data);
				$from_bd = true;
			} else{
				$pagina = "views/inicio.php";
			}
		}
	} else {
		$pagina = "views/inicio.php";
	}

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="css/themes/base/jquery.ui.all.css">
<script src="js/jquery-1.6.2.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>

<title><?php if($from_bd) echo $page['titulo']; else echo "Ambiente de aprendizaje"; ?></title>
<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
<link href="css/application.css" rel="stylesheet" type="text/css" media="all" />
<link rel="shortcut icon" href="img/favicon.ico" type="image/ico" />

<style type="text/css">
  body {
    padding-top: 60px;
  }
</style>

</head>

<body>
    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="./">Ambiente de aprendizaje</a>
          <ul class="nav">
            <li><a href="./">Inicio</a></li>
            <li><a href="#">Acerca de</a></li>
          </ul>
          <p class="pull-right" style="color: #999">Logeado como <a href="#">usuario</a></p>
        </div>
      </div>
    </div>

    <div class="container-fluid">
    <?php if($from_bd) echo "<h1 class=\"title\">".$page['titulo']."</h1>"; ?>
    <?php if($from_bd) echo $page['contenido']; else require_once($pagina); ?>

    </div>
    

</body>
</html>