<?php
session_start();

$page = isset($_GET['paction']) ? $_GET['paction'] : 'login';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/PostController.php';

$controller = new UserController();
$postController = new PostController();

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
    case 'homePage':
        //$controller->homePage();
        $postController->showPosts();
        break;
    case 'addPost':
        $postController->addPost();
        break;
    case 'editPost':
        $postController->editPost();
        break;
    case 'updatePost':
        $postController->updatePost();
        break;
    case 'deletePost':
        $postController->deletePost();
        break;
    default:
        $controller->login();
        break;
}
