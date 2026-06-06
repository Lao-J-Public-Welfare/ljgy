<?php
$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sub = trim($_POST['subdomain'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    if (!preg_match('/^[a-z0-9][a-z0-9-]{0,61}[a-z0-9]$/', $sub)) {
        $error = '子域名只能包含小写字母、数字、连字符';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = '邮箱格式不正确';
    } else {
        $stmt = $db->prepare("SELECT id FROM subdomain_requests WHERE subdomain = ?");
        $stmt->execute([$sub]);
        if ($stmt->fetch()) {
            $error = '该子域名已被申请';
        } else {
            $stmt = $db->prepare("INSERT INTO subdomain_requests (subdomain, owner_email, status) VALUES (?, ?, 1)");
            if ($stmt->execute([$sub, $email])) {
                // 自动创建目录
                $dir = "/opt/data/statics/qwq/sites/$sub";
                mkdir($dir, 0755, true);
                file_put_contents("$dir/index.html", "<h1>欢迎访问 $sub.qwq.ljgy123.top</h1><p>这是你的个人站点</p>");
                $message = "申请成功！你的域名已生效：https://$sub.qwq.ljgy123.top";
            } else {
                $error = '提交失败';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>三级域名申请 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { color: #c0392b; margin-bottom: 10px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-weight: 500; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
        button { background: #2c3e2f; color: white; border: none; padding: 12px; border-radius: 30px; cursor: pointer; width: 100%; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .error { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .domain-preview { background: #f8f9fa; padding: 12px; border-radius: 6px; margin-bottom: 20px; text-align: center; font-family: monospace; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>申请三级域名</h1>
        <div class="domain-preview"><span id="preview">你的子域名</span>.qwq.ljgy123.top</div>
        <?php if ($message): ?>
            <div class="success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>子域名</label>
                <input type="text" name="subdomain" id="subdomain" required pattern="[a-z0-9][a-z0-9-]{0,61}[a-z0-9]">
            </div>
            <div class="form-group">
                <label>联系邮箱</label>
                <input type="email" name="email" required>
            </div>
            <button type="submit">立即申请</button>
        </form>
    </div>
</div>
<script>
    document.getElementById('subdomain').addEventListener('input', function() {
        document.getElementById('preview').textContent = this.value || '你的子域名';
    });
</script>
</body>
</html>
