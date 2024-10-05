<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài viết</title>
    <link rel="stylesheet" href="/Forum/public/css/postDetail.css">


</head>

<body>

    <div class="container">

        <div class="post-detail">
            <a href="index.php?paction=homePage">Quay lại trang chủ</a>
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
                    <div class="comment" id="comment-<?= $comment['id'] ?>">
                        <p><strong><?= htmlspecialchars($comment['usernames']) ?>:</strong>
                            <span id="comment-content-<?= $comment['id'] ?>"><?= htmlspecialchars($comment['content']) ?></span>
                        </p>
                        <p><?= $comment['date_created'] ?></p>

                        <?php if ($_SESSION['user']['user_id'] == $comment['user_id']): ?>
                            <a href="javascript:void(0);" onclick="editComment(<?= $comment['id'] ?>)">Sửa</a>
                            <a href="index.php?paction=deleteComment&comment_id=<?= $comment['id'] ?>&post_id=<?= $post['id'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">Xóa</a>
                        <?php endif; ?>

                        <!-- Form sửa -->
                        <form id="edit-form-<?= $comment['id'] ?>" class="edit-form" style="display:none;" method="POST" onsubmit="return saveComment(<?= $comment['id'] ?>, <?= $post['id'] ?>)">
                            <textarea id="edit-content-<?= $comment['id'] ?>"><?= htmlspecialchars($comment['content']) ?></textarea>
                            <div class="button-group">
                                <button type="submit">Update</button>
                                <button type="button" onclick="cancelEdit(<?= $comment['id'] ?>)">Cancel</button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có bình luận nào.</p>
            <?php endif; ?>

            <form action="index.php?paction=addComment" method="POST">
                <textarea name="content" placeholder="Thêm bình luận" required></textarea>
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <button type="submit">Bình luận</button>
            </form>
        </div>

    </div>
</body>
<script src="/Forum/public/js/comment.js"></script>

</html>