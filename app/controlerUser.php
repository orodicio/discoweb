<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------
include_once 'config.php';
include_once 'ModeloUserDB.php';
include_once 'cifrador.php';
include_once 'User.php';
/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function ctlUserInicio()
{

    $msg = "";
    $user = "";
    $clave = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['user']) && isset($_POST['clave'])) {
            $user = $_POST['user'];
            $clave = $_POST['clave'];
            if (modeloUserDB::OkUser($user, $clave)) {
                $_SESSION['user'] = $user;
                $_SESSION['tipouser'] = modeloUserDB::ObtenerTipo($user);
                if ($_SESSION['tipouser'] == "Máster") {
                    $_SESSION['modo'] = GESTIONUSUARIOS;
                    header('Location:index.php?orden=VerUsuarios');
                } else {
                    $estado = modeloUserDB::ObtenerEstado($user);
                    if ($estado == 'I') {
                        $_SESSION['modo'] = GESTIONUSUARIOS;
                        $msg = TMENSAJES['USERNOACTIVO'];
                        header("refresh:5; url=index.php?orden=Cerrar");
                    } else {
                        $_SESSION['modo'] = GESTIONFICHEROS;
                        header('Location:index.php');
                    }
                }
            } else {
                $msg = TMENSAJES['LOGINERROR'];;
            }
        }
    }
    include_once 'plantilla/facceso.php';
}

// Cierra la sesión y vuelva los datos
function ctlUserCerrar()
{
    session_destroy();
    modeloUserDB::closeDB();
    header('Location:index.php');
}

// Muestro la tabla con los usuario 
function ctlUserVerUsuarios()
{
    // Obtengo los datos del modelo
    $usuarios = modeloUserDB::GetAll();
    // Invoco la vista
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
    }
    include_once 'plantilla/verusuariosp.php';

}

function ctlUserAlta()
{

    //Ingresar los datos al modelo.Muestro la vista de alta
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!empty($_POST)) {
            $clave1 = recoge('clave1');
            $clave2 = recoge('clave2');
            $email = recoge('email');
            $identificador = recoge('identificador');
            $plan = recoge('plan');
            $nombre = recoge('nombre');
            $estado = 'I';
            $existeID = modeloUserDB::existeID($identificador);
            $existeMail = modeloUserDB::existeEmail($email);
            try {
                checkEmpty($clave1, $email, $identificador, $nombre);
                checkClave($clave1, $clave2);
                checkExisteId($existeID);
                checkExisteEmail($existeMail);
                $user = new User($identificador, $clave1, $nombre, $email, $plan, $estado);
                $result = modeloUserDB::UserAdd($user);
                if ($result) {
                    if (!isset($_SESSION['user'])) {
                        $msg = TMENSAJES['USERSAVE'];
                        header("refresh:5; url=index.php?orden=Cerrar");
                    } else {
                        $msg = TMENSAJES['USERSAVE'];
                        header("refresh:5; url=index.php?orden=VerUsuarios");
                    }
                } else {
                    throw new \Exception(TMENSAJES['USERNOSAVE']);
                }
            } catch (Exception $e) {
                $msg = $e->getMessage();
            }
        }
    }
    include_once 'plantilla/fnuevo.php';
}


function ctlUserDetalles()
{
    if (!empty($_GET['id'])) {
        $user = $_GET['id'];
        $tablaAmostrar = modeloUserDB::UserGet($user);
    } else {
        $msg = "[ERROR] FALLO DE ENVÍO";
    }
    include_once 'plantilla/detalles.php';


}

function ctlUserBorrar()
{

    $result = modeloUserDB::UserDel($_GET["id"]);
    if ($result) {

        $msg = TMENSAJES['USERDEL'];
    } else {
        $msg = TMENSAJES['ERRORDEL'];
    }
    header('Location:index.php?orden=VerUsuarios&msg=' . $msg);
}

function ctlUserModificar()
{
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        include_once 'plantilla/modificarusuario.php';
    } else {
        $user =modeloUserDB::UserGet($_GET['id']);
        $clave1 = recoge('contrasenia');
        $clave2 = recoge('repcontrasenia');
        $email = recoge('correo');
        $identificador = $user[0];
        $plan = recoge('plan');
        $nombre = recoge('nombre');
        $estado = recoge('estado');

        try {
            checkClave($clave1, $clave2);
            if ($user[3] != $email) {
                $existeMail = modeloUserDB::existeEmail($email);
                checkExisteEmail($existeMail);
            }
            if($user[4] != $plan){

            }
            $user = new User($identificador, $clave1, $nombre, $email, $plan, $estado);
            $result = modeloUserDB::UserUpdate($user);
            var_dump($result);
            if ($result) {
                $msg = TMENSAJES['USERUPDATE'];
            } else {
                $msg = TMENSAJES['ERRORUPDATE'];
            }
            if($_SESSION['tipouser']=="Máster"){
            header('Location:index.php?orden=VerUsuarios&msg=' . $msg);
            }else{
                header('Location:index.php?orden=cambiarModo&msg=' . $msg);
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
            include_once 'plantilla/modificarusuario.php';
        }
    }
}

/**
 * Cambia de modo en el que estemos
 */
function cltUserCambiarModo()
{
    if ($_SESSION['modo'] == GESTIONUSUARIOS && $_SESSION['tipouser']=="Máster") {
        $_SESSION['modo'] = GESTIONFICHEROS;
        header('Location:index.php');
    } else if($_SESSION['modo'] == GESTIONUSUARIOS && $_SESSION['tipouser']!="Máster"){
        $msg = $_GET['msg'];
        $_SESSION['modo'] = GESTIONFICHEROS;
        header('Location:index.php?msg=' . $msg);
    }else{
        $_SESSION['modo'] = GESTIONUSUARIOS;
        $id = $_SESSION['user'];
        header('Location:index.php?orden=Modificar&id=' . $id);
    }
}

/**
 * @param $var recoge
 * @return string
 */
function recoge($var)
{
    $tmp = (isset($_POST[$var])) ? trim(htmlspecialchars($_POST[$var], ENT_QUOTES, "UTF-8")) : "";
    return $tmp;
}

/**
 * @param bool $existeMail
 * @throws Exception
 */
function checkExisteEmail(bool $existeMail): void
{
    if ($existeMail) {
        throw new \Exception(TMENSAJES['MAILREPE']);
    }
}

/**
 * @param bool $existeID
 * @throws Exception
 */
function checkExisteId(bool $existeID): void
{
    if ($existeID) {
        throw new \Exception(TMENSAJES['USREXIST']);
    }
}

/**
 * @param string $clave1
 * @param string $clave2
 * @throws Exception
 */
function checkClave(string $clave1, string $clave2): void
{
    if ($clave1 != $clave2) {
        throw new \Exception(TMENSAJES['PASSDIST']);
    }
}

/**
 * @param string $clave1
 * @param string $email
 * @param string $identificador
 * @param string $nombre
 * @throws Exception
 */
function checkEmpty(string $clave1, string $email, string $identificador, string $nombre): void
{
    if (empty($clave1) || empty($email) || empty($identificador) || empty($nombre)) {
        throw new \Exception(TMENSAJES['NOVACIO']);
    }
}
