<?php

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: zzxx.php");
    exit;
}


$admin_password = 'JONGN123';


$db = new PDO('mysql:host=localhost;dbname=laojing_forum_new;charset=utf8mb4', 'root', 'JONGN123');


$db->exec("
    CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        message TEXT NOT NULL,
        reply TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $name = trim($_POST['name'] ?? '匿名');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message']);
    
    if (!empty($message)) {
        $stmt = $db->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        $success = "消息已发送，站长会尽快回复";
    } else {
        $error = "消息内容不能为空";
    }
}


$is_admin = false;
if (isset($_POST['admin_login'])) {
    if ($_POST['admin_login'] == $admin_password) {
        $_SESSION['admin'] = true;
        $is_admin = true;
    } else {
        $admin_error = "密码错误";
    }
}
if (isset($_SESSION['admin'])) {
    $is_admin = true;
}


if ($is_admin && isset($_POST['reply'])) {
    $stmt = $db->prepare("UPDATE messages SET reply = ? WHERE id = ?");
    $stmt->execute([$_POST['reply'], $_POST['id']]);
}


if ($is_admin) {
    $messages = $db->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>牢J公益 · 站长信箱</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 20px; }
        h1 { text-align: center; margin-bottom: 30px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        textarea { min-height: 150px; resize: vertical; }
        button { padding: 12px 30px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .error { color: #dc3545; margin-bottom: 15px; padding: 10px; background: #f8d7da; border-radius: 4px; }
        .success { color: #28a745; margin-bottom: 15px; padding: 10px; background: #d4edda; border-radius: 4px; }
        .message-item { border-bottom: 1px solid #eee; padding: 20px 0; }
        .message-meta { color: #999; font-size: 12px; margin-bottom: 10px; }
        .reply-box { margin-top: 10px; background: #f8f9fa; padding: 15px; border-radius: 4px; }
        .admin-login { margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>牢J公益 · 站长信箱</h1>
            
            <?php if (!$is_admin): ?>
                <!-- 普通用户提交消息 -->
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div class="success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="form-group">
                        <label>你的名字（可选）</label>
                        <input type="text" name="name" placeholder="匿名">
                    </div>
                    <div class="form-group">
                        <label>邮箱（可选，用于回复）</label>
                        <input type="email" name="email" placeholder="your@email.com">
                    </div>
                    <div class="form-group">
                        <label>留言内容</label>
                        <textarea name="message" required></textarea>
                    </div>
                    <button type="submit">发送留言</button>
                </form>

                <!-- 管理员登录 -->
                <div class="admin-login">
                    <h3>管理员登录</h3>
                    <?php if (isset($admin_error)): ?>
                        <div class="error"><?php echo $admin_error; ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="form-group">
                            <input type="password" name="admin_login" placeholder="管理员密码">
                        </div>
                        <button type="submit">登录</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($is_admin): ?>
        <div class="card">
            <h2>消息列表</h2>
            <p><a href="?logout=1">退出管理</a></p>
            <?php foreach ($messages as $msg): ?>
            <div class="message-item">
                <div class="message-meta">
                    <strong><?php echo htmlspecialchars($msg['name'] ?: '匿名'); ?></strong> 
                    (<?php echo htmlspecialchars($msg['email'] ?: '无邮箱'); ?>) 
                    于 <?php echo $msg['created_at']; ?>
                </div>
                <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                
                <?php if ($msg['reply']): ?>
                <div class="reply-box">
                    <strong>站长回复：</strong>
                    <p><?php echo nl2br(htmlspecialchars($msg['reply'])); ?></p>
                </div>
                <?php else: ?>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                    <textarea name="reply" placeholder="写回复..." style="width:100%; padding:8px;"></textarea>
                    <button type="submit" style="margin-top:5px;">回复</button>
                </form>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
