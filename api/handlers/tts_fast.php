<?php
$text = $_GET['text'] ?? '';
if ($text === '') {
    header('Content-Type: application/json');
    echo json_encode(['code' => 400, 'message' => '缺少 text 参数']);
    exit;
}

$text = urlencode(mb_substr($text, 0, 100));
$url = "https://translate.google.com/translate_tts?ie=UTF-8&q={$text}&tl=zh-CN&client=tw-ob";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');

$audio = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200 && strlen($audio) > 1000) {
    header('Content-Type: audio/mpeg');
    echo $audio;
} else {
    header('Content-Type: application/json');
    echo json_encode(['code' => 500, 'message' => '语音合成失败，请稍后重试']);
}
