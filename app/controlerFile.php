<?php
// --------------------------------------------------------------
// Controlador que realiza la gestión de ficheros de un usuario
// ---------------------------------------------------------------

include_once 'config.php';
include_once 'ModeloFicherosDB.php';
include_once 'Fichero.php';

// Muestro la tabla con los archivos
function ctlFileVerArchivos()
{
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        header('refresh:5; url=index.php?orden2=VerArchivos');
    }
    $directorio = RUTA_FICHEROS . '/' . $_SESSION['user'];
    if (!is_dir($directorio)) {
        mkdir(RUTA_FICHEROS . '/' . $_SESSION['user'], 0777);
    }
    $justFiles = ModeloFicherosDB::FileGetAllByUser($_SESSION['user']);

    include_once 'plantilla/verarchivos.php';
}

function ctlFileSubir()
{
    $codigosErrorSubida = [
        0 => 'Subida correcta',
        1 => 'El tamaño del archivo excede el admitido por el servidor',  // directiva upload_max_filesize en php.ini
        2 => 'El tamaño del archivo excede el admitido por el cliente',  // directiva MAX_FILE_SIZE en el formulario HTML
        3 => 'El archivo no se pudo subir completamente',
        4 => 'No se seleccionó ningún archivo para ser subido',
        6 => 'No existe un directorio temporal donde subir el archivo',
        7 => 'No se pudo guardar el archivo en disco',  // permisos
        8 => 'Una extensión PHP evito la subida del archivo', // extensión PHP
        9 => 'Su plan no admite que guarde tantos ficheros o ha excedido el número de megas contratados'
    ];
    $errorFichero = 3;
    if (isset($_FILES) && !empty($_FILES)) {
        $directorioSubida = RUTA_FICHEROS . '/' . $_SESSION['user'];
        $temporalFichero = $_FILES['archivo1']['tmp_name'];
        $errorFichero = $_FILES['archivo1']['error'];
        $nombreFichero = $_FILES['archivo1']['name'];
        $tamanioFichero = $_FILES['archivo1']['size'];
        $msg = "";
        //Comprobamos si podemos subir por peso total de ficheros, por tamaño del fichero subido y por numero de ficheros
        if ($tamanioFichero > TAMMAXIMOFILE) {
            $errorFichero = 2;
        }
        if ($_SESSION['tipouser'] != "Máster") {
            $numMaxArchivos = hallarNumeroMaximoArchivos($_SESSION['tipouser']);
            $tamMaxFicheros = hallarTamMaximoFicheros($_SESSION['tipouser']);
            $totalArchivosSubidos = ModeloFicherosDB::FileGetAllNumbereByUser($_SESSION['user']);
            $totalArchivosSubidosFinal = $totalArchivosSubidos['total_ficheros'];
            $totalPesoCarpeta = ModeloFicherosDB::FileGetAllSizeByUser($_SESSION['user']);
            $totalPesoCarpetaFinal = $totalPesoCarpeta['suma_total'];
            if ($totalArchivosSubidosFinal + 1 > $numMaxArchivos || $totalPesoCarpetaFinal + $tamanioFichero > $tamMaxFicheros) {
                $errorFichero = 9;
            }
        }
    }
    // Obtengo el código de error de la operación, 0 si ha ido bien
    if ($errorFichero > 0) {
        $msg .= "Se ha producido el error: $errorFichero:"
            . $codigosErrorSubida[$errorFichero] . ' <br />';
    } else { // subida correcta del temporal
        // si es un directorio y tengo permisos
        if (is_dir($directorioSubida) && is_writable($directorioSubida)) {
            //Intento mover el archivo temporal al directorio indicado
            $path = $directorioSubida . '/' . $nombreFichero;
            if (!move_uploaded_file($temporalFichero, $path)) {
                $msg .= 'ERROR: Archivo no guardado correctamente <br />';
            } else {
                $msg .= 'Archivo guardado correctamente <br />';
                $filesize = filesize($path);
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $hash = md5($nombreFichero);
                $fichero = new Fichero($nombreFichero, $filesize, $extension, $hash, $_SESSION['user']);
                // modeloFicherosDB::Init();
                ModeloFicherosDB::FileAdd($fichero);
            }
        } else {
            $msg .= 'ERROR: No es un directorio correcto o no se tiene permiso de escritura <br />';
        }
    }
    header('Location:index.php?orden2=VerArchivos&msg=' . $msg);
}

function ctlFileDescargar($resultDesdeCompartir = null)
{

    //1.- COger la extension del fichero y meterla para el contenttype
    //2.- Tabla en bbdd id title (nombre que viene del usuario) name (random id del fichero) idU
    //redirigir

    if (empty($resultDesdeCompartir)) {
        $archivo = $_GET['id'];
        $usuario = $_SESSION['user'];
    } else {
        $archivo = $resultDesdeCompartir['nombre'];
        $usuario = $resultDesdeCompartir['usuario'];
    }

    $directorio = RUTA_FICHEROS . '/' . $usuario . '/' . $archivo;
    if (!empty($archivo) && file_exists($directorio)) {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$archivo");
        header("Content-Transfer-Encoding: binary");
        // Read the file
        readfile($directorio);
        return;
    }

}

function ctlFileBorrar()
{
    $archivo = $_POST['id'];
    $directorio = RUTA_FICHEROS . '/' . $_SESSION['user'] . '/' . $archivo;
    if (!empty($archivo) && file_exists($directorio)) {
        unlink($directorio);
        ModeloFicherosDB::FileDel($archivo);
        echo "Archivo borrado correctamente";
    } else {
        echo "No se ha podido borrar el archivo";
    }
}

function ctlFileRenombrar()
{
    $nombreActual = $_POST['actual'];
    $nombreNuevo = $_POST['nuevo'];
    $rutaNombreActual = RUTA_FICHEROS . '/' . $_SESSION['user'] . '/' . $_POST['actual'];
    $rutaNombreNuevo = RUTA_FICHEROS . '/' . $_SESSION['user'] . '/' . $nombreNuevo;
    if (!empty($nombreActual) && file_exists($rutaNombreActual)) {
        rename($rutaNombreActual, $rutaNombreNuevo);
        ModeloFicherosDB::FileUpdate($nombreActual, $nombreNuevo);
        echo "Se ha modificado el fichero " . $nombreActual . " a " . $nombreNuevo . " correctamente";
    } else {
        echo "No se ha podido modificar correctamente el fichero " . $nombreActual . ". No exite en el directorio";
    }

}

function ctlFileCompartir()
{
    $result = ModeloFicherosDB::FileGetByHash($_GET['id']);
    ctlFileDescargar($result);
}


//funciones auxiliares
function hallarNumeroMaximoArchivos($tipouser)
{
    switch ($tipouser) {
        case 'Básico':
            $numeroMaximoArchivos = LIMITE_FICHEROS[0];
            break;
        case 'Profesional':
            $numeroMaximoArchivos = LIMITE_FICHEROS[1];
            break;
        case 'Premium':
            $numeroMaximoArchivos = LIMITE_FICHEROS[2];
            break;
    }
    return $numeroMaximoArchivos;
}

function hallarTamMaximoFicheros($tipouser)
{
    switch ($tipouser) {
        case 'Básico':
            $tamMaxArchivos = LIMITE_ESPACIO[0];
            break;
        case 'Profesional':
            $tamMaxArchivos = LIMITE_ESPACIO[1];
            break;
        case 'Premium':
            $tamMaxArchivos = LIMITE_ESPACIO[2];
            break;
    }
    return $tamMaxArchivos;
}