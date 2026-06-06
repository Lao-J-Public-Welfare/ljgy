<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>快速出题器 · xyydz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; border-radius: 24px; padding: 40px; max-width: 600px; width: 100%; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eef2f5; }
        h1 { color: #c0392b; margin-bottom: 8px; }
        .sub { color: #5a6874; margin-bottom: 24px; font-size: 0.85rem; }
        .quiz-area { margin: 20px 0; }
        .question { font-size: 2rem; font-weight: bold; margin: 20px 0; }
        .answer { width: 150px; padding: 10px; font-size: 1rem; text-align: center; border: 1px solid #ddd; border-radius: 8px; margin: 10px; }
        .btn { background: #2c3e2f; color: white; border: none; padding: 10px 20px; border-radius: 30px; font-size: 0.9rem; cursor: pointer; margin: 5px; }
        .btn:hover { background: #1e2a21; }
        .result { margin-top: 15px; font-size: 1rem; }
        .back { margin-top: 20px; display: inline-block; color: #c0392b; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h1>快速出题器</h1>
    <div class="sub">小学数学 · 加减乘除</div>
    <div class="quiz-area">
        <div class="question" id="question">5 + 3 = ?</div>
        <input type="number" id="answer" class="answer" placeholder="输入答案">
        <br>
        <button class="btn" onclick="checkAnswer()">验证答案</button>
        <button class="btn" onclick="newQuestion()">下一题</button>
        <div class="result" id="result"></div>
    </div>
    <a href="index.php" class="back">← 返回工具箱</a>
</div>
<script>
let currentAnswer = 0;

function newQuestion() {
    const operators = ['+', '-', '*', '/'];
    const op = operators[Math.floor(Math.random() * operators.length)];
    let a, b, answer;
    
    if (op === '+') {
        a = Math.floor(Math.random() * 50) + 1;
        b = Math.floor(Math.random() * 50) + 1;
        answer = a + b;
    } else if (op === '-') {
        a = Math.floor(Math.random() * 50) + 1;
        b = Math.floor(Math.random() * a) + 1;
        answer = a - b;
    } else if (op === '*') {
        a = Math.floor(Math.random() * 10) + 1;
        b = Math.floor(Math.random() * 10) + 1;
        answer = a * b;
    } else {
        b = Math.floor(Math.random() * 9) + 1;
        answer = Math.floor(Math.random() * 10) + 1;
        a = answer * b;
        answer = a / b;
    }
    
    currentAnswer = answer;
    let displayOp = op;
    if (op === '*') displayOp = '×';
    if (op === '/') displayOp = '÷';
    document.getElementById('question').innerHTML = `${a} ${displayOp} ${b} = ?`;
    document.getElementById('answer').value = '';
    document.getElementById('result').innerHTML = '';
}

function checkAnswer() {
    const userAnswer = parseFloat(document.getElementById('answer').value);
    if (userAnswer === currentAnswer) {
        document.getElementById('result').innerHTML = '<span style="color:#2c5a2e;">✓ 回答正确！</span>';
        newQuestion();
    } else {
        document.getElementById('result').innerHTML = '<span style="color:#c0392b;">✗ 回答错误，再试试</span>';
    }
}

newQuestion();
</script>
</body>
</html>
