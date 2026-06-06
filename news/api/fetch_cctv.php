<?php
header('Content-Type: application/json');

$db = new PDO("mysql:host=localhost;dbname=ljgy_links;charset=utf8mb4", "root", "JONGN123");

$apis = [
    '国内' => 'https://api.istero.com/api/cctv/news/domestic',
    '国际' => 'https://api.istero.com/api/cctv/news/international',
    '社会' => 'https://api.istero.com/api/cctv/news/society',
    '科技' => 'https://api.istero.com/api/cctv/news/tech',
    '法治' => 'https://api.istero.com/api/cctv/news/law',
    '文体' => 'https://api.istero.com/api/cctv/news/entertainment',
    '热搜' => 'https://api.istero.com/api/tencent/hot'
];

$total_count = 0;
$errors = [];
$max_per_category = 7;  // 7个分类 × 7 ≈ 50条

foreach ($apis as $category => $url) {
    $response = @file_get_contents($url);
    if ($response === false) {
        $errors[] = "拉取 {$category} 新闻失败";
        continue;
    }
    
    $data = json_decode($response, true);
    if (!isset($data['data']) || empty($data['data'])) {
        continue;
    }
    
    $count = 0;
    foreach ($data['data'] as $news) {
        if ($count >= $max_per_category) break;
        
        $stmt = $db->prepare("SELECT id FROM news WHERE title = ?");
        $stmt->execute([$news['title']]);
        if ($stmt->fetch()) {
            continue;
        }
        
        $summary = isset($news['summary']) ? $news['summary'] : (isset($news['description']) ? $news['description'] : $news['title']);
        $content = isset($news['content']) ? $news['content'] : $summary;
        
        $stmt = $db->prepare("INSERT INTO news (title, summary, content, category, source, is_published) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute([
            $news['title'],
            $summary,
            $content,
            $category,
            '央视新闻'
        ]);
        $total_count++;
        $count++;
    }
}

echo json_encode([
    'success' => empty($errors),
    'count' => $total_count,
    'message' => empty($errors) ? '同步完成，共 ' . $total_count . ' 条新新闻' : implode('; ', $errors)
]);
