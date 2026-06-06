<?php
require_once 'Short.class.php';
$code = $_GET['code'] ?? '';
$id = Short::decode($code);
if ($id) {
    header("Location: /post.php?id=$id");
} else {
    die('短链不存在');
}
