<?php
$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");


$db->exec("CREATE TABLE IF NOT EXISTS votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    options TEXT NOT NULL,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$db->exec("CREATE TABLE IF NOT EXISTS vote_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vote_id INT NOT NULL,
    option_index INT NOT NULL,
    ip VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$message = '';
$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $title = trim($_POST['title']);
    $options = array_filter(array_map('trim', explode("\n", $_POST['options'])));
    if (empty($title) || count($options) < 2) {
        $error = '请填写标题和至少2个选项';
    } else {
        $stmt = $db->prepare("INSERT INTO votes (title, options) VALUES (?, ?)");
        $stmt->execute([$title, json_encode($options)]);
        $vote_id = $db->lastInsertId();
        header("Location: ?id=$vote_id");
        exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote_id'])) {
    $vote_id = intval($_POST['vote_id']);
    $option = intval($_POST['option']);
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $stmt = $db->prepare("SELECT COUNT(*) FROM vote_records WHERE vote_id = ? AND ip = ?");
    $stmt->execute([$vote_id, $ip]);
    if ($stmt->fetchColumn() > 0) {
        $error = '您已经投过票了';
    } else {
        $stmt = $db->prepare("INSERT INTO vote_records (vote_id, option_index, ip) VALUES (?, ?, ?)");
        $stmt->execute([$vote_id, $option, $ip]);
        $message = '投票成功！';
    }
}


$votes_list = $db->query("SELECT id, title, created_at FROM votes WHERE status = 1 ORDER BY id DESC")->fetchAll();


$current_vote = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $db->prepare("SELECT * FROM votes WHERE id = ?");
    $stmt->execute([$id]);
    $current_vote = $stmt->fetch();
    if ($current_vote) {
        $options = json_decode($current_vote['options'], true);
        $stmt = $db->prepare("SELECT option_index, COUNT(*) as count FROM vote_records WHERE vote_id = ? GROUP BY option_index");
        $stmt->execute([$id]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[$row['option_index']] = $row['count'];
        }
        $total = array_sum($results);
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投票系统 · 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f0f2f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: white; border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #e0e0e0; }
        h1 { color: #3498db; margin-bottom: 8px; font-size: 1.8rem; }
        .sub { color: #666; margin-bottom: 20px; font-size: 0.85rem; border-left: 3px solid #3498db; padding-left: 12px; }
        .vote-item { padding: 12px; border-bottom: 1px solid #eee; cursor: pointer; }
        .vote-item:hover { background: #f8f9fa; }
        .btn { background: #3498db; color: white; border: none; padding: 8px 20px; border-radius: 6px; cursor: pointer; }
        .btn:hover { background: #2980b9; }
        .btn-green { background: #2c3e2f; }
        .btn-green:hover { background: #1e2a21; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 10px; }
        .option-bar { background: #3498db; height: 30px; border-radius: 6px; margin: 5px 0; }
        .back { display: inline-block; margin-top: 15px; color: #3498db; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>投票系统</h1>
        <div class="sub">创建投票 · 参与投票 · 查看结果</div>

        <?php if ($current_vote): ?>
            <h2><?php echo htmlspecialchars($current_vote['title']); ?></h2>
            <?php if ($message): ?>
                <p style="color: #2c5a2e; margin: 10px 0;"><?php echo $message; ?></p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p style="color: #c0392b; margin: 10px 0;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="vote_id" value="<?php echo $current_vote['id']; ?>">
                <?php foreach ($options as $i => $opt): ?>
                    <div style="margin: 10px 0;">
                        <label>
                            <input type="radio" name="option" value="<?php echo $i; ?>" required>
                            <?php echo htmlspecialchars($opt); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn">提交投票</button>
            </form>
            <hr style="margin: 20px 0;">
            <h3>投票结果</h3>
            <?php foreach ($options as $i => $opt): ?>
                <div><?php echo htmlspecialchars($opt); ?></div>
                <div class="option-bar" style="width: <?php echo $total > 0 ? ($results[$i] ?? 0) / $total * 100 : 0; ?>%"></div>
                <div><?php echo $results[$i] ?? 0; ?> 票</div>
            <?php endforeach; ?>
            <a href="?list=1" class="back">← 返回投票列表</a>
        <?php elseif (isset($_GET['list']) || !isset($_GET['create'])): ?>
            <h2>投票列表</h2>
            <?php foreach ($votes_list as $vote): ?>
                <div class="vote-item" onclick="location.href='?id=<?php echo $vote['id']; ?>'">
                    <strong><?php echo htmlspecialchars($vote['title']); ?></strong>
                    <div style="font-size:0.8rem; color:#999;"><?php echo $vote['created_at']; ?></div>
                </div>
            <?php endforeach; ?>
            <div style="margin-top: 20px;">
                <button class="btn btn-green" onclick="location.href='?create=1'">创建新投票</button>
                <a href="index.html" class="back" style="margin-left: 15px;">← 返回官网</a>
            </div>
        <?php else: ?>
            <h2>创建新投票</h2>
            <form method="POST">
                <input type="text" name="title" placeholder="投票标题" required>
                <textarea name="options" rows="5" placeholder="选项（每行一个）" required></textarea>
                <button type="submit" name="create" class="btn">创建投票</button>
            </form>
            <a href="?list=1" class="back">← 返回投票列表</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
