<?php
check_auth();
$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
if ($method === 'GET' && !$id) {
    json_response(200, '获取帖子列表', ['posts' => []]);
} elseif ($method === 'GET' && $id) {
    json_response(200, '获取帖子详情', ['id' => $id]);
} elseif ($method === 'POST') {
    json_response(201, '帖子创建成功', [], 201);
} elseif ($method === 'PUT' && $id) {
    json_response(200, '帖子更新成功');
} elseif ($method === 'DELETE' && $id) {
    json_response(200, '帖子删除成功');
} else {
    json_response(405, '方法不允许');
}
