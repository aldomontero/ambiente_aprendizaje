<?php
/**
 * Acerca de este archivo
 *
 * Este script en PHP permite mantener la compatibilidad para conexiones
 * a bases de datos MySQL en códigos escritos en PHP 5 que necesitan
 * ejecutarse en entornos con PHP 8.
 *
 * No está diseñado para reemplazar ni fomentar el uso de código obsoleto
 * en versiones modernas de PHP. Su propósito es permitir que sistemas
 * heredados funcionen temporalmente en plataformas actualizadas que utilicen PHP 8.
 *
 *  About this file
 *
 *  This PHP script enables compatibility for MySQL database connections
 *  in legacy PHP 5 code that needs to run on PHP 8 environments.
 *
 *  It is not intended to replace or encourage the use of outdated code
 *  in modern PHP versions. Its purpose is to allow legacy systems to
 *  function temporarily on updated platforms running PHP 8.
 */

$GLOBAL_MySQLi = null;
$GLOBAL_MySQLi_BD = null;

if (!function_exists("mysql_pconnect")){
    function mysql_pconnect($host, $username, $password){
        global $GLOBAL_MySQLi;
        $GLOBAL_MySQLi = new mysqli($host, $username, $password);
        return $GLOBAL_MySQLi;
    }
}

if (!function_exists("mysql_select_db")){

    function mysql_select_db($db, $connection){
        global $GLOBAL_MySQLi;
        global $GLOBAL_MySQLi_BD;
        $GLOBAL_MySQLi_BD = $db;
        if($GLOBAL_MySQLi !== null)
            $GLOBAL_MySQLi->select_db($db);
    }
}

if (!function_exists("mysql_escape_string")){
    function mysql_escape_string($unescaped_string){
        global $GLOBAL_MySQLi;
        if($GLOBAL_MySQLi !== null)
            return $GLOBAL_MySQLi->real_escape_string($unescaped_string);
        else
            return $unescaped_string;
    }
}

if (!function_exists("mysql_num_rows")){
    function mysql_num_rows($result){
        if($result !== null)
            return $result->num_rows;
        else
            return false;
    }
}

if (!function_exists("mysql_query")){
    function mysql_query($query, $link_identifier = NULL){
        global $GLOBAL_MySQLi;
        if($GLOBAL_MySQLi !== null)
            return $GLOBAL_MySQLi->query($query);
        else
            return false;
    }
}

if (!function_exists("mysql_fetch_array")){
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH){
        if($result !== null)
            return $result->fetch_array($result_type);
        else
            return false;
    }
}

if (!function_exists("mysql_fetch_assoc")){
    function mysql_fetch_assoc($result){
        if($result !== null){
            $r = $result->fetch_assoc();
            return $r === null ? false : $r;
        } else {
            return false;
        }
    }
}

if (!function_exists("mysql_free_result")){
    function mysql_free_result($result){
        return true;
    }
}

if (!function_exists("mysql_error")){
    function mysql_error(){
        throw new  Exception("MySQL error. ");
    }
}

if(!function_exists("mysql_insert_id")){
    function mysql_insert_id(){
        global $GLOBAL_MySQLi;
        return $GLOBAL_MySQLi->insert_id;
    }
}
