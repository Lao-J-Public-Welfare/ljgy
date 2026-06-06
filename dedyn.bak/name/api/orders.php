<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php:
    $id = intval($input['id'] ?? 0);
    $action = $input['action'] ?? '';
    
    if ($action === 'done' && $id) {
        $stmt = $db->prepare("UPDATE pc_orders SET status = 1 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }
}

$stmt = $db->query("SELECT * FROM pc_orders ORDER BY id DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['success' => true, 'orders' => $orders]);
