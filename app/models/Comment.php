<?php
require_once '../config/database.php';

class Comment
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // Tạo bình luận mới
    public function createComment($post_id, $user_id, $content)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO comments (post_id, user_id, content, date_created) 
             VALUES (?, ?, ?, NOW())"
        );

        if ($stmt === false) {
            die('Lỗi khi chuẩn bị câu truy vấn: ' . $this->conn->error);
        }

        $stmt->bind_param("iis", $post_id, $user_id, $content);

        if (!$stmt->execute()) {
            die('Lỗi khi thực thi câu truy vấn: ' . $stmt->error);
        }

        return true;
    }

    // Lấy tất cả bình luận của bài post theo post_id
    public function getCommentsByPostId($post_id)
    {
        $stmt = $this->conn->prepare(
            "SELECT comments.*, user.usernames FROM comments 
             JOIN user ON comments.user_id = user.user_id 
             WHERE post_id = ? ORDER BY date_created DESC"
        );

        if ($stmt === false) {
            die('Lỗi khi chuẩn bị câu truy vấn: ' . $this->conn->error);
        }

        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            die('Lỗi khi thực thi câu truy vấn: ' . $this->conn->error);
        }

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }

        return $comments;
    }

    // Cập nhật bình luận
    public function updateComment($id, $content)
    {
        $stmt = $this->conn->prepare("UPDATE comments SET content = ? WHERE id = ?");

        if ($stmt === false) {
            die('Lỗi khi chuẩn bị câu truy vấn: ' . $this->conn->error);
        }

        $stmt->bind_param("si", $content, $id);

        if (!$stmt->execute()) {
            die('Lỗi khi thực thi câu truy vấn: ' . $stmt->error);
        }

        return true;
    }

    // Xóa bình luận
    public function deleteComment($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE id = ?");

        if ($stmt === false) {
            die('Lỗi khi chuẩn bị câu truy vấn: ' . $this->conn->error);
        }

        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            die('Lỗi khi thực thi câu truy vấn: ' . $stmt->error);
        }

        return true;
    }
}
