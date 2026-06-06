<?php
$log_file = '/var/log/nginx/access.log';
$today = date('d/M/Y');
$today_access = 0;

if (file_exists($log_file)) {
    $lines = file($log_file);
    foreach ($lines as $line) {
        if (strpos($line, $today) !== false) {
            if (strpos($line, '127.0.0.1') === false && strpos($line, '/api/') === false && strpos($line, 'traffic.php') === false) {
                $today_access++;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>牢J公益 · 网络监控墙</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: white; font-family: 'Segoe UI', system-ui, sans-serif; overflow: hidden; height: 100vh; }
        .header { position: fixed; top: 0; left: 0; right: 0; height: 60px; background: white; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; padding: 0 24px; z-index: 100; }
        .logo { font-size: 20px; font-weight: 600; color: #c0392b; }
        .header-options { display: flex; gap: 24px; }
        .option { display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; color: #2c3e2f; padding: 6px 12px; border-radius: 30px; transition: 0.2s; }
        .option:hover { background: #f1f5f9; }
        .option.active { background: #ecfdf5; color: #2c5a2e; }
        .option .indicator { width: 12px; height: 12px; border-radius: 12px; background: #cbd5e1; }
        .option.active .indicator { background: #2c5a2e; }
        canvas { position: fixed; top: 60px; left: 0; width: 100%; height: calc(100vh - 60px); background: white; display: block; }
        .stats-panel { position: fixed; bottom: 20px; left: 20px; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); border-radius: 12px; padding: 12px 20px; border: 1px solid #e2e8f0; font-size: 12px; font-family: monospace; color: #2c3e2f; pointer-events: none; z-index: 50; }
        .stats-panel span { color: #c0392b; font-weight: 600; }
    </style>
</head>
<body>
<div class="header">
    <div class="logo">牢J公益</div>
    <div class="header-options">
        <div class="option" id="firewallToggle"><span class="indicator"></span><span>防火墙</span></div>
        <div class="option" id="ddosToggle"><span class="indicator"></span><span>DDOS模拟</span></div>
    </div>
</div>
<canvas id="networkCanvas"></canvas>
<div class="stats-panel">今日访问次数: <span id="accessCount"><?php echo $today_access; ?></span></div>
<script src="/js/network.js"></script>
</body>
</html>
