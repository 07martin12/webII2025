<?php

class ArtistView
{
    public function showArtists($artists, int $totalArtists)
    {
        $user = $_SESSION['user'] ?? null;

        if ($artists && !is_array($artists)) {
            $artists = [$artists];
        }

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require_once './app/templates/admin/artistCount.phtml';
        require './app/templates/home/artistDetail.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showArtistNotFound(string $name)
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/messages/artistNotFound.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showSuccess($artists)
    {
        $user = $_SESSION['user'] ?? null;
        if ($artists && !is_array($artists)) {
            $artists = [$artists];
        }
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require_once './app/templates/messages/operationSuccessful.phtml';
        require './app/templates/home/artistDetail.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showArtistAlreadyExists()
    {
        $user = $_SESSION['user'] ?? null;

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require_once './app/templates/messages/artistAlreadyExists.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showArtistsList($artists, int $limit, int $totalArtists)
    {
        $user = $_SESSION['user'] ?? null;

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/home/listArtist.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showArtistDetails(array $artists, array $songs = []): void
    {
        $user = $_SESSION['user'] ?? null;

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/home/artistDetail.phtml';
        require_once './app/templates/home/songDetail.phtml';
        require_once './app/templates/home/footer.phtml';
    }
}
