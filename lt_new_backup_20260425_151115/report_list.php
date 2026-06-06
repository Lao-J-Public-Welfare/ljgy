<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}

$status = $_GET['status'] ?? 'pending';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;


$stmt = $pdo->prepare("
    SELECT r.*, u.username as reporter_name,
           CASE 
               WHEN r.target_type = 'post' THEN (SELECT title FROM posts WHERE id = r.target_id)
               WHEN r.target_type = 'comment' THEN (SELECT content FROM comments WHERE id = r.target_id)
               ELSE (SELECT username FROM users WHERE id = r.target_id)
           END as target_title
    FROM reports r
    JOIN users u ON r.reporter_id = u.id
    WHERE r.status = ?
    ORDER BY r.created_at DESC
    LIMIT " . (int)$offset . ", " . (int)$per_page . "
");
$stmt->execute([$status]);
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);


$total = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE status = ?");
$total->execute([$status]);
$total_pages = ceil($total->fetchColumn() / $per_page);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>举报管理 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; }
        .logo { font-size: 24px; font-weight: bold; color: #333; border-bottom: 2px solid #007bff; padding-bottom: 5px; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .card { background: white; border-radius: 8px; padding: 30px; }
        h1 { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f5f5f5; }
        .btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-resolve { background: #28a745; color: white; }
        .btn-dismiss { background: #6c757d; color: white; }
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #999; border-top: 1px solid #ddd; }
        .target-link { color: #007bff; text-decoration: none; }
        .target-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">牢J公益</div>
            <div class="nav">
                <a href="index.php">首页</a>
                <a href="admin.php">管理</a>
                <a href="logout.php">退出</a>
            </div>
        </div>

        <div class="card">
            <h1>举报管理</h1>
            
            <div style="margin-bottom: 20px;">
                <a href="?status=pending" style="margin-right: 10px;">待处理</a>
                <a href="?status=resolved" style="margin-right: 10px;">已处理</a>
                <a href="?status=dismissed">已驳回</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>举报人</th>
                        <th>被举报内容</th>
                        <th>类型</th>
                        <th>原因</th>
                        <th>时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $r): ?>
                    <tr>
                        <td><?php echo $r['id']; ?></td>
                        <td><?php echo htmlspecialchars($r['reporter_name']); ?></td>
                        <td>
                            <a href="<?php echo $r['target_type'] == 'post' ? 'post.php?id=' . $r['target_id'] : ($r['target_type'] == 'comment' ? 'post.php?id=' . $r['target_id'] : 'profile.php?id=' . $r['target_id']); ?>" target="_blank" class="target-link">
                                <?php echo htmlspecialchars(mb_substr($r['target_title'] ?? '已删除', 0, 50)); ?>
                            </a>
                        </td>
                        <td><?php echo $r['target_type']; ?></td>
                        <td><?php echo htmlspecialchars($r['reason']); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($r['created_at'])); ?></td>
                        <td>
                            <?php if ($r['status'] == 'pending'): ?>
                                <button class="btn btn-resolve" onclick="handleReport(<?php echo $r['id']; ?>, 'resolved')">通过</button>
                                <button class="btn btn-dismiss" onclick="handleReport(<?php echo $r['id']; ?>, 'dismissed')">驳回</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="footer">© 2026 牢J公益</div>
    </div>

    <script>
    function handleReport(id, status) {
        if (!confirm('确定要' + (status == 'resolved' ? '通过' : '驳回') + '该举报吗？')) return;
        
        fetch('report_handle.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id + '&status=' + status
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('操作失败：' + data.message);
            }
        });
    }
    </script>
</body>
</html>
