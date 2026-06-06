<?php
$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");
$stmt = $db->query("SELECT * FROM news WHERE is_published = 1 ORDER BY created_at DESC LIMIT 20");
$news_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>牢J公益 · 新闻</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f7fa; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .header { background: white; border-bottom: 1px solid #e9ecef; position: sticky; top: 0; z-index: 100; }
        .header-content { max-width: 1200px; margin: 0 auto; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; }
        .logo h1 { font-size: 1.5rem; font-weight: 600; color: #c0392b; }
        .logo p { font-size: 0.7rem; color: #7c8b9c; }
        .nav a { margin-left: 24px; text-decoration: none; color: #2c3e2f; }
        .nav a:hover { color: #c0392b; }
        .container { max-width: 1200px; margin: 0 auto; padding: 32px 24px; }
        .news-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; }
        .news-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: 0.2s; cursor: pointer; }
        .news-card:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(0,0,0,0.08); }
        .card-image { background: #e9ecef; height: 160px; display: flex; align-items: center; justify-content: center; color: #9aaebf; }
        .card-content { padding: 20px; }
        .card-category { font-size: 0.65rem; color: #c0392b; text-transform: uppercase; margin-bottom: 8px; }
        .card-title { font-weight: 600; margin-bottom: 8px; line-height: 1.4; }
        .card-summary { font-size: 0.8rem; color: #5a6874; line-height: 1.5; margin-bottom: 12px; }
        .card-date { font-size: 0.7rem; color: #9aaebf; }
        .footer { text-align: center; padding: 32px; color: #9aaebf; font-size: 0.7rem; border-top: 1px solid #e9ecef; margin-top: 32px; }
        a { text-decoration: none; color: inherit; }
    </style>
</head>
<body>
<div class="header">
    <div class="header-content">
        <div class="logo"><h1>牢J公益</h1><p>公益新闻</p></div>
        <div class="nav">
            <a href="/">首页</a>
            <a href="/admin/news.php">管理</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="news-grid">
        <?php if (empty($news_list)): ?>
            <p>暂无新闻，请先添加</p>
        <?php else: ?>
            <?php foreach ($news_list as $news): ?>
            <a href="detail.php?id=<?php echo $news['id']; ?>">
                <div class="news-card">
                    <div class="card-image"><?php echo $news['image_url'] ? '<img src="'.$news['image_url'].'" style="width:100%;height:100%;object-fit:cover">' : '📰'; ?></div>
                    <div class="card-content">
                        <div class="card-category"><?php echo htmlspecialchars($news['category']); ?></div>
                        <div class="card-title"><?php echo htmlspecialchars($news['title']); ?></div>
                        <div class="card-summary"><?php echo htmlspecialchars(mb_substr($news['summary'], 0, 80)); ?>...</div>
                        <div class="card-date"><?php echo date('Y-m-d', strtotime($news['created_at'])); ?></div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div class="footer">牢J公益</div>
</body>
</html>
