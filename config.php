<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_DOMAIN', 'ljgy123.top');
define('MAX_DOMAINS', 2);
define('CF_ZONE_ID', 'ee6e652bb083e7f1d50a1da9c0169b97');
define('CF_API_TOKEN', 'cfut_2a2RvR2k9l3XdJo3hi9lsYUqVqWjqilpuYfSFLHs20c4f4f7');

$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'cscscs;
$db_name = 'dns_system';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('数据库连接失败: ' . $e->getMessage());
}
?>
