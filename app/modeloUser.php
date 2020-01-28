<?php
include_once 'config.php';
include_once 'cifrador.php';
include_once dirname(__DIR__). '/persistence/UserRepository.php';
include_once dirname(__DIR__). '/persistence/User.php';

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
function modeloUserInit()
{

    /*
    $tusuarios = [ 
         "admin"  => ["12345"      ,"Administrado"   ,"admin@system.com"   ,3,"A"],
         "user01" => ["user01clave","Fernando Pérez" ,"user01@gmailio.com" ,0,"A"],
         "user02" => ["user02clave","Carmen García"  ,"user02@gmailio.com" ,1,"B"],
         "yes33" =>  ["micasa23"   ,"Jesica Rico"    ,"yes33@gmailio.com"  ,2,"I"]
        ];
    */
    if (!isset ($_SESSION['tusuarios'])) {
        $datosjson = @file_get_contents(FILEUSER) or die("ERROR al abrir fichero de usuarios");
        $tusuarios = json_decode($datosjson, true);
        $_SESSION['tusuarios'] = $tusuarios;
    }


}

// Comprueba usuario y contraseña (boolean)
function modeloOkUser($user, $clave)
{
    $mitabla = $_SESSION['tusuarios'];
    return isset($mitabla[$user]) && Cifrador::verificar($clave, $mitabla[$user][0]);
}

// Devuelve el plan de usuario (String)
function modeloObtenerTipo($user)
{
    $mitabla = $_SESSION['tusuarios'];
    return PLANES[$mitabla[$user][3]];
}

// Borrar un usuario (boolean)
function modeloUserDel($user)
{
    if (array_key_exists($user, $_SESSION['tusuarios'])) {
        unset($_SESSION['tusuarios'][$user]);
        rmdir(RUTA_FICHEROS . '/' . $user);
        return true;
    } else {
        return false;
    }
}

/**
 * @param string $login
 * @param array $request
 * @return bool
 */
// Añadir un nuevo usuario (boolean)
function modeloUserAdd(string $login, array $request):bool
{
    $userRepository = new UserRepository();
    $user = $userRepository->find($login, $request[2]);
    if (!empty($user)) {
        return false;
    }
    $user = new User(
        $login,
        $request[0],
        $request[1],
        $request[2],
        $request[3],
        $request[4]
    );
    $result = $userRepository->add($user);
    if($result==0){
        return false;
    }
    mkdir(RUTA_FICHEROS . '/' . $login, 0777);
    return true;
}

// Actualizar un nuevo usuario (boolean)
function modeloUserUpdate($userid, $userdat)
{
    foreach ($_SESSION['tusuarios'] as $clave => $datosusuario) {

        if ($clave != $userid && $datosusuario[2] == $userdat["email"]) {
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
function modeloUserGetAll()
{
    $userRepository = new UserRepository();
    $allUsers = $userRepository->findAll();
    // Genero lo datos para la vista que no muestra la contraseña ni los códigos de estado o plan
    // sino su traducción a texto
    $tuservista = [];
    for ($i=0; $i<count($allUsers); $i++){
        $tuservista[$clave] = [$datosusuario[1],
            $datosusuario[2],
            PLANES[$datosusuario[3]],
            ESTADOS[$datosusuario[4]]
        ];
    }
    return $tuservista;
}

// Datos de un usuario para visualizar
function modeloUserGet($user)
{
    return $_SESSION['tusuarios'] [$user];
}

// Vuelca los datos al fichero
function modeloUserSave()
{

    $datosjon = json_encode($_SESSION['tusuarios']);
    file_put_contents(FILEUSER, $datosjon) or die ("Error al escribir en el fichero.");
    //fclose($fich);
}
