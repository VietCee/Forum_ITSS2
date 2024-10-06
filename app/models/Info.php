<?php
require_once '../config/database.php';

class Info
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // Tạo bài post mới
    
    public function countPostsByUserId($user_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM post WHERE user_id = ?");
        
        // Ràng buộc tham số user_id
        $stmt->bind_param("i", $user_id);
        
        // Thực thi truy vấn
        $stmt->execute();
        
        // Khởi tạo biến $count
        $stmt->bind_result($count);
        
        // Fetch dữ liệu
        if ($stmt->fetch()) {
            // Nếu truy vấn thành công, trả về $count
            return $count;
        }
        
        // Nếu không có kết quả, trả về 0 hoặc một giá trị mặc định
        return 0; // hoặc return null; tùy vào logic bạn muốn
    }
    
    public function getPostsByUserId($user_id)
    {
        $query = "SELECT post.*, user.usernames FROM post 
              JOIN user ON post.user_id = user.user_id 
              WHERE post.user_id = ?  -- Thêm điều kiện này
              ORDER BY date_created DESC";
    
    $stmt = $this->conn->prepare($query); 
    $stmt->bind_param("i", $user_id); // Ràng buộc tham số user_id
    $stmt->execute();
    
    // Trả về danh sách bài viết của người dùng
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateUserProfile($user_id, $username, $email, $profilePic = null) {
        // Câu truy vấn SQL để cập nhật thông tin người dùng
        $query = "UPDATE user SET usernames = ?, email = ?";

        // Nếu có ảnh mới, thêm profile_picture vào câu truy vấn
        if (!empty($profilePic)) {
            $query .= ", profile_picture = ?";
        }

        $query .= " WHERE user_id = ?";

        // Chuẩn bị câu truy vấn
        $stmt = $this->conn->prepare($query);

        // Ràng buộc tham số (bind parameters) cho câu truy vấn
        if (!empty($profilePic)) {
            $stmt->bind_param("sssi", $username, $email, $profilePic, $user_id);
        } else {
            $stmt->bind_param("ssi", $username, $email, $user_id);
        }

        // Thực thi câu truy vấn và trả về kết quả
        return $stmt->execute();
    }
    public function validateUpdate($email, $username) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Địa chỉ email không hợp lệ";
        } elseif (substr($email, -10) !== '@gmail.com') {
            return "Email phải là Gmail";
        } elseif (empty($username)) {
            return "Username không được bỏ trống";
        }
        return ''; // Không có lỗi
    }

}
