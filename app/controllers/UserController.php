<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../app/models/User.php';

class UserController
{
    public function login()
    {
        $error = $_SESSION['error'] ?? '';
        $form_data = $_SESSION['form_data'] ?? [];
        require_once '../app/views/login.php';
        unset($_SESSION['error'], $_SESSION['form_data']);
    }

    public function handleLogin()
    {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $passwords = $_POST['passwords'];
        $userModel = new User();

        $error = $userModel->validateLogin($email, $passwords);

        if (!empty($error)) {
            $_SESSION['error'] = $error;
            $_SESSION['form_data'] = $_POST;
            header("Location: index.php?paction=login");
            exit();
        }

        $user = $userModel->getUserByEmail($email);
        if (!$user) {
            $_SESSION['error'] = "Email không tồn tại trong hệ thống";
            $_SESSION['form_data'] = $_POST;
            header("Location: index.php?paction=login");
            exit();
        }

        if ($passwords === $user['passwords']) {
            $_SESSION['user'] = $user;
            header("Location: index.php?paction=homePage");
        } else {
            $_SESSION['error'] = "Mật khẩu không chính xác";
            $_SESSION['form_data'] = $_POST;
            header("Location: index.php?paction=login");
        }
        exit();
    }
    }
    public function register()
    {
        $error = $_SESSION['error'] ?? '';
        $form_data = $_SESSION['form_data'] ?? [];
        require_once '../app/views/register.php';
        unset($_SESSION['error'], $_SESSION['form_data']);
    }

    public function handleRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $usernames = $_POST['usernames'];
            $passwords = $_POST['passwords'];
            $confirm_password = $_POST['confirm_password'];
            $userModel = new User();

            $error = $userModel->validateRegister($email, $usernames, $passwords, $confirm_password);

            if (!empty($error)) {
                $_SESSION['error'] = $error;
                $_SESSION['form_data'] = $_POST;
                header("Location: index.php?paction=register");
                exit();
            }

            if ($userModel->getUserByEmail($email)) {
                $_SESSION['error'] = "Email đã tồn tại trong hệ thống";
                $_SESSION['form_data'] = $_POST;
                header("Location: index.php?paction=register");
                exit();
            }

            if ($userModel->getUserByUsername($usernames)) {
                $_SESSION['error'] = "Username đã tồn tại trong hệ thống";
                $_SESSION['form_data'] = $_POST;
                header("Location: index.php?paction=register");
                exit();
            }

            if ($userModel->insertUser($email, $usernames, $passwords)) {
                header("Location: index.php?paction=login");
            } else {
                $_SESSION['error'] = "Lỗi khi tạo tài khoản";
                header("Location: index.php?paction=register");
            }
            exit();
        }
    }

    public function homePage()
    {
        require_once '../app/views/homepage.php';
    }
}