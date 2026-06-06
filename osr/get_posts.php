<?php
require_once 'config.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM posts ORDER BY date DESC");
    echo json_encode(['success' => true, 'data' => $stmt->fetchAll()]);
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
