<?php
session_start();
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header('Location: dashboard.php');
        exit;
    }
    $error = '邮箱或密码错误';
}
?>
<!DOCTYPE html>
<html>
<head><title>登录 - 牢J公益域名分发</title>
<style>
body{font-family:system-ui;background:#f0f2f5;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0}
.card{background:white;padding:30px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.1);width:350px}
h1{color:#3498db;margin-bottom:24px;text-align:center}
input{width:100%;padding:10px;margin-bottom:15px;border:1px solid #ddd;border-radius:6px}
button{width:100%;padding:10px;background:#3498db;color:white;border:none;border-radius:6px;cursor:pointer}
.link{text-align:center;margin-top:15px}
.error{color:red;text-align:center;margin-bottom:15px}
</style>
</head>
<body>
<div class="card">
<h1>牢J公益 · 域名分发</h1>
<?php if($error) echo "<div class='error'>$error</div>"; ?>
<form method="post">
<input type="email" name="email" placeholder="邮箱" required>
<input type="password" name="password" placeholder="密码" required>
<button type="submit">登录</button>
</form>
<div class="link"><a href="register.php">注册账号</a></div>
</div>
</body>
</html>
