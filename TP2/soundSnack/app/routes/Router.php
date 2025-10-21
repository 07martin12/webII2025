<?php
require_once './app/controllers/BaseController.php';
require_once './app/controllers/UserController.php';
require_once './app/controllers/AuthController.php';
require_once './app/controllers/ArtistController.php';
require_once './app/controllers/SongController.php';
require_once './app/views/ErrorView.php';

class Router
{
    private BaseController $baseController;
    private UserController $userController;
    private AuthController $authController;
    private ArtistController $artistController;
    private SongController $songController;

    private string $action;
    private static string $baseUrl;

    // Array asociativo multidimensional para almacenar todas las actions disponibles para el usuario
    private const ACTIONS = [
        // Home
        'home'               => ['controller' => 'baseController',   'method' => 'showHome'],
        'home/login'         => ['controller' => 'baseController',   'method' => 'showLogin'],
        'home/register'      => ['controller' => 'baseController',   'method' => 'showRegister'],
        'home/registerUser'  => ['controller' => 'userController',   'method' => 'registerUser'],
        'home/logIn'         => ['controller' => 'authController',   'method' => 'logInUser'],
        'home/logOut'        => ['controller' => 'authController',   'method' => 'logOut'],
        'home/listArtists'   => ['controller' => 'artistController', 'method' => 'getListArtists'],
        'home/artistDetail'  => ['controller' => 'artistController', 'method' => 'getArtistDetails'],
        'home/listSongs'     => ['controller' => 'songController',   'method' => 'getListSongs'],
        'home/songDetail'    => ['controller' => 'songController',   'method' => 'getSongDetails'],

        // Admin Users
        'admin'                 => ['controller' => 'baseController',   'method' => 'showAdmin'],
        'admin/viewUserById'    => ['controller' => 'userController',   'method' => 'getUserById'],
        'admin/viewUserByName'  => ['controller' => 'userController',   'method' => 'getUserByName'],
        'admin/viewUsers'       => ['controller' => 'userController',   'method' => 'getUsersLimit'],
        'admin/addUser'   => ['controller' => 'userController', 'method' => 'insertUser'],
        'admin/removeUser' => ['controller' => 'userController', 'method' => 'deleteUser'],

        // Admin Artists
        'admin/addArtist'       => ['controller' => 'artistController', 'method' => 'insertArtist'],
        'admin/updateArtist'    => ['controller' => 'artistController', 'method' => 'updateArtist'],
        'admin/deleteArtist'    => ['controller' => 'artistController', 'method' => 'deleteArtistByName'],
        'admin/viewArtistById'  => ['controller' => 'artistController', 'method' => 'getArtistById'],
        'admin/viewArtistByName' => ['controller' => 'artistController', 'method' => 'getArtistByName'],
        'admin/viewArtists'     => ['controller' => 'artistController', 'method' => 'getArtistsLimit'],

        // Admin Songs
        'admin/addSong'         => ['controller' => 'songController',   'method' => 'addSong'],
        'admin/editSong'        => ['controller' => 'songController',   'method' => 'editSong'],
        'admin/removeSong'      => ['controller' => 'songController',   'method' => 'removeSong']
    ];

    // Constructor: inicializa los controladores y define la URL base y la acción
    public function __construct()
    {
        $this->baseController   = new BaseController();
        $this->userController   = new UserController();
        $this->authController   = new AuthController();
        $this->artistController = new ArtistController();
        $this->songController   = new SongController();

        self::defineBaseUrl();
        $this->defineAction();
    }

    // Determina la URL base de la aplicación
    private static function defineBaseUrl(): void
    {
        self::$baseUrl = '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']
            . dirname($_SERVER['PHP_SELF']) . '/';
    }

    // Retorna la URL base de la aplicación
    public static function getBaseUrl(): string
    {
        return self::$baseUrl;
    }

    // Determina la acción solicitada por la URL
    private function defineAction(): void
    {
        $uri  = $_SERVER['REQUEST_URI'];
        $base = dirname($_SERVER['PHP_SELF']);
        $path = trim(substr($uri, strlen($base)), '/');

        // Si no hay path, se asume 'home'
        $this->action = $path ?: 'home';
    }

    // Evalúa la acción solicitada y llama al método correspondiente de forma dinámica
    public function evaluateAction(): void
    {
        // Obtiene la URL completa
        $uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = rtrim(dirname($_SERVER['PHP_SELF']), '/');
        $path = trim(str_replace($base, '', $uri), '/');

        // 'home' por defecto si no hay ruta
        if ($path === '') {
            $path = 'home';
        }

        // Divide la URL en partes separadas por "/"
        $parts = explode('/', $path);

        // Determina la ruta principal 
        $route = $parts[0] . (isset($parts[1]) ? '/' . $parts[1] : '');

        // Captura los parámetros restantes para pasarlos al método
        $params = array_slice($parts, 2);

        // Si la acción no existe, mostrar error 404
        if (!isset(self::ACTIONS[$route])) {
            ErrorView::show404();
            return;
        }

        $controllerName = self::ACTIONS[$route]['controller'];
        $method         = self::ACTIONS[$route]['method'];

        $controller = $this->$controllerName;

        // Ejecuta el método si existe, pasando los parámetros
        if (method_exists($controller, $method)) {
            $controller->$method($params);
        } else {
            ErrorView::show500();
        }
    }
}
