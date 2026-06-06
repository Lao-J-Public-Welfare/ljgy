<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$group_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$stmt = $pdo->prepare("SELECT * FROM groups WHERE id = ?");
$stmt->execute([$group_id]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$group) {
    die('小组不存在');
}


if (!isGroupAdmin($group_id) && !isAdmin()) {
    redirect('group.php?id=' . $group_id);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $user = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $user->execute([$username]);
    $user = $user->fetch();
    
    if ($user) {
        
        $pdo->prepare("INSERT IGNORE INTO group_members (group_id, user_id) VALUES (?, ?)")->execute([$group_id, $user['id']]);
        
        $pdo->prepare("INSERT IGNORE INTO group_admins (group_id, user_id) VALUES (?, ?)")->execute([$group_id, $user['id']]);
        $success = "管理员添加成功";
    } else {
        $error = "用户不存在";
    }
}


if (isset($_GET['remove_admin']) && isAdmin()) {
    $user_id = (int)$_GET['remove_admin'];
    $pdo->prepare("DELETE FROM group_admins WHERE group_id = ? AND user_id = ?")->execute([$group_id, $user_id]);
    redirect("group_admin.php?id=$group_id");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['set_title'])) {
    $user_id = (int)$_POST['user_id'];
    $title = trim($_POST['title']);
    
    $pdo->prepare("INSERT INTO group_titles (group_id, user_id, title) VALUES (?, ?, ?) 
                    ON DUPLICATE KEY UPDATE title = ?")
        ->execute([$group_id, $user_id, $title, $title]);
    $success = "称号已设置";
}


if (isset($_GET['remove_member'])) {
    $user_id = (int)$_GET['remove_member'];
    if (isAdmin() || ($user_id != $_SESSION['user_id'])) {
        $pdo->prepare("DELETE FROM group_members WHERE group_id = ? AND user_id = ?")->execute([$group_id, $user_id]);
        $pdo->prepare("DELETE FROM group_admins WHERE group_id = ? AND user_id = ?")->execute([$group_id, $user_id]);
        $pdo->prepare("DELETE FROM group_titles WHERE group_id = ? AND user_id = ?")->execute([$group_id, $user_id]);
        redirect("group_admin.php?id=$group_id");
    }
}


$members = $pdo->prepare("
    SELECT u.*,
           (SELECT id FROM group_admins WHERE group_id = ? AND user_id = u.id) as is_admin,
           (SELECT title FROM group_titles WHERE group_id = ? AND user_id = u.id) as title
    FROM users u
    JOIN group_members gm ON u.id = gm.user_id
    WHERE gm.group_id = ?
    ORDER BY is_admin DESC, u.username ASC
");
$members->execute([$group_id, $group_id, $group_id]);
$members = $members->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理小组 - <?php echo htmlspecialchars($group['name']); ?></title>
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
        h2 { margin-bottom: 20px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .btn-small { padding: 5px 10px; font-size: 12px; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .error { color: #dc3545; margin-bottom: 15px; }
        .success { color: #28a745; margin-bottom: 15px; }
        .member-list { margin-top: 20px; }
        .member-item { display: flex; align-items: center; gap: 20px; padding: 15px; border-bottom: 1px solid #eee; }
        .member-item:last-child { border-bottom: none; }
        .member-avatar { width: 50px; height: 50px; border-radius: 50%; }
        .member-info { flex: 1; }
        .member-name { font-size: 16px; font-weight: bold; color: #333; }
        .member-title { color: #999; font-size: 12px; margin-top: 5px; }
        .member-actions { display: flex; gap: 10px; }
        .title-form { display: flex; gap: 10px; margin-top: 5px; }
        .title-form input { width: 200px; padding: 5px; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
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

        <a href="group.php?id=<?php echo $group_id; ?>" class="back-link">← 返回小组</a>

        <div class="card">
            <h1>管理小组 · <?php echo htmlspecialchars($group['name']); ?></h1>
            
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <h2>添加管理员</h2>
            <form method="post">
                <div class="form-group">
                    <input type="text" name="username" placeholder="输入用户名" required>
                </div>
                <button type="submit" class="btn">添加为管理员</button>
            </form>
        </div>

        <div class="card">
            <h2>成员管理 (<?php echo count($members); ?>)</h2>
            
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
                        
                        <form class="title-form" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $member['id']; ?>">
                            <input type="text" name="title" placeholder="称号" value="<?php echo htmlspecialchars($member['title'] ?? ''); ?>">
                            <button type="submit" name="set_title" class="btn btn-small">设置</button>
                        </form>
                    </div>
                    <div class="member-actions">
                        <?php if (isAdmin() && $member['id'] != $_SESSION['user_id'] && !$member['is_admin']): ?>
                            <a href="?id=<?php echo $group_id; ?>&remove_member=<?php echo $member['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('确定移除该成员？')">移除</a>
                        <?php endif; ?>
                        <?php if (isAdmin() && $member['is_admin'] && $member['id'] != $_SESSION['user_id']): ?>
                            <a href="?id=<?php echo $group_id; ?>&remove_admin=<?php echo $member['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('确定移除该管理员？')">移除管理员</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>
</body>
</html>
