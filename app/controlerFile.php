<?php
// --------------------------------------------------------------
// Controlador que realiza la gestión de ficheros de un usuario
// ---------------------------------------------------------------
include_once 'config.php';
include_once 'modeloFile.php';
// Muestro la tabla con los archivos
function ctlFileVerArchivos (){
    $usuario = $_SESSION['user'];
    if ($_SESSION['tusuarios'][$usuario][3]== 'I'){
        $_SESSION['modo'] == GESTIONUSUARIOS;
        $_SESSION['mensaje'] == 'Su usuario sigue sin activar. Pruebe en las próximas horas';
        header('Location:index.php?orden=Inicio');
    }
    // Obtengo los datos del usuario
    $archivosUsuario = modeloFileGetAll();

    include_once 'plantilla/verarchivos.php';

}