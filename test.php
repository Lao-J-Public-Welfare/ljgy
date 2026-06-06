<?php
header('Content-Type: application/json');
echo json_encode([
    'code' => 200,
    'message' => 'API测试成功',
    'time' => date('Y-m-d H:i:s')
]);
