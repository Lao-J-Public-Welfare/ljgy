<?php
require_once 'config.php';


$posts = [];
try {
    $stmt = $pdo->prepare("
        SELECT p.*, u.username
        FROM posts p
        JOIN users u ON p.user_id = u.id
        ORDER BY p.created_at DESC
        LIMIT 10
    ");
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("数据库查询失败: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>牢J公益论坛 - 测试版</title>
</head>
<body>
    <h1>牢J公益论坛 (测试版)</h1>
    <p>当前服务器时间: <?php echo date('Y-m-d H:i:s'); ?></p>
    <h2>最新帖子</h2>
    <ul>
    <?php foreach ($posts as $post): ?>
        <li><?php echo htmlspecialchars($post['title']); ?> - <?php echo htmlspecialchars($post['username']); ?></li>
    <?php endforeach; ?>
    </ul>
    <p>如果能看到这个页面，说明基础功能正常。</p>
</body>
</html>
