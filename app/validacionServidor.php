<?php

function recoge($var)
{
    $tmp = (isset($_POST[$var])) ? trim(htmlspecialchars($_POST[$var], ENT_QUOTES, "UTF-8")) : "";
    return $tmp;
}

 function validarIdentificador($id){
    $resu="";
    if(strlen($id)<5 ||strlen($id)>8 ){
        $resu="la contraseña debe tener entre 5 y 8 caracteres";
    }
    return $resu;
}
function validarEmail($email){
    $resu="";
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $resu="EL correro electrónico debe ser válido";
    }
    return $resu;

}
function claveDePatron($clave){
    $resu=true;
    if (! preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&()=])([A-Za-z\d$@$!%*?&()=]|[^ ]){8,15}$/", $clave)) {
        $resu = false;
    }
        return $resu;
}

function validarClavesIguales($clave1,$clave2){
    $resu="";
    if ($clave1 != $clave2) {
        $resu = "Las contraseñas deben ser iguales";
    }
    return $resu;
}
function validarDosClavesCorrectas($clave1,$clave2){
    $resu="";
    if(!claveDePatron($clave1)||!claveDePatron($clave2)){
        $resu = "Las contraseñas deben ser seguras";
    }
    return $resu;
}
function validarGeneral($clave1,$clave2,$email,$identificador,$nombre){
    $msg="";
    if(empty($identificador)||empty($clave1)||empty($clave2)|| empty($email) ||empty($nombre)) {
        return "Debe rellenar todos los campos";
    }
    $msg = validarClavesIguales($clave1, $clave2);
    if (!empty($msg)) return $msg;

    $msg = validarDosClavesCorrectas($clave1, $clave2);
    if (!empty($msg)) return $msg;

    $msg=validarIdentificador($identificador);
    if (!empty($msg)) return $msg;

    $msg=validarEmail($email);
    if (!empty($msg)) return $msg;

    return $msg;
}




