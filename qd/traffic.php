<?php
$log_file = '/var/log/nginx/access.log';
$today = date('d/M/Y');
$count = 0;

if (file_exists($log_file)) {
    $lines = file($log_file);
    foreach ($lines as $line) {
        if (strpos($line, $today) !== false) {
            if (strpos($line, '127.0.0.1') === false && 
                strpos($line, '/api/') === false && 
                strpos($line, 'traffic.php') === false) {
                $count++;
            }
        }
    }
}
header('Content-Type: application/json');
echo json_encode(['access_count' => $count]);
