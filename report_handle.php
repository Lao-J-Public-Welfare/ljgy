<?php
require_once 'config.php';

if (!isAdmin()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => '无权操作']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$status = $_POST['status'] ?? '';
$action = $_POST['action'] ?? '';

if (!$id) {
    echo json_encode(['success' => false, 'message' => '参数错误']);
    exit;
}

if ($action == 'delete') {
    $pdo->prepare("DELETE FROM reports WHERE id = ?")->execute([$id]);
    echo json_encode(['success' => true]);
    exit;
}

if (in_array($status, ['resolved', 'dismissed'])) {
    $pdo->prepare("UPDATE reports SET status = ? WHERE id = ?")->execute([$status, $id]);
    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false, 'message' => '无效操作']);
?>
