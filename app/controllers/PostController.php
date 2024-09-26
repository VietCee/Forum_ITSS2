<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../app/models/User.php';
require_once '../app/models/Post.php';

class PostController
{
    public function addPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = $_POST['content'];
            $tag = $_POST['tag'];
            $user_id = $_SESSION['user']['user_id'];

            // Xử lý upload ảnh
            $image = '';
            if (!empty($_FILES['image']['name'])) {
                $image = time() . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], '../public/uploads/' . $image);
            }

            $postModel = new Post();
            $postModel->createPost($user_id, $content, $image, $tag);

            $_SESSION['successMessage'] = "Bài viết đã được đăng tải thành công!";

            header("Location: index.php?paction=homePage");
            exit();
        }
    }

    public function showPosts()
    {
        $postModel = new Post();
        $posts = $postModel->getAllPosts();
        require_once '../app/views/homePage.php';
    }


    public function editPost()
{
    if (isset($_GET['id'])) {
        $postModel = new Post();
        $post = $postModel->getPostById($_GET['id']);

        
        if ($post['user_id'] == $_SESSION['user']['user_id']) { // kiểm tra xem bài viết có thuộc user hiện tại đăng không
            require_once '../app/views/editPost.php';
        } else {
            echo 'Bạn không có quyền chỉnh sửa bài viết này.';
        }
    }
}


public function updatePost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $postModel = new Post();
        $content = $_POST['content'];
        $tag = $_POST['tag'];

        $postModel->updatePost($_POST['id'], $content, $tag);

        header("Location: index.php?paction=homePage");
        exit();
    } else {
        echo "Không thể cập nhật bài viết.";
    }
}

public function deletePost()
{
    if (isset($_GET['id'])) {
        $postModel = new Post();
        $post = $postModel->getPostById($_GET['id']);

        if ($post['user_id'] == $_SESSION['user']['user_id']) { // kiểm tra xem bài viết có thuộc user hiện tại đăng không
            $postModel->deletePost($_GET['id']);
            header("Location: index.php?paction=homePage");
            exit();
        } else {
            echo 'Bạn không có quyền xóa bài viết này.';
        }
    }
}


}
