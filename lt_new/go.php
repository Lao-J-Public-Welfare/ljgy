<?php
require_once __DIR__ . '/config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id) {
    $stmt = $pdo->prepare("SELECT id FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    if ($stmt->fetch()) {
        header("Location: post.php?id=$id");
        exit;
    }
}

http_response_code(404);
echo "帖子不存在";
