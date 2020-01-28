<?php


class Conexion
{
    private const DBNAME = "discoweb";
    private const USER = "olalla";
    private const PASSWD = "()L4ll4r0d1c10";
    private const HOST = "192.168.1.55";

    private static $connection;

    public static function getConnection() : mysqli {
        if (self::$connection == null) {
            self::$connection = new mysqli(self::HOST, self::USER, self::PASSWD, self::DBNAME); // Abre una conexión
            if (!self::$connection) {
                printf("Conexión fallida: %s\n", mysqli_connect_error());
                exit();
            }
        }

        return self::$connection;
    }
}