<?php

require_once './app/database/dbConfig/DBConnection.php';

class SongModel
{
    private ?PDO $db;

    public function __construct()
    {
        $connection = DBConnection::getInstance();
        $this->db = $connection->getPDO();
    }

    public function addSong(
        int $id_artist,
        string $title,
        string $album,
        ?string $duration,
        ?string $genre,
        ?string $video
    ): bool {
        $sql = "INSERT INTO songs (id_artist, title, album, duration, genre, video)
            VALUES (?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_artist, $title, $album, $duration, $genre, $video]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al insertar canción '$title': " . $e->getMessage());
            return false;
        }
    }

    // Retorna la cantidad n. de canciones disponibles 
    public function getSongsCount(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM songs";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ? (int)$row->total : 0;
        } catch (PDOException $e) {
            error_log("Error al obtener la cantidad de canciones: " . $e->getMessage());
            return 0;
        }
    }

    // Obtiene una cantidad limitada de canciones junto con el nombre del artista.
    public function getSongsLimit(int $limit): array
    {
        $songsList = [];
        $limit = max(1, $limit);

        $sql = "SELECT s.id_song, s.id_artist, s.title, s.album, s.duration, s.genre, s.video, a.name AS artist_name
            FROM songs s
            JOIN artists a ON s.id_artist = a.id_artist
            LIMIT $limit";

        try {
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $songsList[] = $row;
            }
        } catch (PDOException $e) {
            error_log("Error al obtener las canciones con límite: " . $e->getMessage());
            return [];
        }

        return $songsList;
    }

    // Obtiene todas las canciones de un artista específico.
    public function getSongsByArtist(int $idArtist): array
    {
        $songsList = [];

        $sql = "SELECT id_song, title, album, duration, genre, video 
            FROM songs 
            WHERE id_artist = :id_artist";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_artist', $idArtist, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $songsList[] = $row;
            }
        } catch (PDOException $e) {
            error_log("Error al obtener canciones del artista: " . $e->getMessage());
            return [];
        }

        return $songsList;
    }

    // Obtiene la canción por ID
    public function getSongById(int $id): ?object
    {
        $sql = "SELECT s.id_song, s.id_artist, s.title, s.album, s.duration, s.genre, s.video,
                   a.name AS artist_name
            FROM songs s
            JOIN artists a ON s.id_artist = a.id_artist
            WHERE s.id_song = ?";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ?: null;
        } catch (PDOException $e) {
            error_log("Error al buscar canción con ID '$id': " . $e->getMessage());
            return null;
        }
    }

    // Obtiene una canción por id del artista y título
    public function getSongByTitle(int $artistId, string $title): ?object
    {
        $sql = "SELECT id_song, id_artist, title, album, duration, genre, video 
                FROM songs 
                WHERE id_artist = ? AND title = ? 
                LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$artistId, $title]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row ?: null;
        } catch (PDOException $e) {
            error_log("Error al obtener canción '$title': " . $e->getMessage());
            return null;
        }
    }

    // Elimina una canción por su ID
    public function deleteSongById(int $id_song): bool
    {
        $sql = "DELETE FROM songs WHERE id_song = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_song]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al eliminar canción con ID '$id_song': " . $e->getMessage());
            return false;
        }
    }

    public function updateSongArtist(int $id, int $artistId): bool
    {
        $sql = "UPDATE songs SET id_artist = ? WHERE id_song = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$artistId, $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar artista de la canción '$id': " . $e->getMessage());
            return false;
        }
    }

    public function updateSongTitle(int $id, string $title): bool
    {
        $sql = "UPDATE songs SET title = ? WHERE id_song = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$title, $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar título de la canción '$id': " . $e->getMessage());
            return false;
        }
    }

    public function updateSongAlbum(int $id, string $album): bool
    {
        $sql = "UPDATE songs SET album = ? WHERE id_song = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$album, $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar álbum de la canción '$id': " . $e->getMessage());
            return false;
        }
    }

    public function updateSongDuration(int $id, string $duration): bool
    {
        $sql = "UPDATE songs SET duration = ? WHERE id_song = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$duration, $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar duración de la canción '$id': " . $e->getMessage());
            return false;
        }
    }

    public function updateSongGenre(int $id, string $genre): bool
    {
        $sql = "UPDATE songs SET genre = ? WHERE id_song = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$genre, $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar género de la canción '$id': " . $e->getMessage());
            return false;
        }
    }

    public function updateSongVideo(int $id, ?string $video): bool
    {
        $sql = "UPDATE songs SET video = ? WHERE id_song = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$video, $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar video de la canción '$id': " . $e->getMessage());
            return false;
        }
    }
}
