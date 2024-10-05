<?php
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/PostController.php';
require_once '../app/controllers/UserInfoController.php'; 


$controller = new UserController();
$postController = new PostController();
$userInfoController = new UserInfoController(); // Đảm bảo khởi tạo đối tượng đúng cách


$page = isset($_GET['paction']) ? $_GET['paction'] : 'login';

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
    case 'postDetail':
        $postController->postDetail();
        break;
    case 'addComment':
        $postController->addComment();
        break;
    case 'userInfo': // Xử lý yêu cầu đến userInfo
        $userInfoController->showUserInfo();
        break;
    case 'updateProfile':
        $userInfoController->updateProfile();
        break;
    default:
        $controller->login();
        break;
}
