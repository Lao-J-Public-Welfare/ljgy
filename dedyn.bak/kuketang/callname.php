<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>随机点名器 · xyydz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; border-radius: 24px; padding: 40px; max-width: 600px; width: 100%; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eef2f5; }
        h1 { color: #c0392b; margin-bottom: 8px; }
        .sub { color: #5a6874; margin-bottom: 24px; font-size: 0.85rem; }
        textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 12px; font-size: 14px; font-family: monospace; resize: vertical; margin-bottom: 20px; }
        .btn { background: #2c3e2f; color: white; border: none; padding: 10px 24px; border-radius: 30px; font-size: 1rem; cursor: pointer; margin: 5px; }
        .btn:hover { background: #1e2a21; }
        .result { margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 12px; font-size: 2rem; font-weight: bold; color: #c0392b; }
        .back { margin-top: 20px; display: inline-block; color: #c0392b; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h1>随机点名器</h1>
    <div class="sub">每行一个学生姓名</div>
    <textarea id="studentList" rows="6" placeholder="张三&#10;李四&#10;王五&#10;赵六"></textarea>
    <br>
    <button class="btn" onclick="pickStudent()">随机点名</button>
    <div class="result" id="result">点击按钮开始</div>
    <a href="index.php" class="back">← 返回工具箱</a>
</div>
<script>
function pickStudent() {
    const textarea = document.getElementById('studentList');
    const students = textarea.value.split('\n').filter(s => s.trim() !== '');
    if (students.length === 0) {
        document.getElementById('result').innerHTML = '请先输入学生名单';
        return;
    }
    const randomIndex = Math.floor(Math.random() * students.length);
    document.getElementById('result').innerHTML = students[randomIndex].trim();
}
</script>
</body>
</html>
