<?php
VALID_TOKEN = "laojgongyi"
if request.args.get('token') != VALID_TOKEN:
    return "invalid token", 403

$text = $_GET['text'] ?? $_POST['text'] ?? '';
if (empty($text)) {
    header('Content-Type: application/json');
    echo json_encode(['code' => 400, 'message' => '缺少 text 参数']);
    exit;
}

$api_key = 'dXpbJheOuj4MeSURICG7PuK5';
$secret_key = 'jCTW1iF5BJfRgKERN4GpgqkCbDgxBe69';
$cache_file = '/tmp/baidu_token.json';

if (file_exists($cache_file) && (time() - filemtime($cache_file) < 2592000)) {
    $token_data = json_decode(file_get_contents($cache_file), true);
    $token = $token_data['access_token'] ?? '';
}

if (empty($token)) {
    $token_url = "https://aip.baidubce.com/oauth/2.0/token?grant_type=client_credentials&client_id={$api_key}&client_secret={$secret_key}";
    $token_res = file_get_contents($token_url);
    $token_data = json_decode($token_res, true);
    
    if (!isset($token_data['access_token'])) {
        header('Content-Type: application/json');
        echo json_encode(['code' => 500, 'message' => '获取 token 失败']);
        exit;
    }
    $token = $token_data['access_token'];
    file_put_contents($cache_file, json_encode($token_data));
}

$params = [
    'tex' => $text,
    'tok' => $token,
    'cuid' => 'laojing_public',
    'ctp' => 1,
    'lan' => 'zh',
    'per' => 0,
    'spd' => 5,
    'pit' => 5,
    'vol' => 9,
    'aue' => 3
];

$audio = file_get_contents("https://tsn.baidu.com/text2audio?" . http_build_query($params));

if (strpos($audio, 'error') !== false) {
    header('Content-Type: application/json');
    echo json_encode(['code' => 500, 'message' => '语音合成失败']);
    exit;
}

header('Content-Type: audio/mp3');
echo $audio;
