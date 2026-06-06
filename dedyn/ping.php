<?php

$result = '';
$host = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['host'])) {
    $host = trim($_POST['host']);
    $host = escapeshellarg($host);
$output = shell_exec("/usr/bin/ping -c 4 $host 2>&1");
if ($output) {
        $result = $output;
    } else {
        $result = "Ping 失败，请检查域名或IP";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>牢J公益 · 在线Ping</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #ffffff; font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { max-width: 600px; width: 100%; padding: 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; }
        h1 { text-align: center; margin-bottom: 30px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input[type=text] { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: #dc3545; margin-bottom: 15px; padding: 10px; background: #f8d7da; border-radius: 4px; }
        .result { margin-top: 20px; padding: 15px; background: #f5f5f5; border-radius: 4px; font-family: monospace; white-space: pre-wrap; word-wrap: break-word; }
        .back { text-align: center; margin-top: 20px; }
        .back a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>牢J公益 · 在线Ping</h1>
            
            <form method="post">
                <div class="form-group">
                    <label>输入域名或IP</label>
                    <input type="text" name="host" placeholder="例如：ljgy123.top 或 8.8.8.8" value="<?php echo htmlspecialchars($host); ?>" required>
                </div>
                <button type="submit">Ping</button>
            </form>
            
            <?php if ($result): ?>
                <div class="result"><?php echo htmlspecialchars($result); ?></div>
            <?php endif; ?>
            
            <div class="back">
                <a href="dlj.php">去短链接</a>
            </div>
        </div>
    </div>
</body>
</html>
