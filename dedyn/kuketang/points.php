<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>小组积分器 · xyydz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; border-radius: 24px; padding: 40px; max-width: 800px; width: 100%; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eef2f5; }
        h1 { text-align: center; color: #c0392b; margin-bottom: 8px; }
        .sub { text-align: center; color: #5a6874; margin-bottom: 24px; font-size: 0.85rem; }
        .groups { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 20px; margin-bottom: 30px; }
        .group { background: #f8f9fa; border-radius: 16px; padding: 20px; text-align: center; min-width: 150px; }
        .group h3 { font-size: 1.2rem; margin-bottom: 15px; }
        .group-score { font-size: 2.5rem; font-weight: bold; color: #c0392b; margin: 10px 0; }
        .group-buttons button { background: #2c3e2f; color: white; border: none; padding: 8px 15px; border-radius: 30px; margin: 3px; cursor: pointer; }
        .group-buttons button:hover { background: #1e2a21; }
        .btn-reset { background: #c0392b; color: white; border: none; padding: 10px 20px; border-radius: 30px; cursor: pointer; display: block; margin: 0 auto; }
        .back { text-align: center; margin-top: 20px; display: block; color: #c0392b; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h1>小组积分器</h1>
    <div class="sub">课堂小组PK · 实时加减分</div>
    <div class="groups" id="groups"></div>
    <button class="btn-reset" onclick="resetScores()">重置所有分数</button>
    <a href="index.php" class="back">← 返回工具箱</a>
</div>
<script>
let groups = [
    { name: '第一组', score: 0 },
    { name: '第二组', score: 0 },
    { name: '第三组', score: 0 },
    { name: '第四组', score: 0 }
];

function renderGroups() {
    const container = document.getElementById('groups');
    container.innerHTML = '';
    groups.forEach((group, index) => {
        const groupDiv = document.createElement('div');
        groupDiv.className = 'group';
        groupDiv.innerHTML = `
            <h3>${group.name}</h3>
            <div class="group-score">${group.score}</div>
            <div class="group-buttons">
                <button onclick="changeScore(${index}, 1)">+1</button>
                <button onclick="changeScore(${index}, 5)">+5</button>
                <button onclick="changeScore(${index}, -1)">-1</button>
                <button onclick="changeScore(${index}, -5)">-5</button>
            </div>
        `;
        container.appendChild(groupDiv);
    });
}

function changeScore(index, delta) {
    groups[index].score += delta;
    if (groups[index].score < 0) groups[index].score = 0;
    renderGroups();
}

function resetScores() {
    groups.forEach(g => g.score = 0);
    renderGroups();
}

renderGroups();
</script>
</body>
</html>
