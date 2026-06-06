<?php
$host = 'localhost';
$dbname = 'forum_db';
$username = 'root';
$password = 'JONGN123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die(json_encode(['success' => false, 'message' => $e->getMessage()]));
}
?>
