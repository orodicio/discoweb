<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------
include_once 'config.php';
include_once 'modeloUser.php';
include_once 'validacionServidor.php';

/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlUserInicio(){
    $msg = "";
    $user ="";
    $clave ="";
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['user']) && isset($_POST['clave'])){
            $user =$_POST['user'];
            $clave=$_POST['clave'];
            if ( modeloOkUser($user,$clave)){
                $_SESSION['user'] = $user;
                $_SESSION['tipouser'] = modeloObtenerTipo($user);
                if ( $_SESSION['tipouser'] == "Máster"){
                    $_SESSION['modo'] = GESTIONUSUARIOS;
                    header('Location:index.php?orden=VerUsuarios');
                }
                else {
                  // Usuario normal
                  $_SESSION['modo'] = GESTIONFICHEROS;
                    header('Location:index.php?orden=VerFicheros');
                }
            }
            else {
                $msg="Error: usuario y contraseña no válidos.";
           }  
        }
    }
    
    include_once 'plantilla/facceso.php';
}

// Cierra la sesión y vuelva los datos
function ctlUserCerrar(){
    session_destroy();
    modeloUserSave();
    header('Location:index.php');
}

// Muestro la tabla con los usuario 
function ctlUserVerUsuarios (){
    // Obtengo los datos del modelo
    $usuarios = modeloUserGetAll(); 
    // Invoco la vista 
    include_once 'plantilla/verusuariosp.php';
   
}
function ctlUserAlta(){

    //Ingresar los datos al modelo.Muestro la vista de alta
   if ($_SERVER['REQUEST_METHOD']=='POST'){

    if(!empty($_POST)) {
        $clave1 = recoge('clave1');
        $clave2 = recoge('clave2');
        $email = recoge('email');
        $identificador = recoge('identificador');
        $plan = recoge('plan');
        $nombre = recoge('nombre');
        $estado = 'I';
        $mensaje = validarGeneral($clave1,$clave2,$email,$identificador,$nombre);
        if(!empty($mensaje)) {
            $msg=$mensaje;
        }else{
                $datos = [$clave1,$nombre,$email,$plan,$estado];
                $resultado =modeloUserAdd($identificador,$datos);
                if(!$resultado){
                    $msg="El usuario o el correo electrónico facilitado ya existen";
                }else{
                    if(!isset($_SESSION['user'])){
                        $msg="Gracias por registrarse. Esperando activación por parte del administrador";
                        header( "refresh:10; url=index.php?orden=Cerrar" );
                    }else {
                        header('Location:index.php?orden=VerUsuarios');
                    }
                }
            }
            }
        }
    include_once 'plantilla/fnuevo.php';
    }
    function ctlUserDetalles(){
    if(!empty($_GET['id'])){
        $user =$_GET['id'];
        $tablaAmostrar=modeloUserGet($user);
    }else{
        $msg= "[ERROR] FALLO DE ENVÍO";
    }
        include_once 'plantilla/detalles.php';


    }
function ctlUserBorrar(){
    modeloUserDel($_GET["id"]);
    header("Location: ".$_SERVER['PHP_SELF']);
}

function ctlUserModificar(){

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        include_once 'plantilla/modificarusuario.php';
    }else{
        $clave1 = recoge('contrasenia');
        $clave2 = recoge('repcontrasenia');
        $email = recoge('correo');
        $identificador = recoge('identificador');
        $plan = recoge('plan');
        $nombre = "nosecambia";
        $estado = recoge('estado');
        //echo $clave1.$email.$identificador.$plan.$estado.$clave2.$nombre;
        $mensaje = validarGeneral($clave1,$clave2,$email,$identificador,$nombre);
        if(!empty($mensaje)) {
            $msg=$mensaje;
            include_once 'plantilla/modificarusuario.php';

        }else{
            $userdat = array();
            $userdat["password"] = $clave1;
            $userdat["email"] = $email;
            $userdat["estado"] = $estado;
            $userdat["plan"] = $plan ;
            $resultado = modeloUserUpdate($identificador,$userdat);

            if(!$resultado){
                $msg="El usuario o el correo electrónico facilitado ya existen";
                include_once 'plantilla/modificarusuario.php';
            }else{
                header('Location:index.php?orden=VerUsuarios');
            }
        }

    }
}