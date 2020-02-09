<?php

include_once 'config.php';
include_once 'User.php';
include_once 'cifrador.php';

class ModeloUserDB
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

// Comprueba usuario y contraseña son correctos (boolean)
    public static function OkUser($user, $clave)
    {
        $stmt = self::$dbh->prepare(self::$consulta_user);
        $stmt->bindValue(1, $user);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $fila = $stmt->fetch();
            $clavecifrada = $fila['clave'];
            if (Cifrador::verificar($clave, $clavecifrada)) {
                return true;
            }
        }
        return false;
    }

// Comprueba si ya existe un usuario con ese identificar
    public static function existeID(String $user): bool
    {
        $stmt = self::$dbh->prepare(self::$consulta_user);
        $stmt->bindValue(1, $user);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

//Comprueba si existe en email en la BD
    public static function existeEmail(String $user)
    {
        $stmt = self::$dbh->prepare(self::$consulta_email);
        $stmt->bindValue(1, $user);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }


// Devuelve el plan de usuario (String)
    public static function ObtenerTipo($user): string
    {
        $stmt = self::$dbh->prepare(self::$consulta_user);
        $stmt->bindValue(1, $user);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $fila = $stmt->fetch();
            $plan = $fila['plan'];
            return PLANES[$plan];
        }
    }

    // Devuelve el estado de usuario (String)
    public static function ObtenerEstado($user): string
    {
        $stmt = self::$dbh->prepare(self::$consulta_user);
        $stmt->bindValue(1, $user);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $fila = $stmt->fetch();
            return $fila['estado'];
        }
    }


// Borrar un usuario (boolean)
    public static function UserDel($userid)
    {
        $stmt = self::$dbh->prepare("Delete from Usuarios where id = ?");
        $stmt->bindValue(1, $userid);
        $result = $stmt->execute();
        return $result;
    }

// Añadir un nuevo usuario (boolean)
    public
    static function UserAdd($user): bool
    {
        $stmt = self::$dbh->prepare("Insert into Usuarios values (?,?,?,?,?,?)");
        $stmt->bindValue(1, $user->id);
        $stmt->bindValue(2, $user->clave);
        $stmt->bindValue(3, $user->nombre);
        $stmt->bindValue(4, $user->email);
        $stmt->bindValue(5, $user->plan);
        $stmt->bindValue(6, $user->estado);
        $result = $stmt->execute();
        mkdir(RUTA_FICHEROS . '/' . $user->id, 0777);
        return $result;
    }

// Actualizar un nuevo usuario (boolean)
    public static function UserUpdate($user): bool
    {
        if (empty($user->clave)) {
            $stmt = self::$dbh->prepare("update Usuarios set email=?, plan=?, estado=? where id=?");
            $stmt->bindValue(1, $user->email);
            $stmt->bindValue(2, $user->plan);
            $stmt->bindValue(3, $user->estado);
            $stmt->bindValue(4, $user->id);
        } else {
            $stmt = self::$dbh->prepare("update Usuarios set clave=?, email=?, plan=?, estado=? where id=?");
            $stmt->bindValue(1, $user->clave);
            $stmt->bindValue(2, $user->email);
            $stmt->bindValue(3, $user->plan);
            $stmt->bindValue(4, $user->estado);
            $stmt->bindValue(5, $user->id);


        }
        $result = $stmt->execute();
        return $result;
    }

// Tabla de todos los usuarios para visualizar
    public static function GetAll(): array
    {
        // Genero los datos para la vista que no muestra la contraseña ni los códigos de estado o plan
        // sino su traducción a texto  PLANES[$fila['plan']],
        $stmt = self::$dbh->query("select * from Usuarios");

        $tUserVista = [];
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($fila = $stmt->fetch()) {
            $datosuser = [
                $fila['nombre'],
                $fila['email'],
                PLANES[$fila['plan']],
                ESTADOS[$fila['estado']]
            ];
            $tUserVista[$fila['id']] = $datosuser;
        }
        return $tUserVista;
    }


// Datos de un usuario para visualizar
    public static function UserGet($user)
    {
        $userArray = [];
        $stmt = self::$dbh->prepare(self::$consulta_user);
        $stmt->bindValue(1, $user);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $fila = $stmt->fetch();
            foreach ($fila as $result) {
                array_push($userArray, $result);
            }
            return $userArray;
        }

        return null;
    }

    public static function closeDB()
    {
        self::$dbh = null;
    }
}






