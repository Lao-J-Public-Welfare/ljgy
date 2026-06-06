<?php
require_once 'config.php';

session_start();

$action = $_GET['action'] ?? 'home';

if ($action == 'throw' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = trim($_POST['content'] ?? '');
    if (mb_strlen($content) < 5) {
        $_SESSION['error'] = '内容太短，至少5个字';
        header('Location: bottle.php');
        exit;
    }
    if (mb_strlen($content) > 200) {
        $_SESSION['error'] = '内容太长，最多200字';
        header('Location: bottle.php');
        exit;
    }
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bottles WHERE ip = ? AND DATE(created_at) = CURDATE()");
    $stmt->execute([$ip]);
    if ($stmt->fetchColumn() >= 3) {
        $_SESSION['error'] = '今天已经扔了3个瓶子，明天再来';
        header('Location: bottle.php');
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO bottles (content, ip) VALUES (?, ?)");
    $stmt->execute([$content, $ip]);
    $_SESSION['success'] = '瓶子已扔出';
    header('Location: bottle.php');
    exit;
}

if ($action == 'pick') {
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt = $pdo->prepare("SELECT id, content, created_at FROM bottles WHERE ip != ? AND reply_to IS NULL ORDER BY RAND() LIMIT 1");
    $stmt->execute([$ip]);
    $bottle = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($bottle) {
        $_SESSION['pick_result'] = $bottle;
    } else {
        $_SESSION['error'] = '海里没有瓶子，先扔一个吧';
    }
    header('Location: bottle.php');
    exit;
}

$my_bottles = [];
$ip = $_SERVER['REMOTE_ADDR'];
$stmt = $pdo->prepare("SELECT id, content, created_at FROM bottles WHERE ip = ? ORDER BY created_at DESC LIMIT 10");
$stmt->execute([$ip]);
$my_bottles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>漂流瓶</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 30px; }
        .card h2 { font-size: 20px; margin-bottom: 20px; color: #333; }
        textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; resize: vertical; font-family: inherit; }
        .btn { display: inline-block; background: #007bff; color: white; padding: 10px 24px; border-radius: 4px; text-decoration: none; border: none; cursor: pointer; font-size: 14px; margin-top: 12px; }
        .btn:hover { background: #0056b3; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .bottle { background: #fafafa; border-radius: 8px; padding: 15px; margin-bottom: 12px; border-left: 4px solid #007bff; }
        .bottle-content { font-size: 14px; color: #333; margin-bottom: 8px; line-height: 1.5; word-break: break-all; }
        .bottle-time { font-size: 12px; color: #999; }
        .pick-result { border-left-color: #28a745; }
        .info { text-align: center; color: #999; font-size: 12px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #999; border-top: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">漂流瓶</div>
            <div class="nav">
                <a href="bottle.php">首页</a>
                <a href="bottle.php?action=pick">捞一个</a>
                <a href="index.php">论坛</a>
            </div>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['pick_result'])): ?>
            <?php $pick = $_SESSION['pick_result']; unset($_SESSION['pick_result']); ?>
            <div class="card">
                <h2>捞到一个瓶子</h2>
                <div class="post-card" style="border-left: 4px solid #28a745;">
                    <div class="post-title" style="margin-bottom: 10px;"><?php echo htmlspecialchars($pick['content']); ?></div>
                    <div class="post-time" style="margin-left: 0;"><?php echo date('Y-m-d H:i', strtotime($pick['created_at'])); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <h2>扔一个瓶子</h2>
            <form method="post" action="?action=throw">
                <textarea name="content" rows="4" placeholder="写下你想说的话... (5-200字)"></textarea>
                <button type="submit" class="btn">扔出</button>
            </form>
            <p style="color: #999; font-size: 12px; margin-top: 12px;">每人每天最多扔3个</p>
        </div>

      
        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>
</body>
</html>
