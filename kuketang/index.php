<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教学工具箱 · xyydz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 24px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: white; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .logo h1 { font-size: 1.5rem; font-weight: 600; color: #c0392b; }
        .logo p { font-size: 0.7rem; color: #7c8b9c; }
        .nav a { margin-left: 20px; color: #5a6874; text-decoration: none; font-size: 0.85rem; }
        .nav a:hover { color: #c0392b; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px; }
        .card { background: white; border-radius: 16px; padding: 24px; text-align: center; transition: 0.2s; border: 1px solid #eef2f5; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(0,0,0,0.08); border-color: #c0392b; }
        .card-icon { font-size: 2.5rem; margin-bottom: 12px; }
        .card h3 { font-size: 1.2rem; font-weight: 600; margin-bottom: 8px; color: #1e2a3a; }
        .card p { font-size: 0.8rem; color: #5a6874; margin-bottom: 16px; }
        .btn { display: inline-block; background: #2c3e2f; color: white; padding: 8px 20px; border-radius: 30px; text-decoration: none; font-size: 0.8rem; transition: 0.2s; }
        .btn:hover { background: #1e2a21; }
        .footer { text-align: center; padding: 24px; color: #9aaebf; font-size: 0.7rem; border-top: 1px solid #eef2f5; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">
            <h1>xyydz</h1>
            <p>教学工具箱</p>
        </div>
        <div class="nav">
            <a href="index.php">首页</a>
            <a href="https:
        </div>
    </div>

    <div class="grid">
        <div class="card">
            <div class="card-icon">🐣</div>
            <h3>电子宠物</h3>
            <p>喂食、清洁、玩耍，陪它长大</p>
            <a href="pet.php" class="btn">使用</a>
        </div>
        <div class="card">
            <div class="card-icon">🎲</div>
            <h3>随机点名器</h3>
            <p>输入学生名单，随机抽取幸运儿</p>
            <a href="callname.php" class="btn">使用</a>
        </div>
        <div class="card">
            <div class="card-icon">⏱️</div>
            <h3>课堂计时器</h3>
            <p>倒计时/正计时，投影到屏幕</p>
            <a href="timer.php" class="btn">使用</a>
        </div>
        <div class="card">
            <div class="card-icon">📝</div>
            <h3>快速出题器</h3>
            <p>小学数学加减乘除，一键生成</p>
            <a href="quiz.php" class="btn">使用</a>
        </div>
        <div class="card">
            <div class="card-icon">🏆</div>
            <h3>小组积分器</h3>
            <p>课堂小组PK，实时加分减分</p>
            <a href="points.php" class="btn">使用</a>
        </div>
        <div class="card">
            <div class="card-icon">🗣️</div>
            <h3>英语单词抽背</h3>
            <p>随机抽取单词，检查背诵情况</p>
            <a href="word.php" class="btn">使用</a>
        </div>
        <div class="card">
            <div class="card-icon">🔊</div>
            <h3>课堂噪声仪</h3>
            <p>检测课堂音量，自动提醒安静</p>
            <a href="noise.php" class="btn">使用</a>
        </div>
    </div>

    <div class="footer">
        <p>开箱即用 · 完全免费</p>
    </div>
</div>
</body>
</html>
