<?php
session_start();

$host = 'localhost';
$dbname = 'laojing_forum_new';  
$db_user = 'root';
$db_pass = 'JONGN123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_user, $db_pass);  
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("set names utf8mb4");
} catch(PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function getAvatar($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT avatar FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $avatar = $stmt->fetchColumn();
    return $avatar ? "/uploads/avatars/$avatar" : "/uploads/avatars/default.png";
}
?>
