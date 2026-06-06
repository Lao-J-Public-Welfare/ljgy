<?php
header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    echo json_encode(['code' => 405, 'message' => 'Method Not Allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';
$file_url = $input['file_url'] ?? '';

// 验证账号（固定写死，也可以改成从数据库查）
if ($email !== 'lsccxmwithmia@ljgy123.top' || $password !== '3smvc32rqliwaklfbi2daz8wdwiy8z57') {
    echo json_encode(['code' => 401, 'message' => '认证失败']);
    exit;
}

if (empty($file_url)) {
    echo json_encode(['code' => 400, 'message' => '请提供 file_url']);
    exit;
}

// 下载源文件
$ch = curl_init($file_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$file_content = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo json_encode(['code' => 400, 'message' => '下载源文件失败']);
    exit;
}

// 生成唯一文件名
$timestamp = time();
$unique_id = substr(md5(uniqid()), 0, 8);
$remote_filename = "{$unique_id}_{$timestamp}";
$webdav_url = "https://yp.ljgy123.top/dav/临时分享/{$remote_filename}";

// 通过 WebDAV 上传到云盘
$ch = curl_init($webdav_url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $file_content);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, 'lsccxmwithmia@ljgy123.top:3smvc32rqliwaklfbi2daz8wdwiy8z57');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$upload_resp = curl_exec($ch);
$upload_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($upload_code < 200 || $upload_code >= 300) {
    echo json_encode(['code' => 500, 'message' => '上传到云盘失败']);
    exit;
}

// 记录上传日志（用于后续清理）
$log_line = date('Y-m-d H:i:s') . "|{$webdav_url}\n";
file_put_contents('/opt/data/statics/api/upload_log.txt', $log_line, FILE_APPEND);

// 返回结果
echo json_encode([
    'code' => 200,
    'message' => '上传成功',
    'url' => $webdav_url,
    'expires_in' => '5小时',
    'expires_at' => $timestamp + 5*3600
]);
