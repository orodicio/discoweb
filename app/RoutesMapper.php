<?php


class RoutesMapper
{
    private static $routes =  [
        "user" => [
            "Inicio" => "ctlUserInicio",
            "Alta" => "ctlUserAlta",
            "Detalles" => "ctlUserDetalles",
            "Modificar" => "ctlUserModificar",
            "Borrar" => "ctlUserBorrar",
            "Cerrar" => "ctlUserCerrar",
            "VerUsuarios" => "ctlUserVerUsuarios"
        ],
        "files" => [
            "VerArchivos" => "ctlFileVerArchivos",
            "Borrar"=> "ctlFileBorrar",
            "Renombrar"=>"ctlFileRenombrar",
            "Compartir"=>"ctlFileCompartir",
            "Subir"=>"ctlFileSubir",
            "Cerrar" => "ctlUserCerrar",
            "Modificar" => "ctlFileModificar"
        ],
        "error" => [
            "404" => "notfound.php"
        ]
    ];

    public static function user($route) {
        if (empty($route)) return  self::$routes['user']['Inicio'];
        if (!array_key_exists($route, self::$routes['user']))
            return self::$routes['error']['404'];

        return  self::$routes['user'][$route];
    }

    public static function file($route) {
        if (empty($route)) return  self::$routes['files']['VerArchivos'];
        if (!array_key_exists($route, self::$routes['files']))
            return self::$routes['error']['404'];

        return  self::$routes['files'][$route];
    }
}