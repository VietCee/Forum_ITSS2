<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="/Forum/public/css/editPost.css?v=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>

<body>

    <form action="index.php?paction=updatePost&id=<?= $post['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="header-container">
            <a href="index.php?paction=homePage" class="back-arrow"><i class="fas fa-arrow-left"></i></a>
            <h2>Edit Post</h2>
        </div>
        <input type="hidden" name="id" value="<?= $post['id'] ?>">
        <textarea name="content" rows="5" cols="50"><?= htmlspecialchars($post['content']) ?></textarea><br>
        <input type="text" name="tag" value="<?= htmlspecialchars($post['tag']) ?>"><br>

        <?php if (!empty($post['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Current Image" style="width: 300px; height: auto;">
        <?php endif; ?>
        <input type="file" name="image" accept="image/*"><br>
        <input type="hidden" name="returnTo" value="<?= isset($_GET['returnTo']) ? $_GET['returnTo'] : 'homePage' ?>">
        <button type="submit">Update Post</button>
    </form>
</body>

</html>