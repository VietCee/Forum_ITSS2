<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài viết</title>
    <link rel="stylesheet" href="/Forum/public/css/postDetail.css">

    <style>

        /* public/css/postDetail.css */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.post-detail {
    background-color: #f9f9f9;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.comments-section {
    background-color: #f1f1f1;
    padding: 15px;
    border-radius: 5px;
}

.comment {
    background-color: #fff;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

textarea {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
}

button {
    display: block;
    margin-top: 10px;
    padding: 8px 12px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

    </style>
</head>

<body>
    <div class="container">
        <div class="post-detail">
        <p>Đăng bởi: <?= htmlspecialchars($post['usernames']) ?></p>
        <p>Ngày đăng: <?= $post['date_created'] ?></p>
            <h2><?= htmlspecialchars($post['content']) ?></h2>
            <p style="color: #1E90FF;"><strong>#</strong><?= htmlspecialchars($post['tag']) ?></p>
            <?php if (!empty($post['image'])): ?>
                <img src="../public/uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post Image" style="width: 300px; height: auto;">
            <?php endif; ?>

        </div>

        <div class="comments-section">
    <h3>Bình luận</h3>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><strong><?= htmlspecialchars($comment['usernames']) ?>:</strong> <?= htmlspecialchars($comment['content']) ?></p>
                <p><?= $comment['date_created'] ?></p>

                <!-- Hiển thị nút Sửa và Xóa nếu là bình luận của người dùng hiện tại -->
                <?php if ($_SESSION['user']['user_id'] == $comment['user_id']): ?>
                    <a href="index.php?paction=editComment&id=<?= $comment['id'] ?>">Sửa</a>
                    <a href="index.php?paction=deleteComment&id=<?= $comment['id'] ?>"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">Xóa</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Chưa có bình luận nào.</p>
    <?php endif; ?>

    <!-- Form để thêm bình luận -->
    <form action="index.php?paction=addComment" method="POST">
        <textarea name="content" placeholder="Thêm bình luận" required></textarea>
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <button type="submit">Bình luận</button>
    </form>
</div>

    </div>
</body>

</html>