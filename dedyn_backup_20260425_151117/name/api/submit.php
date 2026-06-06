<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");

$input = json_decode(file_get_contents('php:
$config = trim($input['config'] ?? '');
$price = trim($input['price'] ?? '');

if (empty($config) || empty($price)) {
    echo json_encode(['success' => false, 'message' => '请填写完整信息']);
    exit;
}

$stmt = $db->prepare("INSERT INTO pc_orders (config, price) VALUES (?, ?)");
if ($stmt->execute([$config, $price])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => '提交失败']);
}
