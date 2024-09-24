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

    public function insertUser($email, $username, $password)
    {
        $stmt = $this->conn->prepare("INSERT INTO user (email, usernames, passwords, date_created) VALUES (?, ?, ?, ?)");
        $date_created = date('Y-m-d H:i:s');
        $stmt->bind_param("ssss", $email, $username, $password, $date_created);
        return $stmt->execute();
    }
}
