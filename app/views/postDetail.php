<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿の詳細</title>
    <link rel="stylesheet" href="/Forum/public/css/postDetail.css">
</head>

<body>
    <div class="container">
    <h1>POST DETAIL</h1>
        <div class="post-header">
            <!-- Profile Image -->
            <div class="profile-pic-container">
                <img src="../public/img/register.jpg" alt="Profile Picture" class="profile-pic">
            </div>

            <!-- User Info (Usernames and Date Created) -->
            <div class="post-info">
                <h3>投稿者: <?= htmlspecialchars($post['usernames']) ?></h3>
                <p>投稿日: <?= $post['date_created'] ?></p>
            </div>
        </div>

        <div class="post-detail">
            <h2><?= htmlspecialchars($post['content']) ?></h2>
            <p class="tag"><strong>#</strong><?= htmlspecialchars($post['tag']) ?></p>
            <?php if (!empty($post['image'])): ?>
                <img src="../public/uploads/<?= htmlspecialchars($post['image']) ?>" alt="投稿画像" class="post-image">
            <?php endif; ?>
        </div>

        <div class="comments-section">
            <h3>コメント</h3>
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <strong><?= htmlspecialchars($comment['usernames']) ?></strong>
                            <span class="comment-date"><?= $comment['date_created'] ?></span>
                        </div>
                        <p class="comment-content"><?= htmlspecialchars($comment['content']) ?></p>
                        <?php if ($_SESSION['user']['user_id'] == $comment['user_id']): ?>
                            <div class="comment-actions">
                                <a href="index.php?paction=editComment&id=<?= $comment['id'] ?>" class="edit-comment">編集</a>
                                <a href="index.php?paction=deleteComment&id=<?= $comment['id'] ?>" class="delete-comment" onclick="return confirm('このコメントを削除してもよろしいですか？')">削除</a>
                            </div>
                        <?php endif; ?>
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

</html>
