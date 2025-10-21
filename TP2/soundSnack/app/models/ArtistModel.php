<?php

require_once './app/database/dbConfig/DBConnection.php';

//Modelo para gestionar operaciones sobre Artistas.
class ArtistModel
{
    private ?PDO $db;

    public function __construct()
    {
        $connection = DBConnection::getInstance();
        $this->db = $connection->getPDO();
    }

    // Obtiene el id del artista por nombre o retorna null si falla la consulta
    public function getArtistIdByName(string $name): ?int
    {
        $sql = "SELECT id_artist FROM artists WHERE LOWER(name) = LOWER(?)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ? (int)$row->id_artist : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el ID del artista '$name': " . $e->getMessage());
            return null;
        }
    }

    // Retorna la cantidad n. de artistas disponibles 
    public function getArtistsCount(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM artists";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ? (int)$row->total : 0;
        } catch (PDOException $e) {
            error_log("Error al obtener la cantidad de artistas: " . $e->getMessage());
            return 0;
        }
    }

    // Obtiene una cantidad limitada de artistas. 
    public function getArtistsLimit(int $limit): array
    {
        $artistsList = [];
        $limit = max(1, $limit);

        $sql = "SELECT id_artist, name, biography, cover, date_of_birth, date_of_death, place_of_birth
            FROM artists
            LIMIT $limit";

        try {
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $artistsList[] = $row;
            }
        } catch (PDOException $e) {
            error_log("Error al obtener los artistas con límite: " . $e->getMessage());
            return [];
        }

        return $artistsList;
    }

    // Obtiene todos los artistas disponibles. 
    public function getAllArtists(): array
    {
        $artistsList = [];

        $sql = "SELECT id_artist, name, biography, cover, date_of_birth, date_of_death, place_of_birth
            FROM artists";

        try {
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $artistsList[] = $row;
            }
        } catch (PDOException $e) {
            error_log("Error al obtener todos los artistas: " . $e->getMessage());
            return [];
        }

        return $artistsList;
    }

    // Obtiene el artista por nombre 
    public function getArtistByName(string $name): ?object
    {
        $sql = "SELECT id_artist, name, biography, cover, date_of_birth, date_of_death, place_of_birth
                FROM artists WHERE LOWER(name) = LOWER(?)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ?: null;
        } catch (PDOException $e) {
            error_log("Error al buscar artista '$name': " . $e->getMessage());
            return null;
        }
    }

    // Obtiene el artista por ID
    public function getArtistById(int $id): ?object
    {
        $sql = "SELECT id_artist, name, biography, cover, date_of_birth, date_of_death, place_of_birth
            FROM artists WHERE id_artist = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ?: null;
        } catch (PDOException $e) {
            error_log("Error al buscar artista con ID '$id': " . $e->getMessage());
            return null;
        }
    }

    // Inserta un artista en la base de datos
    public function insertArtist(
        string $name,
        string $biography,
        string $cover,
        string $dateOfBirth,
        ?string $dateOfDeath,
        string $placeOfBirth
    ): bool {
        $sql = "INSERT INTO artists (name, biography, cover, date_of_birth, date_of_death, place_of_birth)
                VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name, $biography, $cover, $dateOfBirth, $dateOfDeath, $placeOfBirth]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al insertar artista '$name': " . $e->getMessage());
            return false;
        }
    }

    // Elimina un artista por nombre 
    public function deleteArtistByName(string $name): bool
    {
        $sql = "DELETE FROM artists WHERE LOWER(name) = LOWER(?)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al eliminar artista '$name': " . $e->getMessage());
            return false;
        }
    }

    // Actualiza el nombre de un artista 
    public function updateArtistName(int $id_artist, string $name): bool
    {
        $sql = "UPDATE artists SET name = ? WHERE id_artist = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name, $id_artist]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar el nombre del artista: " . $e->getMessage());
            return false;
        }
    }

    // Actualiza la biografía del artista
    public function updateArtistBiography(int $id_artist, string $biography): bool
    {
        $sql = "UPDATE artists SET biography = ? WHERE id_artist = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$biography, $id_artist]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar la biografía del artista: " . $e->getMessage());
            return false;
        }
    }

    // Actualiza la portada del artista 
    public function updateArtistCover(int $id_artist, string $cover): bool
    {
        $sql = "UPDATE artists SET cover = ? WHERE id_artist = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$cover, $id_artist]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar la portada del artista: " . $e->getMessage());
            return false;
        }
    }

    // Actualiza la fecha de nacimiento del artista
    public function updateArtistDateOfBirth(int $id_artist, string $dateOfBirth): bool
    {
        $sql = "UPDATE artists SET date_of_birth = ? WHERE id_artist = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$dateOfBirth, $id_artist]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar la fecha de nacimiento del artista: " . $e->getMessage());
            return false;
        }
    }

    // Actualiza solo la fecha de fallecimiento 
    public function updateArtistDateOfDeath(int $id_artist, ?string $dateOfDeath): bool
    {
        $sql = "UPDATE artists SET date_of_death = ? WHERE id_artist = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$dateOfDeath, $id_artist]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar la fecha de fallecimiento del artista: " . $e->getMessage());
            return false;
        }
    }

    // Actualiza solo el lugar de nacimiento 
    public function updateArtistPlaceOfBirth(int $id_artist, string $placeOfBirth): bool
    {
        $sql = "UPDATE artists SET place_of_birth = ? WHERE id_artist = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$placeOfBirth, $id_artist]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar el lugar de nacimiento del artista: " . $e->getMessage());
            return false;
        }
    }

    // Verifica si un artista existe
    public function artistExists(string $name): bool
    {
        $sql = "SELECT 1 FROM artists WHERE LOWER(name) = LOWER(?) LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$name]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ? true : false;
        } catch (PDOException $e) {
            error_log("Error al verificar existencia del artista '$name': " . $e->getMessage());
            return false;
        }
    }
}
