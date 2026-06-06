<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}


if (!isset($pdo)) {
    die('数据库连接失败');
}


$pdo->exec("
    CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT,
        description VARCHAR(255)
    )
");


$default_settings = [
    'site_name' => '牢J公益',
    'site_description' => '一个简约的社区',
    'allow_register' => '1',
    'require_email' => '0',
    'posts_per_page' => '20',
    'comments_per_page' => '50',
    'max_upload_size' => '2',
    'allow_guest_view' => '1'
];


foreach ($default_settings as $key => $value) {
    $pdo->prepare("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (?, ?)")
        ->execute([$key, $value]);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (array_key_exists($key, $default_settings)) {
            $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?")
                ->execute([trim($value), $key]);
        }
    }
    $success = '设置已保存';
}


$settings = [];
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>系统设置 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        h1 { margin-bottom: 20px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #666; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input { width: auto; }
        .btn { padding: 12px 30px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #0056b3; }
        .success { color: #28a745; margin-bottom: 15px; padding: 10px; background: #d4edda; border-radius: 4px; }
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
                <a href="admin.php">管理</a>
                <a href="logout.php">退出</a>
            </div>
        </div>

        <div class="card">
            <h1>系统设置</h1>
            
            <?php if (isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>站点名称</label>
                    <input type="text" name="site_name" value="<?php echo htmlspecialchars($settings['site_name'] ?? '牢J公益'); ?>" required>
                </div>

                <div class="form-group">
                    <label>站点描述</label>
                    <input type="text" name="site_description" value="<?php echo htmlspecialchars($settings['site_description'] ?? ''); ?>">
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" name="allow_register" value="1" <?php echo ($settings['allow_register'] ?? '1') == '1' ? 'checked' : ''; ?>>
                    <label style="margin:0;">允许新用户注册</label>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" name="require_email" value="1" <?php echo ($settings['require_email'] ?? '0') == '1' ? 'checked' : ''; ?>>
                    <label style="margin:0;">注册需要邮箱</label>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" name="allow_guest_view" value="1" <?php echo ($settings['allow_guest_view'] ?? '1') == '1' ? 'checked' : ''; ?>>
                    <label style="margin:0;">允许游客浏览</label>
                </div>

                <div class="form-group">
                    <label>每页帖子数</label>
                    <input type="number" name="posts_per_page" value="<?php echo htmlspecialchars($settings['posts_per_page'] ?? 20); ?>" min="5" max="100" required>
                </div>

                <div class="form-group">
                    <label>每页评论数</label>
                    <input type="number" name="comments_per_page" value="<?php echo htmlspecialchars($settings['comments_per_page'] ?? 50); ?>" min="10" max="200" required>
                </div>

                <div class="form-group">
                    <label>最大上传大小 (MB)</label>
                    <input type="number" name="max_upload_size" value="<?php echo htmlspecialchars($settings['max_upload_size'] ?? 2); ?>" min="1" max="10" step="0.5" required>
                </div>

                <button type="submit" class="btn">保存设置</button>
            </form>
        </div>

        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>
</body>
</html>
