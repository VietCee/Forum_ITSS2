<?php
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/PostController.php';
require_once '../app/controllers/CommentController.php';
require_once '../app/controllers/UserInfoController.php';



$page = isset($_GET['paction']) ? $_GET['paction'] : 'login';

$controller = new UserController();
$postController = new PostController();
$commentController = new CommentController();
$userInfoController = new UserInfoController();


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
        $commentController->addComment();
        break;
    case 'deleteComment':
        $commentController->deleteComment();
        break;
    case 'updateComment':
        $commentController->updateComment();
        break;
    case 'toggleLike':
        $postController->toggleLike();
        break;
    case 'toggleSave':
        $postController->toggleSave();
        break;
    case 'savedPosts':
        $postController->savedPosts();
        break;
    case 'userInfo':
        $userInfoController->showUserInfo();
        break;
    case 'updateProfile':
        $userInfoController->updateProfile();
        break;
    case 'manageAccounts':
        $controller->manageAccounts();
        break;
    case 'deleteUser':
        $controller->deleteUser();
        break;
    case 'searchForm':
        $postController->search();
        break;
    case 'searchPost':
        $postController->searchPost();
        break;
    case 'deletePostInfo':
        $userInfoController->deletePostInfo();
        break;
    default:
        $controller->login();
        break;
}
