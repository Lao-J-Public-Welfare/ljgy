<?php
require_once 'config.php';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


if ($action == 'create' && isLoggedIn()) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        
        if (empty($name)) {
            $error = '分类名称不能为空';
        } else {
            $stmt = $pdo->prepare("INSERT INTO categories (name, description, created_by) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $description, $_SESSION['user_id']])) {
                $cat_id = $pdo->lastInsertId();
                
                $pdo->prepare("INSERT INTO groups (category_id, name, description) VALUES (?, ?, ?)")
                    ->execute([$cat_id, $name, $description]);
                redirect("category.php?id=$cat_id");
            } else {
                $error = '创建失败';
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>新建分类 - 牢J公益</title>
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
            .form-group { margin-bottom: 20px; }
            label { display: block; margin-bottom: 5px; color: #666; }
            input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
            textarea { height: 100px; resize: vertical; }
            .btn { padding: 12px 30px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
            .btn:hover { background: #218838; }
            .error { color: #dc3545; margin-bottom: 15px; }
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
                <h1>新建分类</h1>
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="form-group">
                        <label>分类名称</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>描述</label>
                        <textarea name="description"></textarea>
                    </div>
                    <button type="submit" class="btn">创建</button>
                </form>
            </div>

            <div class="footer">
                © 2026 牢J公益
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}


$categories = $pdo->query("SELECT c.*, u.username, COUNT(p.id) as post_count 
                           FROM categories c 
                           LEFT JOIN users u ON c.created_by = u.id 
                           LEFT JOIN posts p ON c.id = p.category_id 
                           GROUP BY c.id 
                           ORDER BY c.created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>分类 - 牢J公益</title>
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
        .create-btn { display: inline-block; margin-bottom: 20px; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; }
        .create-btn:hover { background: #218838; }
        .category-item { padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .category-item:last-child { border-bottom: none; }
        .category-name { font-size: 18px; font-weight: bold; color: #333; }
        .category-name a { color: #333; text-decoration: none; }
        .category-name a:hover { color: #007bff; }
        .category-meta { color: #999; font-size: 12px; margin-top: 5px; }
        .category-stats { display: flex; gap: 20px; color: #666; }
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
                <?php if (isLoggedIn()): ?>
                    <a href="profile.php"><?php echo $_SESSION['username']; ?></a>
                    <a href="logout.php">退出</a>
                <?php else: ?>
                    <a href="login.php">登录</a>
                    <a href="register.php">注册</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <h1>分类</h1>
            <?php if (isLoggedIn()): ?>
                <a href="?action=create" class="create-btn">+ 新建分类</a>
            <?php endif; ?>

            <?php foreach ($categories as $cat): ?>
            <div class="category-item">
                <div>
                    <div class="category-name">
                        <a href="group.php?category_id=<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></a>
                    </div>
                    <div class="category-meta">
                        创建者：<?php echo htmlspecialchars($cat['username'] ?? '系统'); ?> · 
                        创建时间：<?php echo date('Y-m-d', strtotime($cat['created_at'])); ?>
                    </div>
                    <?php if ($cat['description']): ?>
                        <div style="color:#666; margin-top:5px;"><?php echo htmlspecialchars($cat['description']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="category-stats">
                    <span>📄 <?php echo $cat['post_count']; ?> 帖子</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>
</body>
</html>
