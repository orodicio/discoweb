<?php
include_once 'Conexion.php';

class UserRepository
{
    /**
     * @param User $user
     * @return int
     */
    public function add(User $user): int
    {
        $db = Conexion::getConnection();
        $query = 'INSERT INTO usuarios (login, passwd, name, email, plan, status)  VALUES (?,?,?,?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bind_param(
            "ssssis",
            $user->getLogin(),
            $user->getPasswd(),
            $user->getName(),
            $user->getEmail(),
            $user->getPlan(),
            $user->getStatus()
        );
        $result = $stmt->execute();
        if (!$result) {
            return 0;
        }

        return $stmt->insert_id;
    }

    /**
     * @param string $userId
     * @param string $email
     * @return array
     */
    public function find(string $userId, string $email): array
    {
        $db = Conexion::getConnection();
        $query = 'SELECT * FROM usuarios where login =? ||email =?';
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss", $userId, $email);
        $stmt->execute();
        $mysqli_result = $stmt->get_result();
        if (!$mysqli_result || $mysqli_result->num_rows == 0) {
            return [];
        }

        return $mysqli_result->fetch_assoc();
    }

    /**
     * findAll
     * Select * from usuarios
     * a verUsurios un array de usuarios de la base datos
     */
    public function findAll(): array
    {
        $db = Conexion::getConnection();
        $query = 'SELECT login, passwd, name, email, plan, status FROM usuarios';
        $stmt = $db->prepare($query);
        $stmt->execute();
        $mysqli_result = $stmt->get_result();
        if (!$mysqli_result || $mysqli_result->num_rows == 0) {
            return [];
        }
        return $mysqli_result->fetch_all();
    }


}