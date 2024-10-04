<?php
require_once '../config/database.php';

class Post
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // Tạo bài post mới
    public function createPost($user_id, $content, $image, $tag)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO post (user_id, content, image, tag, like_count, date_created) 
             VALUES (?, ?, ?, ?, 0, NOW())"
        );

        if ($stmt === false) {
            die('Lỗi khi chuẩn bị câu truy vấn: ' . $this->conn->error);
        }

        $stmt->bind_param("isss", $user_id, $content, $image, $tag);

        if (!$stmt->execute()) {
            die('Lỗi khi thực thi câu truy vấn: ' . $stmt->error);
        }

        return true;
    }

    // Lấy tất cả các bài post
    public function getAllPosts()
    {
        $sql = "SELECT post.*, user.usernames FROM post 
                JOIN user ON post.user_id = user.user_id 
                ORDER BY date_created DESC";

        $result = $this->conn->query($sql);

        if ($result === false) {
            die('Lỗi khi thực thi câu truy vấn: ' . $this->conn->error);
        }

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }

        return $posts;
    }

    public function getPostById($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT post.*, user.usernames FROM post 
             JOIN user ON post.user_id = user.user_id 
             WHERE post.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public function updatePost($id, $content, $tag)
    {
        $stmt = $this->conn->prepare("UPDATE post SET content = ?, tag = ? WHERE id = ?");
        if (!$stmt) {
            echo "Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error;
            return false;
        }
        $stmt->bind_param("ssi", $content, $tag, $id);
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        return true;
    }

    public function deletePost($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM post WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
