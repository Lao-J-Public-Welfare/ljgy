<?php
$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");

$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';

$screen_resolution = $_POST['screen_resolution'] ?? '';
$timezone = $_POST['timezone'] ?? '';
$platform = $_POST['platform'] ?? '';

$stmt = $db->prepare("INSERT INTO malicious_visitors_new (ip, user_agent, accept_language, screen_resolution, timezone, platform, referer) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$ip, $user_agent, $accept_language, $screen_resolution, $timezone, $platform, $referer]);

http_response_code(404);
echo json_encode(['error' => 'Not Found']);
