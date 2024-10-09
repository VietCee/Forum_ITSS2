<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra và hiển thị thông báo thành công
if (isset($_SESSION['successMessage'])) {
    echo '<script>
            alert("' . htmlspecialchars($_SESSION['successMessage']) . '");
          </script>';
    unset($_SESSION['successMessage']);
}


// Kiểm tra và hiển thị thông báo lỗi
if (isset($_SESSION['error_message'])) {
    echo '<script>
            alert("' . htmlspecialchars($_SESSION['error_message']) . '");
          </script>';
    unset($_SESSION['error_message']);
}

$userAvatar = !empty($_SESSION['user']['profile_picture']) ? "/Forum/public/uploads/" . $_SESSION['user']['profile_picture'] : "/Forum/public/img/default-avatar.jpg";



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage Form</title>
    <link rel="stylesheet" href="/Forum/public/css/homePage.css?v=1.1">
    <link rel="stylesheet" href="/Forum/public/css/post.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/Forum/public/js/homePage.js"></script>
    <style>
        .file-input {
            display: none;
        }

        .file-label {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .file-name {
            margin-left: 10px;
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

                <img src="<?= htmlspecialchars($userAvatar) ?>" alt="User Avatar" class="user-avatar dropdown-toggle" id="userOptionsButton" data-bs-toggle="dropdown" aria-expanded="false">
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userOptionsButton">
                    <li><a class="dropdown-item" href="index.php?paction=userInfo&id=<?= $_SESSION['user']['user_id'] ?>">マイプロフィール</a></li>
                    <li><a class="dropdown-item" href="index.php?login">ログアウト</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <aside class="sidebar">
            <ul>
                <li><a href="index.php?paction=homePage"><i class="fas fa-home"></i> ホーム</a></li>
                <li><a href="index.php?paction=savedPosts"><i class="fas fa-bookmark"></i> 保存されました</a></li>
                <?php if ($_SESSION['user']['admin'] == 1): ?>
                    <li><a href="index.php?paction=manageAccounts"><i class="fas fa-user-shield"></i> ユーザーの管理</a></li>
                <?php endif; ?>
                <li><a href="index.php?paction=searchForm"><i class="fas fa-magnifying-glass"></i> 検索</a></li>
            </ul>
        </aside>

        <section class="feed">
            <form action="index.php?paction=addPost" method="POST" enctype="multipart/form-data">
                <div class="status-box">
                    <textarea name="content" placeholder="何を考えているのですか？" required></textarea>
                    <label for="image" class="file-label">写真を選択</label>
                    <input type="file" id="image" name="image" accept="image/*" class="file-input" onchange="updateFileName()">
                    <span class="file-name">ファイルがまだ選択されていません</span>
                    <input type="text" name="tag" placeholder="タグ" style="margin-left: 15px;">
                    <button type="submit">ポスト</button>
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

                            <?php if ($_SESSION['user']['user_id'] == $post['user_id'] || $_SESSION['user']['admin'] == 1): ?>
                                <div class="menu-options">
                                    <button class="menu-btn">⋮</button>
                                    <div class="menu-content">
                                        <a href="index.php?paction=editPost&id=<?= $post['id'] ?>">編集</a>
                                        <a href="index.php?paction=deletePost&id=<?= $post['id'] ?>"
                                            onclick="return confirm('この投稿を削除してもよろしいですか?')">削除</a>
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
                        </div>

                        <div class="post-actions">
                            <input type="hidden" class="post-id" value="<?= $post['id'] ?>">
                            <button class="like-button" data-post-id="<?= $post['id'] ?>">
                                <?php if ($postModel->hasLiked($post['id'], $_SESSION['user']['user_id'])): ?>
                                    <i class="fas fa-thumbs-up"></i> 好かん (<?= $post['like_count'] ?>)
                                <?php else: ?>
                                    <i class="fas fa-thumbs-up"></i> 好き (<?= $post['like_count'] ?>)
                                <?php endif; ?>
                            </button>
                            <a href="index.php?paction=postDetail&id=<?= $post['id'] ?>" class="btn">
                                <i class="fas fa-comment"></i> コメント
                            </a>
                            <button class="save-button" data-post-id="<?= $post['id'] ?>">
                                <?php if ($postModel->hasSaved($post['id'], $_SESSION['user']['user_id'])): ?>
                                    <i class="fas fa-bookmark"></i> 保存しない
                                <?php else: ?>
                                    <i class="fas fa-bookmark"></i> 保存
                                <?php endif; ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có bài viết nào.</p>
            <?php endif; ?>
        </section>

        <!-- Right Sidebar -->
        <aside class="right-sidebar">
            <h4>スポンサー</h4>
            <div class="ad">
                <p></p>ここに広告コンテンツがあります...</p>
            </div>
            <h4>トレンド</h4>
            <div class="contact-list">
                <p>#ケーキ</p>
                <p>#辛い</p>
                <p>#バカ</p>
            </div>
        </aside>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function updateFileName() {
            const input = document.getElementById('image');
            const fileNameDisplay = document.querySelector('.file-name');
            if (input.files.length > 0) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = "Chưa chọn tệp nào";
            }
        }
    </script>

</body>



</html>