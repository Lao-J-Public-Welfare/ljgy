<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}


$stats = [
    'users' => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'posts' => $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn(),
    'comments' => $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn(),
    'categories' => $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
    'groups' => $pdo->query("SELECT COUNT(*) FROM groups")->fetchColumn(),
    'reports_pending' => $pdo->query("SELECT COUNT(*) FROM reports WHERE status = 'pending'")->fetchColumn()
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理员面板 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 20px; }
        h1 { margin-bottom: 20px; color: #333; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-item { background: #f5f5f5; padding: 20px; border-radius: 8px; text-align: center; }
        .stat-number { font-size: 36px; font-weight: bold; color: #007bff; margin-bottom: 5px; }
        .stat-label { color: #666; }
        .admin-menu { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .menu-item { background: #f5f5f5; padding: 20px; border-radius: 8px; text-decoration: none; color: #333; transition: 0.2s; }
        .menu-item:hover { background: #007bff; color: white; transform: translateY(-2px); }
        .menu-item h3 { margin-bottom: 5px; }
        .menu-item p { font-size: 14px; opacity: 0.8; }
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
                <a href="admin.php" style="color:#007bff;">管理</a>
                <a href="logout.php">退出</a>
            </div>
        </div>

        <div class="card">
            <h1>管理员面板</h1>
            
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number"><?php echo $stats['users']; ?></div>
                    <div class="stat-label">用户</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo $stats['posts']; ?></div>
                    <div class="stat-label">帖子</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo $stats['comments']; ?></div>
                    <div class="stat-label">评论</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo $stats['categories']; ?></div>
                    <div class="stat-label">分类</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo $stats['groups']; ?></div>
                    <div class="stat-label">小组</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo $stats['reports_pending']; ?></div>
                    <div class="stat-label">待处理举报</div>
                </div>
            </div>

            <h2 style="margin-bottom:20px;">管理功能</h2>
            <div class="admin-menu">
                <a href="admin_users.php" class="menu-item">
                    <h3>用户管理</h3>
                    <p>查看、编辑、删除用户</p>
                </a>
                <a href="admin_posts.php" class="menu-item">
                    <h3>帖子管理</h3>
                    <p>查看、删除帖子</p>
                </a>
                <a href="admin_comments.php" class="menu-item">
                    <h3>评论管理</h3>
                    <p>查看、删除评论</p>
                </a>
                <a href="admin_categories.php" class="menu-item">
                    <h3>分类管理</h3>
                    <p>管理全部分类</p>
                </a>
                <a href="admin_groups.php" class="menu-item">
                    <h3>小组管理</h3>
                    <p>管理全部小组</p>
                </a>
                <a href="report_list.php" class="menu-item">
                    <h3>举报管理</h3>
                    <p>处理用户举报</p>
                </a>
                <a href="admin_settings.php" class="menu-item">
                    <h3>系统设置</h3>
                    <p>论坛基础设置</p>
                </a>
            </div>
        </div>

        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>
</body>
</html>
