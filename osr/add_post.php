<?php
require_once 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

try {
    // 修正：字段名和表结构完全匹配
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, author, category, date, anonymous) VALUES (?,?,?,?, NOW(), ?)");
    $stmt->execute([
        $data['title'],
        $data['content'],
        $data['author'],
        $data['category'],
        $data['anonymous'] ? 1 : 0
    ]);
    
    echo json_encode([
        'success' => true,
        'message' => '帖子发布成功',
        'id' => $pdo->lastInsertId()
    ]);
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => '数据库错误: ' . $e->getMessage()
    ]);
}
?>
