<?php
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$action = $_GET['action'] ?? 'view';


if ($id) {
    $stmt = $pdo->prepare("SELECT g.*, c.name as category_name FROM groups g JOIN categories c ON g.category_id = c.id WHERE g.id = ?");
    $stmt->execute([$id]);
    $group = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$group) {
        die('小组不存在');
    }
    
    
    $members = $pdo->prepare("
        SELECT u.*, gt.title,
               (SELECT id FROM group_admins WHERE group_id = ? AND user_id = u.id) as is_admin
        FROM users u
        JOIN group_members gm ON u.id = gm.user_id
        LEFT JOIN group_titles gt ON u.id = gt.user_id AND gt.group_id = ?
        WHERE gm.group_id = ?
    ");
    $members->execute([$id, $id, $id]);
    $members = $members->fetchAll(PDO::FETCH_ASSOC);
    
    
    $posts = $pdo->prepare("
        SELECT p.*, u.username, u.avatar
        FROM posts p
        JOIN users u ON p.user_id = u.id
        WHERE p.group_id = ?
        ORDER BY p.created_at DESC
    ");
    $posts->execute([$id]);
    $posts = $posts->fetchAll(PDO::FETCH_ASSOC);
} elseif ($category_id) {
    
    $groups = $pdo->prepare("SELECT g.*, c.name as category_name FROM groups g JOIN categories c ON g.category_id = c.id WHERE g.category_id = ?");
    $groups->execute([$category_id]);
    $groups = $groups->fetchAll(PDO::FETCH_ASSOC);
    
    $cat = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $cat->execute([$category_id]);
    $category = $cat->fetch(PDO::FETCH_ASSOC);
}


if ($action == 'join' && isLoggedIn() && $id) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO group_members (group_id, user_id) VALUES (?, ?)");
    $stmt->execute([$id, $_SESSION['user_id']]);
    header("Location: group.php?id=$id");
    exit;
}


if ($action == 'leave' && isLoggedIn() && $id) {
    $pdo->prepare("DELETE FROM group_members WHERE group_id = ? AND user_id = ?")->execute([$id, $_SESSION['user_id']]);
    header("Location: group.php?id=$id");
    exit;
}


$is_member = false;
if (isLoggedIn() && $id) {
    $stmt = $pdo->prepare("SELECT id FROM group_members WHERE group_id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    $is_member = $stmt->fetch() ? true : false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? htmlspecialchars($group['name']) : htmlspecialchars($category['name']); ?> - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 20px; }
        h1 { margin-bottom: 10px; color: #333; }
        .group-meta { color: #999; margin-bottom: 20px; }
        .stats { display: flex; gap: 30px; margin-bottom: 20px; color: #666; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px; }
        .btn:hover { background: #0056b3; }
        .btn-join { background: #28a745; }
        .btn-join:hover { background: #218838; }
        .btn-leave { background: #dc3545; }
        .btn-leave:hover { background: #c82333; }
        .group-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .group-item { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 20px; }
        .group-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .group-name a { color: #333; text-decoration: none; }
        .group-name a:hover { color: #007bff; }
        .group-desc { color: #666; font-size: 14px; margin-bottom: 10px; }
        .group-stats { color: #999; font-size: 12px; }
        .member-list { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; }
        .member-item { display: flex; align-items: center; gap: 10px; width: calc(33.33% - 14px); padding: 10px; background: #f5f5f5; border-radius: 4px; }
        .member-avatar { width: 40px; height: 40px; border-radius: 50%; }
        .member-info { flex: 1; }
        .member-name { font-weight: bold; color: #333; }
        .member-title { color: #999; font-size: 12px; }
        .member-admin { color: #28a745; font-size: 12px; }
        .post-list { margin-top: 20px; }
        .post-item { padding: 15px; border-bottom: 1px solid #eee; }
        .post-item:last-child { border-bottom: none; }
        .post-title { font-size: 16px; font-weight: bold; color: #333; text-decoration: none; }
        .post-title:hover { color: #007bff; }
        .post-meta { color: #999; font-size: 12px; margin-top: 5px; }
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
                <a href="category.php">分类</a>
                <?php if (isLoggedIn()): ?>
                    <a href="profile.php"><?php echo $_SESSION['username']; ?></a>
                    <a href="logout.php">退出</a>
                <?php else: ?>
                    <a href="login.php">登录</a>
                    <a href="register.php">注册</a>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($id): ?>
            <!-- 单个小组详情 -->
            <div class="card">
                <h1><?php echo htmlspecialchars($group['name']); ?></h1>
                <div class="group-meta">
                    分类：<a href="category.php?id=<?php echo $group['category_id']; ?>"><?php echo htmlspecialchars($group['category_name']); ?></a> · 
                    创建时间：<?php echo date('Y-m-d', strtotime($group['created_at'])); ?>
                </div>
                <?php if ($group['description']): ?>
                    <p style="color:#666; margin-bottom:20px;"><?php echo htmlspecialchars($group['description']); ?></p>
                <?php endif; ?>
                
                <div class="stats">
                    <span>👥 成员 <?php echo count($members); ?> 人</span>
                    <span>📄 帖子 <?php echo count($posts); ?> 篇</span>
                </div>

                <?php if (isLoggedIn()): ?>
                    <?php if ($is_member): ?>
                        <a href="?action=leave&id=<?php echo $id; ?>" class="btn btn-leave">退出小组</a>
                        <?php if (isGroupAdmin($id)): ?>
                            <a href="group_admin.php?id=<?php echo $id; ?>" class="btn">管理小组</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="?action=join&id=<?php echo $id; ?>" class="btn btn-join">加入小组</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="card">
                <h2>成员列表</h2>
                <div class="member-list">
                    <?php foreach ($members as $member): ?>
                    <div class="member-item">
                        <img src="<?php echo getAvatar($member['id']); ?>" class="member-avatar">
                        <div class="member-info">
                            <div class="member-name">
                                <?php echo htmlspecialchars($member['username']); ?>
                                <?php if ($member['is_admin']): ?>
                                    <span style="color:#28a745; font-size:12px;">(管理员)</span>
                                <?php endif; ?>
                            </div>
                            <?php if ($member['title']): ?>
                                <div class="member-title">称号：<?php echo htmlspecialchars($member['title']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card">
                <h2>小组帖子</h2>
                <div class="post-list">
                    <?php if (empty($posts)): ?>
                        <p style="color:#999;">暂无帖子</p>
                    <?php else: ?>
                        <?php foreach ($posts as $post): ?>
                        <div class="post-item">
                            <a href="post.php?id=<?php echo $post['id']; ?>" class="post-title"><?php echo htmlspecialchars($post['title']); ?></a>
                            <div class="post-meta">
                                作者：<?php echo htmlspecialchars($post['username']); ?> · 
                                时间：<?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        <?php elseif ($category_id): ?>
            <!-- 分类下的小组列表 -->
            <div class="card">
                <h1><?php echo htmlspecialchars($category['name']); ?></h1>
                <?php if ($category['description']): ?>
                    <p style="color:#666; margin-bottom:20px;"><?php echo htmlspecialchars($category['description']); ?></p>
                <?php endif; ?>

                <div class="group-grid">
                    <?php foreach ($groups as $g): ?>
                    <div class="group-item">
                        <div class="group-name">
                            <a href="group.php?id=<?php echo $g['id']; ?>"><?php echo htmlspecialchars($g['name']); ?></a>
                        </div>
                        <?php if ($g['description']): ?>
                            <div class="group-desc"><?php echo htmlspecialchars(mb_substr($g['description'], 0, 50)); ?></div>
                        <?php endif; ?>
                        <div class="group-stats">创建于 <?php echo date('Y-m-d', strtotime($g['created_at'])); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>
</body>
</html>
