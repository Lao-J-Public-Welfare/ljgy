<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';


$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar'])) {
    $upload_dir = 'uploads/avatars/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $target = $upload_dir . $filename;
    
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
        $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?")->execute([$filename, $user_id]);
        $success = '头像已更新';
    } else {
        $error = '上传失败';
    }
}


$stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt->execute([$user_id]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>个人资料 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .profile-card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 30px; }
        .avatar-section { display: flex; align-items: center; gap: 30px; margin-bottom: 30px; }
        .avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; }
        .avatar-upload { flex: 1; }
        .error { color: #dc3545; margin-bottom: 15px; }
        .success { color: #28a745; margin-bottom: 15px; }
        .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .post-list { margin-top: 30px; }
        .post-item { padding: 15px; border-bottom: 1px solid #eee; }
        .post-item:last-child { border-bottom: none; }
        .post-title { font-size: 18px; color: #333; text-decoration: none; }
        .post-title:hover { color: #007bff; }
        .post-time { color: #999; font-size: 12px; margin-top: 5px; }
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

        <div class="profile-card">
            <h2 style="margin-bottom: 20px;">个人资料</h2>
            
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <div class="avatar-section">
                <img src="<?php echo getAvatar($user_id); ?>" class="avatar">
                <div class="avatar-upload">
                    <form method="post" enctype="multipart/form-data">
                        <input type="file" name="avatar" accept="image/*" required>
                        <button type="submit" class="btn">上传新头像</button>
                    </form>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <p><strong>用户名：</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>注册时间：</strong> <?php echo date('Y-m-d H:i', strtotime($user['created_at'])); ?></p>
                <p><strong>身份：</strong> <?php echo $user['role'] == 'admin' ? '管理员' : '普通用户'; ?></p>
            </div>
        </div>

        <div class="profile-card">
            <h3 style="margin-bottom: 20px;">我的帖子</h3>
            <?php if (empty($posts)): ?>
                <p style="color: #999;">暂无帖子</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                <div class="post-item">
                    <a href="post.php?id=<?php echo $post['id']; ?>" class="post-title"><?php echo htmlspecialchars($post['title']); ?></a>
                    <div class="post-time"><?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>
</body>
</html>
