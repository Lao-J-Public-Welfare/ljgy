<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'JONGN123';
$db_name = 'ljgy_links';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die('数据库连接失败');
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = trim($_POST['site_name'] ?? '');
    $site_url = trim($_POST['site_url'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $intro = trim($_POST['intro'] ?? '');
    $ip = $_SERVER['REMOTE_ADDR'];
    
    if (empty($site_name) || empty($site_url) || empty($email)) {
        $error = '请填写完整信息';
    } elseif (!filter_var($site_url, FILTER_VALIDATE_URL)) {
        $error = '网站地址格式不正确';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = '邮箱格式不正确';
    } else {
        $stmt = $pdo->prepare("INSERT INTO link_applications (site_name, site_url, email, intro, ip) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$site_name, $site_url, $email, $intro, $ip])) {
            $message = '申请已提交，我们会尽快审核！';
        } else {
            $error = '提交失败，请稍后重试';
        }
    }
}

$stmt = $pdo->query("SELECT site_name, site_url FROM links ORDER BY sort_order ASC");
$approved_links = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申请友链 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: white; font-family: sans-serif; padding: 20px; }
        .container { max-width: 700px; margin: 0 auto; }
        .card { background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 20px; }
        h1 { color: black; margin-bottom: 10px; text-align: center; font-size: 24px; }
        .sub { text-align: center; color: black; font-size: 14px; margin-bottom: 25px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-weight: 500; color: black; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: inherit; color: black; background: white; }
        textarea { resize: vertical; min-height: 80px; }
        button { width: 100%; background: #2c3e2f; color: white; border: none; padding: 12px; border-radius: 40px; font-size: 16px; cursor: pointer; transition: 0.2s; }
        button:hover { background: #1e2a21; transform: translateY(-1px); }
        .message { padding: 12px; border-radius: 8px; margin-bottom: 20px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .back { text-align: center; margin-top: 20px; }
        .back a { color: #c0392b; text-decoration: none; }
        .links-list { margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee; }
        .links-list h3 { font-size: 16px; margin-bottom: 12px; color: black; }
        .links-list a { color: #2c3e2f; text-decoration: none; margin-right: 15px; }
        .links-list a:hover { text-decoration: underline; }
        .footer-note { font-size: 12px; color: black; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>申请友情链接</h1>
            <div class="sub">交换友链，互相引流，共同成长</div>
            
            <?php if ($message): ?>
                <div class="message success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="message error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>网站名称</label>
                    <input type="text" name="site_name" required placeholder="例如：牢J公益">
                </div>
                <div class="form-group">
                    <label>网站地址</label>
                    <input type="url" name="site_url" required placeholder="https:
                </div>
                <div class="form-group">
                    <label>联系邮箱</label>
                    <input type="email" name="email" required placeholder="用于接收审核结果">
                </div>
                <div class="form-group">
                    <label>网站简介</label>
                    <textarea name="intro" placeholder="简单介绍一下你的网站"></textarea>
                </div>
                <button type="submit">提交申请</button>
            </form>
            
            <div class="back">
                <a href="/">返回首页</a>
            </div>
        </div>
        
        <div class="card">
            <h3>现有友链</h3>
            <div class="links-list">
                <?php if (empty($approved_links)): ?>
                    <p style="color: black;">暂无友链，欢迎申请</p>
                <?php else: ?>
                    <?php foreach ($approved_links as $link): ?>
                        <a href="<?php echo htmlspecialchars($link['site_url']); ?>" target="_blank"><?php echo htmlspecialchars($link['site_name']); ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="footer-note">
                申请后我们会尽快审核，通过后自动显示在上方。
            </div>
        </div>
    </div>
</body>
</html>
