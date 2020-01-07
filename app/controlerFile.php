<?php
// --------------------------------------------------------------
// Controlador que realiza la gestión de ficheros de un usuario
// ---------------------------------------------------------------
include_once 'config.php';
include_once 'modeloFile.php';
// Muestro la tabla con los archivos
function ctlFileVerArchivos (){
    // Obtengo los datos del usuario
    $archivosUsuario = modeloFileGetAll();
    include_once 'plantilla/verarchivos.php';

}