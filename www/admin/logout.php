<?php
// *** Logout the current user.
$logoutGoTo = "../index.php";
session_start();

$_SESSION['Username'] = NULL;
$_SESSION['Nombre'] = NULL;
$_SESSION['Rol'] = NULL;
$_SESSION['IdUsuario'] = NULL;

unset($_SESSION['Username']);
unset($_SESSION['Nombre']);
unset($_SESSION['Rol']);
unset($_SESSION['IdUsuario']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
}
?>
