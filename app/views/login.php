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
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Forum/public/css/signup_signin.css">
</head>

<body>
    <div class="content-wrapper">
        <div class="img-container">
            <img src="./img/logo.png" alt="Login Image">
        </div>
        <div class="login-container">
            <h3 class="text-center mb-4">おかえり！</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="index.php?paction=handleLogin" method="post">
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="メールアドレスを入力してください..." value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="passwords" placeholder="パスワード">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                    <label class="form-check-label" for="rememberMe">覚えて</label>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn login-btn">ログイン</button>
                </div>
                <hr>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-danger">Googleでログイン</button>
                    <button type="button" class="btn btn-primary">Facebookでログイン</button>
                </div>
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none">パスワードをお忘れですか？</a><br>
                    <a href="index.php?paction=register" class="text-decoration-none">アカウントを作成する！</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>