<?php
session_start();
include_once 'app/config.php';
include_once 'app/controlerFile.php';
include_once 'app/controlerUser.php';
include_once 'app/ModeloUserDB.php';
// Inicializo el modelo

modeloUserDB::Init();

// Enrutamiento
// Relación entre peticiones y función que la va a tratar
// Versión sin POO no manejo de Clases ni objetos
$rutasUser = [
    "Inicio" => "ctlUserInicio",
    "Alta" => "ctlUserAlta",
    "Detalles" => "ctlUserDetalles",
    "Modificar" => "ctlUserModificar",
    "Borrar" => "ctlUserBorrar",
    "Cerrar" => "ctlUserCerrar",
    "VerUsuarios" => "ctlUserVerUsuarios",
    "cambiarModo"=> "cltUserCambiarModo"
];
$rutasFiles = [
    "VerArchivos" => "ctlFileVerArchivos",
    "Borrar" => "ctlFileBorrar",
    "Renombrar" => "ctlFileRenombrar",
    "Compartir" => "ctlFileCompartir",
    "Subir" => "ctlFileSubir",
    "Cerrar" => "ctlUserCerrar",
    "cambiarModo"=> "cltUserCambiarModo",
    "Descargar" => "ctlFileDescargar"
];
// Si no hay usuario a Inicio
if (!isset($_SESSION['user'])) {
    if (isset($_GET['orden'])) {
        if (isset ($rutasUser[$_GET['orden']])) {
            $procRuta = $rutasUser[$_GET['orden']];
        } else {
            // Error no existe función para la ruta
            header('Status: 404 Not Found');
            echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                $_GET['ctl'] .
                '</p></body></html>';
            exit;
        }
    } else {
        $procRuta = "ctlUserInicio";
    }
} else {
    if ($_SESSION['modo'] == GESTIONUSUARIOS) {
        if (isset($_GET['orden'])) {
            // La orden tiene una funcion asociada 
            if (isset ($rutasUser[$_GET['orden']])) {
                $procRuta = $rutasUser[$_GET['orden']];
            } else {
                // Error no existe función para la ruta
                header('Status: 404 Not Found');
                echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                    $_GET['ctl'] .
                    '</p></body></html>';
                exit;
            }
        } else {
            $procRuta = "ctlUserVerUsuarios";
        }
    }
    if ($_SESSION['modo'] == GESTIONFICHEROS) {
        if (isset($_GET['orden2'])) {
            // La orden tiene una funcion asociada
            if (isset ($rutasFiles[$_GET['orden2']])) {
                $procRuta = $rutasFiles[$_GET['orden2']];
            } else {
                // Error no existe función para la ruta
                header('Status: 404 Not Found');
                echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                    $_GET['ctl'] .
                    '</p></body></html>';
                exit;
            }
        } else {
            $procRuta = "ctlFileVerArchivos";
        }
    }
}

// Llamo a la función seleccionada

$procRuta();




