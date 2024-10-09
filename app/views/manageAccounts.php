<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウントの管理</title>
    <link rel="stylesheet" href="/Forum/public/css/manageUser.css?v=1.0">
</head>
<body>
    
<div class="container">
    <a href="index.php?paction=homePage">ホームページに戻る</a>
    <h2>アカウントの管理</h2>
    <table>
        <thead>
            <tr>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
                <th>Gmail</th>
                <th>アクション</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['usernames']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <form action="index.php?paction=deleteUser" method="POST" onsubmit="return confirm('このユーザーを削除してもよろしいですか？');">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
