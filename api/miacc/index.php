<?php
header('Content-Type: application/json');

// 支持 GET（URL参数）和 POST（表单/JSON）
$email = $_REQUEST['email'] ?? '';
$password = $_REQUEST['password'] ?? '';

if ($email !== 'lsccxmwithmia@ljgy123.top' || $password !== '3smvc32rqliwaklfbi2daz8wdwiy8z57') {
    echo json_encode(['code' => 401, 'message' => '认证失败']);
    exit;
}

// 获取文件内容（支持两种方式）
$file_content = null;
$original_name = '';

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // 方式1：直接上传文件（multipart/form-data）
    $file_content = file_get_contents($_FILES['file']['tmp_name']);
    $original_name = $_FILES['file']['name'];
} elseif (isset($_REQUEST['file_url']) && !empty($_REQUEST['file_url'])) {
    // 方式2：通过 URL 下载
    $file_url = $_REQUEST['file_url'];
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
    $original_name = basename($file_url);
} else {
    echo json_encode(['code' => 400, 'message' => '请提供 file 或 file_url']);
    exit;
}

if (!$file_content) {
    echo json_encode(['code' => 400, 'message' => '文件内容为空']);
    exit;
}

// 生成唯一文件名
$timestamp = time();
$ext = pathinfo($original_name, PATHINFO_EXTENSION);
$unique_id = substr(md5(uniqid()), 0, 8);
$remote_filename = $ext ? "{$unique_id}_{$timestamp}.{$ext}" : "{$unique_id}_{$timestamp}";
$webdav_url = "https://yp.ljgy123.top/dav/临时分享/{$remote_filename}";

// 上传到 WebDAV
$ch = curl_init($webdav_url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $file_content);
curl_setopt($ch, CURLOPT_USERPWD, 'lsccxmwithmia@ljgy123.top:3smvc32rqliwaklfbi2daz8wdwiy8z57');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
$upload_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($upload_code < 200 || $upload_code >= 300) {
    echo json_encode(['code' => 500, 'message' => '上传到云盘失败']);
    exit;
}

// 记录日志
file_put_contents('/opt/data/statics/api/upload_log.txt', date('Y-m-d H:i:s') . "|{$webdav_url}\n", FILE_APPEND);

echo json_encode([
    'code' => 200,
    'url' => $webdav_url,
    'expires_in' => '5小时'
]);
