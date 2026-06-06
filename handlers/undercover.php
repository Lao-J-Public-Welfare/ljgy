<?php
session_start();
$word_pairs = [
    ['civil' => '苹果', 'undercover' => '香蕉'],
    ['civil' => '可乐', 'undercover' => '雪碧'],
    ['civil' => '猫', 'undercover' => '狗'],
    ['civil' => '电脑', 'undercover' => '手机'],
    ['civil' => '足球', 'undercover' => '篮球'],
    ['civil' => '咖啡', 'undercover' => '茶'],
    ['civil' => '火车', 'undercover' => '高铁'],
    ['civil' => '老师', 'undercover' => '学生'],
    ['civil' => '医生', 'undercover' => '护士'],
    ['civil' => '夏天', 'undercover' => '冬天'],
];
$action = $_GET['action'] ?? '';
if ($action == 'start') {
    $pair = $word_pairs[array_rand($word_pairs)];
    $is_undercover = rand(0, 1) == 1;
    $_SESSION['undercover_game'] = [
        'civil' => $pair['civil'],
        'undercover' => $pair['undercover'],
        'is_undercover' => $is_undercover,
        'word' => $is_undercover ? $pair['undercover'] : $pair['civil'],
        'start_time' => time()
    ];
    json_response(200, '游戏开始', ['word' => $_SESSION['undercover_game']['word'], 'role' => $is_undercover ? '卧底' : '平民']);
} elseif ($action == 'reveal') {
    if (!isset($_SESSION['undercover_game'])) json_response(400, '请先开始游戏');
    json_response(200, '游戏结束', ['civil_word' => $_SESSION['undercover_game']['civil'], 'undercover_word' => $_SESSION['undercover_game']['undercover']]);
} else {
    json_response(400, '无效操作');
}
