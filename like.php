<?php
require_once 'config.php';

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => '未登录']);
    exit;
}

$type = $_POST['type'] ?? $_GET['type'] ?? '';
$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);
$format = $_GET['format'] ?? 'json';

if (!in_array($type, ['post', 'comment']) || !$id) {
    http_response_code(400);
    if ($format == 'json') {
        echo json_encode(['success' => false, 'message' => '参数错误']);
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
    exit;
}


$stmt = $pdo->prepare("SELECT id FROM likes WHERE user_id = ? AND target_type = ? AND target_id = ?");
$stmt->execute([$_SESSION['user_id'], $type, $id]);
$existing = $stmt->fetch();

$pdo->beginTransaction();
try {
    if ($existing) {
        
        $pdo->prepare("DELETE FROM likes WHERE id = ?")->execute([$existing['id']]);
        $pdo->prepare("UPDATE {$type}s SET like_count = like_count - 1 WHERE id = ?")->execute([$id]);
        $liked = false;
    } else {
        
        $pdo->prepare("INSERT INTO likes (user_id, target_type, target_id) VALUES (?, ?, ?)")
            ->execute([$_SESSION['user_id'], $type, $id]);
        $pdo->prepare("UPDATE {$type}s SET like_count = like_count + 1 WHERE id = ?")->execute([$id]);
        $liked = true;
    }
    
    
    $stmt = $pdo->prepare("SELECT like_count FROM {$type}s WHERE id = ?");
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();
    
    $pdo->commit();
    
    if ($format == 'json') {
        echo json_encode([
            'success' => true,
            'liked' => $liked,
            'count' => $count
        ]);
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
} catch (Exception $e) {
    $pdo->rollBack();
    if ($format == 'json') {
        echo json_encode(['success' => false, 'message' => '操作失败']);
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
exit;
?>
