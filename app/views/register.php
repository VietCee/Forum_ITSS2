<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = $_SESSION['error'] ?? '';
$form_data = $_SESSION['form_data'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Forum/public/css/signup_signin.css">
</head>

<body>
    <div class="content-wrapper">
        <div class="img-container">
            <img src="./img/logo.png" alt="Register Image">
        </div>
        <div class="login-container">
            <h3 class="text-center mb-4">アカウントを作成する！</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="index.php?paction=handleRegister" method="post">
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="メールアドレスを入力してください..." value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="usernames" placeholder="ユーザー名を入力してください..." value="<?php echo htmlspecialchars($form_data['usernames'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="passwords" placeholder="パスワード">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="confirm_password" placeholder="パスワードを認証する">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn login-btn">使用域</button>
                </div>
                <hr>
                <div class="text-center mt-3">
                    <a href="index.php?paction=login" class="text-decoration-none">すでにアカウントをお持ちですか? ログイン！</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>