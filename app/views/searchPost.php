<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        /* CSS cho toàn bộ trang */
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef; /* Màu nền nhạt */
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #495057; /* Màu tiêu đề */
            text-align: center;
            margin-bottom: 20px;
        }

        .post {
            border: 1px solid #ced4da; /* Viền nhẹ */
            border-radius: 5px; /* Bo góc */
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff; /* Màu nền trắng cho bài viết */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Đổ bóng */
            transition: transform 0.2s; /* Hiệu ứng khi hover */
        }

        .post:hover {
            transform: translateY(-2px); /* Đưa lên khi hover */
        }

        .post h3 {
            color: #007bff; /* Màu tiêu đề bài viết */
            margin-bottom: 10px;
        }

        .post a {
            text-decoration: none; /* Bỏ gạch chân */
            color: inherit; /* Kế thừa màu từ tiêu đề */
        }

        .post a:hover {
            text-decoration: underline; /* Gạch chân khi hover */
        }

        .post p {
            color: #6c757d; /* Màu chữ nội dung bài viết */
            margin: 10px 0;
        }

        .post small {
            color: #868e96; /* Màu chữ cho thời gian đăng */
            font-style: italic; /* Chữ nghiêng */
        }

        /* Thêm style cho phần không tìm thấy kết quả */
        .no-results {
            text-align: center;
            color: #dc3545; /* Màu đỏ cho thông báo không có kết quả */
            font-weight: bold;
            margin-top: 20px;
        }

        /* CSS cho thanh tìm kiếm */
        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .search-form button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="search-form">
        <form action="index.php?paction=search" method="GET">
            <input type="text" name="tag" placeholder="Search by tag" required>
            <button type="submit">Search</button>
        </form>
    </div>

    <h2>Search Results for: <?= htmlspecialchars($tag) ?></h2>

    <?php if (count($searchResults) > 0): ?>
        <?php foreach ($searchResults as $post): ?>
            <div class="post">
                <h3><a href="index.php?paction=postDetail&id=<?= htmlspecialchars($post['id']) ?>"><?= htmlspecialchars($post['tag']) ?></a></h3>
                <p><?= htmlspecialchars($post['content']) ?></p>
                <small>Posted on: <?= htmlspecialchars($post['date_created']) ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-results">No posts found for the tag: <?= htmlspecialchars($tag) ?></p>
    <?php endif; ?>

</body>

</html>
