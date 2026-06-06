<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/lib/response.php';
require_once __DIR__ . '/lib/auth.php';
$path = str_replace('/api', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$segments = explode('/', trim($path, '/'));
$version = $segments[0] ?? 'v1';
$resource = $segments[1] ?? '';
if ($version !== 'v1') json_response(404, '不支持的API版本');
$handlerMap = [
    'undercover' => __DIR__ . '/handlers/undercover.php',
    'tts' => __DIR__ . '/handlers/tts.php',
    'tts_fast' => __DIR__ . '/handlers/tts_fast.php',
    'ip' => __DIR__ . '/handlers/ip.php',
    'time' => __DIR__ . '/handlers/time.php',
    'qrlocal' => __DIR__ . '/handlers/qrlocal.php',
    'createpage' => __DIR__ . '/handlers/createpage.php',
    'posts' => __DIR__ . '/handlers/posts.php',
    'users' => __DIR__ . '/handlers/users.php',
];
if (isset($handlerMap[$resource]) && file_exists($handlerMap[$resource])) {
    require_once $handlerMap[$resource];
} else {
    json_response(404, '接口不存在');
}
