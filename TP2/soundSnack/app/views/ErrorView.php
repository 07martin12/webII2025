<?php
class ErrorView
{
    public static function photoUploadError()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/messages/photoUploadError.phtml';
        require_once './app/templates/home/register.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public static function coverUploadError()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/messages/coverUploadError.phtml';
        require_once './app/templates/home/register.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public static function show404()
    {
        require_once './app/templates/messages/show404.phtml';
    }

    public static function show500()
    {
        require_once './app/templates/messages/show500.phtml';
    }

    public static function failedLogin()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/messages/failedLogin.phtml';
        require_once './app/templates/home/login.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public static function userAlreadyExists()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/messages/userAlreadyExist.phtml';
        require_once './app/templates/home/register.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public static function emailAlreadyExists()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require_once './app/templates/messages/emailAlreadyExists.phtml';
        require_once './app/templates/home/register.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public static function showError()
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/messages/genericError.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public static function showMaintenance()
    {
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/home/nav.phtml';
        require './app/templates/messages/maintenance.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public static function showUserNotFound(): void
    {
        $user = $_SESSION['user'] ?? null;
        require_once './app/templates/home/header.phtml';
        require_once './app/templates/messages/userNotFound.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUser.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public static function showSongNotFound()
    {
        $user = $_SESSION['user'] ?? null;

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require './app/templates/messages/songNotFound.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }

    public static function showSongError(): void
    {
        $user = $_SESSION['user'] ?? null;

        require_once './app/templates/home/header.phtml';
        require_once './app/templates/admin/nav.phtml';
        require_once './app/templates/admin/sectionArtist.phtml';
        require_once './app/templates/admin/sectionSong.phtml';
        require_once './app/templates/admin/sectionUsers.phtml';
        require_once './app/templates/home/footer.phtml';
    }
}
