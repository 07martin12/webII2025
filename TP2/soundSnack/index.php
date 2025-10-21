<?php
session_start();

require_once 'app/routes/Router.php';
// Crea la instancia del Router
$router = new Router();
// Evalúa la acción solicitada por el usuario y llama al método correspondiente
$router->evaluateAction();
