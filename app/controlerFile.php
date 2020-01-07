<?php
// --------------------------------------------------------------
// Controlador que realiza la gestión de ficheros de un usuario
// ---------------------------------------------------------------

include_once 'config.php';
include_once 'modeloFile.php';
include_once 'gestionFicheros.php';

// Muestro la tabla con los archivos
function ctlFileVerArchivos (){
    $tieneFicheros =modeloFileInit();
    if(!$tieneFicheros){
        header('Location:index.php?orden2=Subir');
    }else{
    // Obtengo los datos del usuario
    $archivosUsuario = modeloFileGetAll();
    }
    include_once 'plantilla/verarchivos.php';
}
function ctlFileSubir(){
    $resultadoSubida =subirficheros();
    include_once 'plantilla/subirArchivos.php';
}