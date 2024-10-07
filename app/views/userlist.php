<?php
// Bắt đầu phiên làm việc
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hiển thị thông báo nếu có
if (isset($_SESSION['successMessage'])) {
    echo '<script>
            alert("' . htmlspecialchars($_SESSION['successMessage']) . '");
          </script>';
    unset($_SESSION['successMessage']);
}

// Kết nối tới lớp User
require_once '../models/User.php';  // Đảm bảo đường dẫn đúng đến file User.php
$userModel = new User();

// Lấy danh sách người dùng từ cơ sở dữ liệu
$users = $userModel->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Userlist Form</title>
    <link rel="stylesheet" href="/Forum/public/css/userlist.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .menu-content {
            display: none; /* Ẩn menu theo mặc định */
            position: absolute;
            background-color: white;
            border: 1px solid #ddd;
            padding: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 100; /* Để menu hiện lên trên các phần tử khác */
        }
        .user-item {
            position: relative; /* Thêm thuộc tính để menu hiện ra đúng vị trí */
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="navbar-center">
        <h1>SmallFood</h1>
    </div>
    <div class="navbar-right">
        <div class="dropdown">
            <img src="../public/img/register.jpg" alt="User Avatar" class="user-avatar dropdown-toggle" id="userOptionsButton" data-bs-toggle="dropdown" aria-expanded="false">
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userOptionsButton">
                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <aside class="sidebar">
        <ul>
            <li><i class="fas fa-home"></i> Home</li>
            <li><i class="fas fa-bookmark"></i> Saved</li>
            <li><i class="fas fa-user"></i> Users</li>
            <li><i class="fas fa-magnifying-glass"></i> Search</li>
        </ul>
    </aside>

    <section class="User">
        <div class="user-list-container">
            <header>
                <button class="back-btn">&lt;</button>
                <h2>Users</h2>
            </header>

            
            <div class="user-list">
            <?php
            // Duyệt qua danh sách người dùng và hiển thị
            foreach ($users as $user) {
                echo '
                <div class="user-item">
                    <div class="avatar">' . strtoupper($user['usernames'][0]) . '</div>
                    <div class="user-info">
                        <h3>' . htmlspecialchars($user['usernames']) . '</h3>
                        <p>' . htmlspecialchars($user['email']) . '</p>
                        <div class="meta-info">
                            <span>#' . htmlspecialchars($user['user_id']) . '</span>
                            <span class="dot"></span>
                            <span>' . htmlspecialchars($user['date_created']) . '</span>
                        </div>
                    </div>
                    <button class="menu-btn" onclick="confirmDelete(' . $user['user_id'] . ')"> &#8942; </button>
                </div>';
            }
            ?>
        </div>


        </div>
    </section>

    <!-- Right Sidebar -->
    <aside class="right-sidebar">
        <h4>Sponsored</h4>
        <div class="ad">
            <p>Ad content here...</p>
        </div>
        <h4>Trending</h4>
        <div class="contact-list">
            <p>#cake</p>
            <p>#spicy</p>
            <p>#stupid</p>
        </div>
    </aside>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    function confirmDelete(userId) {
        const confirmation = confirm("Bạn có chắc chắn muốn xóa tài khoản này không?");
        if (confirmation) {
            // Chuyển hướng đến ManageController với ID người dùng
            window.location.href = '../controllers/ManageController.php?action=delete&id=' + userId;
        }
    }


</script>

</body>
</html>
