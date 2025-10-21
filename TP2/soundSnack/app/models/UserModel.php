<?php

require_once './app/models/UserModel.php';

class UserModel
{
    private ?PDO $db;

    public function __construct()
    {
        $connection = DBConnection::getInstance();
        $this->db = $connection->getPDO();
    }

    /* Verifica si un nombre de usuario ya existe en la base de datos. */
    public function userNameExists(string $name): bool
    {
        $sql = "SELECT 1 FROM users WHERE LOWER(name) = LOWER(?) LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name]);
            return $stmt->fetchColumn() !== false;
        } catch (PDOException $e) {
            error_log("Error al verificar existencia del nombre '$name': " . $e->getMessage());
            return false;
        }
    }

    /* Verifica si un email ya está registrado en la base de datos. */
    public function emailExists(string $email): bool
    {
        $sql = "SELECT 1 FROM users WHERE LOWER(email) = LOWER(?) LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetchColumn() !== false;
        } catch (PDOException $e) {
            error_log("Error al verificar existencia del email '$email': " . $e->getMessage());
            return false;
        }
    }

    /* Verifica si la contraseña es correcta. */
    public function verifyPassword(string $name, string $password): bool
    {
        $sql = "SELECT password FROM users WHERE LOWER(name) = LOWER(?) LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if ($row && password_verify($password, $row->password)) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error al verificar contraseña de '$name': " . $e->getMessage());
            return false;
        }
    }

    /*Registra un nuevo usuario en la base de datos.*/
    public function registerUser(string $name, string $email, string $password, string $profilePhoto): bool
    {
        $sql = "INSERT INTO users (name, email, password, profile_photo) VALUES (?, ?, ?, ?)";
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name, $email, $hash, $profilePhoto]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al registrar usuario '$name': " . $e->getMessage());
            return false;
        }
    }

    /* Obtiene los datos completos de un usuario por su nombre.*/
    public function getUserByName(string $name): ?object
    {
        $sql = "SELECT id_user, name, email, password, profile_photo FROM users WHERE LOWER(name) = LOWER(?) LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ?: null;
        } catch (PDOException $e) {
            error_log("Error al obtener datos del usuario '$name': " . $e->getMessage());
            return null;
        }
    }

    // Elimina un usuario por ID
    public function deleteUserById(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id_user = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al eliminar usuario con ID '$id': " . $e->getMessage());
            return false;
        }
    }

    // Obtiene el usuario por ID
    public function getUserById(int $id): ?object
    {
        $sql = "SELECT id_user, name, email, password, profile_photo
            FROM users
            WHERE id_user = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ?: null;
        } catch (PDOException $e) {
            error_log("Error al buscar usuario con ID '$id': " . $e->getMessage());
            return null;
        }
    }

    // Retorna la cantidad de usuarios disponibles
    public function getUsersCount(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM users";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ? (int)$row->total : 0;
        } catch (PDOException $e) {
            error_log("Error al obtener la cantidad de usuarios: " . $e->getMessage());
            return 0;
        }
    }

    // Obtiene una cantidad limitada de usuarios
    public function getUsersLimit(int $limit): array
    {
        $usersList = [];
        $limit = max(1, $limit);

        $sql = "SELECT id_user, name, email, profile_photo
            FROM users
            LIMIT $limit";

        try {
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $usersList[] = $row;
            }
        } catch (PDOException $e) {
            error_log("Error al obtener los usuarios con límite: " . $e->getMessage());
            return [];
        }

        return $usersList;
    }

    // Obtiene todos los usuarios disponibles.
    public function getAllUsers(): array
    {
        $usersList = [];

        $sql = "SELECT id_user, name, email, password, profile_photo
            FROM users";

        try {
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $usersList[] = $row;
            }
        } catch (PDOException $e) {
            error_log("Error al obtener todos los usuarios: " . $e->getMessage());
            return [];
        }

        return $usersList;
    }
}
