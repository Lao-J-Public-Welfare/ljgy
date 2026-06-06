<?php
$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");
$stmt = $db->query("SELECT id, ip, user_agent, screen_resolution, timezone, created_at FROM malicious_visitors ORDER BY id DESC LIMIT 50");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>反制数据 · 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: monospace; padding: 20px; }
        h1 { color: #c0392b; margin-bottom: 20px; }
        table { background: white; border-collapse: collapse; width: 100%; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; font-size: 12px; }
        th { background: #2c3e2f; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .footer { margin-top: 20px; text-align: center; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <h1>牢J公益 · 反制数据记录</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>IP</th>
            <th>UserAgent</th>
            <th>分辨率</th>
            <th>时区</th>
            <th>时间</th>
        </tr>
        <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['ip']) ?></td>
            <td style="max-width: 300px; word-break: break-all;"><?= htmlspecialchars($row['user_agent']) ?></td>
            <td><?= htmlspecialchars($row['screen_resolution']) ?></td>
            <td><?= htmlspecialchars($row['timezone']) ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="footer">牢J公益 · 仅内部查看</div>
</body>
</html>
