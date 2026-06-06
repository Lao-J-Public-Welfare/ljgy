<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=shortlink_db;charset=utf8mb4', 'root', 'JONGN123');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['url'])) {
    $url = filter_var($_POST['url'], FILTER_VALIDATE_URL);
    if ($url) {
        $code = substr(md5(uniqid()), 0, 6);
        $stmt = $db->prepare("INSERT INTO short_links (short_code, original_url) VALUES (?, ?)");
        if ($stmt->execute([$code, $url])) {
            $short_url = "https://www.ljgy123.top/s/" . $code;
            $success = "短链接生成成功！";
        } else {
            $error = "生成失败，请重试";
        }
    } else {
        $error = "请输入有效的URL";
    }
}

if (isset($_GET['c'])) {
    $code = $_GET['c'];
    $stmt = $db->prepare("SELECT original_url FROM short_links WHERE short_code = ?");
    $stmt->execute([$code]);
    $url = $stmt->fetchColumn();
    if ($url) {
        header("Location: $url");
        exit;
    } else {
        $error = "短链接不存在";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>牢J公益 · 短链接</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{background:#f5f5f5;font-family:sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh}
        .container{max-width:600px;width:100%;padding:20px}
        .card{background:white;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);padding:30px}
        h1{text-align:center;margin-bottom:30px;color:#333}
        .form-group{margin-bottom:20px}
        label{display:block;margin-bottom:5px;color:#666}
        input[type=url]{width:100%;padding:12px;border:1px solid #ddd;border-radius:4px;font-size:16px}
        button{width:100%;padding:12px;background:#007bff;color:white;border:none;border-radius:4px;font-size:16px;cursor:pointer}
        button:hover{background:#0056b3}
        .error{color:#dc3545;margin-bottom:15px;padding:10px;background:#f8d7da;border-radius:4px}
        .success{color:#28a745;margin-bottom:15px;padding:10px;background:#d4edda;border-radius:4px}
        .result{margin-top:20px;padding:15px;background:#e9ecef;border-radius:4px;word-break:break-all}
        .back{text-align:center;margin-top:20px}
        .back a{color:#007bff;text-decoration:none}
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>牢J短链接</h1>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label>输入长网址</label>
                    <input type="url" name="url" placeholder="https://example.com" required>
                </div>
                <button type="submit">生成短链接</button>
            </form>
            <?php if (isset($short_url)): ?>
                <div class="result">
                    <p><strong>短链接：</strong></p>
                    <p><a href="<?php echo $short_url; ?>" target="_blank"><?php echo $short_url; ?></a></p>
                </div>
            <?php endif; ?>
            <div class="back">
                <a href="zzxx.php">去站长信箱</a>
            </div>
        </div>
    </div>
</body>
</html>
