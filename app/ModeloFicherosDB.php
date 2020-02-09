<?php

include_once 'config.php';
include_once 'User.php';
include_once 'cifrador.php';

class ModeloFicherosDB
{
    /**
     * @var PDO $dbh
     */
    private static $dbh = null;
    private static $consulta_user = "Select * from Usuarios where id = ?";
    private static $consulta_email = "Select id from Usuarios where email= ?";


    public static function init()
    {
        if (self::$dbh == null) {
            try {
                // Cambiar  los valores de las constantes en config.php
                $dsn = "mysql:host=" . DBSERVER . ";dbname=" . DBNAME . ";charset=utf8";
                self::$dbh = new PDO($dsn, DBUSER, DBPASSWORD);
                // Si se produce un error se genera una excepción;
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión " . $e->getMessage();
                exit();
            }
        }
    }

// Añadir un nuevo usuario (boolean)
    public static function FileAdd($fichero): bool
    {
        $stmt = self::$dbh->prepare("Insert into ficheros (nombre, size, extension, hash) values (?,?,?,?)");
        $stmt->bindValue(1, $fichero->nombre);
        $stmt->bindValue(2, $fichero->size);
        $stmt->bindValue(3, $fichero->extension);
        $stmt->bindValue(4, $fichero->hash);
        $result = $stmt->execute();
        return $result;
    }
    public static function FileDel($nombre)
    {
        $stmt = self::$dbh->prepare("Delete from ficheros where nombre = ?");
        $stmt->bindValue(1, $nombre);
        $result = $stmt->execute();
        return $result;
    }
    public static function FileUpdate($actual, $nuevo): bool
    {
        if (!empty($nuevo)){
            $stmt = self::$dbh->prepare("update ficheros set nombre=? where nombre=?");
            $stmt->bindValue(1, $nuevo);
            $stmt->bindValue(2, $actual);
            return $stmt->execute();
        }

        return false;
    }

    // Añadir un nuevo usuario (boolean)
    public static function closeDB()
    {
        self::$dbh = null;
    }

}






