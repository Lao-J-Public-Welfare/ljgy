<?php
session_start();
require_once 'config.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $code = $_POST['code'];
    
    if (!isset($_SESSION['verify_code']) || $_SESSION['verify_code'] != $code) {
        $error = "验证码错误";
    } elseif ($_SESSION['verify_expire'] < time()) {
        $error = "验证码已过期";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "邮箱已被注册";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->execute([$email, $password_hash]);
            unset($_SESSION['verify_code']);
            unset($_SESSION['verify_expire']);
            header('Location: index.php');
            exit;
        }
    }
}

if (isset($_GET['send_code'])) {
    $email = $_GET['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("邮箱格式错误");
    }
    
    $code = rand(100000, 999999);
    $_SESSION['verify_code'] = $code;
    $_SESSION['verify_expire'] = time() + 600;
    
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.exmail.qq.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ljgymail@ljgy123.top';
        $mail->Password = 'gPBBhKg8mEcz5NQH';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        
        $mail->setFrom('ljgymail@ljgy123.top', '牢J公益');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = '牢J公益域名分发系统 - 验证码';
        $mail->Body = "<h2>您的验证码是：<b style='color:#3498db'>$code</b></h2><p>验证码10分钟内有效。</p>";
        
        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo "邮件发送失败: " . $mail->ErrorInfo;
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>注册 - 牢J公益域名分发</title>
<script>
function sendCode() {
    var email = document.getElementById('email').value;
    if (!email) {
        alert('请先填写邮箱');
        return;
    }
    var btn = document.getElementById('sendBtn');
    btn.disabled = true;
    btn.innerText = '发送中...';
    
    fetch('register.php?send_code=1&email=' + encodeURIComponent(email))
        .then(response => response.text())
        .then(data => {
            if (data == 'success') {
                alert('验证码已发送到邮箱');
                var countdown = 60;
                var timer = setInterval(function() {
                    btn.innerText = countdown + '秒后重试';
                    countdown--;
                    if (countdown < 0) {
                        clearInterval(timer);
                        btn.disabled = false;
                        btn.innerText = '获取验证码';
                    }
                }, 1000);
            } else {
                alert(data);
                btn.disabled = false;
                btn.innerText = '获取验证码';
            }
        });
}
</script>
<style>
body{font-family:system-ui;background:#f0f2f5;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0}
.card{background:white;padding:30px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.1);width:400px}
h1{color:#3498db;margin-bottom:24px;text-align:center}
input{width:100%;padding:10px;margin-bottom:15px;border:1px solid #ddd;border-radius:6px}
button{width:100%;padding:10px;background:#3498db;color:white;border:none;border-radius:6px;cursor:pointer}
.link{text-align:center;margin-top:15px}
.error{color:red;text-align:center;margin-bottom:15px}
.code-group{display:flex;gap:10px}
.code-group input{flex:1}
.code-group button{width:auto;white-space:nowrap}
</style>
</head>
<body>
<div class="card">
<h1>注册账号</h1>
<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
<form method="post">
<input type="email" name="email" id="email" placeholder="邮箱" required>
<div class="code-group">
<input type="text" name="code" placeholder="验证码" required>
<button type="button" id="sendBtn" onclick="sendCode()">获取验证码</button>
</div>
<input type="password" name="password" placeholder="密码" required>
<button type="submit">注册</button>
</form>
<div class="link"><a href="index.php">已有账号？去登录</a></div>
</div>
</body>
</html>
