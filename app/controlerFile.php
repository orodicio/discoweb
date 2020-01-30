<?php
// --------------------------------------------------------------
// Controlador que realiza la gestión de ficheros de un usuario
// ---------------------------------------------------------------

include_once 'config.php';


// Muestro la tabla con los archivos
function ctlFileVerArchivos (){
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
    }
    $directorio = RUTA_FICHEROS.'/'.$_SESSION['user'];
    $justFiles = preg_grep('/^([^.])/',scandir($directorio));

    if(empty($justFiles)){
        $msg ="No tiene ningún fichero aún";

    }
    include_once 'plantilla/verarchivos.php';
}
function ctlFileSubir(){
    $codigosErrorSubida= [
        0 => 'Subida correcta',
        1 => 'El tamaño del archivo excede el admitido por el servidor',  // directiva upload_max_filesize en php.ini
        2 => 'El tamaño del archivo excede el admitido por el cliente',  // directiva MAX_FILE_SIZE en el formulario HTML
        3 => 'El archivo no se pudo subir completamente',
        4 => 'No se seleccionó ningún archivo para ser subido',
        6 => 'No existe un directorio temporal donde subir el archivo',
        7 => 'No se pudo guardar el archivo en disco',  // permisos
        8 => 'Una extensión PHP evito la subida del archivo'  // extensión PHP
    ];

        $directorioSubida =RUTA_FICHEROS.'/'.$_SESSION['user'];
        $temporalFichero =   $_FILES['archivo1']['tmp_name'];
        $errorFichero    =   $_FILES['archivo1']['error'];
        $nombreFichero   =   $_FILES['archivo1']['name'];
         $msg="";

        // Obtengo el código de error de la operación, 0 si todo ha ido bien
        if ($errorFichero > 0) {
            $msg .= "Se ha producido el error: $errorFichero:"
                . $codigosErrorSubida[$errorFichero] . ' <br />';
        } else { // subida correcta del temporal
            // si es un directorio y tengo permisos
            if ( is_dir($directorioSubida) && is_writable ($directorioSubida)) {
                //Intento mover el archivo temporal al directorio indicado
                if (!move_uploaded_file($temporalFichero,  $directorioSubida .'/'. $nombreFichero)) {
                    $msg .= 'ERROR: Archivo no guardado correctamente <br />';
                }
            } else {
                $msg .= 'ERROR: No es un directorio correcto o no se tiene permiso de escritura <br />';
            }
        }
    ctlFileVerArchivos ();
}
