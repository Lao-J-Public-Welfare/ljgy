<?php
// 短链接跳转处理
$code = basename($_SERVER['REQUEST_URI']);

if (empty($code) || $code == 'index.php') {
    header('HTTP/1.0 404 Not Found');
    die('短链接不存在');
}

// 这里需要从数据库或文件查找对应的长链接
// 暂时先返回一个提示（因为你的 dlj.php 可能没有真正保存映射）
$long_url = get_long_url($code);

if ($long_url) {
    header("Location: $long_url", true, 301);
    exit;
} else {
    header('HTTP/1.0 404 Not Found');
    die('短链接不存在或已失效');
}

function get_long_url($code) {
    // 简单实现：从文件读取映射
    $map_file = __DIR__ . '/map.json';
    if (file_exists($map_file)) {
        $data = json_decode(file_get_contents($map_file), true);
        return $data[$code] ?? false;
    }
    return false;
}
