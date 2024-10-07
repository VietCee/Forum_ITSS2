<?php
require_once '../models/User.php';

class ManageController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showUserList()
    {
        // Lấy danh sách tất cả người dùng
        $users = $this->userModel->getUsers();

        // Hiển thị danh sách người dùng
        include '../views/userlist.php';
    }

    public function deleteUser($userId)
    {
        if ($this->userModel->deleteUser($userId)) {
            session_start();
            $_SESSION['successMessage'] = 'Người dùng đã được xóa thành công!';
        } else {
            session_start();
            $_SESSION['errorMessage'] = 'Có lỗi xảy ra khi xóa người dùng!';
        }
        header('Location: /Forum/app/controllers/ManageController.php'); // Đường dẫn về trang danh sách người dùng
        exit();
    }

}

// Kiểm tra xem có yêu cầu xóa người dùng không
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $controller = new ManageController();
    $controller->deleteUser($_GET['id']);
} else {
    // Khởi tạo ManageController và hiển thị danh sách tài khoản
    $controller = new ManageController();
    $controller->showUserList();
}
