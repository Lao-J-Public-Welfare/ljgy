<?php
// 数据库配置
$host = 'localhost';
$dbname = 'forum';
$username = 'root';
$password = 'JONGN123';  // 你设置的密码

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => '数据库连接失败: ' . $e->getMessage()]));
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($method === 'GET' && $action === 'list') {
    // 获取帖子列表
    $stmt = $pdo->query("SELECT * FROM posts ORDER BY date DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($posts);
    
} elseif ($method === 'POST' && $action === 'create') {
    // 创建新帖子
    $data = json_decode(file_get_contents('php://input'), true);
    
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, author, category, date, anonymous, likes, comments, views) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['title'],
        $data['content'],
        $data['author'],
        $data['category'],
        $data['date'],
        $data['anonymous'] ? 1 : 0,
        $data['likes'],
        $data['comments'],
        $data['views']
    ]);
    
    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}
