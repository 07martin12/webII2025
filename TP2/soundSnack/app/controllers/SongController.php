<?php

require_once './app/models/SongModel.php';
require_once './app/views/SongView.php';
require_once './app/controllers/AuthController.php';

class SongController
{
    private SongModel $songModel;
    private SongView $songView;
    private AuthController $authController;

    public function __construct()
    {
        $this->songModel = new SongModel();
        $this->songView = new SongView();
        $this->authController = new AuthController();
    }

    public function getListSongs($params)
    {
        $limit = isset($params[0]) && is_numeric($params[0]) ? intval($params[0]) : 5;

        if ($limit < 1) {
            ErrorView::show404();
            return;
        }

        $totalSongs = $this->songModel->getSongsCount();
        $limit = min($limit, $totalSongs);

        $songs = $this->songModel->getSongsLimit($limit);

        if (!empty($songs)) {
            $this->songView->showSongsList($songs, $limit, $totalSongs);
        } else {
            ErrorView::showMaintenance();
        }
    }

    public function getSongDetails($params)
    {
        if (empty($params[0]) || !is_numeric($params[0])) {
            ErrorView::show404();
            return;
        }

        $idSong = intval($params[0]);
        $song = $this->songModel->getSongById($idSong);

        if ($song) {
            $this->songView->showSongDetails([$song]);
        } else {
            ErrorView::showMaintenance();
        }
    }

    public function addSong(): void
    {
        $id_artist = $_POST['id_artist'] ?? null;
        $title     = $_POST['title'] ?? null;
        $album     = $_POST['album'] ?? null;
        $duration  = $_POST['duration'] ?? null;
        $genre     = $_POST['genre'] ?? null;
        $video     = $_POST['video'] ?? null;

        if (!$id_artist || !$title || !$album) {
            $this->authController->redirectUser();
            return;
        }

        $result = $this->songModel->addSong(
            (int)$id_artist,
            $title,
            $album,
            $duration,
            $genre,
            $video
        );

        if ($result) {
            $song = (object)[
                'id_artist' => (int)$id_artist,
                'title'     => $title,
                'album'     => $album,
                'duration'  => $duration,
                'genre'     => $genre,
                'video'     => $video,
            ];
            $this->songView->showSongSuccess($song);
        } else {
            ErrorView::showSongError();
        }
    }

    public function editSong(): void
    {
        $currentTitle = $_POST['current_title'] ?? null;
        $artistId     = $_POST['id_artist'] ?? null;
        $newTitle     = $_POST['title'] ?? null;
        $newAlbum     = $_POST['album'] ?? null;
        $newDuration  = $_POST['duration'] ?? null;
        $newGenre     = $_POST['genre'] ?? null;
        $newVideo     = $_POST['video'] ?? null;

        if (!$currentTitle || !$artistId || !is_numeric($artistId)) {
            $this->authController->redirectUser();
            return;
        }

        $artistId = (int)$artistId;
        $song = $this->songModel->getSongByTitle($artistId, $currentTitle);

        if (!$song) {
            ErrorView::showSongNotFound();
            return;
        }

        $songId = $song->id_song;
        $updated = false;

        if ($newTitle) {
            $updated = $this->songModel->updateSongTitle($songId, $newTitle) || $updated;
        }
        if ($newAlbum) {
            $updated = $this->songModel->updateSongAlbum($songId, $newAlbum) || $updated;
        }
        if ($newDuration) {
            $updated = $this->songModel->updateSongDuration($songId, $newDuration) || $updated;
        }
        if ($newGenre) {
            $updated = $this->songModel->updateSongGenre($songId, $newGenre) || $updated;
        }
        if ($newVideo) {
            $updated = $this->songModel->updateSongVideo($songId, $newVideo) || $updated;
        }

        if ($updated) {
            $songAfter = $this->songModel->getSongById($songId);
            $this->songView->showSongSuccess([$song, $songAfter]);
        } else {
            ErrorView::showSongError();
        }
    }

    public function removeSong(): void
    {
        $artistId = $_POST['id_artist'] ?? null;
        $title    = $_POST['title'] ?? null;

        if (empty($artistId) || empty($title)) {
            $this->authController->redirectUser();
            return;
        }

        $song = $this->songModel->getSongByTitle((int)$artistId, $title);

        if ($song) {
            $result = $this->songModel->deleteSongById($song->id_song);
            if ($result) {
                $this->songView->showSongSuccess($song);
            } else {
                ErrorView::showSongError();
            }
        } else {
            ErrorView::showSongNotFound();
        }
    }
}
