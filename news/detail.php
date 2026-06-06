<?php
$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");
$id = intval($_GET['id'] ?? 0);
$stmt = $db->prepare("SELECT * FROM news WHERE id = ? AND is_published = 1");
$stmt->execute([$id]);
$news = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$news) { header('HTTP/1.0 404 Not Found'); echo '<h1>新闻不存在</h1>'; exit; }
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title><?php echo htmlspecialchars($news['title']); ?> - 牢J公益</title><style>body{background:#f5f7fa;font-family:sans-serif;padding:20px}.container{max-width:800px;margin:0 auto;background:white;border-radius:16px;padding:32px;box-shadow:0 1px 3px rgba(0,0,0,0.05)}h1{color:#c0392b;margin-bottom:16px}.meta{color:#9aaebf;font-size:0.8rem;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid #e9ecef}.content{line-height:1.8;color:#2c3e2f}.back{margin-top:32px;display:inline-block;color:#c0392b}</style></head>
<body>
<div class="container">
    <h1><?php echo htmlspecialchars($news['title']); ?></h1>
    <div class="meta"><?php echo $news['category']; ?> · <?php echo date('Y-m-d', strtotime($news['created_at'])); ?> · 来源: <?php echo htmlspecialchars($news['source']); ?></div>
<?php if($news["image_url"]): ?><img src="<?php echo $news["image_url"]; ?>" style="width:100%;max-height:300px;object-fit:cover;border-radius:12px;margin-bottom:20px"><?php endif; ?>
    <div class="content"><?php echo nl2br(htmlspecialchars($news['content'])); ?></div>
    <a href="index.php" class="back">← 返回首页</a>
</div>
</body>
</html>
