<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['successMessage'])) {
    echo '<script>
            alert("' . htmlspecialchars($_SESSION['successMessage']) . '");
          </script>';
    unset($_SESSION['successMessage']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserInfo Form</title>
    <link rel="stylesheet" href="/Forum/public/css/homePage.css">
    <link rel="stylesheet" href="/Forum/public/css/post.css">
    <link rel="stylesheet" href="/Forum/public/css/userInfo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                        <li><a class="dropdown-item" href="#">My Profile</a></li>
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

        <section class="feed">
            <form action="index.php?paction=updateProfile&id=<?php echo $_SESSION['user']['user_id']; ?>" method="POST" enctype="multipart/form-data">
                <div class="profile-header">
                    <div class="profile-pic">
                <!-- Hiển thị ảnh đại diện của người dùng -->
                        <?php if (!empty($user['profile_picture'])): ?>
                            <img src="uploads/<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" style="width: 60px; height: 70px; border-radius: 50%;">
                        <?php else: ?>
                            <div class="profile-placeholder">
                                <span><?php echo strtoupper(substr($user['usernames'], 0, 1)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="profile-info">
                        <h1 style="color: #000000;"><?= $user['usernames'] ?></h1>
                        <p><?= $postCount ?> posts</p>
                    </div>
                    <button class="edit-profile-btn" id="ep-Btn">Edit profile</button>
                </div>
            </form>

            <!-- Hiển thị bài viết -->
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <div class="post-header">

                            <img src="../public/img/register.jpg" alt="Profile Picture" class="profile-pic">

                            <div class="post-info">
                                <h3><?= $post['usernames'] ?></h3>
                                <p><?= $post['date_created'] ?></p>
                            </div>

                            <?php if ($_SESSION['user']['user_id'] == $post['user_id']): ?>
                                <div class="menu-options">
                                    <button class="menu-btn">⋮</button>
                                        <div class="menu-content">
                                            <a href="index.php?paction=editPost&id=<?= $post['id'] ?>">Edit</a>
                                            <a href="index.php?paction=deletePost&id=<?= $post['id'] ?>"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">Delete</a>
                                        </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="post-content">

                            <p><?= htmlspecialchars($post['content']) ?></p>
                            <p style="color: #1E90FF;"><strong>#</strong><?= htmlspecialchars($post['tag']) ?></p>
                            <?php if (!empty($post['image'])): ?>
                                <div style="text-align: center;">
                                    <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post Image" style="width: 500px; height: auto;">
                                </div>
                            <?php endif; ?>
                            <a href="index.php?paction=postDetail&id=<?= $post['id'] ?>">Xem chi tiết</a>
                        </div>

                        <div class="post-actions">
                            <button><i class="fas fa-thumbs-up"></i> Like (<?= $post['like_count'] ?>)</button>
                            <button ><i class="fas fa-comment"></i> Comment</button>
                            <button><i class="fas fa-share"></i> Share</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có bài viết nào.</p>
            <?php endif; ?>
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

    <!-- Modal chỉnh sửa profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($_SESSION['errorMessage'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['errorMessage']; ?>
                    </div>
                    <?php unset($_SESSION['errorMessage']); // Xóa thông báo sau khi hiển thị ?>
                <?php endif; ?>

                <form action="index.php?paction=updateProfile&id=<?php echo $_SESSION['user']['user_id']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="ABC" 
                            value="<?php echo $_SESSION['user']['input_username'] ?? $_SESSION['user']['usernames']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="abc@example.com" 
                            value="<?php echo $_SESSION['user']['input_email'] ?? $_SESSION['user']['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="profilePic" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profilePic" name="profilePic">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

</div>

</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (!empty($_GET['modal']) && $_GET['modal'] === 'open'): ?>
            var editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'), {
                backdrop: 'static',
                keyboard: false
            });
            editProfileModal.show();
        <?php endif; ?>
    });
</script>

<script>
    document.addEventListener('click', function(event) {
        var isClickInside = event.target.closest('.menu-options');

        document.querySelectorAll('.menu-content').forEach(function(menu) {
            if (!isClickInside || !menu.contains(event.target)) {
                menu.style.display = 'none';
            }
        });

        if (isClickInside) {
            var menu = isClickInside.querySelector('.menu-content');
            if (menu) {
                menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
            }
        }
    })
    
    document.getElementById('ep-Btn').addEventListener('click', function(event) {
        event.preventDefault();
        var editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
        editProfileModal.show();
    });

</script>

</html>