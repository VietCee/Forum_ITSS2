<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../app/models/User.php';
require_once '../app/models/Post.php';
require_once '../app/models/Comment.php';
require_once '../app/models/Info.php';
class UserInfoController
{
    public function showUserInfo()
{
    if (isset($_GET['id'])) {
        $userModel = new User();
        $userInfoModel = new Info(); // Tạo đối tượng của UserInfo
        $userId = $_GET['id'];

        // Lấy thông tin người dùng
        $user = $userModel->getUserById($userId);
        
        if ($user) {
            // Lấy số lượng bài viết của người dùng
            $postCount = $userInfoModel->countPostsByUserId($user['user_id']); // Sử dụng đối tượng UserInfo
            
            // Lấy các bài viết của người dùng
            $posts = $userInfoModel->getPostsByUserId($user['user_id']); // Cũng dùng UserInfo
            
            // Gọi view để hiển thị thông tin người dùng và bài viết
            require_once '../app/views/userInfo.php';
        } else {
            echo "Người dùng không tồn tại.";
        }
    } else {
        echo "ID người dùng không hợp lệ.";
    }
}

    public function showPosts()
    {
        $postModel = new Post();
        $posts = $postModel->getAllPosts();
        require_once '../app/views/userInfo.php';
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


public function postDetail()
{
    if (isset($_GET['id'])) {
        $postModel = new Post();
        $commentModel = new Comment();
        $post = $postModel->getPostById($_GET['id']);
        $comments = $commentModel->getCommentsByPostId($_GET['id']);

        require_once '../app/views/postDetail.php';
    } else {
        echo 'Bài viết không tồn tại.';
    }
}

public function addComment()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $commentModel = new Comment();
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user']['user_id'];
        $content = $_POST['content'];

        $commentModel->createComment($post_id, $user_id, $content);

        header("Location: index.php?paction=postDetail&id=" . $post_id);
        exit();
    }
}
public function getUserPosts()
{
    // Lấy user_id từ session mà không kiểm tra đăng nhập
    $user_id = $_SESSION['user']['user_id'];
    
    $userInfoModel = new Info(); // Tạo đối tượng của UserInfo
    $posts = $userInfoModel->getPostsByUserId($user_id); // Gọi phương thức từ UserInfo

    return $posts;
}
public function updateProfile()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_SESSION['user']['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];

        // Tạo instance của Info Model
        $infoModel = new Info();
        
        // Gọi phương thức validateUpdate để kiểm tra định dạng
        $errorMessage = $infoModel->validateUpdate($email, $username);
        
        if (!empty($errorMessage)) {
            // Nếu có lỗi, lưu thông báo lỗi và giá trị đã nhập vào session
            $_SESSION['errorMessage'] = $errorMessage;
            $_SESSION['user']['input_username'] = $username; // Lưu username đã nhập
            $_SESSION['user']['input_email'] = $email; // Lưu email đã nhập
            
            // Chuyển hướng về trang hồ sơ với tham số modal
            header("Location: index.php?paction=userInfo&id=" . $user_id . "&modal=open");
            exit();
        }

        // Kiểm tra và xử lý ảnh đại diện (nếu có)
        $profilePic = '';
        if (!empty($_FILES['profilePic']['name'])) {
            $profilePic = time() . '_' . $_FILES['profilePic']['name'];
            move_uploaded_file($_FILES['profilePic']['tmp_name'], '../public/uploads/' . $profilePic);
        }

        // Cập nhật thông tin người dùng
        $result = $infoModel->updateUserProfile($user_id, $username, $email, $profilePic);

        if ($result) {
            // Cập nhật session với thông tin mới
            $_SESSION['user']['usernames'] = $username;
            $_SESSION['user']['email'] = $email;
            unset($_SESSION['user']['input_username']); // Xóa giá trị đã nhập khi cập nhật thành công
            unset($_SESSION['user']['input_email']); // Xóa giá trị đã nhập khi cập nhật thành công
            if ($profilePic) {
                $_SESSION['user']['profile_picture'] = $profilePic;
            }   

            $_SESSION['successMessage'] = "Thông tin hồ sơ đã được cập nhật thành công!";
            $_SESSION['showModal'] = true; // Thêm biến để theo dõi việc hiển thị modal
        } else {
            $_SESSION['errorMessage'] = "Có lỗi xảy ra khi cập nhật hồ sơ.";
        }

        // Chuyển hướng về trang hồ sơ
        header("Location: index.php?paction=userInfo&id=" . $user_id);
        exit();
    }
}



}
