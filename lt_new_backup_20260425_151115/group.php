<?php
require_once 'config.php';

$group_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($group_id <= 0) {
    die("无效的小组ID");
}


$sql = "SELECT g.*, c.name as category_name 
        FROM `groups` g 
        LEFT JOIN categories c ON g.category_id = c.id 
        WHERE g.id = $group_id";
$group = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

if (!$group) {
    die("小组不存在");
}


$members_sql = "SELECT u.username, u.avatar, ug.joined_at 
                FROM user_groups ug 
                JOIN users u ON ug.user_id = u.id 
                WHERE ug.group_id = $group_id 
                ORDER BY ug.joined_at DESC";
$members = $pdo->query($members_sql)->fetchAll(PDO::FETCH_ASSOC);


$posts_sql = "SELECT p.*, u.username 
              FROM posts p 
              JOIN users u ON p.user_id = u.id 
              WHERE p.group_id = $group_id 
              ORDER BY p.created_at DESC 
              LIMIT 20";
$posts = $pdo->query($posts_sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($group['name']); ?> - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .card { background: white; border-radius: 8px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .group-name { font-size: 28px; margin-bottom: 10px; }
        .group-meta { color: #666; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .member-list { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 15px; }
        .member { display: flex; align-items: center; gap: 10px; background: #f9f9f9; padding: 8px 15px; border-radius: 30px; }
        .post-item { padding: 15px 0; border-bottom: 1px solid #eee; }
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php"><?php echo $_SESSION['username']; ?></a>
                    <a href="logout.php">退出</a>
                <?php else: ?>
                    <a href="login.php">登录</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <h1 class="group-name"><?php echo htmlspecialchars($group['name']); ?></h1>
            <div class="group-meta">
                分类：<?php echo htmlspecialchars($group['category_name'] ?? '未分类'); ?> | 
                创建于：<?php echo date('Y-m-d', strtotime($group['created_at'])); ?>
            </div>
            <p><?php echo nl2br(htmlspecialchars($group['description'] ?? '暂无简介')); ?></p>
        </div>

        <div class="card">
            <h2>小组成员 (<?php echo count($members); ?>)</h2>
            <div class="member-list">
                <?php foreach ($members as $member): ?>
                <div class="member">
                    <span><?php echo htmlspecialchars($member['username']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card">
            <h2>小组帖子</h2>
            <?php if (empty($posts)): ?>
                <p>暂无帖子，快去发布第一个吧！</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                <div class="post-item">
                    <a href="post.php?id=<?php echo $post['id']; ?>" style="font-size: 18px; font-weight: bold; color: #007bff; text-decoration: none;"><?php echo htmlspecialchars($post['title']); ?></a>
                    <div style="font-size: 12px; color: #999; margin-top: 5px;"><?php echo htmlspecialchars($post['username']); ?> · <?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="footer">© 2026 牢J公益 | 人民万岁</div>
    </div>
</body>
</html>
