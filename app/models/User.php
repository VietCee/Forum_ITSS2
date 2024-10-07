<?php
require_once 'E:/xampp/htdocs/Forum/config/database.php';

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

    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE admin = 0"); // Chỉ lấy những người không phải admin
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    // Lấy danh sách người dùng với id, usernames và email
    public function getUsers()
    {
        $stmt = $this->conn->prepare("SELECT user_id, usernames, email FROM user"); // Sửa 'id' thành 'user_id'
        
        if ($stmt === false) {
            // In ra thông báo lỗi
            echo "Lỗi SQL: " . $this->conn->error;
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    
    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM user WHERE user_id = ?"); // Đảm bảo tên cột đúng
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return true; // Trả về true nếu xóa thành công
        } else {
            return false; // Trả về false nếu có lỗi
        }
    }
   

}
