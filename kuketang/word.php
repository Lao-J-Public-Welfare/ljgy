<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>英语单词抽背 · xyydz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; border-radius: 24px; padding: 40px; max-width: 600px; width: 100%; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eef2f5; }
        h1 { color: #c0392b; margin-bottom: 8px; }
        .sub { color: #5a6874; margin-bottom: 24px; font-size: 0.85rem; }
        .word-area { margin: 20px 0; }
        .word { font-size: 2rem; font-weight: bold; margin: 20px 0; color: #1e2a3a; }
        .meaning { font-size: 1rem; color: #c0392b; margin-top: 10px; display: none; }
        .btn { background: #2c3e2f; color: white; border: none; padding: 10px 20px; border-radius: 30px; font-size: 0.9rem; cursor: pointer; margin: 5px; }
        .btn:hover { background: #1e2a21; }
        .back { margin-top: 20px; display: inline-block; color: #c0392b; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h1>英语单词抽背</h1>
    <div class="sub">随机抽取单词，检查背诵情况</div>
    <div class="word-area">
        <div class="word" id="word">点击开始</div>
        <div class="meaning" id="meaning"></div>
    </div>
    <div>
        <button class="btn" onclick="pickWord()">随机抽词</button>
        <button class="btn" onclick="showMeaning()">显示释义</button>
    </div>
    <a href="index.php" class="back">← 返回工具箱</a>
</div>
<script>
const words = [
    { word: 'apple', meaning: '苹果' },
    { word: 'book', meaning: '书' },
    { word: 'car', meaning: '汽车' },
    { word: 'dog', meaning: '狗' },
    { word: 'cat', meaning: '猫' },
    { word: 'house', meaning: '房子' },
    { word: 'happy', meaning: '快乐的' },
    { word: 'big', meaning: '大的' },
    { word: 'small', meaning: '小的' },
    { word: 'run', meaning: '跑' }
];

let currentWord = null;

function pickWord() {
    const randomIndex = Math.floor(Math.random() * words.length);
    currentWord = words[randomIndex];
    document.getElementById('word').innerHTML = currentWord.word;
    document.getElementById('meaning').style.display = 'none';
    document.getElementById('meaning').innerHTML = '';
}

function showMeaning() {
    if (currentWord) {
        document.getElementById('meaning').innerHTML = currentWord.meaning;
        document.getElementById('meaning').style.display = 'block';
    }
}
</script>
</body>
</html>
