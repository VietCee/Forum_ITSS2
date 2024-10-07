<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿の詳細</title>
    <link rel="stylesheet" href="/Forum/public/css/postDetail.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div class="container">
        <div class="header-container">
            <a href="index.php?paction=homePage" class="back-arrow"><i class="fas fa-arrow-left"></i></a>
            <h1>POST DETAIL</h1>
        </div>
        <div class="post-header">
            <!-- Profile Image -->
            <div class="profile-pic-container">
                <img src="../public/img/register.jpg" alt="Profile Picture" class="profile-pic">
            </div>

            <!-- User Info (Usernames and Date Created) -->
            <div class="post-info">
                <h3><?= htmlspecialchars($post['usernames']) ?></h3>
                <p><?= $post['date_created'] ?></p>
            </div>
        </div>

        <div class="post-detail">
            <h2><?= htmlspecialchars($post['content']) ?></h2>
            <p class="tag"><strong>#</strong><?= htmlspecialchars($post['tag']) ?></p>
            <?php if (!empty($post['image'])): ?>
                <div style="display: flex;  justify-content: center;">
                    <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="投稿画像" class="post-image">
                </div>
            <?php endif; ?>
        </div>

        <div class="comments-section">
            <h3>コメント</h3>
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment" id="comment-<?= $comment['id'] ?>">
                        <div class="comment-header">
                            <strong>コメント者: <?= htmlspecialchars($comment['usernames']) ?></strong>
                            <span  class="comment-date"><?= $comment['date_created'] ?></span>
                        </div>
                        <p id="comment-content-<?= $comment['id'] ?>" class="comment-content">内容: <?= htmlspecialchars($comment['content']) ?></p>
                        <?php if ($_SESSION['user']['user_id'] == $comment['user_id']): ?>
                            <div class="comment-actions">
                                <a class="edit-comment" href="javascript:void(0);" onclick="editComment(<?= $comment['id'] ?>)">編集</a>
                                <a class="delete-comment"  href="index.php?paction=deleteComment&comment_id=<?= $comment['id'] ?>&post_id=<?= $post['id'] ?>"
                                    onclick="return confirm('このコメントを削除してもよろしいですか？')">削除</a>
                            </div>
                        <?php endif; ?>
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
                <p class="no-comments">コメントがまだありません。</p>
            <?php endif; ?>

            <form action="index.php?paction=addComment" method="POST" class="comment-form">
                <textarea name="content" placeholder="コメントを追加" required></textarea>
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <button type="submit" class="comment-button">コメント</button>
            </form>
        </div>

    </div>
</body>
<script src="/Forum/public/js/comment.js"></script>

</html>