<?php
file_put_contents('/tmp/ip_debug.log', print_r($_SERVER, true));
header('Content-Type: application/json');

$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';

$input = json_decode(file_get_contents('php://input'), true);
$screen_resolution = $input['screen_resolution'] ?? '';
$timezone = $input['timezone'] ?? '';
$platform = $input['platform'] ?? '';
$language = $input['language'] ?? '';

$stmt = $db->prepare("
    INSERT INTO malicious_visitors_new 
    (ip, user_agent, accept_language, screen_resolution, timezone, platform, language, referer, created_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
");
$stmt->execute([
    $ip, $user_agent, $accept_language, $screen_resolution, 
    $timezone, $platform, $language, $referer
]);

http_response_code(404);
echo json_encode(['error' => 'Not Found']);
