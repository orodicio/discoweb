<?php
include_once 'config.php';
/* DATOS DE  LOS ARCHIVOS DE LOS USUARIOS*/
function modeloFileInit()
{
    $user = $_SESSION['user'];
    if (! isset ($_SESSION['tarchivos'] )){
        if(!file_exists(USUARIO.$user.'.json')){
            $fh = fopen(USUARIO.$user.'.json', 'a') or die("Se produjo un error al crear el archivo");
            fclose($fh);
            $_SESSION['tarchivos'] ="";
            return false;
        }else {
            $datosjson = @file_get_contents(USUARIO.$user.'json') or die("ERROR al abrir fichero de usuarios");
            $tusuario_fich = json_decode($datosjson, true);
            $_SESSION['tarchivos'] = $tusuario_fich;
            return true;
        }
    }


}
function modeloFileGetAll(){
    // Genero lo datos para la vista que no muestra la contraseña ni los códigos de estado o plan
    // sino su traducción a texto
    $tuserArchvista=[];
    foreach ($_SESSION['tarchivos'] as $archivo => $archivoUsuario){
        $tuserArchvista[$archivo] = [$archivoUsuario[1],
            $archivoUsuario[2],
            $archivoUsuario[3],
        ];
    }
    return $tuserArchvista;


}
