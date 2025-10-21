<?php

require_once './app/models/UserModel.php';
require_once './app/helpers/FileUploader.php';
require_once './app/controllers/AuthController.php';
require_once './app/views/View.php';
require_once './app/views/ErrorView.php';

class UserController
{
    private UserModel $userModel;
    private AuthController $authController;
    private View $view;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->authController = new AuthController();
        $this->view = new View();
    }

    public function registerUser(): void
    {
        if (empty($_POST)) {
            $this->authController->redirectUser();
            return;
        }

        $userData = [
            'name'     => $_POST['userName'] ?? '',
            'email'    => $_POST['userEmail'] ?? '',
            'password' => $_POST['userPassword'] ?? '',
            'photo'    => $_FILES['photoUser'] ?? null
        ];

        $result = $this->handleUserRegistration($userData);

        if ($result) {
            $this->view->showSuccess();
        } else {
            ErrorView::showError();
        }
    }

    public function insertUser(): void
    {
        $userData = [
            'name'     => $_POST['name'] ?? null,
            'email'    => $_POST['email'] ?? null,
            'password' => $_POST['password'] ?? null,
            'photo'    => $_FILES['profile_photo'] ?? null
        ];

        if (!$userData['name'] || !$userData['email'] || !$userData['password']) {
            $this->authController->redirectUser();
            return;
        }

        $result = $this->handleUserRegistration($userData);

        if ($result) {
            $user = (object)[
                'id_user'       => '-',
                'name'          => $userData['name'],
                'email'         => $userData['email'],
                'profile_photo' => $result
            ];
            $this->view->insertSuccess([$user]);
        } else {
            ErrorView::showError();
        }
    }

    private function handleUserRegistration(array $data)
    {
        $name     = trim($data['name']);
        $email    = trim($data['email']);
        $password = trim($data['password']);
        $photo    = $data['photo'];

        if (empty($name) || empty($email) || empty($password)) {
            return false;
        }

        if ($this->userModel->userNameExists($name)) {
            ErrorView::userAlreadyExists();
            return false;
        }

        if ($this->userModel->emailExists($email)) {
            ErrorView::emailAlreadyExists();
            return false;
        }

        $uploadDir     = "assets/img/covers/users/";
        $defaultPhoto  = "webII2025/soundSnack/assets/img/covers/users/defaultUser.jpg";
        $photoPath     = $defaultPhoto;

        $hasPhoto = $photo && isset($photo['name']) && $photo['error'] === UPLOAD_ERR_OK;
        if ($hasPhoto) {
            $uploadedPath = FileUploader::handleCoverUpload($photo, $name, $uploadDir);
            if ($uploadedPath !== null) {
                $photoPath = $uploadedPath;
            } else {
                ErrorView::photoUploadError();
                return false;
            }
        } else if ($photo && $photo['error'] !== UPLOAD_ERR_NO_FILE) {
            ErrorView::photoUploadError();
            return false;
        }
        $result = $this->userModel->registerUser($name, $email, $password, $photoPath);
        return $result ? $photoPath : false;
    }

    public function getUserByName(): void
    {
        $name = $_POST['name'] ?? '';

        if (empty($name)) {
            $this->authController->redirectUser();
            return;
        }

        $user = $this->userModel->getUserByName($name);

        if ($user !== null) {
            $this->view->userProfile($user, 1);
        } else {
            $this->authController->redirectUser();
        }
    }

    public function getUserById(): void
    {
        $id = $_POST['id_user'] ?? null;

        if (empty($id) || !is_numeric($id) || (int)$id <= 0) {
            $this->authController->redirectUser();
            return;
        }

        $id = (int)$id;
        $user = $this->userModel->getUserById($id);

        if ($user !== null) {
            $this->view->userProfile($user, 1);
        } else {
            $this->authController->redirectUser();
        }
    }

    public function getUsersLimit(): void
    {
        $limit = $_POST['limit'] ?? null;

        if (empty($limit) || !is_numeric($limit) || (int)$limit <= 0) {
            $this->authController->redirectUser();
            return;
        }

        $limit = (int)$limit;

        $totalUsers = $this->userModel->getUsersCount();

        if ($totalUsers === 0) {
            $this->authController->redirectUser();
            return;
        }

        if ($limit > $totalUsers) {
            $limit = $totalUsers;
        }

        $users = $this->userModel->getUsersLimit($limit);

        if (!empty($users)) {
            $this->view->userProfile($users, count($users));
        } else {
            $this->authController->redirectUser();
        }
    }

    public function deleteUser(): void
    {
        $id = $_POST['id_user'] ?? null;

        if (empty($id) || !is_numeric($id) || (int)$id <= 0) {
            $this->authController->redirectUser();
            return;
        }

        $id = (int)$id;
        $user = $this->userModel->getUserById($id);

        if ($user !== null) {
            $result = $this->userModel->deleteUserById($id);

            if ($result) {
                $this->view->showDeleteSuccess([$user]);
            } else {
                ErrorView::showError();
            }
        } else {
            ErrorView::showUserNotFound();
        }
    }
}
