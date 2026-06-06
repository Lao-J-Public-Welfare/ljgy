<?php
$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");
$stmt = $db->query("SELECT id, ip, user_agent, screen_resolution, timezone, created_at FROM malicious_visitors ORDER BY id DESC LIMIT 20");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>反制数据</title></head>
<body>
<table border="1" cellpadding="8">
<tr><th>ID</th><th>IP</th><th>UserAgent</th><th>分辨率</th><th>时区</th><th>时间</th></tr>
<?php foreach ($rows as $row): ?>
<tr>
<td><?= htmlspecialchars($row['id']) ?></td>
<td><?= htmlspecialchars($row['ip']) ?></td>
<td><?= htmlspecialchars($row['user_agent']) ?></td>
<td><?= htmlspecialchars($row['screen_resolution']) ?></td>
<td><?= htmlspecialchars($row['timezone']) ?></td>
<td><?= htmlspecialchars($row['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
