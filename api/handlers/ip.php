<?php
function getClientIP() {
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) return $_SERVER['HTTP_CF_CONNECTING_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
    if (!empty($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}
$client_ip = getClientIP();
if (isset($_GET['simple']) && $_GET['simple'] === 'true') { echo $client_ip; exit; }
json_response(200, '获取IP成功', ['your_ip' => $client_ip, 'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown']);
