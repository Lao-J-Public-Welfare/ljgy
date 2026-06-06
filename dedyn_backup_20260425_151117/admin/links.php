<?php
$admin_password = 'jongn123';  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        session_start();
        $_SESSION['links_admin'] = true;
        header('Location: links.php');
        exit;
    } else {
        $login_error = '密码错误';
    }
}

session_start();
if (!isset($_SESSION['links_admin'])) {
    
    ?>
    <!DOCTYPE html>
    <html>
    <head><meta charset="UTF-8"><title>管理登录</title><style>body{background:#f5f5f5;display:flex;align-items:center;justify-content:center;min-height:100vh;}form{background:white;padding:30px;border-radius:16px;}</style></head>
    <body>
        <form method="POST">
            <h2>友链管理登录</h2>
            <?php if(isset($login_error)) echo "<p style='color:red'>$login_error</p>"; ?>
            <input type="password" name="password" placeholder="密码" required>
            <button type="submit" name="login">登录</button>
        </form>
    </body>
    </html>
    <?php
    exit;
}


$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'JONGN123';
$db_name = 'ljgy_links';

$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? 0;
    
    if ($action === 'approve') {
        
        $stmt = $pdo->prepare("SELECT site_name, site_url FROM link_applications WHERE id = ?");
        $stmt->execute([$id]);
        $app = $stmt->fetch();
        if ($app) {
          
           $stmt = $pdo->prepare("INSERT INTO links (site_name, site_url) VALUES (?, ?)");
            $stmt->execute([$app['site_name'], $app['site_url']]);
        
            $stmt = $pdo->prepare("UPDATE link_applications SET status=1, reviewed_at=NOW() WHERE id = ?");
            $stmt->execute([$id]);
        }
    } elseif ($action === 'reject') {
        $stmt = $pdo->prepare("UPDATE link_applications SET status=2, reviewed_at=NOW() WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'delete_link') {
        $stmt = $pdo->prepare("DELETE FROM links WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    header('Location: links.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM link_applications WHERE status=0 ORDER BY created_at DESC");
$pending = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM links ORDER BY sort_order ASC");
$links = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM link_applications WHERE status=2 ORDER BY created_at DESC LIMIT 20");
$rejected = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>友链管理</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { margin-bottom: 20px; color: #c0392b; }
        .card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f8f8; }
        button { background: #2c3e2f; color: white; border: none; padding: 6px 16px; border-radius: 20px; cursor: pointer; margin-right: 8px; }
        button.reject { background: #999; }
        button.danger { background: #c0392b; }
        .logout { float: right; background: #666; }
        a { color: #c0392b; text-decoration: none; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 12px; }
        .badge.pending { background: #ffc107; color: #333; }
        .badge.approved { background: #28a745; color: white; }
        .badge.rejected { background: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>友链管理</h1>
            <a href="?logout=1" class="logout" style="float:right; background:#666; color:white; padding:6px 16px; border-radius:20px; text-decoration:none;">退出登录</a>
            <div style="clear:both"></div>
        </div>
        
        <div class="card">
            <h2>待审核申请 (<?php echo count($pending); ?>)</h2>
            <?php if (empty($pending)): ?>
                <p>暂无待审核</p>
            <?php else: ?>
                <table>
                    <tr><th>网站名称</th><th>网址</th><th>邮箱</th><th>简介</th><th>IP</th><th>时间</th><th>操作</th></tr>
                    <?php foreach ($pending as $app): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($app['site_name']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($app['site_url']); ?>" target="_blank"><?php echo htmlspecialchars($app['site_url']); ?></a></td>
                        <td><?php echo htmlspecialchars($app['email']); ?></td>
                        <td><?php echo htmlspecialchars($app['intro']); ?></td>
                        <td><?php echo htmlspecialchars($app['ip']); ?></td>
                        <td><?php echo $app['created_at']; ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $app['id']; ?>">
                                <button type="submit" name="action" value="approve">通过</button>
                                <button type="submit" name="action" value="reject" class="reject">拒绝</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <h2>已通过友链</h2>
            <table>
                <tr><th>网站名称</th><th>网址</th><th>添加时间</th><th>操作</th></tr>
                <?php foreach ($links as $link): ?>
                <tr>
                    <td><?php echo htmlspecialchars($link['site_name']); ?></td>
                    <td><a href="<?php echo htmlspecialchars($link['site_url']); ?>" target="_blank"><?php echo htmlspecialchars($link['site_url']); ?></a></td>
                    <td><?php echo $link['created_at']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $link['id']; ?>">
                            <button type="submit" name="action" value="delete_link" class="danger">删除</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        
        <div class="card">
            <h2>已拒绝申请</h2>
            <table>
                <tr><th>网站名称</th><th>网址</th><th>邮箱</th><th>时间</th></tr>
                <?php foreach ($rejected as $app): ?>
                <tr>
                    <td><?php echo htmlspecialchars($app['site_name']); ?></td>
                    <td><?php echo htmlspecialchars($app['site_url']); ?></td>
                    <td><?php echo htmlspecialchars($app['email']); ?></td>
                    <td><?php echo $app['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
