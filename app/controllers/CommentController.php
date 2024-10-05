<?php
require_once '../app/models/Comment.php';

class CommentController
{
    private $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }

    public function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_id = $_POST['post_id'];
            $user_id = $_SESSION['user']['user_id'];
            $content = $_POST['content'];

            if ($this->commentModel->createComment($post_id, $user_id, $content)) {
                header('Location: index.php?paction=postDetail&id=' . $post_id);
            } else {
                echo "Lỗi khi thêm bình luận.";
            }
        }
    }

    public function deleteComment()
    {
        if (isset($_GET['comment_id'])) {
            $comment_id = $_GET['comment_id'];
            $post_id = $_GET['post_id'];

            if ($this->commentModel->deleteComment($comment_id)) {
                header('Location: index.php?paction=postDetail&id=' . $post_id);
            } else {
                echo "Lỗi khi xóa bình luận.";
            }
        }
    }

    public function updateComment()
    {
        if (isset($_POST['comment_id']) && isset($_POST['content'])) {
            $id = $_POST['comment_id'];
            $content = $_POST['content'];

            if ($this->commentModel->updateComment($id, $content)) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'invalid_data';
        }
    }
}
