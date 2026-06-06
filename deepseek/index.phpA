<?php
header('Content-Type: text/plain; charset=utf-8');

$msg = $_GET['msg'] ?? '';
$key = $_GET['key'] ?? '';

if ($msg === '' || $key === '') {
    die('参数错误');
}

$plain_msg = urldecode($msg);

file_put_contents('/var/log/nginx/deepseek_plain.log', date('Y-m-d H:i:s') . ' USER: ' . $plain_msg . PHP_EOL, FILE_APPEND);

$history = '';
$log_file = '/var/log/nginx/deepseek_plain.log';
if (file_exists($log_file)) {
    $lines = file($log_file);
    $total = count($lines);
    
      $current_index = $total - 1;
    for ($i = $total - 1; $i >= 0; $i--) {
        if (strpos($lines[$i], 'USER:') !== false) {
            $current_index = $i;
            break;
        }
    }
    
    $start = max(0, $current_index - 50);
    $end = min($total, $current_index + 51);
    $selected_lines = array_slice($lines, $start, $end - $start);
    $history = implode('', $selected_lines);
}

$full_msg = "以下是最近的对话记录：\n" . $history . "\n现在用户说：" . $msg;

$payload = [
    'model' => 'deepseek-chat',
    'messages' => [
        ['role' => 'system', 'content' => ''],
        ['role' => 'user', 'content' => $full_msg]
    ]
];

$ch = curl_init('https://api.deepseek.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $key
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    die('AI 服务异常');
}

$result = json_decode($resp, true);
$reply = $result['choices'][0]['message']['content'] ?? '无回复';

file_put_contents('/var/log/nginx/deepseek_plain.log', date('Y-m-d H:i:s') . ' AI: ' . $reply . PHP_EOL, FILE_APPEND);

$reply = $reply . "";

echo $reply;
