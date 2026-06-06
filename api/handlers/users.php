<?php
check_auth();
json_response(200, '用户接口', ['method' => $_SERVER['REQUEST_METHOD'], 'id' => $_GET['id'] ?? null]);
