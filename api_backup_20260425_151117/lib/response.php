<?php
function json_response($code, $message, $data = null, $status = 200) {
    http_response_code($status);
    $response = ['code' => $code, 'message' => $message, 'version' => 'v1', 'time' => date('Y-m-d H:i:s')];
    if ($data !== null) $response['data'] = $data;
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}
