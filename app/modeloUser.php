<?php 
include_once 'config.php';
/* DATOS DE USUARIO
• Identificador ( 5 a 10 caracteres, no debe existir previamente, solo letras y números)
• Contraseña ( 8 a 15 caracteres, debe ser segura)
• Nombre ( Nombre y apellidos del usuario
• Correo electrónico ( Valor válido de dirección correo, no debe existir previamente)
• Tipo de Plan (0-Básico |1-Profesional |2- Premium| 3- Máster)
• Estado: (A-Activo | B-Bloqueado |I-Inactivo )
*/
// Inicializo el modelo 
// Cargo los datos del fichero a la session
function loadUserFixture(){
    if (isset ($_SESSION['tusuarios'] )) return;
    $datosjson = @file_get_contents(FILEUSER) or die("ERROR al abrir fichero de usuarios");
    $tusuarios = json_decode($datosjson, true);
    $_SESSION['tusuarios'] = $tusuarios;
}

// Comprueba usuario y contraseña (boolean)
function modeloOkUser($user,$clave){
    $mitabla = $_SESSION['tusuarios'];
    return isset($mitabla[$user]) && $mitabla[$user][0]===$clave ;
}

// Devuelve el plan de usuario (String)
function modeloObtenerTipo($user){
    $mitabla = $_SESSION['tusuarios'];
    return PLANES[$mitabla[$user][3]];
}

// Borrar un usuario (boolean)
function modeloUserDel($user){
    if(array_key_exists($user,$_SESSION['tusuarios'])){
        unset($_SESSION['tusuarios'][$user]);
        rmdir(RUTA_FICHEROS.'/'.$user );
        return true;
    }else{
        return false;
    }
}
// Añadir un nuevo usuario (boolean)
function modeloUserAdd($userid,$userdat){
    foreach ($_SESSION['tusuarios'] as $clave => $datosusuario){
        if($clave == $userid){
            return false;
        }
        if($datosusuario[2] == $userdat[2]){
            return false;
        }

    }
    $_SESSION['tusuarios'][$userid]=$userdat;
     mkdir ( RUTA_FICHEROS.'/'.$userid ,0777 );
    return true;
}

// Actualizar un nuevo usuario (boolean)
function modeloUserUpdate ($userid,$userdat){
    foreach ($_SESSION['tusuarios'] as $clave => $datosusuario) {

        if($clave != $userid && $datosusuario[2]==$userdat["email"]){
    return false;
    }
    }
    $usuario = $_SESSION["tusuarios"][$userid];
    //var_dump($_SESSION["tusuarios"][$userid]);
    $_SESSION["tusuarios"][$userid][0] = $userdat["password"];
    $_SESSION["tusuarios"][$userid][2] = $userdat["email"];
    $_SESSION["tusuarios"][$userid][3] = $userdat["plan"];
    $_SESSION["tusuarios"][$userid][4] = $userdat["estado"];
    //var_dump($_SESSION["tusuarios"][$userid]);
    return true;
}


// Tabla de todos los usuarios para visualizar
function modeloUserGetAll (){
    // Genero lo datos para la vista que no muestra la contraseña ni los códigos de estado o plan
    // sino su traducción a texto
    $tuservista=[];
    foreach ($_SESSION['tusuarios'] as $clave => $datosusuario){
        $tuservista[$clave] = [$datosusuario[1],
                               $datosusuario[2],
                               PLANES[$datosusuario[3]],
                               ESTADOS[$datosusuario[4]]
                               ];
    }
    return $tuservista;
}
// Datos de un usuario para visualizar
function modeloUserGet ($user){
    return $_SESSION['tusuarios'] [$user];
}

// Vuelca los datos al fichero
function modeloUserSave(){
    
    $datosjon = json_encode($_SESSION['tusuarios']);
    file_put_contents(FILEUSER, $datosjon) or die ("Error al escribir en el fichero.");
    //fclose($fich);
}
