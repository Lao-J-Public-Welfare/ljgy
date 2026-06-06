<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$type = $_GET['type'] ?? $_POST['type'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

if (!in_array($type, ['post', 'comment', 'user']) || !$id) {
    die('参数错误');
}


if ($type == 'post') {
    $stmt = $pdo->prepare("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
    $stmt->execute([$id]);
    $target = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = '帖子：' . $target['title'];
} elseif ($type == 'comment') {
    $stmt = $pdo->prepare("SELECT c.*, u.username, p.title as post_title FROM comments c JOIN users u ON c.user_id = u.id JOIN posts p ON c.post_id = p.id WHERE c.id = ?");
    $stmt->execute([$id]);
    $target = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = '评论：' . $target['post_title'];
} else {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $target = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = '用户：' . $target['username'];
}

if (!$target) {
    die('内容不存在');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reason = trim($_POST['reason']);
    $details = trim($_POST['details']);
    
    if (empty($reason)) {
        $error = '请选择举报原因';
    } else {
        $stmt = $pdo->prepare("INSERT INTO reports (reporter_id, target_type, target_id, reason, details) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$_SESSION['user_id'], $type, $id, $reason, $details])) {
            $success = '举报已提交，管理员将尽快处理';
        } else {
            $error = '提交失败，请稍后重试';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>举报 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        h1 { margin-bottom: 20px; color: #333; }
        .target-info { background: #f5f5f5; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .target-info p { margin: 5px 0; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        textarea { height: 150px; resize: vertical; }
        .btn { padding: 12px 30px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #c82333; }
        .error { color: #dc3545; margin-bottom: 15px; }
        .success { color: #28a745; margin-bottom: 15px; }
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #999; border-top: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">牢J公益</div>
            <div class="nav">
                <a href="index.php">首页</a>
                <a href="new_post.php">发帖</a>
                <a href="profile.php"><?php echo $_SESSION['username']; ?></a>
                <a href="logout.php">退出</a>
            </div>
        </div>

        <div class="card">
            <h1>举报</h1>
            
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="target-info">
                <p><strong>举报内容：</strong> <?php echo htmlspecialchars($title); ?></p>
                <p><strong>举报类型：</strong> <?php echo $type == 'post' ? '帖子' : ($type == 'comment' ? '评论' : '用户'); ?></p>
            </div>

            <form method="post">
                <div class="form-group">
                    <label>举报原因</label>
                    <select name="reason" required>
                        <option value="">请选择</option>
                        <option value="spam">垃圾广告</option>
                        <option value="abuse">人身攻击</option>
                        <option value="illegal">违法信息</option>
                        <option value="pornography">色情内容</option>
                        <option value="other">其他</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>详细说明</label>
                    <textarea name="details" placeholder="请详细描述举报原因..."></textarea>
                </div>
                <button type="submit" class="btn">提交举报</button>
            </form>
        </div>

        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>
</body>
</html>
