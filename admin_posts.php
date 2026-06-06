<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;


if (isset($_GET['delete'])) {
    $post_id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM posts WHERE id = ?")->execute([$post_id]);
    header("Location: admin_posts.php");
    exit;
}


$posts = $pdo->query("
    SELECT p.*, u.username, 
           (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comment_count
    FROM posts p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.id DESC
    LIMIT $per_page OFFSET $offset
")->fetchAll(PDO::FETCH_ASSOC);

$total = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$total_pages = ceil($total / $per_page);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>帖子管理 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        h1 { margin-bottom: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f5f5f5; }
        .post-title { color: #333; text-decoration: none; }
        .post-title:hover { color: #007bff; }
        .btn { padding: 5px 10px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; }
        .btn:hover { background: #c82333; }
        .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 30px; }
        .pagination a { padding: 5px 10px; background: #f5f5f5; border-radius: 4px; text-decoration: none; color: #333; }
        .pagination a.active { background: #007bff; color: white; }
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
                <a href="admin.php">管理</a>
                <a href="logout.php">退出</a>
            </div>
        </div>

        <div class="card">
            <h1>帖子管理</h1>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>作者</th>
                        <th>评论数</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo $post['id']; ?></td>
                        <td><a href="post.php?id=<?php echo $post['id']; ?>" class="post-title" target="_blank"><?php echo htmlspecialchars($post['title']); ?></a></td>
                        <td><?php echo htmlspecialchars($post['username']); ?></td>
                        <td><?php echo $post['comment_count']; ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></td>
                        <td>
                            <a href="?delete=<?php echo $post['id']; ?>" class="btn" onclick="return confirm('确定删除该帖子？所有评论也会被删除！')">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>
</body>
</html>
