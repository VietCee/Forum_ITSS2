<?php
session_start();

$page = isset($_GET['paction']) ? $_GET['paction'] : 'login';
require_once '../app/controllers/UserController.php';

$controller = new UserController();

switch ($page) {
    case 'login':
        $controller->login();
        break;
    case 'handleLogin':
        $controller->handleLogin();
        break;
    case 'register':
        $controller->register();
        break;
    case 'handleRegister':
        $controller->handleRegister();
        break;
    case 'login':
        $controller->homePage();
        break;
    default:
        $controller->login(); // Mặc định về login nếu không có route
        break;
}
