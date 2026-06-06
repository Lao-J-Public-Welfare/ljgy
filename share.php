<?php
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$type = $_GET['type'] ?? 'post';

if (!$id || !in_array($type, ['post', 'comment'])) {
    die('参数错误');
}

if ($type == 'post') {
    $stmt = $pdo->prepare("SELECT title FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $item ? $item['title'] : '分享';
    $url = "http:
} else {
    $stmt = $pdo->prepare("SELECT c.content, p.title FROM comments c JOIN posts p ON c.post_id = p.id WHERE c.id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $item ? $item['title'] : '分享';
    $url = "http:
}

$site_name = '牢J公益';
$description = mb_substr(strip_tags($item['content'] ?? $title), 0, 100);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>分享 - 牢J公益</title>
    <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="og:url" content="<?php echo $url; ?>">
    <meta property="og:site_name" content="<?php echo $site_name; ?>">
    <meta name="twitter:card" content="summary">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { max-width: 500px; padding: 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; text-align: center; }
        h1 { margin-bottom: 20px; color: #333; }
        p { margin-bottom: 30px; color: #666; }
        .btn { display: inline-block; padding: 12px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin: 0 5px; }
        .btn:hover { background: #0056b3; }
        .btn-copy { background: #28a745; }
        .btn-copy:hover { background: #218838; }
        .url-box { background: #f5f5f5; padding: 10px; border-radius: 4px; margin: 20px 0; word-break: break-all; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>分享</h1>
            <p><?php echo htmlspecialchars($title); ?></p>
            <div class="url-box" id="shareUrl"><?php echo $url; ?></div>
            <div>
                <button class="btn btn-copy" onclick="copyUrl()">复制链接</button>
                <a href="<?php echo $url; ?>" class="btn">查看原文</a>
            </div>
        </div>
    </div>
    <script>
        function copyUrl() {
            const url = document.getElementById('shareUrl').innerText;
            navigator.clipboard.writeText(url).then(() => {
                alert('链接已复制');
            });
        }
    </script>
</body>
</html>
