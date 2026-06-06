<?php
check_auth();
$baseDir = '/opt/data/user_pages/';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pages = [];
    if (is_dir($baseDir)) {
        foreach (glob($baseDir . '*', GLOB_ONLYDIR) as $folderPath) {
            $folder = basename($folderPath);
            foreach (glob($folderPath . '/*.{html,htm}', GLOB_BRACE) as $filePath) {
                $pages[] = ['folder' => $folder, 'file' => basename($filePath), 'url' => "https://e.ljgy123.top/{$folder}/" . basename($filePath)];
            }
        }
    }
    json_response(200, '获取页面列表成功', ['pages' => $pages]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $folder = trim($input['folder'] ?? '');
    $filename = trim($input['filename'] ?? '');
    $code = $input['code'] ?? '';
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $folder)) json_response(400, '文件夹名不合法');
    if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $filename)) json_response(400, '文件名不合法');
    if (preg_match('/.php$/i', $filename)) json_response(400, '禁止创建PHP文件');
    if (!is_dir($baseDir)) mkdir($baseDir, 0755, true);
    $targetDir = $baseDir . $folder;
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
    $code = preg_replace('/<?php/i', '&lt;?php', $code);
    if (file_put_contents($targetDir . '/' . $filename, $code)) {
        json_response(200, '创建成功', ['url' => "https://e.ljgy123.top/{$folder}/{$filename}"]);
    } else {
        json_response(500, '写入失败');
    }
} else {
    json_response(405, '方法不允许');
}
