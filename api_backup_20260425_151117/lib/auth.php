<?php
function check_auth() {
    $api_key = $_GET['key'] ?? $_POST['key'] ?? $_SERVER['HTTP_X_API_KEY'] ?? '';
    if ($api_key !== API_KEY) {
        require_once __DIR__ . '/response.php';
        json_response(403, '无效的API密钥', null, 403);
    }
}
