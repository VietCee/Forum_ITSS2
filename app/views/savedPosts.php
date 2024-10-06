<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Saved Posts</title>
    <link rel="stylesheet" href="/Forum/public/css/savedPost.css">
</head>

<body>

    <h2>Your Saved Posts</h2>

    <?php if (count($savedPosts) > 0): ?>
        <?php foreach ($savedPosts as $post): ?>
            <div class="post">
                <h3><a href="index.php?paction=postDetail&id=<?= htmlspecialchars($post['id']) ?>"><?= htmlspecialchars($post['tag']) ?></a></h3>

                <?php if (!empty($post['image'])): ?>
                    <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['tag']) ?>">
                <?php endif; ?>

                <p><?= htmlspecialchars($post['content']) ?></p>
                <small>Posted on: <?= htmlspecialchars($post['date_created']) ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Bạn chưa lưu bài viết nào.</p>
    <?php endif; ?>

</body>

</html>