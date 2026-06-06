<?php
session_start();
$admin_password = 'jongn123';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['news_admin'] = true;
    } else { $login_error = '密码错误'; }
}
if (!isset($_SESSION['news_admin'])) {
    echo '<form method="POST"><input type="password" name="password"><button type="submit" name="login">登录</button></form>';
    if(isset($login_error)) echo "<p style='color:red'>$login_error</p>";
    exit;
}
$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $stmt = $db->prepare("INSERT INTO news (title, summary, content, category, source, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['summary'], $_POST['content'], $_POST['category'], $_POST['source'], $_POST['image_url']]);
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $db->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    }
    header("Location: news.php"); exit;
}
$news_list = $db->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>新闻管理</title><style>body{font-family:sans-serif;padding:20px}form{margin-bottom:30px}input,textarea,select{width:100%;padding:8px;margin:5px 0}button{padding:8px 16px;background:#c0392b;color:white;border:none}table{width:100%;border-collapse:collapse}th,td{padding:10px;border-bottom:1px solid #ddd}</style></head>
<body>
<h1>新闻管理</h1>
<form method="POST">
    <input type="hidden" name="action" value="add">
    <input type="text" name="title" placeholder="标题" required>
    <input type="text" name="summary" placeholder="摘要">
    <textarea name="content" rows="5" placeholder="正文"></textarea>
    <input type="text" name="category" placeholder="分类 (公益/技术/校园/活动)">
    <input type="text" name="source" placeholder="来源">
    <input type="text" name="image_url" placeholder="图片URL">
    <button type="submit">添加新闻</button>
</form>
<h2>现有新闻</h2>
<table>
    <tr><th>ID</th><th>标题</th><th>分类</th><th>时间</th><th>操作</th></tr>
    <?php foreach ($news_list as $news): ?>
    <tr>
        <td><?php echo $news['id']; ?></td>
        <td><?php echo htmlspecialchars($news['title']); ?></td>
        <td><?php echo $news['category']; ?></td>
        <td><?php echo $news['created_at']; ?></td>
        <td><form method="POST" style="display:inline"><input type="hidden" name="id" value="<?php echo $news['id']; ?>"><input type="hidden" name="action" value="delete"><button type="submit">删除</button></form></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
