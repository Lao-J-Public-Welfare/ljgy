<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$action = $_GET['action'] ?? '';
$comment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($action == 'delete') {
    $stmt = $pdo->prepare("SELECT user_id, post_id FROM comments WHERE id = ?");
    $stmt->execute([$comment_id]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($comment && ($_SESSION['user_id'] == $comment['user_id'] || isAdmin())) {
        $pdo->prepare("DELETE FROM comments WHERE id = ?")->execute([$comment_id]);
        redirect("post.php?id=" . $comment['post_id']);
    }
}

if ($action == 'like') {
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

if ($action == 'report') {
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

redirect('index.php');
?>
