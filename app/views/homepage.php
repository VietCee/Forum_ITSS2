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
    <title>HomePage Form</title>
    <link rel="stylesheet" href="/Forum/public/css/homePage.css">
    <link rel="stylesheet" href="/Forum/public/css/post.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <nav class="navbar">
        <!-- <div class="navbar-left">
            <img src="/public/img/446foxface2_100697.ico" alt="Facebook Logo" class="logo">
        </div> -->
        <div class="navbar-center">
            <h1>SmallFood</h1>
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

            <form action="index.php?paction=addPost" method="POST" enctype="multipart/form-data">
                <div class="status-box">
                    <textarea name="content" placeholder="何を考えているのですか？" required></textarea>
                    <input type="file" name="image" accept="image/*">
                    <input type="text" name="tag" placeholder="タグ">
                    <button type="submit">Post</button>
                </div>
            </form>

            <!-- Hiển thị bài viết -->
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <div class="post-header">

                            <img src="/public/img/profile-pic.jpg" alt="Profile Picture" class="profile-pic">

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

                            <p><?= htmlspecialchars($post['content']) ?></p></br>
                            <p style="color: #1E90FF;"><strong>#</strong><?= htmlspecialchars($post['tag']) ?></p>
                            <?php if (!empty($post['image'])): ?>
                                <div style="text-align: center;">
                                    <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post Image" style="width: 300px; height: auto;">
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
</body>

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
</script>

</html>