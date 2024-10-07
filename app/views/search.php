<?php
// search.php
if (isset($_POST['search_tag'])) {
    $tag = htmlspecialchars($_POST['search_tag']);
    // Gọi controller để xử lý tìm kiếm
    $posts = $postController->searchPostsByTag($tag);
} else {
    $posts = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Posts</title>
</head>
<body>
    <h1>Search Posts by Tag</h1>
    <form method="POST" action="index.php?paction=search">
        <input type="text" name="search_tag" placeholder="Enter tag" required>
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($posts)): ?>
        <h2>Search Results:</h2>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li><?php echo htmlspecialchars($post['content']); ?> (Tags: <?php echo htmlspecialchars($post['tags']); ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No results found for the tag "<?php echo htmlspecialchars($tag); ?>".</p>
    <?php endif; ?>
</body>
</html>
