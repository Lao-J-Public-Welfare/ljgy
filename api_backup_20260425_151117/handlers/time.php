<?php
$format = $_GET['format'] ?? 'iso';
$timezone = $_GET['tz'] ?? 'Asia/Shanghai';
date_default_timezone_set($timezone);
$now = time();
$data = ['timestamp' => $now, 'iso' => date('c', $now), 'date' => date('Y-m-d', $now), 'time' => date('H:i:s', $now), 'datetime' => date('Y-m-d H:i:s', $now), 'timezone' => $timezone];
if ($format !== 'all' && isset($data[$format])) json_response(200, '时间获取成功', [$format => $data[$format]]);
json_response(200, '时间获取成功', $data);
