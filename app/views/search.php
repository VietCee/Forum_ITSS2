<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Posts by Tag</title>
    <link rel="stylesheet" href="/Forum/public/css/search.css">
</head>
<body>
    <div class="container">
        <a href="index.php?paction=homePage" class="back-home">ホームページに戻る</a>
        
        <div class="search-form">
            <h2>タグで投稿を検索</h2>
            <form action="index.php?paction=searchPost" method="POST">
                <label for="tag">タグを入力してください:</label>
                <input type="text" name="tag" id="tag" required>
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="search-results">
            <h2>検索結果</h2>
            <?php if (!empty($posts)): ?>
                <ul>
                    <?php foreach ($posts as $post): ?>
                        <li>
                            <p><strong><?php echo htmlspecialchars($post['usernames']); ?></strong> on <?php echo htmlspecialchars($post['date_created']); ?></p>
                            <?php if (!empty($post['image'])): ?>
                                <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post Image">
                            <?php endif; ?>
                            <p><?php echo htmlspecialchars($post['content']); ?></p>
                            <small>タグ: <?php echo htmlspecialchars($post['tag']); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>そのタグが付いた投稿は見つかりませんでした。</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
