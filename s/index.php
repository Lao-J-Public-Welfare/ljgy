<?php
$code = $_GET['code'] ?? '';

if (!$code) {
    http_response_code(404);
    die('短链不存在');
}

$mapFile = dirname(__DIR__) . '/short/map.json';
if (!file_exists($mapFile)) {
    http_response_code(404);
    die('短链失效');
}

$map = json_decode(file_get_contents($mapFile), true);
if (!isset($map[$code])) {
    http_response_code(404);
    die('短链不存在');
}

$id = $map[$code]['id'];
$type = $map[$code]['type'];

header("Location: /share.php?id={$id}&type={$type}");
exit;
?>
