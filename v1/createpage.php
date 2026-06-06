<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$key = $_GET['key'] ?? '';
if ($key !== 'laojing2026') {
    echo json_encode(['success' => false, 'message' => 'API key 无效']);
    exit;
}

$baseDir = '/opt/data/user_pages/';
$maxFolders = 10;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // 获取页面列表
    $pages = [];
    foreach (glob($baseDir . '*', GLOB_ONLYDIR) as $folderPath) {
        $folder = basename($folderPath);
        foreach (glob($folderPath . '/*.{html,htm}', GLOB_BRACE) as $filePath) {
            $filename = basename($filePath);
            if ($filename === 'index.html' || $filename === 'index.htm') {
                $url = "https://e.ljgy123.top/{$folder}/";
            } else {
                $url = "https://e.ljgy123.top/{$folder}/{$filename}";
            }
            $pages[] = ['folder' => $folder, 'file' => $filename, 'url' => $url];
        }
    }
    echo json_encode(['success' => true, 'pages' => $pages]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $folder = trim($input['folder'] ?? '');
    $filename = trim($input['filename'] ?? '');
    $code = $input['code'] ?? '';
    
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $folder)) {
        echo json_encode(['success' => false, 'message' => '文件夹名只能包含字母、数字、下划线、短横线']);
        exit;
    }
    
    if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $filename)) {
        echo json_encode(['success' => false, 'message' => '文件名只能包含字母、数字、下划线、短横线、点']);
        exit;
    }
    
    if (preg_match('/\.php$/i', $filename)) {
        echo json_encode(['success' => false, 'message' => '禁止创建 PHP 文件']);
        exit;
    }
    
    $existingFolders = glob($baseDir . '*', GLOB_ONLYDIR);
    if (count($existingFolders) >= $maxFolders && !is_dir($baseDir . $folder)) {
        echo json_encode(['success' => false, 'message' => "最多只能创建 {$maxFolders} 个文件夹"]);
        exit;
    }
    
    $targetDir = $baseDir . $folder;
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    
    $filePath = $targetDir . '/' . $filename;
    $code = preg_replace('/<\?php/i', '&lt;?php', $code);
    $code = preg_replace('/<\?=/i', '&lt;?=', $code);
    
    if (file_put_contents($filePath, $code)) {
        echo json_encode(['success' => true, 'message' => '创建成功']);
    } else {
        echo json_encode(['success' => false, 'message' => '写入失败，请检查目录权限']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => '不支持的请求方法']);
