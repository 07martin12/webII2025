<?php
require_once './app/views/View.php';
require_once './app/controllers/AuthController.php';
require_once './app/models/ArtistModel.php';
require_once './app/models/UserModel.php';

class BaseController
{
    private View $view;
    private AuthController $authController;
    private ArtistModel $artistModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->view = new View();
        $this->authController = new AuthController();
        $this->artistModel = new ArtistModel();
        $this->userModel = new UserModel();
    }

    public function showHome(): void
    {
        $this->view->showHome();
    }

    public function showAdmin(): void
    {
        if ($this->authController->isAdmin()) {
            $allArtists = $this->artistModel->getAllArtists();
            $users      = $this->userModel->getAllUsers();
            $showArtists = false;

            $this->view->showAdmin($allArtists, $users, $showArtists);
        } else {
            $this->view->showHome();
        }
    }


    public function showLogin(): void
    {
        $this->view->showLogin();
    }

    public function showRegister(): void
    {
        $this->view->showRegister();
    }
}
