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
            "404" => "ctlNotFound"
        ]
    ];

    public static function fetch($route) : Matcheable {
        if (empty($route)) return  new Found(self::$routes['user']['Inicio']);
        if (!array_key_exists($route, self::$routes['user']))
            return new NotFound(self::$routes['error']['404']);

        return  new Found(self::$routes['user'][$route]);
    }

    public static function user($route) : Matcheable {
        if (empty($route)) return  new Found(self::$routes['user']['Inicio']);
        if (!array_key_exists($route, self::$routes['user']))
            return new NotFound(self::$routes['error']['404']);

        return  new Found(self::$routes['user'][$route]);
    }

    public static function file($route) : Matcheable {
        if (empty($route)) return  self::$routes['files']['VerArchivos'];
        if (!array_key_exists($route, self::$routes['files']))
            return new NotFound(self::$routes['error']['404']);

        return  new Found(self::$routes['files'][$route]);
    }
}