<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Saved Posts</title>
    <link rel="stylesheet" href="/Forum/public/css/savedPost.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <div class="header-container">
            <a href="index.php?paction=homePage" class="back-arrow"><i class="fas fa-arrow-left"></i></a>
            <h2>保存した投稿</h2>
    </div>

    <?php if (count($savedPosts) > 0): ?>
        <?php foreach ($savedPosts as $post): ?>
            <div class="post">
                <h3>#<a href="index.php?paction=postDetail&id=<?= htmlspecialchars($post['id']) ?>"><?= htmlspecialchars($post['tag']) ?></a></h3>

                <div style="display: flex; justify-content: center"> 
                <?php if (!empty($post['image'])): ?>
                    <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['tag']) ?>">
                <?php endif; ?>
                </div>

                <p><?= htmlspecialchars($post['content']) ?></p>
                <small>Posted on: <?= htmlspecialchars($post['date_created']) ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center;">まだ投稿を保存していません。</p>
    <?php endif; ?>

</body>

</html>