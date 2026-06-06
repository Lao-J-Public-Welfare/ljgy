<?php
session_start();
$admin_password = 'jongn2026';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['subadmin'] = true;
    } else {
        $login_error = '密码错误';
    }
}
if (!isset($_SESSION['subadmin'])) {
    echo '<form method="POST"><input type="password" name="password" placeholder="密码"><button type="submit" name="login">登录</button></form>';
    if(isset($login_error)) echo "<p style='color:red'>$login_error</p>";
    exit;
}

$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'];
    if ($action === 'approve') {
        $stmt = $db->prepare("UPDATE subdomain_requests SET status=1, reviewed_at=NOW() WHERE id=?");
        $stmt->execute([$id]);
    } elseif ($action === 'reject') {
        $stmt = $db->prepare("UPDATE subdomain_requests SET status=2, reviewed_at=NOW() WHERE id=?");
        $stmt->execute([$id]);
    } elseif ($action === 'delete') {
        $stmt = $db->prepare("DELETE FROM subdomain_requests WHERE id=?");
        $stmt->execute([$id]);
    }
    header("Location: index.php");
    exit;
}

$pending = $db->query("SELECT * FROM subdomain_requests WHERE status=0 ORDER BY created_at DESC")->fetchAll();
$approved = $db->query("SELECT * FROM subdomain_requests WHERE status=1 ORDER BY created_at DESC")->fetchAll();
$rejected = $db->query("SELECT * FROM subdomain_requests WHERE status=2 ORDER BY created_at DESC LIMIT 20")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>三级域名管理</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f5f5f5; }
        .card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
        button { background: #2c3e2f; color: white; border: none; padding: 4px 12px; border-radius: 20px; cursor: pointer; margin-right: 5px; }
        .reject { background: #999; }
        .delete { background: #c0392b; }
    </style>
</head>
<body>
    <div class="card"><h1>三级域名管理</h1><a href="?logout=1">退出</a></div>
    <div class="card"><h2>待审核 (<?php echo count($pending); ?>)</h2>
        <?php if(empty($pending)) echo '<p>暂无</p>'; else { ?>
        <table>
            <tr><th>子域名</th><th>类型</th><th>目标</th><th>邮箱</th><th>说明</th><th>操作</th></tr>
            <?php foreach($pending as $p): ?>
            <tr>
                <td><?php echo $p['subdomain']; ?>.qwq.ljgy123.top</td>
                <td><?php echo $p['target_type']; ?></td>
                <td><?php echo $p['target_value']; ?></td>
                <td><?php echo $p['owner_email']; ?></td>
                <td><?php echo $p['description']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                        <button type="submit" name="action" value="approve">通过</button>
                        <button type="submit" name="action" value="reject" class="reject">拒绝</button>
                    </form>
                 </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php } ?>
    </div>
    <div class="card"><h2>已通过</h2><?php foreach($approved as $a): ?><div><?php echo $a['subdomain']; ?>.qwq.ljgy123.top → <?php echo $a['target_value']; ?> <form method="POST" style="display:inline;"><input type="hidden" name="id" value="<?php echo $a['id']; ?>"><button type="submit" name="action" value="delete" class="delete">删除</button></form></div><?php endforeach; ?></div>
</body>
</html>
