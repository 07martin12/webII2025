<?php

class View
{
    public function showHome()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/home/footer.phtml';
    }
    public function showAdmin($artists,$users, $showArtists): void
    {
        $user = $_SESSION['user'] ?? null;

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require './app/templates/admin/sectionArtist.phtml';
        require './app/templates/admin/sectionSong.phtml';
        require './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showLogin()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/home/login.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showRegister()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/home/register.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showSuccess()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/messages/showSuccess.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function insertSuccess($user)
    {
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require_once './app/templates/messages/insertSuccess.phtml';
        require_once './app/templates/home/userDetail.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showDeleteSuccess($user)
    {
        $sessionUser = $_SESSION['user'] ?? null;

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require_once './app/templates/messages/deleteSuccess.phtml';
        require_once './app/templates/home/userDetail.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }


    public function userProfile($user, $totalUsers)
    {
        $sessionUser = $_SESSION['user'] ?? null;

        if ($user && !is_array($user)) {
            $user = [$user];
        }

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require_once './app/templates/admin/userCount.phtml';
        require_once './app/templates/home/userDetail.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public function showDeleteSucces($user)
    {
        $sessionUser = $_SESSION['user'] ?? null;

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require_once './app/templates/messages/deleteSuccess.phtml';
        require_once './app/templates/home/userDetail.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }
}
