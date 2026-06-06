<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => '请先登录']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['success' => false, 'message' => '无效的请求方法']);
    exit;
}

$target_type = $_POST['target_type'] ?? '';
$target_id = (int)($_POST['target_id'] ?? 0);
$reason = trim($_POST['reason'] ?? '');

if (!in_array($target_type, ['post', 'comment', 'user'])) {
    echo json_encode(['success' => false, 'message' => '无效的举报类型']);
    exit;
}

if ($target_id <= 0) {
    echo json_encode(['success' => false, 'message' => '无效的目标ID']);
    exit;
}

if (empty($reason)) {
    echo json_encode(['success' => false, 'message' => '请填写举报原因']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO reports (reporter_id, target_type, target_id, reason, status, created_at)
        VALUES (?, ?, ?, ?, 'pending', NOW())
    ");
    $stmt->execute([$_SESSION['user_id'], $target_type, $target_id, $reason]);
    
    echo json_encode(['success' => true, 'message' => '举报已提交，管理员会尽快处理']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => '提交失败：' . $e->getMessage()]);
}
