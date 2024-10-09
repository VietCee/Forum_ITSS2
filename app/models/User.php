<?php
require_once '../config/database.php';

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function validateLogin($email, $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Địa chỉ email không hợp lệ";
        } elseif (substr($email, -10) !== '@gmail.com') {
            return "Email phải là Gmail";
        } elseif (strlen($password) < 8) {
            return "Mật khẩu phải ít nhất 8 ký tự";
        } elseif (!preg_match("/[a-zA-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
            return "Mật khẩu phải bao gồm cả chữ cái và số";
        }
        return '';
    }

    public function validateRegister($email, $username, $password, $confirm_password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Địa chỉ email không hợp lệ";
        } elseif (substr($email, -10) !== '@gmail.com') {
            return "Email phải là Gmail";
        } elseif (empty($username)) {
            return "Username không được bỏ trống";
        } elseif (strlen($password) < 8) {
            return "Mật khẩu phải ít nhất 8 ký tự";
        } elseif ($password !== $confirm_password) {
            return "Mật khẩu không khớp";
        }
        return '';
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE usernames = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insertUser($email, $username, $password)
    {
        $stmt = $this->conn->prepare("INSERT INTO user (email, usernames, passwords, date_created) VALUES (?, ?, ?, ?)");
        $date_created = date('Y-m-d H:i:s');
        $stmt->bind_param("ssss", $email, $username, $password, $date_created);
        return $stmt->execute();
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_id = ?");
        $stmt->bind_param("i", $id); // "i" là loại dữ liệu cho số nguyên (int)
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function getNonAdminUsers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE admin = 0");

        if (!$stmt->execute()) {
            die('Lỗi khi thực thi câu truy vấn: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    public function deleteUserById($userId)
    {
        $postModel = new Post();
    
        // Xóa tất cả bình luận và bài viết của người dùng thông qua Post model
        $postModel->deleteCommentsByUserId($userId);
        $postModel->deletePostsByUserId($userId);
    
        // Xóa tất cả likes của người dùng
        $deleteLikesQuery = "DELETE FROM post_likes WHERE user_id = ?";
        $stmt = $this->conn->prepare($deleteLikesQuery);
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            die('Lỗi khi thực thi câu truy vấn xóa likes: ' . $stmt->error);
        }
    
        // Xóa tất cả saved posts của người dùng
        $deleteSavedPostsQuery = "DELETE FROM saved_posts WHERE user_id = ?";
        $stmt = $this->conn->prepare($deleteSavedPostsQuery);
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            die('Lỗi khi thực thi câu truy vấn xóa saved posts: ' . $stmt->error);
        }
    
        // Xóa người dùng
        $deleteUserQuery = "DELETE FROM user WHERE user_id = ?";
        $stmt = $this->conn->prepare($deleteUserQuery);
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            die('Lỗi khi thực thi câu truy vấn xóa người dùng: ' . $stmt->error);
        }
    
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
